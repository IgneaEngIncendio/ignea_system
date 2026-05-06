<?php

namespace App\Services\Calculations;

class PciCalculations
{
    /**
     * Tabela 2 CSCIP — Classificação por altura
     */
    public static function getClassificacaoAltura(float $altura): array
    {
        if ($altura <= 0)  return ['tipo' => 'TIPO I',   'denominacao' => 'Edificação Térrea',              'faixa' => 'Um pavimento'];
        if ($altura <= 6)  return ['tipo' => 'TIPO II',  'denominacao' => 'Edificação Baixa',               'faixa' => 'H ≤ 6,00 m'];
        if ($altura <= 12) return ['tipo' => 'TIPO III', 'denominacao' => 'Edificação de Baixa-Média Altura','faixa' => '6,00 m < H ≤ 12,00 m'];
        if ($altura <= 23) return ['tipo' => 'TIPO IV',  'denominacao' => 'Edificação de Média Altura',      'faixa' => '12,00 m < H ≤ 23,00 m'];
        if ($altura <= 30) return ['tipo' => 'TIPO V',   'denominacao' => 'Edificação Mediamente Alta',      'faixa' => '23,00 m < H ≤ 30,00 m'];
        return             ['tipo' => 'TIPO VI',  'denominacao' => 'Edificação Alta',              'faixa' => 'Acima de 30,00 m'];
    }

    /**
     * Tabela 3 CSCIP — Classificação por CI (Carga de Incêndio)
     */
    public static function getClassificacaoRisco(float $ci): string
    {
        if ($ci <= 300)  return 'Risco Leve';
        if ($ci <= 1200) return 'Risco Moderado';
        return 'Risco Elevado';
    }

    /**
     * Carga de incêndio média ponderada
     */
    public static function calcularCargaIncendio(array $ocupacoes): float
    {
        $totalArea = collect($ocupacoes)->sum('area');
        if ($totalArea == 0) return 0;
        return collect($ocupacoes)->sum(fn($o) => ($o['ci'] ?? 0) * ($o['area'] ?? 0)) / $totalArea;
    }

    /**
     * Cálculo de brigadistas (NPT 017)
     */
    public static function calcularBrigadistas(
        int $populacao,
        string $tipo = 'organico',
        bool $confinado = false,
        bool $altura = false,
        bool $perigosos = false
    ): array {
        $popExposta  = (int) ceil($populacao * 1.3);
        $numOrganicos = (int) ceil($popExposta / 200);
        $numProfissionais = (int) ceil($numOrganicos / 5);

        $cargaBase = 32;
        $riscos = [];
        if ($confinado) { $riscos[] = ['risco' => 'Espaço Confinado', 'horas' => 32]; $cargaBase += 32; }
        if ($altura)    { $riscos[] = ['risco' => 'Trabalho em Altura', 'horas' => 16]; $cargaBase += 16; }
        if ($perigosos) { $riscos[] = ['risco' => 'Produtos Perigosos', 'horas' => 32]; $cargaBase += 32; }
        if (!empty($riscos)) $cargaBase += 16; // +16h comando se há riscos específicos

        return [
            'num_organicos'       => max(1, $numOrganicos),
            'num_profissionais'   => max(1, $numProfissionais),
            'num_final'           => $tipo === 'profissional' ? max(1, $numProfissionais) : max(1, $numOrganicos),
            'carga_horaria_total' => $cargaBase,
            'riscos_extras'       => $riscos,
        ];
    }

    /**
     * TRRF por ocupação e altura (NPT 008)
     */
    public static function calcularTrrf(string $divisao, float $altura): array
    {
        $grupo = substr($divisao, 0, 1);
        $classeAltura = self::getClassificacaoAltura($altura);

        // Tabela simplificada TRRF (baseada na NPT 008)
        $tabela = [
            'A' => ['TIPO I' => 30, 'TIPO II' => 30, 'TIPO III' => 60, 'TIPO IV' => 60, 'TIPO V' => 90, 'TIPO VI' => 120],
            'B' => ['TIPO I' => 60, 'TIPO II' => 60, 'TIPO III' => 60, 'TIPO IV' => 90, 'TIPO V' => 90, 'TIPO VI' => 120],
            'C' => ['TIPO I' => 30, 'TIPO II' => 30, 'TIPO III' => 60, 'TIPO IV' => 60, 'TIPO V' => 90, 'TIPO VI' => 120],
            'D' => ['TIPO I' => 30, 'TIPO II' => 30, 'TIPO III' => 60, 'TIPO IV' => 60, 'TIPO V' => 90, 'TIPO VI' => 120],
            'E' => ['TIPO I' => 30, 'TIPO II' => 30, 'TIPO III' => 60, 'TIPO IV' => 60, 'TIPO V' => 90, 'TIPO VI' => 120],
            'F' => ['TIPO I' => 60, 'TIPO II' => 60, 'TIPO III' => 60, 'TIPO IV' => 90, 'TIPO V' => 90, 'TIPO VI' => 120],
            'G' => ['TIPO I' => 30, 'TIPO II' => 30, 'TIPO III' => 60, 'TIPO IV' => 60, 'TIPO V' => 90, 'TIPO VI' => 120],
            'H' => ['TIPO I' => 60, 'TIPO II' => 60, 'TIPO III' => 90, 'TIPO IV' => 90, 'TIPO V' => 120,'TIPO VI' => 120],
            'I' => ['TIPO I' => 30, 'TIPO II' => 60, 'TIPO III' => 60, 'TIPO IV' => 90, 'TIPO V' => 90, 'TIPO VI' => 120],
            'J' => ['TIPO I' => 30, 'TIPO II' => 60, 'TIPO III' => 60, 'TIPO IV' => 90, 'TIPO V' => 90, 'TIPO VI' => 120],
        ];

        $trrf = $tabela[$grupo][$classeAltura['tipo']] ?? 60;

        return [
            'divisao'      => $divisao,
            'grupo'        => $grupo,
            'classe_altura'=> $classeAltura['tipo'],
            'faixa_altura' => $classeAltura['faixa'],
            'trrf'         => $trrf,
        ];
    }
}

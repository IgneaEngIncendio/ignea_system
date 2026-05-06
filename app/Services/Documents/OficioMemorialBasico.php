<?php

namespace App\Services\Documents;

class OficioMemorialBasico extends BaseDocument
{
    public function gerar($project): string
    {
        $this->criarSecao();

        $this->addHeading("OFÍCIO DE ENCAMINHAMENTO - MEMORIAL BÁSICO", 1);
        
        $this->addParagrafo("Ao Comandante do 4º Grupamento de Bombeiros", true);
        $this->addParagrafo("Cascavel - PR");

        $this->addParagrafo("\nAssunto: Protocolo de Projeto de Segurança Contra Incêndio e Pânico.");
        
        $this->addParagrafo("\nPrezado Senhor,");
        
        $this->addParagrafo("Vimos por meio deste encaminhar para análise o Projeto de Segurança Contra Incêndio e Pânico da edificação abaixo relacionada:");
        
        $this->addBullet("Nome da Obra: " . $project->nome_obra);
        $this->addBullet("Endereço: " . $project->endereco);
        $this->addBullet("Área Total: " . number_format($project->area_total, 2, ',', '.') . " m²");
        
        $this->addParagrafo("\nNestes termos, pede deferimento.");

        $this->addParagrafo("\n\nCascavel, " . date('d') . " de " . $this->getMesExtenso(date('m')) . " de " . date('Y') . ".");

        $this->addParagrafo("\n\n__________________________________________");
        $this->addParagrafo($project->rt_nome, true);
        $this->addParagrafo($project->rt_crea);

        return $this->salvar($project->codigo_interno . "-oficio-memorial-basico.docx");
    }

    private function getMesExtenso($mes)
    {
        $meses = [
            '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril',
            '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto',
            '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
        ];
        return $meses[$mes] ?? '';
    }
}

<?php

namespace App\Services\Documents;

class Termos extends BaseDocument
{
    public function gerar($project): string
    {
        return $this->gerarTermoCompromisso($project);
    }

    public function gerarTermoCompromisso($project): string
    {
        $this->criarSecao();

        $this->addHeading("TERMO DE COMPROMISSO E RESPONSABILIDADE", 1);
        
        $this->addParagrafo("Eu, " . $project->nome_proprietario . ", portador do " . $project->tipo_documento . " nº " . $project->cpf_cnpj . ", na qualidade de proprietário/responsável pelo uso da edificação denominada " . $project->nome_obra . ", localizada em " . $project->endereco . ", comprometo-me a:");
        
        $this->addBullet("Manter as medidas de segurança contra incêndio e pânico em perfeitas condições de uso.");
        $this->addBullet("Treinar os funcionários conforme o Plano de Emergência.");
        $this->addBullet("Não alterar as características da edificação sem prévia autorização do Corpo de Bombeiros.");

        $this->addParagrafo("\nPor ser verdade, firmo o presente.");

        $this->addParagrafo("\n\nCascavel, " . date('d/m/Y') . ".");

        $this->addParagrafo("\n\n__________________________________________");
        $this->addParagrafo($project->nome_proprietario, true);

        return $this->salvar($project->codigo_interno . "-termo-compromisso.docx");
    }

    public function gerarTermoSaidasEmergencia($project): string
    {
        $this->criarSecao();
        $this->addHeading("TERMO DE RESPONSABILIDADE DAS SAÍDAS DE EMERGÊNCIA", 1);
        $this->addParagrafo("O proprietário declara que as saídas de emergência estão dimensionadas conforme a NPT 011.");
        return $this->salvar($project->codigo_interno . "-termo-saidas.docx");
    }
}

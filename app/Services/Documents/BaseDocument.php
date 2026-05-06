<?php

namespace App\Services\Documents;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;

abstract class BaseDocument
{
    protected PhpWord $phpWord;
    protected $section;

    // Cor institucional Ígnea #912F46
    protected string $corIgnea = '912F46';
    protected string $corBranco = 'FFFFFF';
    protected string $corCinza = 'D9D9D9';

    public function __construct()
    {
        $this->phpWord = new PhpWord();
        $this->configurarEstilos();
    }

    protected function configurarEstilos(): void
    {
        // Estilo padrão Normal
        $this->phpWord->addFontStyle('Normal', [
            'name' => 'Arial', 'size' => 12,
        ]);
        $this->phpWord->addParagraphStyle('Normal', [
            'lineHeight' => 1.5, 'spaceAfter' => Converter::pointToTwip(10),
            'alignment'  => 'both',
        ]);

        // Títulos
        $this->phpWord->addFontStyle('Titulo1', ['name' => 'Arial', 'size' => 20, 'bold' => true, 'color' => $this->corIgnea]);
        $this->phpWord->addParagraphStyle('Titulo1', ['lineHeight' => 1.5, 'spaceBefore' => Converter::pointToTwip(14), 'spaceAfter' => Converter::pointToTwip(10), 'keepNext' => true]);

        $this->phpWord->addFontStyle('Titulo2', ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => $this->corIgnea]);
        $this->phpWord->addParagraphStyle('Titulo2', ['lineHeight' => 1.5, 'spaceBefore' => Converter::pointToTwip(12), 'spaceAfter' => Converter::pointToTwip(10), 'keepNext' => true]);

        $this->phpWord->addFontStyle('Titulo3', ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => $this->corIgnea]);
        $this->phpWord->addParagraphStyle('Titulo3', ['lineHeight' => 1.5, 'spaceBefore' => Converter::pointToTwip(10), 'spaceAfter' => Converter::pointToTwip(8), 'keepNext' => true]);
    }

    protected function criarSecao(): void
    {
        $this->section = $this->phpWord->addSection([
            'paperSize'    => 'A4',
            'marginTop'    => Converter::cmToTwip(4.0),
            'marginBottom' => Converter::cmToTwip(3.0),
            'marginLeft'   => Converter::cmToTwip(3.0),
            'marginRight'  => Converter::cmToTwip(2.5),
        ]);
        $this->adicionarPapelTimbrado();
    }

    protected function adicionarPapelTimbrado(): void
    {
        $imagePath = resource_path('templates/papel_timbrado.png');
        if (!file_exists($imagePath)) return;

        $header = $this->section->addHeader();
        $header->addWatermark($imagePath, [
            'marginTop' => 0, 'marginLeft' => 0,
        ]);
    }

    protected function addHeading(string $texto, int $nivel = 1): void
    {
        $this->section->addText(htmlspecialchars($texto), "Titulo{$nivel}", "Titulo{$nivel}");
    }

    protected function addParagrafo(string $texto, bool $negrito = false): void
    {
        $fontStyle = $negrito ? ['name' => 'Arial', 'size' => 12, 'bold' => true] : 'Normal';
        $this->section->addText(htmlspecialchars($texto), $fontStyle, 'Normal');
    }

    protected function addBullet(string $texto): void
    {
        $this->section->addListItem(htmlspecialchars($texto), 0, 'Normal');
    }

    protected function addQuebraDePagina(): void
    {
        $this->section->addPageBreak();
    }

    abstract public function gerar($project): string;

    protected function salvar(string $nomeArquivo): string
    {
        $path = storage_path("app/generated/{$nomeArquivo}");
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        $writer = IOFactory::createWriter($this->phpWord, 'Word2007');
        $writer->save($path);
        return $path;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\Documents\MemorialDescritivo;
use App\Services\Documents\PlanoEmergencia;
use App\Services\Documents\OficioMemorialBasico;
use App\Services\Documents\Termos;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    private array $geradores = [
        'memorial'                => MemorialDescritivo::class,
        'plano-emergencia'        => PlanoEmergencia::class,
        'oficio'                  => OficioMemorialBasico::class,
        'termo-compromisso'       => [Termos::class, 'gerarTermoCompromisso'],
        'termo-saidas-emergencia' => [Termos::class, 'gerarTermoSaidasEmergencia'],
    ];

    public function gerar(Project $project, string $tipo)
    {
        if (!isset($this->geradores[$tipo])) {
            abort(404, "Tipo de documento não encontrado: {$tipo}");
        }

        try {
            $classe = $this->geradores[$tipo];
            $path = (new $classe())->gerar($project);

            $filename = $project->codigo_interno . '-' . $tipo . '.docx';

            return response()->download($path, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao gerar documento: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $this->prepareData($request);
        $project = Project::create($data);

        return redirect()->route('projects.documents', $project)
                         ->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $this->prepareData($request);
        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projeto excluído com sucesso.');
    }

    /**
     * Custom view for project documents.
     */
    public function documents(Project $project)
    {
        return view('projects.documents', compact('project'));
    }

    /**
     * Prepare and sanitize data for storage/update.
     */
    private function prepareData(Request $request): array
    {
        $data = $request->validated();
        
        // Merge remaining fields not in validation (like specific checkboxes)
        $data = array_merge($request->all(), $data);

        // Cast JSON fields
        $jsonFields = ['ocupacoes', 'medidas_selecionadas', 'sdai_componentes', 'chuveiro_vgas', 'chuveiro_bombas', 'isolamentos'];
        foreach ($jsonFields as $field) {
            if ($request->has($field)) {
                $data[$field] = is_string($request->input($field)) ? json_decode($request->input($field), true) : $request->input($field);
            }
        }

        // Handle Checkboxes
        $checkboxes = ['tem_glp', 'tem_gerador', 'tem_subestacao', 'pne', 'area_fria', 'edificacao_existente', 'substituicao_projeto'];
        foreach ($checkboxes as $check) {
            $data[$check] = $request->has($check);
        }

        return $data;
    }
}

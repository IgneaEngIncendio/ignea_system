<x-app-layout>
    <x-slot name="header">
        <div class="precision-container pt-0 pb-0 flex justify-between items-center">
            <h2 class="precision-heading-3">
                {{ __('Projetos PCI') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="precision-btn precision-btn-primary">
                <i class="fas fa-plus"></i> Novo Projeto
            </a>
        </div>
    </x-slot>

    <div class="precision-container">
        @if(session('success'))
            <div class="precision-alert precision-alert-success">
                <i class="fas fa-check-circle text-2xl"></i>
                <div>
                    <h4 class="font-bold">Sucesso!</h4>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="precision-card">
            <div class="precision-card-header precision-flex-between">
                <div class="precision-flex">
                    <div class="icon-wrapper bg-blue-50">
                        <i class="fas fa-folder-open text-blue-600"></i>
                    </div>
                    <h2 class="precision-heading-5">Todos os Projetos</h2>
                </div>
            </div>
            
            <div class="precision-datatable-wrapper">
                <table class="precision-table" id="projects-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Obra</th>
                            <th>Proprietário</th>
                            <th>Localização</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td><span class="precision-badge precision-badge-primary">{{ $project->codigo_interno }}</span></td>
                                <td class="font-bold text-gray-900">{{ $project->nome_obra }}</td>
                                <td>{{ $project->nome_proprietario ?? '---' }}</td>
                                <td>{{ $project->cidade }} - {{ $project->estado }}</td>
                                <td class="text-right">
                                    <div class="precision-flex-center gap-1 justify-end">
                                        <a href="{{ route('projects.documents', $project) }}" class="precision-btn precision-btn-ghost" title="Documentos">
                                            <i class="fas fa-file-word text-blue-600"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}" class="precision-btn precision-btn-ghost" title="Editar">
                                            <i class="fas fa-edit text-amber-500"></i>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este projeto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="precision-btn precision-btn-ghost" title="Excluir">
                                                <i class="fas fa-trash-alt text-red-500"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center precision-p-24">
                                    <div class="precision-alert precision-alert-warning justify-center mb-0">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Nenhum projeto cadastrado. <a href="{{ route('projects.create') }}" class="font-bold underline ml-1">Clique aqui para criar o primeiro.</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

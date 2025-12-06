<div>
    @livewire('page-toolbar', [
        'title' => 'Départements',
        'breadcrumbs' => [['label' => 'Gestion', 'active' => false], ['label' => 'Départements', 'active' => true]],
        'actionLabel' => 'Créer département',
        'actionRoute' => route('departments.create'),
        'actionClass' => 'btn btn-success btn-sm',
    ])


    {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="h4">Départements</h2>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">
            Ajouter
        </a>
    </div> --}}

    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Rechercher..." class="form-control">
    </div>

    <div class="card">
        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <thead class="table-light">
                <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-150px">Nom</th>
                    <th class="min-w-200px">Description</th>
                    <th class="min-w-150px text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse($departments as $dept)
                    <tr>
                        <td class="d-flex align-items-center">
                            <a href="{{ route('departments.edit', $dept->id) }}"
                                class="text-gray-900 text-hover-primary fw-bold">{{ $dept->name }}</a>
                        </td>
                        <td class="text-truncate">{{ $dept->description }}</td>
                        <td class="text-end">
                            @include('components.table-actions', [
                                'editRoute' => 'departments.edit',
                                'id' => $dept->id,
                                'modelName' => 'Department',
                                'modelLabel' => 'département',
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Aucun département trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $departments->links() }}
    </div>
</div>

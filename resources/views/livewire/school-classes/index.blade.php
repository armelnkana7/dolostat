<div>
    @livewire('page-toolbar', [
        'title' => 'Classes',
        'breadcrumbs' => [['label' => 'Gestion Pédagogique', 'active' => false], ['label' => 'Classes', 'active' => true]],
        'actionLabel' => 'Créer classe',
        'actionRoute' => route('classes.create'),
        'actionClass' => 'btn btn-success btn-sm',
    ])

    {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="h4">Classes</h2>
        <a href="{{ route('classes.create') }}" class="btn btn-primary">
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
                    <th class="min-w-120px">Niveau</th>
                    {{-- <th class="min-w-150px">Département</th> --}}
                    <th class="min-w-150px text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse($schoolClasses as $class)
                    <tr>
                        <td class="d-flex align-items-center">
                            <a href="{{ route('classes.edit', $class->id) }}"
                                class="text-gray-900 text-hover-primary fw-bold">{{ $class->name }}</a>
                        </td>
                        <td>
                            <span class="badge badge-light-primary">{{ $class->level }}</span>
                        </td>
                        {{-- <td>{{ $class->department?->name }}</td> --}}

                        <td class="text-end">
                            <a href="{{ route('classes.show', $class->id) }}" class="btn btn-sm btn-secondary">
                                <i class="ki-duotone ki-eye fs-6">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Voir
                            </a>
                            @include('components.table-actions', [
                                'editRoute' => 'classes.edit',
                                'id' => $class->id,
                                'modelName' => 'SchoolClass',
                                'modelLabel' => 'classe',
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Aucune classe trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $schoolClasses->links() }}
    </div>
</div>

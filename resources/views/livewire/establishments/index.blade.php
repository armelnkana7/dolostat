<div>
    @livewire('page-toolbar', [
        'title' => 'Établissements',
        'breadcrumbs' => [['label' => 'Gestion', 'active' => false], ['label' => 'Établissements', 'active' => true]],
        'actionLabel' => 'Créer établissement',
        'actionRoute' => route('establishments.create'),
        'actionClass' => 'btn btn-success btn-sm',
    ])

    {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="h4">Établissements</h2>
        <a href="{{ route('establishments.create') }}" class="btn btn-primary">
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
                    <th class="min-w-125px">Nom</th>
                    <th class="min-w-125px">Code</th>
                    <th class="min-w-150px">Email</th>
                    <th class="min-w-150px text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse($establishments as $establishment)
                    <tr>
                        <td class="d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <a href="{{ route('establishments.edit', $establishment->id) }}"
                                    class="text-gray-900 text-hover-primary fw-bold">{{ $establishment->name }}</a>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-light-info">{{ $establishment->code }}</span>
                        </td>
                        <td>{{ $establishment->email }}</td>
                        <td class="text-end">
                            @include('components.table-actions', [
                                'editRoute' => 'establishments.edit',
                                'id' => $establishment->id,
                                'modelName' => 'Establishment',
                                'modelLabel' => 'établissement',
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Aucun établissement trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $establishments->links() }}
    </div>
</div>

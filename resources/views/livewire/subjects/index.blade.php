<div>
    @livewire('page-toolbar', [
        'title' => 'Matières',
        'breadcrumbs' => [['label' => 'Gestion Pédagogique', 'active' => false], ['label' => 'Matières', 'active' => true]],
        'actionLabel' => 'Créer matière',
        'actionRoute' => route('subjects.create'),
        'actionClass' => 'btn btn-success btn-sm',
    ])

    <div wire:loading>@include('components.loading-indicator')</div>
    {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="h4">Matières</h2>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">
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
                    <th class="min-w-200px">Nom</th>
                    <th class="min-w-150px">Département</th>
                    <th class="min-w-100px">Code</th>
                    <th class="min-w-150px text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse($subjects as $subject)
                    <tr wire:key="{{ $subject->id }}">
                        <td class="d-flex align-items-center">
                            <a href="{{ route('subjects.edit', $subject->id) }}"
                                class="text-gray-900 text-hover-primary fw-bold">{{ $subject->name }}</a>
                        </td>
                        <td>
                            <span class="badge badge-light-info">{{ $subject->department?->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-light-secondary">{{ $subject->code }}</span>
                        </td>
                        <td class="text-end">
                            @include('components.table-actions', [
                                'editRoute' => 'subjects.edit',
                                'id' => $subject->id,
                                'modelName' => 'Subject',
                                'modelLabel' => 'matière',
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Aucune matière trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $subjects->links() }}
    </div>
</div>

<div>
    @livewire('page-toolbar', [
        'title' => 'Années Académiques',
        'breadcrumbs' => [['label' => 'Gestion Académique', 'active' => false], ['label' => 'Années Académiques', 'active' => true]],
        'actionLabel' => 'Créer année',
        'actionRoute' => route('academic-years.create'),
        'actionClass' => 'btn btn-success btn-sm',
    ])

    {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="h4">Années Académiques</h2>
        <a href="{{ route('academic-years.create') }}" class="btn btn-primary">
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
                    <th class="min-w-150px">Établissement</th>
                    <th class="min-w-150px">Titre</th>
                    <th class="min-w-120px text-center">Début</th>
                    <th class="min-w-120px text-center">Fin</th>
                    <th class="min-w-100px text-center">État</th>
                    <th class="min-w-150px text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse($academicYears as $year)
                    <tr>
                        <td class="d-flex align-items-center">
                            <span class="badge badge-light-primary">{{ $year->establishment?->name }}</span>
                        </td>
                        <td>
                            <a href="{{ route('academic-years.edit', $year->id) }}"
                                class="text-gray-900 text-hover-primary fw-bold">{{ $year->title }}</a>
                        </td>
                        <td class="text-center">{{ $year->start_date?->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $year->end_date?->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if ($year->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @include('components.table-actions', [
                                'editRoute' => 'academic-years.edit',
                                'id' => $year->id,
                                'modelName' => 'AcademicYear',
                                'modelLabel' => 'année académique',
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucune année académique trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $academicYears->links() }}
    </div>
</div>

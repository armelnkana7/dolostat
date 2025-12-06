<div>
    @livewire('page-toolbar', [
        'title' => 'Programmes',
        'breadcrumbs' => [['label' => 'Gestion Pédagogique', 'active' => false], ['label' => 'Programmes', 'active' => true]],
        'actionLabel' => 'Créer programme',
        'actionRoute' => route('programs.create'),
        'actionClass' => 'btn btn-success btn-sm',
    ])

    {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="h4">Programmes</h2>
        <a href="{{ route('programs.create') }}" class="btn btn-primary">
            Ajouter
        </a>
    </div> --}}

    <div class="card">
        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <thead class="table-light">
                <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-150px">Classe</th>
                    <th class="min-w-150px">Matière</th>
                    <th class="min-w-120px">Département</th>
                    <th class="min-w-80px text-center">Heures</th>
                    <th class="min-w-100px text-center">Leçons</th>
                    <th class="min-w-80px text-center">TP</th>
                    <th class="min-w-150px text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse($programs as $program)
                    <tr>
                        <td class="d-flex align-items-center">
                            <a href="{{ route('programs.edit', $program->id) }}"
                                class="text-gray-900 text-hover-primary fw-bold">{{ $program->schoolClass?->name ?? $program->classe?->name }}</a>
                        </td>
                        <td>
                            <span class="badge badge-light-info">{{ $program->subject?->name }}</span>
                        </td>
                        <td>
                            <span
                                class="badge badge-light-secondary">{{ $program->subject?->department?->name ?? 'N/A' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-light-success">{{ $program->nbr_hours }}h</span>
                        </td>
                        <td class="text-center">
                            <div class="fs-7">
                                <div>{{ $program->nbr_lesson }}</div>
                                <small class="text-muted">{{ $program->nbr_lesson_dig }} dig.</small>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="fs-7">
                                <div>{{ $program->nbr_tp }}</div>
                                <small class="text-muted">{{ $program->nbr_tp_dig }} dig.</small>
                            </div>
                        </td>
                        <td class="text-end">
                            @include('components.table-actions', [
                                'editRoute' => 'programs.edit',
                                'id' => $program->id,
                                'modelName' => 'Program',
                                'modelLabel' => 'programme',
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Aucun programme trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $programs->links() }}
    </div>
</div>

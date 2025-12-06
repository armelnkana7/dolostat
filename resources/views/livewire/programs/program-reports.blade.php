<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => 'Programmes et Rapports - ' . $academicYear->title,
        'breadcrumbs' => [['label' => 'Gestion Pédagogique', 'active' => false], ['label' => 'Rapports de Programmes', 'active' => true]],
    ])

    <div class="row g-6 g-xl-9 mb-6">
        <!--begin::Col - Programs List-->
        <div class="col-xl-4">
            <div class="card h-md-100">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Programmes</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">{{ count($programs) }} programme(s)</span>
                    </h3>
                </div>
                <div class="card-body pt-3">
                    @if (empty($programs))
                        <div class="alert alert-info">
                            Aucun programme disponible pour cette année.
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach ($programs as $program)
                                <div class="p-3 border rounded cursor-pointer transition"
                                    wire:click="selectProgram({{ $program->id }})"
                                    style="background-color: {{ $selectedProgramId === $program->id ? '#f3f6f9' : 'white' }}; border-color: {{ $selectedProgramId === $program->id ? '#017a8e' : '#dee2e6' }} !important;"
                                    wire:key="program-{{ $program->id }}">
                                    <div class="fw-bold text-dark">
                                        {{ $program->schoolClass->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $program->subject->name ?? 'N/A' }}
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        @if ($selectedProgramId === $program->id)
                                            <button type="button" class="btn btn-sm btn-danger"
                                                wire:click.stop="deleteProgram({{ $program->id }})"
                                                onclick="return confirm('Êtes-vous sûr ?')">
                                                <i class="ki-duotone ki-trash"><span class="path1"></span><span
                                                        class="path2"></span></i>
                                                Supprimer
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!--end::Col - Programs List-->

        <!--begin::Col - Weekly Reports-->
        <div class="col-xl-8">
            @if ($selectedProgram)
                <div class="card h-md-100">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">
                                Rapports Hebdomadaires
                            </span>
                            <span class="text-muted mt-1 fw-semibold fs-7">
                                {{ $selectedProgram->schoolClass->name }} - {{ $selectedProgram->subject->name }}
                            </span>
                        </h3>
                    </div>
                    <div class="card-body pt-3">
                        @if (empty($weeklyReports))
                            <div class="text-center py-8">
                                <div class="mb-4">
                                    <i class="ki-duotone ki-inbox fs-3x text-muted">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                                <p class="text-muted mb-4">Aucun rapport hebdomadaire pour ce programme</p>
                                <a href="{{ route('weekly-coverage.create', ['program_id' => $selectedProgram->id]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="ki-duotone ki-plus-circle me-2"></i>
                                    Créer le premier rapport
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-muted fs-7 fw-bold">DATE</th>
                                            <th class="text-muted fs-7 fw-bold text-center">HEURES</th>
                                            <th class="text-muted fs-7 fw-bold text-center">LEÇONS</th>
                                            <th class="text-muted fs-7 fw-bold text-center">LEÇONS DIG.</th>
                                            <th class="text-muted fs-7 fw-bold text-center">TP</th>
                                            <th class="text-muted fs-7 fw-bold text-center">TP DIG.</th>
                                            <th class="text-muted fs-7 fw-bold">STATUT</th>
                                            <th class="text-end text-muted fs-7 fw-bold">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($weeklyReports as $report)
                                            <tr class="border-bottom" wire:key="r-{{ $report->id }}">
                                                <td>
                                                    <div class="badge badge-light-primary fw-bold">
                                                        {{ $report->created_at?->format('d/m/Y') ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-semibold">{{ $report->nbr_hours_done ?? 0 }}
                                                        h</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="fw-semibold">{{ $report->nbr_lesson_done ?? 0 }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="fw-semibold">{{ $report->nbr_lesson_dig_done ?? 0 }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-semibold">{{ $report->nbr_tp_done ?? 0 }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="fw-semibold">{{ $report->nbr_tp_dig_done ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $totalDone =
                                                            ($report->nbr_hours_done ?? 0) +
                                                            ($report->nbr_lesson_done ?? 0) +
                                                            ($report->nbr_lesson_dig_done ?? 0) +
                                                            ($report->nbr_tp_done ?? 0) +
                                                            ($report->nbr_tp_dig_done ?? 0);
                                                    @endphp
                                                    @if (
                                                        $totalDone >
                                                            ($selectedProgram->nbr_hours ?? 0) +
                                                                ($selectedProgram->nbr_lesson ?? 0) +
                                                                ($selectedProgram->nbr_lesson_dig ?? 0) +
                                                                ($selectedProgram->nbr_tp ?? 0) +
                                                                ($selectedProgram->nbr_tp_dig ?? 0))
                                                        <span class="badge badge-light-success">Complété</span>
                                                    @else
                                                        <span class="badge badge-light-warning">En cours</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('weekly-coverage.edit', $report->id) }}"
                                                        class="btn btn-sm btn-icon btn-light-primary me-2"
                                                        title="Modifier">
                                                        <i class="ki-duotone ki-pencil fs-6">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger"
                                                        wire:click="deleteReport({{ $report->id }})"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?')"
                                                        title="Supprimer">
                                                        <i class="ki-duotone ki-trash fs-6">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-8">
                                                    <p class="mb-0">Aucun rapport hebdomadaire pour ce programme</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <strong>{{ count($weeklyReports) }}</strong> rapport(s) trouvé(s)
                                </small>
                                <a href="{{ route('weekly-coverage.create', ['program_id' => $selectedProgram->id]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="ki-duotone ki-plus-circle me-2"></i>
                                    Ajouter un Rapport
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-10">
                        <p class="text-muted fs-6">Sélectionnez un programme pour voir ses rapports hebdomadaires</p>
                    </div>
                </div>
            @endif
        </div>
        <!--end::Col - Weekly Reports-->
    </div>
</div>

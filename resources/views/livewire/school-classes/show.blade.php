<div>
    <div>
        <!--begin::Page Toolbar-->
        @livewire('page-toolbar', [
            'title' => 'Détails de la classe: ' . $schoolClass->name,
            'breadcrumbs' => [['label' => 'Gestion Pédagogique', 'active' => false], ['label' => 'Classes', 'href' => route('classes.index'), 'active' => false], ['label' => $schoolClass->name, 'active' => true]],
        ])

        <!--begin::Card - Coverage Summary-->
        <div class="card mb-5">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Couverture Pédagogique Globale</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Résumé de la couverture pour la classe</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('classes.edit', $schoolClass) }}" class="btn btn-sm btn-light-primary">
                        <i class="ki-duotone ki-pencil fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Modifier
                    </a>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Coverage Stats Row-->
                <div class="row mb-10">
                    <!-- Overall Progress -->
                    <div class="col-lg-6">
                        <div class="alert alert-info d-flex align-items-center p-5" role="alert">
                            <div class="d-flex flex-column flex-grow-1">
                                <h5 class="mb-1">Progression Globale</h5>
                                <div class="mb-3">
                                    <div class="progress h-20px" role="progressbar"
                                        aria-valuenow="{{ round($coverage['overall_percentage'] ?? 0) }}"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ round($coverage['overall_percentage'] ?? 0) }}%"></div>
                                    </div>
                                </div>
                                <span class="fw-bold fs-6">{{ round($coverage['overall_percentage'] ?? 0) }}%
                                    complétée</span>
                            </div>
                        </div>
                    </div>

                    <!-- Programs Count -->
                    <div class="col-lg-3">
                        <div class="alert alert-warning d-flex align-items-center p-5" role="alert">
                            <div class="d-flex flex-column">
                                <h5 class="mb-1">Programmes</h5>
                                <span class="fw-bold fs-6">{{ $coverage['programs_count'] ?? 0 }} programme(s)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Count -->
                    <div class="col-lg-3">
                        <div class="alert alert-success d-flex align-items-center p-5" role="alert">
                            <div class="d-flex flex-column">
                                <h5 class="mb-1">Rapports</h5>
                                <span class="fw-bold fs-6">{{ $reports->total() }} rapport(s)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Coverage Stats Row-->

                <!--begin::Detailed Metrics Table-->
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="mb-5">Métriques Agrégées</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Métrique</th>
                                        <th class="text-center">Prévu</th>
                                        <th class="text-center">Réalisé</th>
                                        <th class="text-center">Couverture</th>
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ([
        'nbr_hours' => 'Heures',
        'nbr_lesson' => 'Cours',
        'nbr_lesson_dig' => 'Cours Numériques',
        'nbr_tp' => 'TP',
        'nbr_tp_dig' => 'TP Numériques',
    ] as $key => $label)
                                        @php
                                            $metric = $coverage['aggregated_coverage'][$key] ?? [
                                                'planned' => 0,
                                                'done' => 0,
                                                'percentage' => 0,
                                            ];
                                            $percentage = $metric['percentage'] ?? 0;
                                            $badgeClass =
                                                $percentage >= 100
                                                    ? 'badge-success'
                                                    : ($percentage >= 80
                                                        ? 'badge-warning'
                                                        : 'badge-danger');
                                            $status =
                                                $percentage >= 100
                                                    ? 'Complétée'
                                                    : ($percentage >= 80
                                                        ? 'En cours'
                                                        : 'À faire');
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $label }}</strong></td>
                                            <td class="text-center">{{ $metric['planned'] ?? 0 }}</td>
                                            <td class="text-center">{{ $metric['done'] ?? 0 }}</td>
                                            <td class="text-center">{{ round($percentage) }}%</td>
                                            <td class="text-center">
                                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::Detailed Metrics Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card - Coverage Summary-->

        <!--begin::Card - Add Weekly Report-->
        <div class="card mb-5">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Ajouter un Rapport Hebdomadaire</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Saisir un nouveau rapport de couverture</span>
                </h3>
            </div>
            <div class="card-body pt-0">
                <form wire:submit="addWeeklyReport" class="row g-3">
                    <div class="col-lg-4">
                        <label class="form-label">Programme</label>
                        <select wire:model="formData.program_id" class="form-select">
                            <option value="">-- Sélectionner --</option>
                            @foreach ($schoolClass->programs as $program)
                                <option value="{{ $program->id }}">
                                    {{ $program->subject?->name }} - {{ $program->subject?->code }}
                                </option>
                            @endforeach
                        </select>
                        @error('formData.program_id')
                            <span class="text-danger fs-8">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label">Heures réalisées</label>
                        <input type="number" wire:model="formData.nbr_hours_done" min="0" class="form-control"
                            placeholder="0">
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label">Cours réalisés</label>
                        <input type="number" wire:model="formData.nbr_lesson_done" min="0" class="form-control"
                            placeholder="0">
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label">Cours numériques</label>
                        <input type="number" wire:model="formData.nbr_lesson_dig_done" min="0"
                            class="form-control" placeholder="0">
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label">TP réalisés</label>
                        <input type="number" wire:model="formData.nbr_tp_done" min="0" class="form-control"
                            placeholder="0">
                    </div>

                    <div class="col-lg-12">
                        <label class="form-label">TP numériques</label>
                        <input type="number" wire:model="formData.nbr_tp_dig_done" min="0"
                            class="form-control" placeholder="0">
                    </div>

                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-duotone ki-plus fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Ajouter le rapport
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Card - Add Weekly Report-->

    <!--begin::Card - Weekly Reports List-->
    <div class="card mb-5">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Rapports Hebdomadaires</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Liste des rapports de couverture</span>
            </h3>
        </div>
        <div class="card-body pt-0">
            @forelse($reports as $report)
                <div class="card card-flush mb-4 border-light">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="mb-2">
                                    <strong>Rapport #{{ $report->id }}</strong>
                                    <span class="badge badge-light-info ms-2">
                                        {{ $report->created_at->format('d/m/Y à H:i') }}
                                    </span>
                                </h6>
                                <p class="text-muted fs-8 mb-2">
                                    <strong>Programme:</strong> {{ $report->program?->subject?->name ?? 'N/A' }}
                                </p>
                                <p class="text-muted fs-8 mb-0">
                                    <strong>Créé par:</strong> {{ $report->recordedBy?->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column gap-2">
                                    <div class="fs-8">
                                        <span class="fw-semibold">Heures:</span>
                                        <span
                                            class="badge badge-light-primary">{{ $report->nbr_hours_done ?? 0 }}</span>
                                    </div>
                                    <div class="fs-8">
                                        <span class="fw-semibold">Cours:</span>
                                        <span
                                            class="badge badge-light-success">{{ $report->nbr_lesson_done ?? 0 }}</span>
                                    </div>
                                    <div class="fs-8">
                                        <span class="fw-semibold">TP:</span>
                                        <span class="badge badge-light-warning">{{ $report->nbr_tp_done ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="{{ route('weekly-coverage.edit', $report) }}"
                                    class="btn btn-sm btn-light-info ms-2">
                                    <i class="ki-duotone ki-pencil fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Éditer
                                </a>
                                <button
                                    onclick="if(confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?')) { @this.call('delete', {{ $report->id }}) }"
                                    class="btn btn-sm btn-light-danger ms-2">
                                    <i class="ki-duotone ki-trash fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-light" role="alert">
                    <i class="ki-duotone ki-information fs-2 me-2"></i>
                    Aucun rapport de couverture pour cette classe.
                </div>
            @endforelse

            <!--begin::Pagination-->
            <div class="mt-5">
                {{ $reports->links() }}
            </div>
            <!--end::Pagination-->
        </div>
    </div>
    <!--end::Card - Weekly Reports List-->

    <!--begin::Card - Generate Reports-->
    <div class="card mb-5">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Générer des États</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Exporter les données de couverture</span>
            </h3>
        </div>
        <div class="card-body pt-0">
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="card bg-light-primary border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ki-duotone ki-file-pdf fs-2hx text-danger me-3"></i>
                                <div>
                                    <h6 class="mb-0">Exporter en PDF</h6>
                                    <p class="text-muted fs-8">Rapport de couverture pédagogique</p>
                                </div>
                            </div>
                            <button wire:click="generatePdf" class="btn btn-sm btn-danger w-100">
                                <i class="ki-duotone ki-download-2 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Télécharger PDF
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card bg-light-success border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ki-duotone ki-file-excel fs-2hx text-success me-3"></i>
                                <div>
                                    <h6 class="mb-0">Exporter en Excel</h6>
                                    <p class="text-muted fs-8">Détails de couverture par programme</p>
                                </div>
                            </div>
                            <button wire:click="generateExcel" class="btn btn-sm btn-success w-100">
                                <i class="ki-duotone ki-download-2 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Télécharger Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card - Generate Reports-->

    <!--begin::Back Button-->
    <div class="mt-4">
        <a href="{{ route('classes.index') }}" class="btn btn-light">
            <i class="ki-duotone ki-arrow-left fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            Retour à la liste
        </a>
    </div>
    <!--end::Back Button-->
</div>

<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => 'Rapports de Couverture Pédagogique',
        'breadcrumbs' => [['label' => 'Rapports', 'active' => false], ['label' => 'Couverture', 'active' => true]],
    ])

    <div wire:loading>@include('components.loading-indicator')</div>
    <!--begin::Card - Global Statistics-->
    <div class="card mb-5">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Statistiques Globales</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Résumé de la couverture générale</span>
            </h3>
            <div class="card-toolbar gap-2">
                <button wire:click="exportCsv" class="btn btn-sm btn-light-success">
                    <i class="ki-duotone ki-file-down fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    CSV
                </button>
                <button wire:click="exportExcel" class="btn btn-sm btn-light-info">
                    <i class="ki-duotone ki-file-down fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Excel
                </button>
                <button wire:click="exportPdf" class="btn btn-sm btn-light-danger">
                    <i class="ki-duotone ki-file-down fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    PDF
                </button>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row g-4">
                <!-- Couverture Globale -->
                <div class="col-lg-3">
                    <div class="d-flex flex-column">
                        <label class="mb-2 fw-semibold text-muted">Couverture Globale</label>
                        @php
                            $globalPercentage = $global['coverage_percentage'] ?? 0;
                        @endphp
                        <div class="progress h-30px" role="progressbar" aria-valuenow="{{ $globalPercentage }}"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar {{ $globalPercentage >= 80 ? 'bg-success' : ($globalPercentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                style="width: {{ $globalPercentage }}%"></div>
                        </div>
                        <span class="fw-bold fs-6 mt-2">{{ $globalPercentage }}%</span>
                    </div>
                </div>

                <!-- Programmes -->
                <div class="col-lg-3">
                    <div class="d-flex flex-column">
                        <label class="mb-2 fw-semibold text-muted">Programmes</label>
                        <span class="fw-bold fs-2 text-primary">{{ $global['programs_count'] ?? 0 }}</span>
                        <span class="text-muted fs-7">Total créés</span>
                    </div>
                </div>

                <!-- Rapports -->
                <div class="col-lg-3">
                    <div class="d-flex flex-column">
                        <label class="mb-2 fw-semibold text-muted">Rapports</label>
                        <span class="fw-bold fs-2 text-success">{{ $global['reports_count'] ?? 0 }}</span>
                        <span class="text-muted fs-7">Saisis</span>
                    </div>
                </div>

                <!-- Métriques -->
                <div class="col-lg-3">
                    <div class="d-flex flex-column gap-2">
                        <div class="fw-semibold text-muted fs-7">Heures:
                            <span
                                class="text-dark">{{ $global['total_done']['hours'] ?? 0 }}/{{ $global['total_planned']['hours'] ?? 0 }}</span>
                        </div>
                        <div class="fw-semibold text-muted fs-7">Cours:
                            <span
                                class="text-dark">{{ $global['total_done']['lesson'] ?? 0 }}/{{ $global['total_planned']['lesson'] ?? 0 }}</span>
                        </div>
                        <div class="fw-semibold text-muted fs-7">TP:
                            <span
                                class="text-dark">{{ $global['total_done']['tp'] ?? 0 }}/{{ $global['total_planned']['tp'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card - Global Statistics-->

    <!--begin::Card - Filter Tabs-->
    <div class="card mb-5">
        <div class="card-header border-0">
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-0" role="tablist">
                <li class="nav-item" role="presentation">
                    <button wire:click="setFilter('class')"
                        class="nav-link {{ $filterType === 'class' ? 'active' : '' }}" data-bs-target="#classes-tab"
                        type="button" role="tab">
                        <i class="ki-duotone ki-group fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Par Classe
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button wire:click="setFilter('department')"
                        class="nav-link {{ $filterType === 'department' ? 'active' : '' }}"
                        data-bs-target="#departments-tab" type="button" role="tab">
                        <i class="ki-duotone ki-folder fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Par Département
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button wire:click="setFilter('subject')"
                        class="nav-link {{ $filterType === 'subject' ? 'active' : '' }}" data-bs-target="#subjects-tab"
                        type="button" role="tab">
                        <i class="ki-duotone ki-book fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Par Matière
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            @if ($data->isEmpty())
                <div class="alert alert-info">
                    <i class="ki-duotone ki-information fs-2 me-2"></i>
                    Aucune donnée disponible pour ce filtre
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th class="text-center">Éléments</th>
                                <th class="text-center">Heures</th>
                                <th class="text-center">Cours</th>
                                <th class="text-center">TP</th>
                                <th class="text-center">Couverture</th>
                                <th class="text-center">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item['name'] ?? 'N/A' }}</strong>
                                        @if (isset($item['code']))
                                            <small class="text-muted d-block">({{ $item['code'] }})</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-light-primary">
                                            {{ $item['programs_count'] ?? ($item['classes_count'] ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            {{ $item['total_done']['hours'] ?? 0 }}/{{ $item['total_planned']['hours'] ?? 0 }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            {{ $item['total_done']['lesson'] ?? 0 }}/{{ $item['total_planned']['lesson'] ?? 0 }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            {{ $item['total_done']['tp'] ?? 0 }}/{{ $item['total_planned']['tp'] ?? 0 }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $percentage = $item['coverage_percentage'] ?? 0;
                                        @endphp
                                        <div class="progress h-20px" role="progressbar"
                                            aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                            aria-valuemax="100" style="min-width: 100px;">
                                            <div class="progress-bar {{ $percentage >= 80 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($percentage >= 100)
                                            <span class="badge badge-success">Complétée</span>
                                        @elseif($percentage >= 80)
                                            <span class="badge badge-warning">En cours</span>
                                        @elseif($percentage >= 50)
                                            <span class="badge badge-info">Partielle</span>
                                        @else
                                            <span class="badge badge-danger">Retard</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Stats détaillées -->
                <div class="mt-5">
                    <h6 class="mb-3">Résumé par Métrique</h6>
                    <div class="row g-3">
                        @php
                            $totalMetrics = [
                                'hours' => 0,
                                'lesson' => 0,
                                'lesson_dig' => 0,
                                'tp' => 0,
                                'tp_dig' => 0,
                            ];
                            $totalDoneMetrics = [
                                'hours' => 0,
                                'lesson' => 0,
                                'lesson_dig' => 0,
                                'tp' => 0,
                                'tp_dig' => 0,
                            ];

                            foreach ($data as $item) {
                                $totalMetrics['hours'] += $item['total_planned']['hours'];
                                $totalMetrics['lesson'] += $item['total_planned']['lesson'];
                                $totalMetrics['lesson_dig'] += $item['total_planned']['lesson_dig'];
                                $totalMetrics['tp'] += $item['total_planned']['tp'];
                                $totalMetrics['tp_dig'] += $item['total_planned']['tp_dig'];

                                $totalDoneMetrics['hours'] += $item['total_done']['hours'];
                                $totalDoneMetrics['lesson'] += $item['total_done']['lesson'];
                                $totalDoneMetrics['lesson_dig'] += $item['total_done']['lesson_dig'];
                                $totalDoneMetrics['tp'] += $item['total_done']['tp'];
                                $totalDoneMetrics['tp_dig'] += $item['total_done']['tp_dig'];
                            }
                        @endphp

                        @foreach ([
        'hours' => ['label' => 'Heures', 'color' => 'primary'],
        'lesson' => ['label' => 'Cours', 'color' => 'success'],
        'tp' => ['label' => 'TP', 'color' => 'warning'],
    ] as $key => $metric)
                            <div class="col-md-4">
                                <div class="card bg-light-{{ $metric['color'] }}">
                                    <div class="card-body">
                                        <h6 class="mb-2">{{ $metric['label'] }}</h6>
                                        <div class="fw-bold fs-5 mb-2">
                                            {{ $totalDoneMetrics[$key] }}/{{ $totalMetrics[$key] }}
                                        </div>
                                        <div class="progress h-20px">
                                            <div class="progress-bar bg-{{ $metric['color'] }}"
                                                style="width: {{ $totalMetrics[$key] > 0 ? ($totalDoneMetrics[$key] / $totalMetrics[$key]) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!--end::Card - Filter Tabs-->
</div>

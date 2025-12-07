<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => 'Tableau de Bord - Censeur Pédagogique',
        'breadcrumbs' => [['label' => 'Accueil', 'active' => false], ['label' => 'Tableau de Bord', 'active' => true]],
    ])

    <!--begin::Statistics Row-->
    <div class="row mb-5 g-6 g-xl-9">
        <!-- Total Classes -->
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('classes.index') }}" class="card bg-light-primary text-hover-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-teaching fs-2hx text-primary"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-2">{{ $stats['total_classes'] }}</h3>
                            <span
                                class="fw-semibold text-muted">Classe{{ $stats['total_classes'] > 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Programs -->
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('programs.index') }}" class="card bg-light-success text-hover-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-document fs-2hx text-success"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-2">{{ $stats['total_programs'] }}</h3>
                            <span
                                class="fw-semibold text-muted">Programme{{ $stats['total_programs'] > 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Reports -->
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('reports.coverage') }}" class="card bg-light-info text-hover-info shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-chart-line fs-2hx text-info"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-2">{{ $stats['total_reports'] }}</h3>
                            <span
                                class="fw-semibold text-muted">Rapport{{ $stats['total_reports'] > 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Average Coverage -->
        <div class="col-md-6 col-xl-3">
            <div class="card bg-light-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-chart-pie-3 fs-2hx text-warning"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-2">{{ $stats['avg_coverage'] }}%</h3>
                            <span class="fw-semibold text-muted">Couverture Moy.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Statistics Row-->

    <!--begin::Two Column Row-->
    <div class="row mb-5 g-6 g-xl-9">
        <!-- Classes by Coverage -->
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3">Couverture par Classe</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Top 10</span>
                    </h3>
                </div>
                <div class="card-body pt-5">
                    @forelse($classesByCoverage as $class)
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1 me-4">
                                <span class="text-gray-800 fw-bold">{{ $class['name'] }}</span>
                            </div>
                            <div class="progress" style="width: 150px; height: 8px;">
                                <div class="progress-bar {{ $class['coverage'] >= 80 ? 'bg-success' : ($class['coverage'] >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                    style="width: {{ $class['coverage'] }}%"></div>
                            </div>
                            <span class="text-gray-600 fw-bold ms-3"
                                style="width: 50px;">{{ $class['coverage'] }}%</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-10">
                            <p>Aucune donnée disponible</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pending vs Completed -->
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3">État des Rapports</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Résumé d'activité</span>
                    </h3>
                </div>
                <div class="card-body pt-5">
                    <div class="row g-5">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px symbol-light-success me-3">
                                    <div class="symbol-label">
                                        <i class="ki-duotone ki-check fs-1 text-success"><span
                                                class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>
                                <div>
                                    <span class="fs-4 fw-semibold text-gray-400 d-block">Complétés</span>
                                    <h3 class="fw-bold">{{ $stats['total_reports'] - $stats['pending_reports'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px symbol-light-warning me-3">
                                    <div class="symbol-label">
                                        <i class="ki-duotone ki-hourglass fs-1 text-warning"><span
                                                class="path1"></span><span class="path2"></span></i>
                                    </div>
                                </div>
                                <div>
                                    <span class="fs-4 fw-semibold text-gray-400 d-block">En Attente</span>
                                    <h3 class="fw-bold">{{ $stats['pending_reports'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Two Column Row-->

    <!--begin::Recent Reports-->
    <div class="card shadow-sm">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3">Rapports Récents</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Dernières mises à jour</span>
            </h3>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-muted">
                            <th class="min-w-150px">Classe</th>
                            <th class="min-w-150px">Matière</th>
                            <th class="min-w-100px">Couverture</th>
                            <th class="min-w-100px">Statut</th>
                            <th class="min-w-100px">Mise à Jour</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReports as $report)
                            <tr>
                                <td>
                                    <a href="{{ route('classes.show', $report->program->schoolClass) }}"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        {{ $report->program->schoolClass->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('subjects.edit', $report->program->subject) }}"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        {{ $report->program->subject->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress" style="width: 100%; height: 5px;" role="progressbar">
                                            <div class="progress-bar {{ $report->coverage_percentage >= 80 ? 'bg-success' : ($report->coverage_percentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                                style="width: {{ $report->coverage_percentage }}%"></div>
                                        </div>
                                        <span
                                            class="ms-2 fw-bold">{{ round($report->coverage_percentage, 1) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-light-{{ $report->coverage_percentage >= 80 ? 'success' : ($report->coverage_percentage >= 50 ? 'warning' : 'danger') }}">
                                        {{ $report->coverage_percentage >= 80 ? 'Bon' : ($report->coverage_percentage >= 50 ? 'Moyen' : 'Faible') }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $report->updated_at->diffForHumans() }}</td>
                                <td class="text-end">
                                    <a href="{{ route('reports.coverage') }}?filter_type=class&filter_id={{ $report->program->schoolClass->id }}"
                                        class="btn btn-sm btn-icon btn-bg-light btn-active-light-primary">
                                        <i class="ki-duotone ki-arrow-right fs-2"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10">
                                    <span class="text-muted">Aucun rapport disponible</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end::Recent Reports-->
</div>

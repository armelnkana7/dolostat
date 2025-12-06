<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => 'Tableau de Bord Administrateur',
        'breadcrumbs' => [['label' => 'Accueil', 'active' => false], ['label' => 'Tableau de Bord', 'active' => true]],
    ])

    <!--begin::Statistics Row 1-->
    <div class="row mb-5 g-6 g-xl-9">
        <!-- Total Classes -->
        <div class="col-md-6 col-xl-4">
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

        <!-- Total Departments -->
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('departments.index') }}" class="card bg-light-success text-hover-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-folder-2 fs-2hx text-success"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-2">{{ $stats['total_departments'] }}</h3>
                            <span
                                class="fw-semibold text-muted">Département{{ $stats['total_departments'] > 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Subjects -->
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('subjects.index') }}" class="card bg-light-info text-hover-info shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-book fs-2hx text-info"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-2">{{ $stats['total_subjects'] }}</h3>
                            <span
                                class="fw-semibold text-muted">Matière{{ $stats['total_subjects'] > 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!--end::Statistics Row 1-->

    <!--begin::Statistics Row 2-->
    <div class="row mb-5 g-6 g-xl-9">
        <!-- Total Programs -->
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('programs.index') }}" class="card bg-light-warning text-hover-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-document fs-2hx text-warning"><span class="path1"></span><span
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

        <!-- Total Planned Hours -->
        <div class="col-md-6 col-xl-4">
            <div class="card bg-light-danger shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-calendar fs-2hx text-danger"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-2">{{ $stats['total_planned_hours'] }}</h3>
                            <span class="fw-semibold text-muted">Heures Planifiées</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Coverage -->
        <div class="col-md-6 col-xl-4">
            <div class="card bg-light-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-chart-pie-3 fs-2hx text-primary"><span class="path1"></span><span
                                class="path2"></span></i>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-2">{{ $stats['avg_coverage'] }}%</h3>
                            <span class="fw-semibold text-muted">Couverture Moyenne</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Statistics Row 2-->

    <!--begin::Recent Reports-->
    <div class="card shadow-sm">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3">Rapports Récents</span>
                <span class="text-muted mt-1 fw-semibold fs-7">{{ $stats['total_reports'] }}
                    rapport{{ $stats['total_reports'] > 1 ? 's' : '' }} total</span>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReports as $report)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('classes.show', $report->program->schoolClass) }}"
                                                class="text-gray-800 text-hover-primary fw-bold">
                                                {{ $report->program->schoolClass->name ?? 'N/A' }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('subjects.show', $report->program->subject) }}"
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
                                        <span class="ms-2 fw-bold">{{ round($report->coverage_percentage, 1) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-light-{{ $report->coverage_percentage >= 80 ? 'success' : ($report->coverage_percentage >= 50 ? 'warning' : 'danger') }}">
                                        {{ $report->coverage_percentage >= 80 ? 'Bon' : ($report->coverage_percentage >= 50 ? 'Moyen' : 'Faible') }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted">{{ $report->updated_at->diffForHumans() }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10">
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

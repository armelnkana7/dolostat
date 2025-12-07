<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => 'Tableau de Bord - Animateur Pédagogique',
        'breadcrumbs' => [['label' => 'Accueil', 'active' => false], ['label' => 'Tableau de Bord', 'active' => true]],
    ])

    <!--begin::Statistics Row-->
    <div class="row mb-5 g-6 g-xl-9">
        <!-- My Programs -->
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('programs.index') }}" class="card bg-light-primary text-hover-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-document fs-2hx text-primary"><span class="path1"></span><span
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

        <!-- My Classes -->
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('classes.index') }}" class="card bg-light-success text-hover-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-teaching fs-2hx text-success"><span class="path1"></span><span
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
                            <h3 class="fw-bold mb-2">{{ $stats['coverage_status'] }}%</h3>
                            <span class="fw-semibold text-muted">Couverture Moy.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Statistics Row-->

    <!--begin::My Classes-->
    <div class="card mb-5 shadow-sm">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3">Mes Classes</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Classes de mon département</span>
            </h3>
        </div>
        <div class="card-body pt-5">
            <div class="row g-6 g-xl-9">
                @forelse($myClasses as $class)
                    @if ($class->programs->count() > 0)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('classes.show', $class) }}"
                                class="card bg-light border-hover shadow-sm text-decoration-none">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="symbol symbol-50px symbol-light-primary mx-auto mb-3">
                                            <span class="symbol-label bg-primary">
                                                <i class="ki-duotone ki-teaching text-white fs-1"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                            </span>
                                        </div>
                                        <h6 class="card-title fw-bold text-gray-900">{{ $class->name }}</h6>
                                        <span class="text-muted fs-7">{{ $class->level }}</span>
                                        <div class="mt-3">
                                            <span class="badge badge-light-primary">{{ $class->programs->count() }}
                                                programme{{ $class->programs->count() > 1 ? 's' : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="ki-duotone ki-information-5 fs-2"><span class="path1"></span><span
                                    class="path2"></span></i>
                            <span class="ms-3">Vous n'avez pas de classe assignée dans votre département.</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!--end::My Classes-->

    <!--begin::Recent Reports-->
    <div class="card shadow-sm">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3">Rapports Récents</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Dernières mises à jour de mes programmes</span>
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
                                    <a href="{{ route('classes.show', $report->program->schoolClass) }}"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        {{ $report->program->schoolClass->name ?? 'N/A' }}
                                    </a>
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

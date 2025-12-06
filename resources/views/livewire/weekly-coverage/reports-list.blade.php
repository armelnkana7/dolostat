@php
    $plan_hours = $program->nbr_hours ?? 0;
    $plan_lesson = $program->nbr_lesson ?? 0;
    $plan_lesson_dig = $program->nbr_lesson_dig ?? 0;
    $plan_tp = $program->nbr_tp ?? 0;
    $plan_tp_dig = $program->nbr_tp_dig ?? 0;

    $total_done_hours = $reports->sum('nbr_hours_done');
    $total_done_lesson = $reports->sum('nbr_lesson_done');
    $total_done_lesson_dig = $reports->sum('nbr_lesson_dig_done');
    $total_done_tp = $reports->sum('nbr_tp_done');
    $total_done_tp_dig = $reports->sum('nbr_tp_dig_done');

    $percentage_hours = $plan_hours > 0 ? round(($total_done_hours / $plan_hours) * 100, 2) : 0;
    $percentage_lesson = $plan_lesson > 0 ? round(($total_done_lesson / $plan_lesson) * 100, 2) : 0;
    $percentage_lesson_dig = $plan_lesson_dig > 0 ? round(($total_done_lesson_dig / $plan_lesson_dig) * 100, 2) : 0;
    $percentage_tp = $plan_tp > 0 ? round(($total_done_tp / $plan_tp) * 100, 2) : 0;
    $percentage_tp_dig = $plan_tp_dig > 0 ? round(($total_done_tp_dig / $plan_tp_dig) * 100, 2) : 0;

    $total_planned = $plan_hours + $plan_lesson + $plan_lesson_dig + $plan_tp + $plan_tp_dig;
    $total_done = $total_done_hours + $total_done_lesson + $total_done_lesson_dig + $total_done_tp + $total_done_tp_dig;
    $overall_percentage = $total_planned > 0 ? round(($total_done / $total_planned) * 100, 2) : 0;
@endphp

<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Rapports de couverture hebdomadaire') }}</h5>
            <a href="{{ route('weekly-coverage.create', ['program_id' => $program->id]) }}"
                class="btn btn-sm btn-primary">
                <i class="icon-plus me-2"></i> {{ __('Ajouter') }}
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Indicateurs de couverture -->
        <div class="row mb-4">
            <!-- Heures -->
            <div class="col-md-4 mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">{{ __('Heures') }}</small>
                    <small class="fw-bold">{{ $total_done_hours }}/{{ $plan_hours }}</small>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="{{ $percentage_hours }}" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar @if ($percentage_hours >= 100) bg-success @elseif($percentage_hours >= 75) bg-info @elseif($percentage_hours >= 50) bg-warning @else bg-danger @endif"
                        style="width: {{ min($percentage_hours, 100) }}%"></div>
                </div>
                <small class="text-muted">{{ $percentage_hours }}%</small>
            </div>

            <!-- Leçons -->
            <div class="col-md-4 mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">{{ __('Leçons') }}</small>
                    <small class="fw-bold">{{ $total_done_lesson }}/{{ $plan_lesson }}</small>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="{{ $percentage_lesson }}" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar @if ($percentage_lesson >= 100) bg-success @elseif($percentage_lesson >= 75) bg-info @elseif($percentage_lesson >= 50) bg-warning @else bg-danger @endif"
                        style="width: {{ min($percentage_lesson, 100) }}%"></div>
                </div>
                <small class="text-muted">{{ $percentage_lesson }}%</small>
            </div>

            <!-- Leçons digitalisées -->
            <div class="col-md-4 mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">{{ __('Leçons digitalisées') }}</small>
                    <small class="fw-bold">{{ $total_done_lesson_dig }}/{{ $plan_lesson_dig }}</small>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="{{ $percentage_lesson_dig }}" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar @if ($percentage_lesson_dig >= 100) bg-success @elseif($percentage_lesson_dig >= 75) bg-info @elseif($percentage_lesson_dig >= 50) bg-warning @else bg-danger @endif"
                        style="width: {{ min($percentage_lesson_dig, 100) }}%"></div>
                </div>
                <small class="text-muted">{{ $percentage_lesson_dig }}%</small>
            </div>

            <!-- TP -->
            <div class="col-md-4 mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">{{ __('TP') }}</small>
                    <small class="fw-bold">{{ $total_done_tp }}/{{ $plan_tp }}</small>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="{{ $percentage_tp }}" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar @if ($percentage_tp >= 100) bg-success @elseif($percentage_tp >= 75) bg-info @elseif($percentage_tp >= 50) bg-warning @else bg-danger @endif"
                        style="width: {{ min($percentage_tp, 100) }}%"></div>
                </div>
                <small class="text-muted">{{ $percentage_tp }}%</small>
            </div>

            <!-- TP digitalisés -->
            <div class="col-md-4 mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">{{ __('TP digitalisés') }}</small>
                    <small class="fw-bold">{{ $total_done_tp_dig }}/{{ $plan_tp_dig }}</small>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="{{ $percentage_tp_dig }}" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar @if ($percentage_tp_dig >= 100) bg-success @elseif($percentage_tp_dig >= 75) bg-info @elseif($percentage_tp_dig >= 50) bg-warning @else bg-danger @endif"
                        style="width: {{ min($percentage_tp_dig, 100) }}%"></div>
                </div>
                <small class="text-muted">{{ $percentage_tp_dig }}%</small>
            </div>

            <!-- Couverture globale -->
            <div class="col-md-4 mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted"><strong>{{ __('Couverture globale') }}</strong></small>
                    <small class="fw-bold">{{ $total_done }}/{{ $total_planned }}</small>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="{{ $overall_percentage }}" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar @if ($overall_percentage >= 100) bg-success @elseif($overall_percentage >= 75) bg-info @elseif($overall_percentage >= 50) bg-warning @else bg-danger @endif"
                        style="width: {{ min($overall_percentage, 100) }}%"></div>
                </div>
                <small class="text-muted"><strong>{{ $overall_percentage }}%</strong></small>
            </div>
        </div>

        <!-- Tableau des rapports -->
        @if ($reports->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th class="text-center">{{ __('Heures réalisées') }}</th>
                            <th class="text-center">{{ __('Leçons réalisées') }}</th>
                            <th class="text-center">{{ __('Leçons digitalisées') }}</th>
                            <th class="text-center">{{ __('TP réalisés') }}</th>
                            <th class="text-center">{{ __('TP digitalisés') }}</th>
                            <th class="text-center">{{ __('Par') }}</th>
                            <th class="text-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">{{ $report->nbr_hours_done }}</td>
                                <td class="text-center">{{ $report->nbr_lesson_done }}</td>
                                <td class="text-center">{{ $report->nbr_lesson_dig_done }}</td>
                                <td class="text-center">{{ $report->nbr_tp_done }}</td>
                                <td class="text-center">{{ $report->nbr_tp_dig_done }}</td>
                                <td class="text-center"><small>{{ $report->recordedBy?->name ?? 'N/A' }}</small></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:click="deleteReport({{ $report->id }})"
                                        onclick="confirm('{{ __('Êtes-vous sûr ?') }}') || event.stopImmediatePropagation()">
                                        <i class="icon-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    {{ __('Aucun rapport enregistré') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info" role="alert">
                {{ __('Aucun rapport de couverture enregistré pour ce programme.') }}
            </div>
        @endif
    </div>
</div>

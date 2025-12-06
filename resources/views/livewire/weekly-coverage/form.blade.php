@php
    $plan_hours = $program?->nbr_hours ?? 0;
    $plan_lesson = $program?->nbr_lesson ?? 0;
    $plan_lesson_dig = $program?->nbr_lesson_dig ?? 0;
    $plan_tp = $program?->nbr_tp ?? 0;
    $plan_tp_dig = $program?->nbr_tp_dig ?? 0;
@endphp

<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => $isEditing ? 'Modifier le rapport' : 'Créer un rapport',
        'breadcrumbs' => [['label' => 'Rapports', 'active' => false], ['label' => $isEditing ? 'Édition' : 'Création', 'active' => true]],
    ])
    <!--end::Page Toolbar-->

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 mt-5">
                {{ $isEditing ? __('Modifier un rapport hebdomadaire') : __('Ajouter un rapport hebdomadaire') }}
                @if ($program)
                    <small class="text-muted d-block mt-2">
                        {{ $program->subject?->name ?? 'N/A' }} - {{ $program->schoolClass?->name ?? 'N/A' }}
                    </small>
                @endif
            </h5>
        </div>

        <div class="card-body">
            <form wire:submit.prevent="save">
                @if (!$isEditing && !$program)
                    <!-- Sélection du programme (création uniquement) -->
                    <div class="mb-4">
                        <label for="program_id" class="form-label">{{ __('Sélectionner un programme') }} <span
                                class="text-danger">*</span></label>
                        <select id="program_id" wire:model="program_id"
                            class="form-select @error('program_id') is-invalid @enderror" required>
                            <option value="">-- Choisir un programme --</option>
                            @foreach (\App\Models\Program::with('subject', 'schoolClass')->get() as $prog)
                                <option value="{{ $prog->id }}">
                                    {{ $prog->subject?->name }} - {{ $prog->schoolClass?->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('program_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <div class="row">
                    <!-- Heures réalisées -->
                    <div class="col-md-6 mb-3">
                        <label for="nbr_hours_done" class="form-label">
                            {{ __('Heures réalisées') }}
                            <small class="text-muted">(Planifié: {{ $plan_hours }})</small>
                        </label>
                        <input type="number" class="form-control @error('nbr_hours_done') is-invalid @enderror"
                            id="nbr_hours_done" wire:model.defer="nbr_hours_done" min="0" required>
                        @error('nbr_hours_done')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Leçons réalisées -->
                    <div class="col-md-6 mb-3">
                        <label for="nbr_lesson_done" class="form-label">
                            {{ __('Leçons réalisées') }}
                            <small class="text-muted">(Planifié: {{ $plan_lesson }})</small>
                        </label>
                        <input type="number" class="form-control @error('nbr_lesson_done') is-invalid @enderror"
                            id="nbr_lesson_done" wire:model.defer="nbr_lesson_done" min="0" required>
                        @error('nbr_lesson_done')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Leçons digitalisées réalisées -->
                    <div class="col-md-6 mb-3">
                        <label for="nbr_lesson_dig_done" class="form-label">
                            {{ __('Leçons digitalisées réalisées') }}
                            <small class="text-muted">(Planifié: {{ $plan_lesson_dig }})</small>
                        </label>
                        <input type="number" class="form-control @error('nbr_lesson_dig_done') is-invalid @enderror"
                            id="nbr_lesson_dig_done" wire:model.defer="nbr_lesson_dig_done" min="0" required>
                        @error('nbr_lesson_dig_done')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TP réalisés -->
                    <div class="col-md-6 mb-3">
                        <label for="nbr_tp_done" class="form-label">
                            {{ __('TP réalisés') }}
                            <small class="text-muted">(Planifié: {{ $plan_tp }})</small>
                        </label>
                        <input type="number" class="form-control @error('nbr_tp_done') is-invalid @enderror"
                            id="nbr_tp_done" wire:model.defer="nbr_tp_done" min="0" required>
                        @error('nbr_tp_done')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TP digitalisés réalisés -->
                    <div class="col-md-6 mb-3">
                        <label for="nbr_tp_dig_done" class="form-label">
                            {{ __('TP digitalisés réalisés') }}
                            <small class="text-muted">(Planifié: {{ $plan_tp_dig }})</small>
                        </label>
                        <input type="number" class="form-control @error('nbr_tp_dig_done') is-invalid @enderror"
                            id="nbr_tp_dig_done" wire:model.defer="nbr_tp_dig_done" min="0" required>
                        @error('nbr_tp_dig_done')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-check fs-2 me-2"><span class="path1"></span><span
                                class="path2"></span></i>
                        {{ $isEditing ? __('Modifier') : __('Créer') }}
                    </button>
                    @if ($program?->schoolClass)
                        <a href="{{ route('classes.show', $program->schoolClass) }}" class="btn btn-outline-secondary">
                            {{ __('Annuler') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

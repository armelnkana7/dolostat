@php
    use App\Helpers\AcademicYearHelper;
    $userRole = auth()->user()->roles->first()?->name;
@endphp

<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => 'Gestion des Programmes - ' . AcademicYearHelper::getYearLabel($academicYear),
        'breadcrumbs' => [['label' => 'Gestion Pédagogique', 'active' => false], ['label' => 'Programmes', 'active' => true]],
    ])

    <div wire:loading>@include('components.loading-indicator')</div>
    <!--begin::Card - Classes Selection-->
    <div class="card mb-5">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Sélectionner une Classe</span>
                <span class="text-muted mt-1 fw-semibold fs-7">
                    @if ($userRole === 'pedagogical_animator')
                        Vos classes assignées
                    @elseif($userRole === 'censor')
                        Toutes les classes de l'établissement
                    @else
                        Classes disponibles
                    @endif
                </span>
            </h3>
        </div>
        <div class="card-body pt-0">
            <div class="row g-3">
                @forelse($classes as $class)
                    <div class="col-lg-4">
                        <button wire:click="selectClass({{ $class->id }})"
                            class="btn btn-outline btn-outline-secondary w-100 {{ $schoolClass?->id === $class->id ? 'active btn-secondary' : '' }}">
                            <i class="ki-duotone ki-group fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span class="ms-2">{{ $class->name }}</span>
                        </button>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="ki-duotone ki-information fs-2 me-2"></i>
                            Aucune classe disponible
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!--end::Card - Classes Selection-->

    @if ($schoolClass)
        <!--begin::Card - Programs for Selected Class-->
        <div class="card mb-5">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">
                        Programmes de {{ $schoolClass->name }}
                    </span>
                    <span class="text-muted mt-1 fw-semibold fs-7">
                        Année académique: {{ AcademicYearHelper::getYearLabel($academicYear) }}
                    </span>
                </h3>
                <div class="card-toolbar">
                    <button wire:click="$toggle('showForm')" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Ajouter un Programme
                    </button>
                </div>
            </div>

            @if ($showForm)
                <div class="card-body border-top pt-5">
                    <form wire:submit="{{ $editingProgram ? 'updateProgram' : 'addProgram' }}" class="row g-3">
                        <!-- Matière -->
                        <div class="col-lg-6">
                            <label class="form-label">Matière <span class="text-danger">*</span></label>
                            <select wire:model="subject_id"
                                class="form-select @error('subject_id') is-invalid @enderror">
                                <option value="">-- Sélectionner une matière --</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">
                                        {{ $subject->name }} ({{ $subject->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Heures -->
                        <div class="col-lg-2">
                            <label class="form-label">Heures <span class="text-danger">*</span></label>
                            <input type="number" wire:model="nbr_hours" min="0"
                                class="form-control @error('nbr_hours') is-invalid @enderror">
                            @error('nbr_hours')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cours -->
                        <div class="col-lg-2">
                            <label class="form-label">Cours <span class="text-danger">*</span></label>
                            <input type="number" wire:model="nbr_lesson" min="0"
                                class="form-control @error('nbr_lesson') is-invalid @enderror">
                            @error('nbr_lesson')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cours Numériques -->
                        <div class="col-lg-2">
                            <label class="form-label">Cours Numériques <span class="text-danger">*</span></label>
                            <input type="number" wire:model="nbr_lesson_dig" min="0"
                                class="form-control @error('nbr_lesson_dig') is-invalid @enderror">
                            @error('nbr_lesson_dig')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TP -->
                        <div class="col-lg-2">
                            <label class="form-label">TP <span class="text-danger">*</span></label>
                            <input type="number" wire:model="nbr_tp" min="0"
                                class="form-control @error('nbr_tp') is-invalid @enderror">
                            @error('nbr_tp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TP Numériques -->
                        <div class="col-lg-2">
                            <label class="form-label">TP Numériques <span class="text-danger">*</span></label>
                            <input type="number" wire:model="nbr_tp_dig" min="0"
                                class="form-control @error('nbr_tp_dig') is-invalid @enderror">
                            @error('nbr_tp_dig')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        {{-- <div class="col-lg-12">
                            <label class="form-label">Notes</label>
                            <textarea wire:model="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                                placeholder="Observations ou remarques..."></textarea>
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <!-- Boutons -->
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="ki-duotone ki-check fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ $editingProgram ? 'Mettre à jour' : 'Ajouter' }} le Programme
                            </button>
                            <button type="button" wire:click="resetForm" class="btn btn-light ms-2">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="card-body pt-0">
                @forelse($programs as $program)
                    <div class="card card-flush mb-4 border-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h6 class="mb-2">
                                        <strong>{{ $program->subject?->name ?? 'N/A' }}</strong>
                                        <small class="text-muted">({{ $program->subject?->code }})</small>
                                    </h6>
                                    <p class="text-muted fs-8 mb-0">
                                        {{ $program->notes ?? 'Aucune note' }}
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    <div class="row g-2">
                                        <div class="col-auto">
                                            <span class="badge badge-light-primary">
                                                <i class="ki-duotone ki-timer"></i> {{ $program->nbr_hours }}h
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-light-success">
                                                <i class="ki-duotone ki-book"></i> {{ $program->nbr_lesson }}
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-light-info">
                                                <i class="ki-duotone ki-computer"></i> {{ $program->nbr_lesson_dig }}
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-light-warning">
                                                <i class="ki-duotone ki-flask"></i> {{ $program->nbr_tp }}
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-light-danger">
                                                <i class="ki-duotone ki-computers"></i> {{ $program->nbr_tp_dig }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <button wire:click="editProgram({{ $program->id }})"
                                        class="btn btn-sm btn-light-info">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Éditer
                                    </button>
                                    <button
                                        onclick="if(confirm('Êtes-vous sûr?')) { @this.call('deleteProgram', {{ $program->id }}) }"
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
                    <div class="alert alert-info">
                        <i class="ki-duotone ki-information fs-2 me-2"></i>
                        Aucun programme pour cette classe cette année
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $programs->links() }}
                </div>
            </div>
        </div>
        <!--end::Card - Programs for Selected Class-->
    @endif
</div>

<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => $programId ? 'Éditer le programme' : 'Ajouter un programme',
        'breadcrumbs' => [['label' => 'Programmes', 'url' => route('programs.index'), 'active' => false], ['label' => $programId ? 'Édition' : 'Création', 'active' => true]],
    ])
    <!--end::Page Toolbar-->

    <form wire:submit="save" class="card p-4">
        @csrf

        <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select id="classe_id" wire:model="classe_id" class="form-select @error('classe_id') is-invalid @enderror">
                <option value="">-- Sélectionner --</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
            @error('classe_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="subject_id" class="form-label">Matière</label>
            <select id="subject_id" wire:model="subject_id"
                class="form-select @error('subject_id') is-invalid @enderror">
                <option value="">-- Sélectionner --</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">
                        {{ $subject->name }}
                        @if ($subject->department)
                            ({{ $subject->department->name }})
                        @endif
                    </option>
                @endforeach
            </select>
            @error('subject_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nbr_hours" class="form-label">Heures prévues</label>
                <input type="number" id="nbr_hours" wire:model="nbr_hours" min="0"
                    class="form-control @error('nbr_hours') is-invalid @enderror">
                @error('nbr_hours')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nbr_lesson" class="form-label">Leçons prévues</label>
                <input type="number" id="nbr_lesson" wire:model="nbr_lesson" min="0"
                    class="form-control @error('nbr_lesson') is-invalid @enderror">
                @error('nbr_lesson')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nbr_lesson_dig" class="form-label">Leçons digitalisées prévues</label>
                <input type="number" id="nbr_lesson_dig" wire:model="nbr_lesson_dig" min="0"
                    class="form-control @error('nbr_lesson_dig') is-invalid @enderror">
                @error('nbr_lesson_dig')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="nbr_tp" class="form-label">TP prévus</label>
                <input type="number" id="nbr_tp" wire:model="nbr_tp" min="0"
                    class="form-control @error('nbr_tp') is-invalid @enderror">
                @error('nbr_tp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="nbr_tp_dig" class="form-label">TP digitalisés prévus</label>
            <input type="number" id="nbr_tp_dig" wire:model="nbr_tp_dig" min="0"
                class="form-control @error('nbr_tp_dig') is-invalid @enderror">
            @error('nbr_tp_dig')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" wire:model="description" class="form-control"></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Sauvegarder
            </button>
            <a href="{{ route('programs.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

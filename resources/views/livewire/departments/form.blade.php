<div>
    <div class="mb-4">
        <h2 class="h4">{{ $departmentId ? 'Éditer' : 'Ajouter' }} un département</h2>
    </div>

    <form wire:submit="save" class="card p-4" style="max-width: 800px;">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" id="name" wire:model="name"
                class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" wire:model="description" class="form-control"></textarea>
        </div>

        <!-- Subjects selection -->
        <div class="mb-3">
            <label for="selectedSubjects" class="form-label">Matières associées</label>
            <div class="card p-3 bg-light">
                @if (empty($availableSubjects))
                    <div class="alert alert-info mb-0">
                        Aucune matière disponible pour cet établissement.
                    </div>
                @else
                    <div class="row">
                        @foreach ($availableSubjects as $subjectId => $subjectName)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="subject_{{ $subjectId }}"
                                        wire:model="selectedSubjects" value="{{ $subjectId }}">
                                    <label class="form-check-label" for="subject_{{ $subjectId }}">
                                        {{ $subjectName }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @error('selectedSubjects')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Sauvegarder
            </button>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

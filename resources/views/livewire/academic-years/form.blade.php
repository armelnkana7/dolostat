<div>
    <div class="mb-4">
        <h2 class="h4">{{ $academicYearId ? 'Éditer' : 'Ajouter' }} une année académique</h2>
    </div>

    <form wire:submit="save" class="card p-4">
        @csrf

        <div class="mb-3">
            <label for="establishment_id" class="form-label">Établissement</label>
            <select id="establishment_id" wire:model="establishment_id"
                class="form-select @error('establishment_id') is-invalid @enderror">
                <option value="">-- Sélectionner --</option>
                @foreach ($establishments as $est)
                    <option value="{{ $est->id }}">{{ $est->name }}</option>
                @endforeach
            </select>
            @error('establishment_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" id="title" wire:model="title"
                class="form-control @error('title') is-invalid @enderror">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Date de début</label>
                <input type="date" id="start_date" wire:model="start_date"
                    class="form-control @error('start_date') is-invalid @enderror">
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">Date de fin</label>
                <input type="date" id="end_date" wire:model="end_date"
                    class="form-control @error('end_date') is-invalid @enderror">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" id="is_active" wire:model="is_active" class="form-check-input">
                <label for="is_active" class="form-check-label">Active</label>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Sauvegarder
            </button>
            <a href="{{ route('academic-years.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

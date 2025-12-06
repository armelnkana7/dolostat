<div>
    <div class="mb-4">
        <h2 class="h4">{{ $establishmentId ? 'Éditer' : 'Ajouter' }} un établissement</h2>
    </div>

    <form wire:submit="save" class="card p-4" style="max-width: 600px;">
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
            <label for="code" class="form-label">Code</label>
            <input type="text" id="code" wire:model="code"
                class="form-control @error('code') is-invalid @enderror">
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" id="address" wire:model="address" class="form-control">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="text" id="phone" wire:model="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" wire:model="email" class="form-control">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Sauvegarder
            </button>
            <a href="{{ route('establishments.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

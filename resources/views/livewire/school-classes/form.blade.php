<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => $schoolClassId ? 'Éditer la classe' : 'Ajouter une classe',
        'breadcrumbs' => [['label' => 'Classes', 'url' => route('classes.index'), 'active' => false], ['label' => $schoolClassId ? 'Édition' : 'Création', 'active' => true]],
    ])
    <!--end::Page Toolbar-->

    <form wire:submit="save" class="card p-4" style="max-width: 600px;">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" id="name" wire:model="name" class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="department_id" class="form-label">Niveau</label>
            <select id="department_id" wire:model="level" class="form-select @error('level') is-invalid @enderror">
                <option value="">-- Sélectionner --</option>
                <option value="1">Niveau 1</option>
                <option value="2">Niveau 2</option>
                <option value="3">Niveau 3</option>
                <option value="4">Niveau 4</option>
                <option value="5">Niveau 5</option>
            </select>
            @error('department_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        {{-- 
        <div class="mb-3">
            <label for="level" class="form-label">Niveau</label>
            <input type="text" id="level" wire:model="level" class="form-control">
        </div> --}}

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" wire:model="description" class="form-control"></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Sauvegarder
            </button>
            <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

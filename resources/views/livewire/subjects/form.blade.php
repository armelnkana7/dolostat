<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => $subjectId ? 'Éditer la matière' : 'Ajouter une matière',
        'breadcrumbs' => [['label' => 'Matières', 'url' => route('subjects.index'), 'active' => false], ['label' => $subjectId ? 'Édition' : 'Création', 'active' => true]],
    ])
    <!--end::Page Toolbar-->

    <div wire:loading>@include('components.loading-indicator')</div>

    <form wire:submit="save" class="card p-4" style="max-width: 600px;">
        @csrf

        <div class="mb-3">
            <label for="department_id" class="form-label">Département</label>
            <select id="department_id" wire:model="department_id"
                class="form-select @error('department_id') is-invalid @enderror">
                <option value="">Sélectionnez un département</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
            @error('department_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

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
            <input type="text" id="code" wire:model="code" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" wire:model="description" class="form-control"></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Sauvegarder
            </button>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

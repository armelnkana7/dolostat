<div>
    <!--begin::Page Toolbar-->
    @livewire('page-toolbar', [
        'title' => $userId ? 'Éditer l\'utilisateur' : 'Ajouter un utilisateur',
        'breadcrumbs' => [['label' => 'Utilisateurs', 'url' => route('users.index'), 'active' => false], ['label' => $userId ? 'Édition' : 'Création', 'active' => true]],
    ])
    <!--end::Page Toolbar-->

    <form wire:submit="save" class="card p-4 w-100">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" id="name" wire:model="name" class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" id="username" wire:model="username"
                class="form-control @error('username') is-invalid @enderror">
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" wire:model="email"
                class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe
                {{ $userId ? '(laisser vide pour ne pas changer)' : '' }}</label>
            <input type="password" id="password" wire:model="password"
                class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control">
        </div>

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
            <label for="department_id" class="form-label">Département</label>
            <select id="department_id" wire:model="department_id" class="form-select">
                <option value="">-- Sélectionner --</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">Rôle</label>
            <select id="role_id" wire:model="role_id" class="form-select @error('role_id') is-invalid @enderror">
                <option value="">-- Sélectionner un rôle --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Sauvegarder
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

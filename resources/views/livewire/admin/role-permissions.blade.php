<div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Rôles') }}</h3>
                </div>
                <div class="card-body">
                    @forelse($roles as $role)
                        <div class="mb-2">
                            <button wire:click="selectRole({{ $role->id }})"
                                class="btn btn-sm w-100 {{ $selectedRole == $role->id ? 'btn-primary' : 'btn-outline-primary' }}">
                                {{ $role->name }}
                            </button>
                        </div>
                    @empty
                        <div class="alert alert-info">{{ __('Aucun rôle trouvé') }}</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-8">
            @if ($selectedRole)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Permissions pour le rôle sélectionné') }}</h3>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="updatePermissions">
                            <div class="row">
                                @forelse($permissions as $permission)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="permission_{{ $permission->id }}"
                                                wire:model.defer="selectedPermissions" value="{{ $permission->id }}">
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-info">{{ __('Aucune permission trouvée') }}</div>
                                    </div>
                                @endforelse
                            </div>

                            <button type="submit" class="btn btn-primary mt-5">
                                {{ __('Mettre à jour les permissions') }}
                            </button>
                        </form>

                        @if (session()->has('message'))
                            <div class="alert alert-success mt-3">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-info">{{ __('Sélectionnez un rôle pour voir ses permissions') }}</div>
            @endif
        </div>
    </div>
</div>

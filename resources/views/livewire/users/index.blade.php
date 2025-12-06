<div>
    @livewire('page-toolbar', [
        'title' => 'Utilisateurs',
        'breadcrumbs' => [['label' => 'Administration', 'active' => false], ['label' => 'Utilisateurs', 'active' => true]],
        'actionLabel' => 'Créer utilisateur',
        'actionRoute' => route('users.create'),
        'actionClass' => 'btn btn-success btn-sm',
    ])

    {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="h4">Utilisateurs</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            Ajouter
        </a>
    </div> --}}

    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Rechercher..." class="form-control">
    </div>

    <div class="card">
        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <thead class="table-light">
                <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-150px">Nom</th>
                    <th class="min-w-130px">Nom d'utilisateur</th>
                    <th class="min-w-150px">Email</th>
                    <th class="min-w-150px">Établissement</th>
                    <th class="min-w-150px text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse($users as $user)
                    <tr>
                        <td class="d-flex align-items-center">
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="text-gray-900 text-hover-primary fw-bold">{{ $user->name }}</a>
                        </td>
                        <td>
                            <span class="badge badge-light-info">{{ $user->username ?? '-' }}</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->establishment?->name }}</td>
                        <td class="text-end">
                            @include('components.table-actions', [
                                'editRoute' => 'users.edit',
                                'id' => $user->id,
                                'modelName' => 'User',
                                'modelLabel' => 'utilisateur',
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Aucun utilisateur trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

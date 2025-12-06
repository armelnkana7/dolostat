{{-- 
    Partial pour les boutons d'action (éditer/supprimer) réutilisables
    Usage : @include('components.table-actions', ['editRoute' => 'classes.edit', 'id' => $item->id, 'modelName' => 'SchoolClass', 'modelLabel' => 'classe'])
--}}

@props(['editRoute', 'id', 'modelName' => 'Model', 'modelLabel' => 'ressource'])

<div class="btn-group" role="group">
    <a href="{{ route($editRoute, $id) }}" class="btn btn-sm btn-primary" title="Éditer {{ $modelLabel }}">
        <i class="ki-duotone ki-pencil fs-6">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        Éditer
    </a>

    <button type="button" class="btn btn-sm btn-danger"
        wire:click="$dispatch('openConfirm', {
                'model': '{{ $modelName }}',
                'id': {{ $id }},
                'title': 'Supprimer {{ $modelLabel }}',
                'message': 'Êtes-vous sûr de vouloir supprimer cette {{ $modelLabel }} ? Cette action est irréversible.',
                'event': 'deleteConfirmed'
            })"
        title="Supprimer {{ $modelLabel }}">
        <i class="ki-duotone ki-trash fs-6">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        Supprimer
    </button>
</div>

<?php

namespace App\Livewire\Traits;

/**
 * Trait WithConfirmDelete
 * 
 * Fournit les méthodes et listeners pour gérer les suppressions avec modale de confirmation.
 * 
 * Usage dans un composant Livewire :
 * - use WithConfirmDelete;
 * - Dans la vue : wire:click="$emit('openConfirm', ['model' => 'SchoolClass', 'id' => {{ $item->id }}, 'title' => 'Supprimer', 'message' => 'Êtes-vous sûr ?'])"
 * - Le trait ajoute automatiquement le listener 'confirmed' qui appelle delete($id)
 * 
 * À adapter dans chaque composant selon la logique métier (établissement, permissions, etc.)
 */
trait WithConfirmDelete
{
    /**
     * Fusionne les listeners du trait avec ceux du composant
     * Livewire 3 appelle cette méthode pour obtenir les listeners
     * 
     * @return array
     */
    protected function getListeners()
    {
        $listeners = method_exists($this, 'getListeners') && get_class($this) !== self::class
            ? parent::getListeners()
            : [];

        return array_merge(
            $listeners,
            ['refresh' => '$refresh', 'confirmed' => 'handleConfirmedDelete']
        );
    }

    /**
     * Gère la confirmation de suppression
     * 
     * @param array $data Contient : event, model, id, payload
     * @return void
     */
    public function handleConfirmedDelete($data)
    {
        if (isset($data['id'])) {
            $this->delete($data['id']);
        }
    }

    /**
     * Méthode de suppression à implémenter dans le composant qui utilise ce trait
     * 
     * @param mixed $id Identifiant de la ressource
     * @return void
     */
    abstract public function delete($id);
}

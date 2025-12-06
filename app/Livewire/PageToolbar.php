<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * PageToolbar Component
 * 
 * Composant dynamique pour afficher la toolbar avec titre, breadcrumb, etc.
 * À utiliser dans les vues au lieu de du code HTML statique
 * 
 * Usage :
 * @livewire('page-toolbar', [
 *     'title' => 'Établissements',
 *     'breadcrumbs' => [
 *         ['label' => 'Accueil', 'href' => route('dashboard')],
 *         ['label' => 'Gestion', 'active' => false],
 *         ['label' => 'Établissements', 'active' => true],
 *     ]
 * ])
 * 
 * Avec bouton d'action :
 * @livewire('page-toolbar', [
 *     'title' => 'Établissements',
 *     'breadcrumbs' => [...],
 *     'actionLabel' => 'Créer établissement',
 *     'actionRoute' => route('establishments.create'),
 *     'actionClass' => 'btn btn-primary'
 * ])
 */
class PageToolbar extends Component
{
    public string $title = 'Dashboard';
    public array $breadcrumbs = [];
    public ?string $actionLabel = null;
    public ?string $actionRoute = null;
    public ?string $actionClass = 'btn btn-success';

    public function render()
    {
        return view('livewire.page-toolbar');
    }
}

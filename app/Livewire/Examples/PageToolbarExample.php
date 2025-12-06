<?php

namespace App\Livewire\Examples;

use Livewire\Component;

/**
 * Exemple d'utilisation du composant PageToolbar dynamique
 * 
 * ===================================
 * 1. SANS LE COMPOSANT (ANCIEN)
 * ===================================
 * 
 * Avant, il fallait dupliquer du code HTML statique partout :
 * 
 * @include('partials.toolbar', [
 *     'title' => 'Établissements',
 *     'breadcrumbs' => [...]
 * ])
 * 
 * Problèmes :
 * - Code dupliqué dans chaque vue
 * - Difficile à maintenir
 * - Modifications nécessaires dans toutes les vues
 * 
 * ===================================
 * 2. AVEC LE COMPOSANT (NOUVEAU)
 * ===================================
 * 
 * Utiliser simplement le composant Livewire :
 * 
 * @livewire('page-toolbar', [
 *     'title' => 'Établissements',
 *     'breadcrumbs' => [
 *         ['label' => 'Gestion', 'active' => false],
 *         ['label' => 'Établissements', 'active' => true],
 *     ]
 * ])
 * 
 * ===================================
 * 3. AVEC BOUTON D'ACTION
 * ===================================
 * 
 * @livewire('page-toolbar', [
 *     'title' => 'Établissements',
 *     'breadcrumbs' => [
 *         ['label' => 'Gestion', 'active' => false],
 *         ['label' => 'Établissements', 'active' => true],
 *     ],
 *     'actionLabel' => 'Créer établissement',
 *     'actionRoute' => route('establishments.create'),
 *     'actionClass' => 'btn btn-primary btn-sm'
 * ])
 * 
 * ===================================
 * 4. EXEMPLE COMPLET - ÉTABLISSEMENTS
 * ===================================
 * 
 * resources/views/livewire/establishments/index.blade.php :
 * 
 * @livewire('page-toolbar', [
 *     'title' => 'Établissements',
 *     'breadcrumbs' => [
 *         ['label' => 'Gestion', 'active' => false],
 *         ['label' => 'Établissements', 'active' => true],
 *     ],
 *     'actionLabel' => 'Créer établissement',
 *     'actionRoute' => route('establishments.create'),
 *     'actionClass' => 'btn btn-success btn-sm'
 * ])
 * 
 * <div class="card">
 *     <!-- Table content -->
 * </div>
 * 
 * ===================================
 * 5. PROPRIÉTÉS DISPONIBLES
 * ===================================
 * 
 * 'title' (string, requis)
 *     Titre principal de la page
 *     Example: 'Établissements'
 * 
 * 'breadcrumbs' (array, optionnel)
 *     Tableau des items du breadcrumb
 *     Format: [
 *         ['label' => 'Gestion', 'href' => route('...'), 'active' => false],
 *         ['label' => 'Établissements', 'active' => true],  // Pas de href pour l'item actif
 *     ]
 *     Note: 'active' => true rend l'item en gras et non-cliquable
 * 
 * 'actionLabel' (string, optionnel)
 *     Texte du bouton d'action (ex: "Créer établissement")
 * 
 * 'actionRoute' (string, optionnel)
 *     Route du bouton d'action (ex: route('establishments.create'))
 *     Requis si actionLabel est défini
 * 
 * 'actionClass' (string, optionnel)
 *     Classes CSS Bootstrap du bouton
 *     Default: 'btn btn-success'
 *     Examples: 'btn btn-primary btn-sm', 'btn btn-danger'
 * 
 * ===================================
 * 6. AVANTAGES
 * ===================================
 * 
 * ✓ Code réutilisable et maintenable
 * ✓ Pas de duplication HTML
 * ✓ Modifications faciles (un seul endroit)
 * ✓ Responsive automatique
 * ✓ Breadcrumb dynamique
 * ✓ Bouton d'action optionnel
 * ✓ Styles Saul theme cohérents
 * ✓ Intégré avec Livewire pour wire:navigate
 * 
 * ===================================
 * 7. RÉSULTAT VISUEL
 * ===================================
 * 
 * [🏠 Gestion / Établissements]            [Créer établissement]
 * 
 * Établissements
 * 
 * Les breadcrumbs sont cliquables (sauf l'item actif)
 * Le bouton d'action utilise wire:navigate pour les transitions fluides
 */
class PageToolbarExample extends Component
{
    public function render()
    {
        return view('livewire.examples.page-toolbar-example');
    }
}

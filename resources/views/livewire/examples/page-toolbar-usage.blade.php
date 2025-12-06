{{-- 
    Exemple de migration à l'index des Établissements
    
    AVANT (code statique) : Toolbar complète avec code HTML
    APRÈS (code dynamique) : Une seule ligne Livewire
--}}

{{-- 
    Remplacer toute la section toolbar statique par :
--}}
@livewire('page-toolbar', [
    'title' => 'Établissements',
    'breadcrumbs' => [['label' => 'Gestion', 'active' => false], ['label' => 'Établissements', 'active' => true]],
    'actionLabel' => 'Créer établissement',
    'actionRoute' => route('establishments.create'),
    'actionClass' => 'btn btn-success btn-sm',
])

{{-- 
    C'est tout ! Cela remplace environ 50+ lignes de HTML statique
    avec une seule ligne de code dynamique et réutilisable.
--}}

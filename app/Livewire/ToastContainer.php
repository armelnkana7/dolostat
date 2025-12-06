<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * ToastContainer Component
 * 
 * Utilise toastr.js pour afficher les notifications
 * À inclure une seule fois dans le layout
 * 
 * Usage depuis un composant trait (WithToasts) :
 * - $this->toastSuccess('Message', 'Titre');
 * - $this->toastError('Message d\'erreur', 'Erreur');
 * - $this->toastWarning('Message d\'avertissement', 'Attention');
 * - $this->toastInfo('Message d\'info', 'Information');
 */
class ToastContainer extends Component
{
    public function render()
    {
        return view('livewire.toast-container');
    }
}

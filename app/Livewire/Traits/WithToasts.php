<?php

namespace App\Livewire\Traits;

/**
 * Trait WithToasts
 * 
 * Fournit des méthodes simplifiées pour afficher des toasts via toastr.js
 * Les toasts sont affichés directement via JavaScript
 * 
 * Usage:
 * - $this->toastSuccess('Message', 'Titre');
 * - $this->toastError('Message', 'Titre');
 * - $this->toastWarning('Message', 'Titre');
 * - $this->toastInfo('Message', 'Titre');
 */
trait WithToasts
{
    /**
     * Affiche un toast de succès
     * 
     * @param string $message Message du toast
     * @param string $title Titre du toast
     */
    public function toastSuccess(string $message, string $title = 'Succès'): void
    {
        $this->dispatchToastScript('success', $message, $title);
    }

    /**
     * Affiche un toast d'erreur
     * 
     * @param string $message Message du toast
     * @param string $title Titre du toast
     */
    public function toastError(string $message, string $title = 'Erreur'): void
    {
        $this->dispatchToastScript('error', $message, $title);
    }

    /**
     * Affiche un toast d'avertissement
     * 
     * @param string $message Message du toast
     * @param string $title Titre du toast
     */
    public function toastWarning(string $message, string $title = 'Attention'): void
    {
        $this->dispatchToastScript('warning', $message, $title);
    }

    /**
     * Affiche un toast d'info
     * 
     * @param string $message Message du toast
     * @param string $title Titre du toast
     */
    public function toastInfo(string $message, string $title = 'Info'): void
    {
        $this->dispatchToastScript('info', $message, $title);
    }

    /**
     * Dispatch le script JavaScript pour afficher le toast via toastr.js
     * 
     * @param string $type Type de toast (success, error, warning, info)
     * @param string $message Message du toast
     * @param string $title Titre du toast
     */
    private function dispatchToastScript(string $type, string $message, string $title): void
    {
        // Échappe les caractères spéciaux pour éviter les injections JavaScript
        $message = addslashes($message);
        $title = addslashes($title);

        $script = "toastr.{$type}('{$message}', '{$title}');";
        $this->dispatch('execute-js', script: $script);
    }
}

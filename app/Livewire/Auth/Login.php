<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Login extends Component
{
    #[Validate('required')]
    public $credential = '';

    #[Validate('required|min:6')]
    public $password = '';

    public $rememberMe = false;

    public function login()
    {
        $this->validate();

        // Déterminer si c'est un email ou un username
        $field = filter_var($this->credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!Auth::attempt(
            [$field => $this->credential, 'password' => $this->password],
            $this->rememberMe
        )) {
            $this->addError('credential', __('Username/Email ou mot de passe incorrect.'));
            return;
        }

        session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}

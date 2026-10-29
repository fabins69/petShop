<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    public function mount()
    {
        if (Auth::check()) {
            return $this->redirectRoute('dashboard');
        }
    }

    public function entrar()
    {
        $dados = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'password.required' => 'Informe a senha.',
        ]);

        if (Auth::attempt($dados)) {
            request()->session()->regenerate();

            return $this->redirectRoute('dashboard');
        }

        $this->addError('email', 'E-mail ou senha inválidos.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}

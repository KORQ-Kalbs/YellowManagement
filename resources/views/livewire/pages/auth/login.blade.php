<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest', ['title' => 'Login to your account'])] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <x-text-input 
                wire:model="form.email" 
                id="email" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-50 placeholder-gray-400" 
                type="email" 
                name="email" 
                placeholder="you@email.com"
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <x-text-input 
                wire:model="form.password" 
                id="password" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-50 placeholder-gray-400"
                type="password"
                name="password"
                placeholder="••••••••"
                required 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input 
                wire:model="form.remember" 
                id="remember" 
                type="checkbox" 
                class="rounded border-gray-300 text-yellow-500 shadow-sm focus:ring-yellow-500 focus:ring-offset-0"
                name="remember"
            >
            <label for="remember" class="ms-2 text-sm text-gray-600">Remember me</label>
        </div>

        <!-- Login Button -->
        <button 
            type="submit"
            class="w-full py-3 px-4 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-lg transition-colors duration-200 shadow-md"
        >
            Login
        </button>

        <!-- Forgot Password & Register Links -->
        <div class="flex items-center justify-between text-sm">
            @if (Route::has('password.request'))
                <a 
                    class="text-yellow-500 hover:text-yellow-600 font-medium" 
                    href="{{ route('password.request') }}" 
                    wire:navigate
                >
                    Forgot password?
                </a>
            @endif

            <a 
                class="text-gray-600 hover:text-gray-900 font-medium" 
                href="{{ route('register') }}" 
                wire:navigate
            >
                Create account
            </a>
        </div>
    </form>
</div>

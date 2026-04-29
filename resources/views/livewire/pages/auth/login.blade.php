<?php

use App\Livewire\Forms\LoginForm;
use App\Services\CaptchaService;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest', ['title' => 'Login to your account'])] class extends Component
{
    public LoginForm $form;
    public string $captchaQuestion = '';

    /**
     * Mount component and generate CAPTCHA
     */
    public function mount(): void
    {
        $this->generateNewCaptcha();
    }

    /**
     * Generate a new CAPTCHA challenge
     */
    public function generateNewCaptcha(): void
    {
        $captcha = CaptchaService::generate();
        $this->captchaQuestion = $captcha['question'];
        $this->form->captcha = '';
    }

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

        <!-- CAPTCHA Challenge -->
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
                <label for="captcha" class="block text-sm font-medium text-gray-700">Verify you're human</label>
                <button
                    type="button"
                    wire:click="generateNewCaptcha"
                    class="text-yellow-600 hover:text-yellow-700 text-sm font-medium transition-colors duration-200 flex items-center gap-1"
                    title="Generate new CAPTCHA"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    New
                </button>
            </div>
            
            <div class="bg-white border-2 border-yellow-300 rounded-md p-4 mb-3 text-center">
                <p class="text-lg font-bold text-gray-800">{{ $captchaQuestion }}</p>
            </div>
            
            <x-text-input 
                wire:model="form.captcha" 
                id="captcha" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white placeholder-gray-400" 
                type="text" 
                name="captcha" 
                placeholder="Enter your answer"
                required 
                inputmode="numeric"
            />
            <x-input-error :messages="$errors->get('form.captcha')" class="mt-1" />
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

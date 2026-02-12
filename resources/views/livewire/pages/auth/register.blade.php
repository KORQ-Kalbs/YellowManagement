<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest', ['title' => 'Create your account'])] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'kasir';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,kasir'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register" class="space-y-5">
        <!-- Name -->
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Full Name</label>
            <x-text-input 
                wire:model="name" 
                id="name" 
                class="w-full px-4 py-3 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-50"
                type="text" 
                name="name" 
                placeholder="John Doe"
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
            <x-text-input 
                wire:model="email" 
                id="email" 
                class="w-full px-4 py-3 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-50"
                type="email" 
                name="email" 
                placeholder="you@email.com"
                required 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Role Selection -->
        <div>
            <label for="role" class="block mb-2 text-sm font-medium text-gray-700">Role</label>
            <select 
                wire:model="role" 
                id="role"
                name="role"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-50"
                required
            >
                <option value="kasir" selected>Kasir</option>
                <option value="admin">Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
            <x-text-input 
                wire:model="password" 
                id="password" 
                class="w-full px-4 py-3 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-50"
                type="password"
                name="password"
                placeholder="••••••••"
                required 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-700">Confirm Password</label>
            <x-text-input 
                wire:model="password_confirmation" 
                id="password_confirmation" 
                class="w-full px-4 py-3 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-50"
                type="password"
                name="password_confirmation"
                placeholder="••••••••"
                required 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Register Button -->
        <button 
            type="submit"
            class="w-full px-4 py-3 font-semibold text-white transition-colors duration-200 bg-yellow-400 rounded-lg shadow-md hover:bg-yellow-500"
        >
            Create Account
        </button>

        <!-- Login Link -->
        <div class="text-sm text-center">
            <span class="text-gray-600">Already have an account?</span>
            <a 
                class="ml-1 font-medium text-yellow-500 hover:text-yellow-600" 
                href="{{ route('login') }}" 
                wire:navigate
            >
                Log in
            </a>
        </div>
    </form>
</div>

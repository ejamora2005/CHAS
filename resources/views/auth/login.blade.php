<x-guest-layout>
    <x-slot name="footer">
        <div class="auth-icon-row" aria-label="Alternative login methods">
            <button type="button" class="auth-icon-btn auth-icon-btn--google" aria-label="Continue with Google">
                <svg class="auth-icon-svg" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.2-2.27H12v4.51h6.47a5.53 5.53 0 0 1-2.4 3.63v3h3.88c2.27-2.09 3.54-5.18 3.54-8.87z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.07 7.93-2.9l-3.88-3c-1.07.72-2.44 1.15-4.05 1.15-3.11 0-5.75-2.1-6.69-4.93H1.3v3.09A12 12 0 0 0 12 24z"/>
                    <path fill="#FBBC05" d="M5.31 14.32A7.2 7.2 0 0 1 4.94 12c0-.8.14-1.57.37-2.32V6.59H1.3A12 12 0 0 0 0 12c0 1.94.46 3.77 1.3 5.41l4.01-3.09z"/>
                    <path fill="#EA4335" d="M12 4.77c1.76 0 3.35.6 4.59 1.79l3.44-3.44C17.94 1.16 15.24 0 12 0A12 12 0 0 0 1.3 6.59l4.01 3.09c.94-2.83 3.58-4.91 6.69-4.91z"/>
                </svg>
            </button>
            <button type="button" class="auth-icon-btn auth-icon-btn--facebook" aria-label="Continue with Facebook">
                <svg class="auth-icon-svg" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.79c0-2.5 1.49-3.88 3.77-3.88 1.09 0 2.23.19 2.23.19v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 2.89h-2.33v6.99A10 10 0 0 0 22 12z"/>
                </svg>
            </button>
            <button type="button" class="auth-icon-btn auth-icon-btn--apple" aria-label="Continue with Apple">
                <svg class="auth-icon-svg" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M17.57 12.58c.03 3.24 2.84 4.31 2.87 4.33-.02.08-.45 1.53-1.47 3.03-.88 1.29-1.8 2.58-3.25 2.61-1.42.03-1.88-.84-3.5-.84-1.63 0-2.14.82-3.48.87-1.4.05-2.46-1.4-3.36-2.69C3.57 17.26 2.18 12.45 4.05 9.21c.93-1.61 2.58-2.63 4.38-2.66 1.37-.03 2.66.92 3.5.92.85 0 2.43-1.14 4.09-.97.69.03 2.65.28 3.9 2.11-.1.07-2.33 1.36-2.35 3.97Zm-2.1-7.29c.74-.9 1.24-2.15 1.11-3.4-1.07.04-2.37.71-3.14 1.61-.69.8-1.29 2.08-1.13 3.31 1.2.09 2.42-.61 3.16-1.52Z"/>
                </svg>
            </button>
        </div>
    </x-slot>

    <h1 class="auth-heading">{{ __('Welcome Back') }}</h1>
    <p class="auth-subheading">{{ __('Sign in to manage your campus appointments.') }}</p>

    @if (session('status'))
        <p class="auth-alert">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="email" class="auth-label">{{ __('Email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="auth-input @error('email') auth-input-error @enderror"
                placeholder="{{ __('name@school.edu') }}"
                required
                autofocus
                autocomplete="username"
            >
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">{{ __('Password') }}</label>
            <input
                id="password"
                type="password"
                name="password"
                class="auth-input @error('password') auth-input-error @enderror"
                placeholder="{{ __('Enter your password') }}"
                required
                autocomplete="current-password"
            >
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-hint-row">
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="auth-submit">{{ __('Log in') }}</button>
    </form>

    <p class="auth-switch">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="auth-link">{{ __('Register') }}</a>
    </p>
</x-guest-layout>

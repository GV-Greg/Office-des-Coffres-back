<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <h1 class="my-1 text-4xl md:text-5xl">
                Office des coffres
            </h1>
{{--            <a href="/">--}}
{{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
{{--            </a>--}}
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <h3 class="text-2xl md:text-3xl">
            Enregistrez-vous !
        </h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="pseudo" :value="__('Username')" />
                <x-input id="pseudo" class="block mt-1 w-full" type="text" name="pseudo" :value="old('pseudo')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <div class="form-group mt-4">
                <x-button class="py-2">
                    {{ __('Register') }}
                </x-button>
            </div>

            <div class="form-group mt-4">
                <a class="text-sm font-bold text-blue-600 hover:text-blue-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __("Update the player") }} {{ $player->pseudo }}
    </x-slot>

    <x-content-card>
        <div class="grid grid-cols-1 justify-items-center">
            <h3 class="mt-2 mb-4 text-lg font-bold uppercase">{{ __('Form') }}</h3>
            <form method="POST" action="{{ route('player.update', $player->id) }}" class="w-1/3">
                @csrf
                <!-- Username -->
                <div class="w-full">
                    <x-label for="pseudo" :value="__('Username')" />
                    <x-input id="pseudo" class="block mt-1 w-full" type="text" name="pseudo" :value="$player->pseudo" required autofocus />
                    @error('pseudo')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Email Address -->
                <div class="mt-4 w-full">
                    <x-label for="email" :value="__('Email')" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$player->email" required autofocus />
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password -->
                <div class="mt-4 w-full">
                    <x-label for="password" :value="__('Password')" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="current-password" />
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Button -->
                <div class="mt-8 mb-2 w-full text-center">
                    <button type="submit" class="btn btn-create">{{ __('Send') }}</button>
                </div>
            </form>
        </div>
    </x-content-card>
</x-app-layout>

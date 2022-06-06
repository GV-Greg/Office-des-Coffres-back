<x-app-layout>
    <x-slot name="header">
        {{ __('Create a code activity') }}
    </x-slot>

    <x-content-card>
        <div class="grid grid-cols-1 justify-items-center">
            <h3 class="mt-2 mb-4 text-lg font-bold uppercase">{{ __('Form') }}</h3>
            <form method="POST" action="{{ route('anim.decode.store') }}" class="w-1/3">
                @csrf
                <!-- Name -->
                <div class="w-full">
                    <x-label for="name" :value="__('Name')" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" :placeholder="__('Name your activity')" minlength="3" maxlength="190" required autofocus />
                    @error('name')
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

<x-app-layout>
    <x-slot name="header">
        {{ __('Create a reward grids') }}
    </x-slot>

    <x-content-card>
        <div class="grid grid-cols-1 justify-items-center">
            <h3 class="mt-2 mb-4 text-lg font-bold uppercase">{{ __('Form') }}</h3>
            <form method="POST" action="{{ route('anim.grid.rewards.store') }}" class="w-1/3">
                @csrf
                <!-- Name -->
                    <div class="w-full">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" :placeholder="__('Name your grid')" minlength="3" maxlength="190" required autofocus />
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                <!-- Width -->
                    <div class="w-full flex flex-row mt-2">
                        <div class="w-1/2 mr-2">
                            <x-label for="width" :value="__('Width')" />
                            <x-input id="width" class="block mt-1 w-full" type="number" min="2" max="20" name="width" :value="old('width')" :placeholder="__('Number of horizontal lines')" required autofocus />
                            @error('width')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-1/2 ml-2">
                            <x-label for="height" :value="__('Height')" />
                            <x-input id="height" class="block mt-1 w-full" type="number" min="2" max="20" name="height" :value="old('height')" :placeholder="__('Number of vertical lines')" required autofocus />
                            @error('height')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                <!-- Button -->
                    <div class="mt-8 mb-2 w-full text-center">
                        <button type="submit" class="btn btn-create">{{ __('Send') }}</button>
                    </div>
            </form>
        </div>
    </x-content-card>
</x-app-layout>

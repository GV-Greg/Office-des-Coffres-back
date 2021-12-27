<x-app-layout>
    <x-slot name="header">
        {{ __("Update the permission") }}
    </x-slot>

    <x-content-card>
        <div class="grid grid-cols-1 justify-items-center">
            <form action="{{ route('permission.update', $permission->id) }}" method="POST" class="w-full">
                @csrf
                <div class="grid grid-cols-4 gap-8">
                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $permission->name }}" required autofocus />
                        @error('name')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-start mt-5 ml-2">
                    <button type="submit" class="btn btn-create self-end">{{ __('Send') }}</button>
                </div>
            </form>
        </div>
    </x-content-card>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __("Create a role") }}
    </x-slot>

    <x-content-card>
        <div class="grid grid-cols-1 justify-items-center">
            <form action="{{ route('role.store') }}" method="POST" class="w-full">
                @csrf
                <div class="grid grid-cols-4 gap-8">
                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-span-3">
                        <span class="form-label">{{ __('Permissions') }}</span>
                        <div class="grid grid-cols-4">
                            @foreach($permissions as $key => $permission)
                                <div class="form-check w-full">
                                    <input type="checkbox" id="{{ $permission->name }}" name="permission[]" value="{{ $permission->id }}" class="form-check-input rounded text-blue-500">
                                    <label for="{{ $permission->name }}" class="form-check-label inline-block text-gray-800 ml-1">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-5 mb-2 ml-2">
                    <button type="submit" class="btn btn-create self-end">{{ __('Send') }}</button>
                </div>
            </form>
        </div>
    </x-content-card>
</x-app-layout>

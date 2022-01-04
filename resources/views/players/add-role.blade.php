<x-app-layout>
    <x-slot name="header">
        {{ __("Create a role") }} {{ __('for') }} {{ $player->name }}
    </x-slot>

    <x-content-card>
        <div class="grid grid-cols-1 justify-items-center">
            <form action="{{ route('player.role.store', $player->id) }}" method="POST" class="w-full">
                @csrf
                <div class="grid grid-cols-4 gap-8">
                    <div class="form-group col-span-3">
                        <span class="form-label">{{ __('Roles') }}</span>
                        <div class="grid grid-cols-4">
                        @foreach($roles as $key => $role)
                                <div class="form-check w-full">
                                    <input type="checkbox" id="{{ $role->name }}" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, $playerRoles) ? 'checked' : '' }} class="form-check-input rounded text-blue-500">
                                    <label for="{{ $role->name }}" class="form-check-label inline-block text-gray-800 ml-1">{{ $role->name }}</label>
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

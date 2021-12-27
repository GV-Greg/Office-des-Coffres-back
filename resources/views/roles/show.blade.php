<x-app-layout>
    <x-slot name="header">
        {{ __("Role") }} {{ $role->name }}
    </x-slot>

    <x-content-card>
        <div class="grid grid-cols-2 justify-items-center">
            <div>
                <h3 class="text-2xl">{{ __('List of permissions') }}</h3>
                <ul class="list-outside list-decimal">
                    @foreach($rolePermissions as $permission)
                        <li>{{ $permission->name }}</li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-2xl">{{ __('List of players') }} {{ __('with the role') }}</h3>
                <ul class="list-outside list-decimal">
                    @foreach($role->users as $joueur)
                        <li class="font-bold text-blue-500"><a href="{{ route('player.show', $joueur->id) }}" class="hover:text-orange-500">{{ $joueur->pseudo }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </x-content-card>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __("Player's card") }} {{ $player->pseudo }}
    </x-slot>

    <div class="md:py-3 ml-14">
        <div class="grid grid-cols-3">
            <div class="ml-10 p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-row items-center align-middle">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x" style="color:dodgerblue"></i>
                        <i class="fas fa-user-alt fa-stack-1x fa-inverse"></i>
                    </span>
                    <h3 class="text-4xl">{{ $player->pseudo }}</h3>
                    @if($player->is_validated)
                        <span class="ml-3 -mt-4 px-2 pt-1 pb-1.5 rounded bg-green-500 text-white uppercase font-bold">{{ __('Validated') }}</span>
                    @else
                        <span class="ml-3 -mt-4 px-2 pt-1 pb-1.5 rounded bg-red-500 text-white uppercase font-bold">{{ __('Not validated') }}</span>
                    @endif
                </div>
                <div class="mt-5 flex flex-row justify-between items-center p-3 bg-gray-200 rounded-lg">
                    <div class="mr-3">
                        <span class="text-gray-400 block">{{ __('Kingdom') }}</span>
                        <span class="font-bold text-black text-xl">Test</span>
                    </div>
                    <div class="mr-3">
                        <span class="text-gray-400 block">{{ __('State') }}</span>
                        <span class="font-bold text-black text-xl">test</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block">{{ __('City') }}</span>
                        <span class="font-bold text-black text-xl">test</span>
                    </div>
                </div>
            </div>
            <div class="col-span-2 mx-5 p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h4>{{ __('Roles') }}</h4>
                <a href="{{ route('player.role.add',$player->id) }}" class="btn btn-create">{{ __('Assign roles') }}</a>
                <ul class="ml-5 mt-2">
                    @foreach($player->roles as $role)
                        <li class="list-disc">{{ $role->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

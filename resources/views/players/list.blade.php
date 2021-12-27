<x-app-layout>
    <x-slot name="header">
        {{ __('List of players') }}
    </x-slot>

    <x-content-card>
        <div class="grid grid-cols-1 justify-items-center">
            <div class="w-full md:w-1/2 mb-1 flex flex-col md:flex-row items-center">
                <div class="w-full md:w-2/3 form-group relative">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold" for="search">
                        {{ __('Search') }}
                    </label>
                    <x-input type="text" aria-label="search" class="border-2 focus:outline-none hover:cursor-pointer" />
                    <button type="button" class="absolute top-5 right-0.5 text-teal-500 text-sm border-4 border-transparent py-1 px-2 rounded">
                        <i class="fa fa-search fa-lg"></i>
                    </button>
                </div>
                <div class="w-full md:w-1/3 mt-3 md:mt-1 md:mr-2 flex justify-center md:justify-end">
                    <a class="btn btn-create" href="{{ route('player.create') }}">{{ __('Create a player') }}</a>
                </div>
            </div>
            <table class="mt-5 md:mt-0 w-full">
                <thead>
                <tr>
                    <th class="hidden md:table-cell">{{ __('ID') }}</th>
                    <th>{{ __('Username') }}</th>
                    <th class="hidden md:table-cell">{{ __('Email') }}</th>
                    <th class="hidden md:table-cell">{{ __('Creation') }}</th>
                    <th class="text-center">{{ __('Status') }}</th>
                    <th class="text-center">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($players as $player)
                    <tr>
                        <th class="hidden md:table-cell">{{$player->id}}</th>
                        <td class="font-bold">{{$player->pseudo}}</td>
                        <td class="hidden md:table-cell">{{$player->email}}</td>
                        <td class="hidden md:table-cell">{{$player->created_at->format('j M Y - H:m')}}</td>
                        <td class="text-center">
                            @if($player->is_validated)
                                <a href="{{ route('player.change.status',$player->id) }}" class="ml-3 px-2 py-1 rounded bg-green-500 text-white uppercase font-bold">{{ __('Validated') }}</a>
                            @else
                                <a href="{{ route('player.change.status',$player->id) }}" class="ml-3 px-2 py-1 rounded bg-red-500 text-white uppercase font-bold">{{ __('Not validated') }}</a>
                            @endif
                        </td>
                        <td class="text-center">
                            <a class="btn-show" href="{{ route('player.show',$player->id) }}"><i class="fa fa-fw fa-eye"></i><span class="hidden md:inline-block md:ml-1">{{ __('Show') }}</span></a>
                            <a class="btn-edit" href="{{ route('player.edit',$player->id) }}"><i class="fa fa-fw fa-edit"></i><span class="hidden md:inline-block md:ml-1">{{ __('Edit') }}</span></a>
                            <form action="{{ route('player.destroy',$player->id) }}" method="POST" class="hidden md:inline-block md:ml-1">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button class="btn-delete"><i class="fa fa-fw fa-trash"></i><span>{{ __('Delete') }}</span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{ $players->links('pagination::tailwind') }}
            </div>
        </div>
    </x-content-card>
</x-app-layout>

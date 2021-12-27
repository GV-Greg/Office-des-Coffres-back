<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <x-content-card>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="grid grid-cols-1">
            <h3 class="text-2xl text-left">{{ __('List of non-validated players') }}</h3>
            <table class="mt-5 md:mt-0 w-full">
                <thead>
                <tr>
                    <th class="hidden md:table-cell">{{ __('ID') }}</th>
                    <th>{{ __('Username') }}</th>
                    <th class="hidden md:table-cell">{{ __('Kingdom') }}</th>
                    <th class="hidden md:table-cell">{{ __('State') }}</th>
                    <th class="hidden md:table-cell">{{ __('City') }}</th>
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
                        <td class="hidden md:table-cell"></td>
                        <td class="hidden md:table-cell"></td>
                        <td class="hidden md:table-cell"></td>
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

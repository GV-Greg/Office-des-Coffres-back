<x-app-layout>
    <x-slot name="header">
        {{ __('List of reward grids') }}
    </x-slot>

    <x-content-card>
        @can('festival-create')
            <div class="w-full md:w-1/2 mt-5 mb-3 mx-7 flex flex-col md:flex-row justify-start">
                <a class="btn btn-create" href="{{ route('anim.grid.rewards.create') }}">{{ __('Create a reward grids') }}</a>
            </div>
        @endcan
        @can('festival-show')
            <div class="mt-5 w-full grid grid-cols-6">
                @forelse($grids as $grid)
                    <div class="grid-rewards-card m-5 py-2" id="{{ 'grid' }}" data-id="{{ $grid->id }}">
                        <div class="grid-rewards-header">
                            <i class="fa-solid fa-chess-board fa-2xl"></i>
                            <form action="{{ route('anim.grid.rewards.destroy',$grid->id) }}" method="POST" class="hidden md:inline-block md:ml-1">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button class="reward-destroy"><i class="fa-solid fa-square-xmark fa-xl"></i></button>
                            </form>
                        </div>
                        <div class="grid-rewards-title">{{ __('Grid') }} <span class="grid-rewards-name">{{ $grid->name  }}</span></div>
                        <div class="grid-rewards-status my-3">
                            @if($grid->status === 'new')
                                <span class="text-yellow-500">{{ __($grid->status) }}</span>
                            @elseif($grid->status === 'incomplete')
                                    <span class="text-orange-500">{{ __($grid->status) }}</span>
                            @elseif($grid->status === 'filled')
                                    <span class="text-pink-500">{{ __($grid->status) }}</span>
                            @elseif($grid->status === 'drawed')
                                <span class="text-blue-500">{{ __($grid->status) }}</span>
                            @elseif($grid->status === 'confirmed')
                                <span class="text-green-500">{{ __($grid->status) }}</span>
                            @else
                                <span class="text-blueGray-400">{{ __($grid->status) }}</span>
                            @endif
                        </div>
                        <div class="grid-rewards-footer">{{ __('Created by-f') }} <span class="grid-rewards-creator">{{ $grid->creator->username }}</span></div>
                    </div>
                @empty
                    <div class="mt-5 ml-5 italic">
                        Aucune grille cr&eacute;e
                    </div>
                @endforelse
            </div>
        @endcan
    </x-content-card>

    @push('script')
        <script src="{{ asset('js/rewards.js') }}" defer></script>
    @endpush
</x-app-layout>

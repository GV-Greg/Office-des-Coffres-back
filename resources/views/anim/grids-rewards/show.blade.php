<x-app-layout>
    <x-slot name="header">
        {{ __('The reward grids') }} "{{ $grid->name }}"
    </x-slot>

    <x-content-card>
        <div class="w-full grid grid-cols-6 place-items-stretch" id="grid-rewards-main" >
            <section id="grid-rewards-infos">
                <div class="text-center uppercase font-extrabold text-blueGray-100 mt-3">
                    @if($grid->status === "new")
                        <span class="bg-red-700 rounded py-1 px-2">{{ __('Grid without rewards') }}</span>
                    @elseif($grid->status === "incomplete")
                        <span class="bg-orange-600 rounded py-1 px-2">{{ __('Incomplete grid') }}</span>
                    @elseif($grid->status === "filled")
                        <span class="bg-pink-700 rounded py-1 px-2">{{ __('Complete rewards list') }}</span>
                    @elseif($grid->status === "drawed")
                        <span class="bg-blue-700 rounded py-1 px-2">{{ __('Grid ready') }}</span>
                    @elseif($grid->status === "confirmed")
                        <span class="bg-green-700 rounded py-1 px-2">{{ __('Grid confirmed') }}</span>
                    @endif
                </div>
                <div class="text-center mt-2">
                    @if(($grid->width*$grid->height) - $rewards_count > 0)
                        {{ ($grid->width*$grid->height) - $rewards_count }} {{ __('missing rewards') }}
                    @elseif($grid->status === "new" && $grid->status === "incomplete")
                       0 {{ __('missing reward') }}
                    @endif
                </div>
                @if($grid->status === "drawed")
                    <p class="px-2 text-center">{{ __('Click on a box to inform the player who has won the prize') }}.</p>
                @endif
                @if($grid->status !== "new")
                    <div class="ml-2 flex flex-col mt-2" id="rewards-list">
                        @foreach($rewards as $reward => $value)
                            <div class="my-1">
                                @if($grid->status === "incomplete" || $grid->status === "filled" || $grid->status === "drawed" )
                                    <form action="{{ route('anim.grid.rewards.group.destroy', [$grid->id, $reward]) }}" method="POST" class="hidden md:inline-block md:ml-1">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="rewards-destroy"><i class="fa-solid fa-square-xmark fa-xl"></i></button>
                                    </form>
                                @endif
                                <span class="font-bold ml-1">{{ $reward }}</span> > {{ count($value) }} {{ __('units') }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            <section id="grid-rewards-container" class="col-span-4 justify-self-center">
                <div class="grid-rewards">
                    <div class="line">
                        @if($grid->status === "confirmed")
                            @foreach($grid_rewards as $box)
                                <div class="box" x-data="{ openModalBox: false }">
                                    @if($box->is_taken !== true)
                                        <button class="box-inside" @click="openModalBox = true">{{ $box->place }}</button>
                                    @else
                                        <button class="box-inside-is-taken" disabled>{{ $box->place }}</button>
                                    @endif
                                        <!-- Modal -->
                                    <div class="overlay" x-show="openModalBox" @click.away="openModalBox = false" >
                                        <!-- A basic modal dialog with title, body and one button to close -->
                                        <div class="modal-container">
                                            <div class="modal">
                                                <h3 class="modal-title">
                                                    {{ __('form for reward giving') }}
                                                </h3>
                                                <div class="modal-form mt-2">
                                                    <form method="POST" action="{{ route('anim.grid.rewards.give', $box->id) }}" class="flex flex-col justify-center items-center">
                                                        @csrf
                                                        <!-- hidden field of grid's id -->
                                                            <x-input type="hidden" name="grid_id" value="{{ $grid->id }}"></x-input>
                                                        <!-- Name player -->
                                                            <div class="w-2/3">
                                                                <x-label for="player" :value="__('Name of the player')" />
                                                                <x-input id="player" class="block mt-1 w-full" type="text" name="player" :value="old('player')" :placeholder="__('Enter the name of the player')" minlength="3" maxlength="190" required autofocus />
                                                                @error('player')
                                                                <p class="form-error">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                        <!-- submit button -->
                                                            <div class="w-full mt-7 mb-5 flex justify-between">
                                                                <button @click="openModalBox = false" class="btn btn-close mx-10">
                                                                    {{ __('Close') }}
                                                                </button>
                                                                <button type="submit" class="btn btn-create mx-10">
                                                                    {{ __('Send') }}
                                                                </button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($box->place % $grid->width === 0)
                                    </div><div class="line">
                                @endif
                            @endforeach
                        @else
                            @for($i=1; $i<($grid->width*$grid->height)+1; $i++)
                                <div class="box">
                                    <div class="box-inside">{{ $i }}</div>
                                </div>
                                @if($i % $grid->width === 0)
                                    </div><div class="line">
                               @endif
                            @endfor
                        @endif
                    </div>
                </div>
            </section>
            <section id="grid-rewards-actions">
                @if(($grid->status === "new" || $grid->status === "incomplete") && ($grid->width*$grid->height) - $rewards_count > 0)
                    <div x-data="{ openModalDraw: false }" class="flex justify-center">
                        <button class="btn btn-create mt-3" @click="openModalDraw = true">
                            {{ __('Add rewards') }}
                        </button>
                        <!-- Modal -->
                        <div class="overlay" x-show="openModalDraw" @click.away="openModalDraw = false" >
                            <!-- A basic modal dialog with title, body and one button to close -->
                            <div class="modal-container">
                                <div class="modal">
                                    <h3 class="modal-title">
                                        {{ __('form for adding rewards') }}
                                    </h3>
                                    <div class="modal-form mt-2">
                                        <form method="POST" action="{{ route('anim.grid.rewards.add') }}" class="flex flex-col justify-center items-center">
                                            @csrf
                                            <!-- hidden field of grid's id -->
                                                <x-input type="hidden" name="grid_id" value="{{ $grid->id }}"></x-input>
                                            <!-- Name reward -->
                                                <div class="w-2/3">
                                                    <x-label for="name" :value="__('Name of the reward')" />
                                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" :placeholder="__('Enter the name of the reward')" minlength="3" maxlength="190" required autofocus />
                                                    @error('name')
                                                        <p class="form-error">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            <!-- Number of units -->
                                                <div class="w-2/3 mt-3">
                                                    <x-label for="number" :value="__('Number of units')" />
                                                    <x-input id="number" class="block mt-1 w-full" type="number" name="number" :value="old('number')" :placeholder="__('Enter the number of units in this reward')" min="1" max="{{ ($grid->width*$grid->height) - count($grid->rewards) }}" required autofocus />
                                                    @error('number')
                                                    <p class="form-error">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            <!-- submit button -->
                                                <div class="w-full mt-7 mb-5 flex justify-between">
                                                    <button @click="openModalDraw = false" class="btn btn-close mx-10">
                                                        {{ __('Close') }}
                                                    </button>
                                                    <button type="submit" class="btn btn-create mx-10">
                                                        {{ __('Send') }}
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($grid->status === 'filled')
                    <div class="flex flex-col justify-center m-3">
                        <a href="{{ route('anim.grid.rewards.draw',$grid->id) }}" class="btn btn-create mb-3" >
                            {{ __('Allocate lots') }}
                        </a>
                        <p class="text-center">{{ __('Drawing of the box for each lot') }}.</p>
                    </div>
                @elseif($grid->status === "drawed")
                    <div class="flex flex-col justify-center m-3">
                        <a href="{{ route('anim.grid.rewards.confirm', $grid->id) }}" class="btn btn-create text-center">{{ __('Confirm the grid') }}</a>
                    </div>
                @elseif($grid->status === 'confirmed' || $grid->status === 'closed')
                    <div class="flex flex-col justify-start">
                        <ul class="fa-ul">
                            @foreach($grid_rewards as $reward)
                                @if($reward->is_taken === true)
                                    <li>
                                        <span class="fa-li"><i class="fa-solid fa-gem"></i></span>
                                        {{ __('Reward N°') }}{{ $reward->place }} > <span class="font-bold">{{ $reward->player }}</span> : {{ $reward->name }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </section>
        </div>
    </x-content-card>
</x-app-layout>

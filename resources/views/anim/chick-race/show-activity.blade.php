<x-app-layout>
    <x-slot name="header">
        {{ __('The chick race activity') }} "{{ $activity->name }}"
    </x-slot>

    <x-content-card>
        <div class="w-full grid grid-cols-3 place-items-stretch" id="chick-race-header">
            <div class="justify-self-start ml-2 uppercase font-extrabold text-blueGray-100 my-3">
                @if($activity->status === "new")
                    <span class="bg-red-700 rounded py-1 px-2">{{ __('New activity') }}</span>
                @elseif($activity->status === "prepared")
                    <span class="bg-blue-700 rounded py-1 px-2">{{ __('Race in preparation') }}</span>
                    <a href="{{ route('anim.chick-race.start', $activity->id) }}" class="ml-4 btn btn-primary" >{{ __('Start the race') }}</a>
                @elseif($activity->status === "launched")
                    <span class="bg-blue-700 rounded py-1 px-2">{{ __('Race in progress') }}</span>
                    <a href="{{ route('anim.chick-race.interrupt', $activity->id) }}" class="ml-4 btn btn-primary" >{{ __('Interrupt the race') }}</a>
                @else
                    <span class="bg-green-700 rounded py-1 px-2">{{ __('Activity closed') }}</span>
                @endif
            </div>
            <div>
                <h2 class="mt-2 mb-4 text-lg font-bold uppercase text-green-500">{{ __('Terrain of the race') }}</h2>
            </div>
            <div class="justify-self-end mr-3 mt-3" x-data="{ openModalCreateChick: false }">
                @if($activity->status === "new" || $activity->status === "prepared")
                    <button class="btn btn-create" @click="openModalCreateChick = true">{{ __('Create a chick') }}</button>
                @endif
                <!-- Modal -->
                <div class="overlay" x-show="openModalCreateChick" @click.away="openModalCreateChick = false" >
                    <div class="modal-container">
                        <div class="modal">
                            <h3 class="modal-title">
                                    {{ __('form for create a chick') }}
                            </h3>
                            <div class="modal-form mt-2">
                                <form method="POST" action="{{ route('anim.chick-race.create-chick') }}" class="flex flex-col justify-center items-center">
                                    @csrf
                                    <!-- hidden field of the activity's id -->
                                    <x-input type="hidden" name="chick_race_activity_id" value="{{ $activity->id }}"></x-input>
                                    <!-- Name of Player -->
                                    <div class="form-group">
                                        <x-label for="name_player" :value="__('username')" />
                                        <x-input id="name_player" class="block mt-1 w-full" type="text" name="name_player" :value="old('name_player')" :placeholder="__('Enter the username')" minlength="3" maxlength="50" required autofocus />
                                        @error('name_player')
                                        <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- Name of Chick -->
                                    <div class="form-group">
                                        <x-label for="name_chick" :value="__('chick\'s name')" />
                                        <x-input id="name_chick" class="block mt-1 w-full" type="text" name="name_chick" :value="old('name_chick')" :placeholder="__('Enter the chick\'s name')" minlength="3" maxlength="50" required autofocus />
                                        @error('name_chick')
                                        <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- Color -->
                                    <div class="form-group">
                                        <x-label for="color" :value="__('color')" />
                                        <select x-model="color" id="color" class="block mt-1 w-full form-select focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="color" required autofocus>
                                            <option value="null" class="text-blueGray-400">{{ __('Select a color') }}</option>
                                            <option value="gray">{{ __('white') }}</option>
                                            <option value="yellow">{{ __('yellow') }}</option>
                                            <option value="orange">{{ __('ginger') }}</option>
                                            <option value="black">{{ __('black') }}</option>
                                        </select>
                                        @error('color')
                                        <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- submit button -->
                                    <div class="w-full mt-7 mb-5 flex justify-between">
                                        <button @click="openModalCreateChick = false" class="btn btn-close mx-10">
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
        </div>
        <div class="w-full grid grid-cols-1 place-items-stretch" id="chick-race-main">
            <section id="chick-race" class="col-span-4">
                <div id="grid-chick-race">
                    <div class="text-center uppercase font-bold mb-4">{{ __('Finish') }}</div>
                    <hr class="border-2 border-opacity-50 border-blue-600">
                    @for($y=30; $y >= 0; $y--)
                        @if($y === 0)
                            <hr class="border-2 border-opacity-50 border-blue-600">
                        @endif
                        <div class="line">
                            <span class="w-full h-5 flex justify-end items-center pr-2 text-blueGray-500 text-right border-l border-opacity-50 border-blue-600 {{ $y === 0 ? 'border-b' : '' }}">{{ $y }}</span>
                            @for($x=1; $x < 11 + (3 * count($activity->chicks)); $x++)
                                <div class="box  {{ $y === 0 ? 'border-b' : '' }}">
                                    @foreach($activity->chicks as $chick)
                                        @if($chick->position_x === $x && $chick->position_y === $y && $activity->status === 'launched')
                                            <div x-data="{ openModalModifyChick: false, x: {{$chick->position_x}}, y: {{$chick->position_y}} }">
                                                <button @click="openModalModifyChick = true"
                                                        class="{{ 'w-full h-5 flex justify-center items-center bg-blue-500 text-' . $chick->color . '-300' }}">
                                                    <i class="fa-solid fa-kiwi-bird"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="overlay" x-show="openModalModifyChick" @click.away="openModalModifyChick = false" >
                                                    <!-- A basic modal dialog with title, body and one button to close -->
                                                    <div class="modal-container">
                                                        <div class="modal">
                                                            <h3 class="modal-title">
                                                                {{ __('Changing the position for') }} {{ $chick->name_chick }}
                                                            </h3>
                                                            <div class="modal-form mt-2">
                                                                <form method="POST" action="{{ route('anim.chick-race.update-chick', $chick->id) }}" class="flex flex-col justify-center items-center">
                                                                    @csrf
                                                                    <div class="w-full flex flex-row px-2">
                                                                        <!-- Position X -->
                                                                        <div class="w-2/3 mr-2">
                                                                            <x-label for="position_x" :value="__('x-position')" />
                                                                            <x-input id="position_x" class="block mt-1 w-full" type="number" name="position_x" x-model="x"
                                                                                     min="0" max="100" required autofocus />
                                                                            @error('position_x')
                                                                            <p class="form-error">{{ $message }}</p>
                                                                            @enderror
                                                                        </div>
                                                                        <!-- Position Y -->
                                                                        <div class="w-2/3 ml-2">
                                                                            <x-label for="position_y" :value="__('y-position')" />
                                                                            <x-input id="position_y" class="block mt-1 w-full" type="number" name="position_y" x-model="y"
                                                                                     min="0" max="100" required autofocus />
                                                                            @error('position_y')
                                                                            <p class="form-error">{{ $message }}</p>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <!-- submit button -->
                                                                    <div class="w-full mt-7 mb-5 flex justify-between">
                                                                        <button @click="openModalModifyChick = false" class="btn btn-close mx-10">
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
                                        @elseif($chick->position_x === $x && $chick->position_y === $y && ($activity->status === 'prepared' || $activity->status === 'closed'))
                                            <span class="{{ 'w-full h-5 flex justify-center items-center bg-blue-500 text-' . $chick->color . '-300' }}">
                                                <i class="fa-solid fa-kiwi-bird"></i>
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                        @if($y === 0)
                            <div class="text-center uppercase font-bold">{{ __('Start') }}</div>
                        @endif
                    @endfor
                </div>
            </section>
        </div>
    </x-content-card>
</x-app-layout>

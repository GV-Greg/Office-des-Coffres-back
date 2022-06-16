<x-app-layout>
    <x-slot name="header">
        {{ __('The activity code') }} "{{ $activity->name }}"
    </x-slot>

    <x-content-card>
        <div class="w-full grid grid-cols-3 place-items-stretch" id="code-main">
            <section id="code-infos" class="justify-self-start ml-2">
                <div class="uppercase font-extrabold text-blueGray-100 my-3">
                    @if($activity->status === "new")
                        <span class="bg-red-700 rounded py-1 px-2">{{ __('New activity') }}</span>
                    @elseif($activity->status === "launched" || $activity->status === "relaunch")
                        <span class="bg-blue-700 rounded py-1 px-2">{{ __('Current activity') }}</span>
                    @else
                        <span class="bg-green-700 rounded py-1 px-2">{{ __('Activity closed') }}</span>
                    @endif
                </div>
                @if($activity->status != "new")
                    <span class="font-bold ">{{ __('Mystery codes already discovered') }} :</span>
                    <ul>
                        @foreach($activity->codes as $code)
                            @if($code->status === 1)
                                <li><i class="fa-solid fa-unlock-keyhole"></i>
                                    <a href="{{ route('anim.decode.show-code', $code->id) }}"
                                       class="font-bold text-blue-500 hover:text-orange-500">
                                        {{ Crypt::decryptString($code->code) }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </section>
            <section id="code">
                <h2 class="mt-2 mb-4 text-lg font-bold uppercase text-green-500">{{ __('List of proposals') }}</h2>
                @if($activity->status === "launched")
                    <ul id="list-combinations">
                        @foreach($proposals as $proposal)
                            @if($proposal->points > 1)
                                <li><span class="font-extrabold">{{ $proposal->combination }}</span> : <span class="font-bold text-green-500">{{ $proposal->points }} {{ __('points') }}</span> <span class="text-xs">( {{ $proposal->player }} )</span></li>
                            @else
                                <li><span class="font-extrabold">{{ $proposal->combination }}</span> : <span class="font-bold text-blue-500">{{ $proposal->points }} {{ __('point') }}</span> <span class="text-xs">( {{ $proposal->player }} )</span></li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </section>
            <section id="code-actions" class="justify-self-end mt-2 mb-13 mr-3">
                @if($activity->status === "new" || $activity->status === "relaunch")
                    <div class="flex flex-col items-center mt-5 mr-2">
                        <form action="{{ route('anim.decode.create.code') }}" method="POST" class="hidden md:inline-block md:ml-1">
                            @csrf
                            <!-- hidden field of the activity's id -->
                            <x-input type="hidden" name="code_activity_id" value="{{ $activity->id }}"></x-input>
                            <button class="btn btn-create" type="submit">{{ __('Generate a mystery code') }}</button>
                        </form>
                    </div>
                @elseif($activity->status === "launched")
                    <div class="flex flex-col items-center">
                        <h3 class="mb-4 text-lg font-bold uppercase">{{ __('Form') }} {{ __('for sending combinations') }}</h3>
                        <form action="{{ route('anim.decode.verify', $activity->id) }}" method="POST" class="flex flex-col items-center mb-5">
                            @csrf
                            <!-- Combinations -->
                            <div>
                                <x-label for="combination" :value="__('Proposal')" />
                                <x-input id="combination" class="block mt-1 w-full" type="text" name="combination" :value="old('combination')" :placeholder="__('Enter the proposal')" minlength="5" maxlength="5" required autofocus />
                                @error('combination')
                                <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Pseudo -->
                            <div>
                                <x-label for="player" :value="__('Username')" />
                                <x-input id="player" class="block mt-1 w-full" type="text" name="player" :value="old('player')" :placeholder="__('Enter the username')" minlength="3" maxlength="30" required autofocus />
                                @error('player')
                                <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="btn btn-create mt-5" type="submit">{{ __('Send') }}</button>
                        </form>
                    </div>
                @endif
            </section>
        </div>
    </x-content-card>
</x-app-layout>

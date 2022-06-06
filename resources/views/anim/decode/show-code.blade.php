<x-app-layout>
    <x-slot name="header">
        {{ __('Code found in the activity code') }} "{{ $code->activity->name }}"
    </x-slot>

    <x-content-card>
        <a href="{{ url()->previous()  }}" class="bg-blueGray-800 text-blueGray-50 py-1 pr-1.5 pl-2 rounded">
            <i class="fa-solid fa-reply"></i>
        </a> <span class="font-extrabold uppercase text-lg ml-1">{{ __('Back') }}</span>
        <div class="w-full grid grid-cols-1">
            <section class="justify-self-center">
                <h2 class="mt-2 mb-4 text-lg font-bold uppercase text-green-500">{{ __('List of proposals') }}</h2>
                <ul id="list-combinations">
                    @foreach($code->proposals as $proposal)
                        @if($proposal->points > 1)
                            <li><span class="font-extrabold">{{ $proposal->combination }}</span> : <span class="font-bold text-green-500">{{ $proposal->points }} {{ __('points') }}</span> <span class="text-xs">( {{ $proposal->player }} )</span></li>
                        @else
                            <li><span class="font-extrabold">{{ $proposal->combination }}</span> : <span class="font-bold text-blue-500">{{ $proposal->points }} {{ __('point') }}</span> <span class="text-xs">( {{ $proposal->player }} )</span></li>
                        @endif
                    @endforeach
                </ul>
            </section>
        </div>
    </x-content-card>
</x-app-layout>

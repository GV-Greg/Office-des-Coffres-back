<x-app-layout>
    <x-slot name="header">
        {{ __('List of chick race activity') }}
    </x-slot>

    <x-content-card>
        @can('chick-race-crud')
            <div class="w-full md:w-1/2 mt-5 mb-3 mx-7 flex flex-col md:flex-row justify-start">
                <a class="btn btn-create" href="{{ route('anim.chick-race.create') }}">{{ __('Create a chick race activity') }}</a>
            </div>
            <div class="mt-5 w-full grid grid-cols-6">
                @forelse($activities as $activity)
                    <div class="chick-race-activity-card m-5 py-2" id="{{ 'activity' }}" data-activity-chick-race-id="{{ $activity->id }}">
                        <div class="activity-header">
                            <i class="fa-solid fa-kiwi-bird fa-2xl"></i>
                            <form action="{{ route('anim.chick-race.destroy', $activity->id) }}" method="POST" class="hidden md:inline-block md:ml-1">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button class="activity-destroy"><i class="fa-solid fa-square-xmark fa-xl"></i></button>
                            </form>
                        </div>
                        <div class="activity-title">{{ __('Chick race activity') }} <br /><span class="activity-name">{{ $activity->name  }}</span></div>
                        <div class="activity-status my-3">
                            @if($activity->status === 'new')
                                <span class="text-lime-500">{{ __($activity->status) }}</span>
                            @elseif($activity->status === 'prepared' || $activity->status === 'launched')
                                <span class="text-orange-500">{{ __($activity->status) }}</span>
                            @else
                                <span class="text-blueGray-400">{{ __($activity->status) }}</span>
                            @endif
                        </div>
                        <div class="activity-footer">{{ __('Created by-f') }} <span class="activity-creator">{{ $activity->creator->username }}</span></div>
                    </div>
                @empty
                    <div class="mt-5 ml-5 italic">
                        {{ __('No activity created') }}
                    </div>
                @endforelse
            </div>
        @endcan
    </x-content-card>

    @push('script')
        <script src="{{ asset('js/scripts.js') }}" defer></script>
    @endpush
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __('List of roles') }}
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
                    <a class="btn btn-create" href="{{ route('role.create') }}">{{ __('Create a role') }}</a>
                </div>
            </div>
            <table class="mt-5 md:mt-0 w-full md:w-1/2">
                <thead>
                <tr>
                    <th class="hidden md:table-cell">{{ __('ID') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th class="text-center">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <th class="hidden md:table-cell">{{ $role->id }}</th>
                        <td class="font-bold">{{$role->name}}</td>
                        <td class="text-center">
                            <a class="btn-show" href="{{ route('role.show',$role->id) }}"><i class="fa fa-fw fa-eye"></i><span class="hidden md:inline-block md:ml-1">{{ __('Show') }}</span></a>
                            @can('role-edit')
                                <a class="btn-edit" href="{{ route('role.edit',$role->id) }}"><i class="fa fa-fw fa-edit"></i><span class="hidden md:inline-block md:ml-1">{{ __('Edit') }}</span></a>
                            @endcan
                            @can('role-delete')
                                <form action="{{ route('role.destroy',$role->id) }}" method="POST" class="hidden md:inline-block md:ml-1">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button class="btn-delete"><i class="fa fa-fw fa-trash"></i><span>{{ __('Delete') }}</span></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{ $roles->links('pagination::tailwind') }}
            </div>
        </div>
    </x-content-card>
</x-app-layout>

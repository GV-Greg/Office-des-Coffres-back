<x-app-layout>
    <x-slot name="header">
        {{ __('List of permissions') }}
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
                    @can('permission-crud')
                        <a class="btn btn-create" href="{{ route('permission.create') }}">{{ __('Create a permission') }}</a>
                    @endcan
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
                @foreach($permissions as $permission)
                    <tr>
                        <th class="hidden md:table-cell">{{ $permission->id }}</th>
                        <td class="font-bold">{{$permission->name}}</td>
                        <td class="text-center">
                            @can('permission-crud')
                                <a class="btn-edit" href="{{ route('permission.edit',$permission->id) }}"><i class="fa fa-fw fa-edit"></i><span class="hidden md:inline-block md:ml-1">{{ __('Edit') }}</span></a>
                                <form action="{{ route('permission.destroy',$permission->id) }}" method="POST" class="hidden md:inline-block md:ml-1">
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
                {{ $permissions->links('pagination::tailwind') }}
            </div>
        </div>
    </x-content-card>
</x-app-layout>

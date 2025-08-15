<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions') }}
            </h2>
            <a class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white"
                href="{{ route('permissions.create') }}">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-yellow-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width="60">#</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="180">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($permissions->isNotEmpty())
                        @foreach ($permissions as $permission)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left"> {{$permission->id}}</td>
                                <td class="px-6 py-3 text-left">{{$permission->name}}</td>
                                <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($permission->created_at)->format('d M, Y')}}</td>
                                <td class="px-6 py-3 text-center">
                                    <a class="bg-blue-700 text-sm rounded-md px-3 py-2 text-white hover:bg-green-600"
                                        href="{{ route('permissions.edit', $permission->id) }}">Edit</a>
                                    <a class="bg-red-600 text-sm rounded-md px-3 py-2 text-white hover:bg-red-500"
                                        href="#">Delete</a>


                                </td>
                            </tr>
                        @endforeach

                    @endif

                </tbody>
            </table>

           <div class="my-3">
             {{$permissions->links()}}
           </div>
        </div>
    </div>
</x-app-layout>
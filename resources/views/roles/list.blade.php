<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            <a class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white"
                href="{{ route('roles.create') }}">Create</a>
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
                        <th class="px-6 py-3 text-left">Permission</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="180">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($roles->isNotEmpty())
                        @foreach ($roles as $role)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left"> {{$role->id}}</td>
                                <td class="px-6 py-3 text-left">{{$role->name}}</td>
                                <td class="px-6 py-3 text-left">
                                    {{ method_exists($role, 'getPermissionNames') ? $role->getPermissionNames()->implode(', ') : ($role->permissions && $role->permissions->isNotEmpty() ? $role->permissions->pluck('name')->implode(', ') : '') }}
                                </td>
                                <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($role->created_at)->format('d M, Y')}}</td>

                                <td class="px-6 py-3 text-center"></td>
                            </tr>
                        @endforeach

                    @endif

                </tbody>
            </table>

           <div class="my-3">
          {{--    {{$permissions->links()}} --}}
           </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id){

             if (confirm("Are you sure you want to delete this permission?")) {
                 $.ajax({
                     url: "{{ route('permissions.destroy') }}",
                     type: "delete",
                     data: { id:id },
                     dataType: 'json',
                     headers: {
                        'x-csrf-token': "{{ csrf_token() }}"
                     },
                     success: function (response) {
                        window.location.href = "{{ route('permissions.index') }}";
                     }
                 });
             }
        }
        </script>
    </x-slot>
</x-app-layout>
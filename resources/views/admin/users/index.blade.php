@extends('layouts.admin.app')
@section('Page Title', 'Users')

@section('title')

<p>USERS</p>

<div class="flex">

    <a href="{{ route('users.create') }}"
        class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add User</a>
</div>

@endsection

@section('content')
<div class="w-full  ">
    <table class="w-full table-auto" id="myTable">
        <thead class="bg-tableHead-gray ">
            <tr class="*:h-14">
                <th class="pl-6 text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">Name
                </th>
                <th class="text-left text-base font-bold text-custom-black ">Email
                </th>
                <th class="text-left text-base font-bold text-custom-black ">Roles
                </th>
                <th class="text-base font-bold text-custom-black align-center-important" data-dt-order="disable">Action
                </th>
            </tr>
        </thead>
        <tbody class=" divide-gray-200 ">
            @foreach ($users as $user)
            <tr class="border-b-2 *:h-14 hover:bg-dark-gray">
                <td class="pl-8 ">{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach ($user->roles as $role)
                    {{ ucfirst($role->name) }}
                    @endforeach
                </td>
                <td>
                    <div class="flex justify-center gap-2">
                        <form action="{{ route('users.destroy', $user->id) }}" method="post"id="delete-{{ $user->id }}">
                            @csrf
                            @method('DELETE')
                            <x-delete-button>Delete</x-delete-button>
                        </form>
                        <a href="{{ route('users.edit', $user->id) }}">
                            <x-edit-button>Edit</x-edit-button>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
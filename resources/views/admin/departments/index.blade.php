@extends('layouts.admin.app')
@section('Page Title', 'Departments')

@section('title')
    <p>DEPARTMENT</p>
    <a href="{{ route('departments.create') }}"
       class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add Department</a>

@endsection

@section('content')
    <div class="w-full ">

        <table class="w-full table-auto " id="myTable">
            <thead class="bg-tableHead-gray ">
            <tr class="*:h-14">
                <th class="pl-6  text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">Name
                </th>
                <th class="text-left text-base font-bold text-custom-black ">Head
                </th>
                <th class="text-center text-base font-bold text-custom-black align-center-important" data-dt-order="disable">Action
                </th>
            </tr>
            </thead>
            <tbody class=" divide-gray-200 ">
            @foreach ($departments as $department)
                <tr class="border-b-2 *:h-16 hover:bg-dark-gray">
                    <td class=" pl-8">{{ $loop->iteration }}</td>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->departmentHead->name }}</td>
                    <td class="text-center ">
                        <div class="flex gap-2 justify-center">
                            <form action="{{ route('departments.destroy', $department->id) }}" id="delete-{{ $department->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <x-delete-button>Delete</x-delete-button>
                            </form>
                            <a href="{{ route('departments.edit', $department->id) }}">
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
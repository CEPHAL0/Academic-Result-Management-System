@extends('layouts.hos.app')
@section('Page Title', 'Students')

@section('title')
    <p>Student</p>
    <div class="flex gap-2">
        <a href="{{ route('hosStudents.create') }}"
            class="bg-dark-orange text-white font-normal text-base px-4 py-3 rounded-md">Add Student</a>
        <a href="{{ route('hosStudents.getBulkUpload') }}"
            class="bg-dark-orange text-white font-normal text-base px-4 py-3 rounded-md">Bulk Upload
        </a>

    </div>

@endsection

@section('content')
    <div class="w-full">
        <table class="w-full table-auto" id="myTable">
            <thead class="bg-tableHead-gray ">
                <tr class="*:h-14">
                    <th class="pl-6 text-left text-base font-bold text-custom-black ">S.No.</th>
                    <th class="text-left text-base font-bold text-custom-black ">Name
                    </th>
                    <th class="text-left text-base font-bold text-custom-black ">Section
                    </th>
                    <th class="text-center text-base font-bold text-custom-black ">Roll No.
                    </th>
                    <th class="text-center align-center-important text-base font-bold text-custom-black ">Status
                    </th>
                    <th class="text-center text-base font-bold text-custom-black align-center-important"
                        data-dt-order="disable">Action
                    </th>
                </tr>
            </thead>
            <tbody class=" divide-gray-200 ">
                @foreach ($students as $student)
                    <tr class="*:h-16 border-b-2 hover:bg-dark-gray">
                        <td class="pl-8 ">{{ $loop->iteration }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->section->name }}</td>
                        <td class="text-center ">{{ $student->roll_number }}</td>
                        @if ($student->status == 'DROPPED_OUT')
                            <td class="text-center text-red-600">Dropped Out</td>
                        @else
                            <td class="text-center text-green-600">Active</td>
                        @endif

                        <td>
                            <div class="flex  justify-center gap-2">
                                <form action="{{ route('hosStudents.destroy', $student->id) }}" method="post"
                                    id="delete-{{ $student->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-delete-button>Delete</x-delete-button>
                                </form>
                                <a href="{{ route('hosStudents.edit', $student->id) }}">
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

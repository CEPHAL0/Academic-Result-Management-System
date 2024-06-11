@extends('layouts.admin.app')
@section('Page Title', 'Students')


@section('title')
    <p>STUDENTS</p>
    <div class="flex gap-2">
        <a href="{{ route('students.create') }}"
            class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add Student</a>
        <a href="{{ route('student.getBulkUpload') }}"
            class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Bulk Upload
        </a>

    </div>
@endsection

@section('content')
    <div class="w-full">
        <table class="w-full table-auto" id="myTable">
            <thead class="bg-tableHead-gray ">
                <tr class="*:h-14">
                    <th class="pl-6  text-left text-base font-bold text-custom-black ">S.No.</th>
                    <th class=" text-left text-base font-bold text-custom-black ">Name
                    </th>
                    <th class=" text-left text-base font-bold text-custom-black ">Section
                    </th>
                    <th class=" text-left text-base font-bold text-custom-black ">Roll No.
                    </th>
                    <th class=" text-left text-base font-bold text-custom-black ">Status
                    </th>
                    <th class=" text-center text-base font-bold text-custom-black align-center-important"
                        data-dt-order="disable">Action
                    </th>
                </tr>
            </thead>
            <tbody class=" divide-gray-200 ">
                @foreach ($students as $student)
                    <tr class="border-b-2 *:h-16 hover:bg-dark-gray">
                        <td class="pl-8  ">{{ $loop->iteration }}</td>
                        <td>{{ $student->name }}</td>
                        @if(!$student->section)
                            <td class="text-red-500"><s>Not Assigned</s></td>
                        
                        @else
                            <td>{{$student->section->name}}</td>
                        
                        @endif
                        <td>{{ $student->roll_number }}</td>
                        @if ($student->status == 'DROPPED_OUT')
                            <td class="  text-red-600">Dropped Out</td>
                        @else
                            <td class=" text-green-600">Active</td>
                        @endif

                        <td>
                            <div class="flex  justify-center gap-2">
                                <form action="{{ route('students.destroy', $student->id) }}" method="post" id="delete-{{ $student->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-delete-button>Delete</x-delete-button>
                                </form>
                                <a href="{{ route('students.edit', $student->id) }}">
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

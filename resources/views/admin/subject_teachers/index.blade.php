@extends('layouts.admin.app')
@section('Page Title', 'Subject Teacher')


@section('title')
    <p>SUBJECT TEACHERS</p>
    <a href="{{ route('subject-teachers.create') }}"
       class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add Subject Teacher</a>
@endsection

@section('content')
    <div class="w-full ">
        <table class="w-full table-auto" id="myTable">
            <thead class="bg-tableHead-gray">
            <tr class="*:h-14">
                <th class="pl-6  text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">Subject
                </th>
                <th class="text-left text-base font-bold text-custom-black ">Teacher
                </th>
                <th class="text-center text-base font-bold text-custom-black ">Grade
                </th>
                <th class="text-center text-base font-bold text-custom-black ">Section
                </th>
                <th class="text-center text-base font-bold text-custom-black align-center-important"
                    data-dt-order="disable">Action
                </th>
            </tr>
            </thead>
            <tbody class=" divide-gray-200 ">
            @foreach ($subject_teachers as $subject_teacher)
                <tr class="border-b-2 *:h-16 hover:bg-dark-gray">
                    <td class="pl-8 ">{{ $loop->iteration }}</td>
                    <td>{{ $subject_teacher->subject->name }}</td>
                    <td>{{ $subject_teacher->teacher->name }}</td>
                    <td>{{ $subject_teacher->subject->grade->name }}</td>
                    <td>{{ $subject_teacher->section->name }}</td>
                    <td>
                        <div class="flex gap-2 justify-center">
                            <form action="{{ route('subject-teachers.destroy', $subject_teacher->id) }}" method="post"
                                  id="delete-{{ $subject_teacher->id }}">
                                @csrf
                                @method('DELETE')
                                <x-delete-button>Delete</x-delete-button>
                            </form>
                            <a href="{{ route('subject-teachers.edit', $subject_teacher->id) }}">
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
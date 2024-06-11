@extends('layouts.admin.app')
@section('Page Title', 'All Assignments')

@section('title')
<p>All Assignments</p>
<div>
    <a href="{{ route('assignments.create') }}"
        class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add Assignment</a>
</div>
@endsection

@section('content')
<div class="w-full  ">
    <table class="w-full table-auto" id="myTable">
        <thead class="bg-tableHead-gray">

            <tr class="*:h-14">
                <th class="pl-6 text-left text-base font-bold text-custom-black">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black">Name</th>
                <th class="text-left text-base font-bold text-custom-black">Teacher</th>
                <th class="text-left text-base font-bold text-custom-black">Date</th>
                <th class="text-left text-base font-bold text-custom-black">Subject</th>
                <th class="text-left text-base font-bold text-custom-black">Grade</th>
                <th class="text-left text-base font-bold text-custom-black">Section</th>
                <th class="text-left text-base font-bold text-custom-black">CAS Type</th>
                <th class="text-left text-base font-bold text-custom-black">Term</th>
                <th class="text-center text-base font-bold text-custom-black align-center-important" data-dt-order="disable">Action</th>
            </tr>
        </thead>
        <tbody class="divide-gray-200">
            @foreach ($assignments as $assignment)
            <tr class="border-b-2 *:h-16">
                <td class="pl-8">{{ $loop->iteration }}</td>
                <td>{{ $assignment->name }}</td>
                <td>{{ $assignment->subjectTeacher->teacher->name }}</td>
                <td>{{ $assignment->date_assigned }}</td>
                <td>{{ $assignment->subjectTeacher->subject->name }}</td>
                <td>{{ $assignment->subjectTeacher->subject->grade->name }}</td>
                <td>{{ $assignment->subjectTeacher->section->name }}</td>
                <td>{{ $assignment->casType->name }}</td>
                <td>{{ $assignment->term->name }}</td>
                <td class="text-center">
                    <div class="flex gap-2 justify-center">
                        <form action="{{ route('assignments.destroy', $assignment->id) }}" method="post" id="delete-{{ $assignment->id }}">
                            @csrf
                            @method('DELETE')
                            <x-delete-button>Delete</x-delete-button>
                        </form>
                        <a href="{{ route('assignments.edit', $assignment->id) }}">
                            <x-edit-button>Edit</x-edit-button>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            @if ($assignments->isEmpty())
            <tr>
                <td colspan="10" class="text-center text-2xl  py-4 ">No Assignments Found</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
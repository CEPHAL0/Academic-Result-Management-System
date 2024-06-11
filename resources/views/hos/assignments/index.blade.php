@extends('layouts.hos.app')
@section('Page Title', 'All Assignments')

@section('title')
    <p>Assignments</p>
    <a href="{{ route('hosCasReport.index') }}"
        class="bg-dark-orange text-white px-3 rounded-md markType text-sm font-normal flex items-center hover:bg-white hover:text-dark-orange border border-dark-orange transition-colors py-2">Report</a>
@endsection

@section('content')
    <div class="w-full">
        <table class="w-full" id="myTable">
            <thead class="bg-dark-gray">
                <tr class="bg-dark-gray h-14 border">
                    <th class="pl-4 text-left">S.No.</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Date</th>
                    <th class="text-left">Subject</th>
                    <th class="text-left">Section</th>
                    <th class="text-left">CAS Type</th>
                    <th class="text-left">Term</th>
                    <th class="pr-4 text-center align-center-important" data-dt-order="disable">Actions</th>
                </tr>
            </thead>

            @foreach ($assignments as $assignment)
                <tr class="h-16 border-b-2 hover:bg-dark-gray">
                    <td class="pl-4">{{ $loop->iteration }}</td>
                    <td>{{ $assignment->name }}</td>
                    <td>{{ $assignment->date_assigned }}</td>
                    <td>{{ $assignment->subjectTeacher->subject->name }}</td>

                    <td>{{ $assignment->subjectTeacher->section->name }}</td>
                    <td>{{ $assignment->casType->name }}</td>
                    <td>{{ $assignment->term->name }}</td>
                    <td class="pr-4 text-center">
                        <div class="flex gap-2 justify-center">
                            <a href="{{ route('hosAssignments.edit', $assignment->id) }}">
                                <x-edit-button>Edit</x-edit-button>
                            </a>

                            <form action="{{ route('hosAssignments.destroy', $assignment->id) }}" method="POST"
                                id="delete-{{ $assignment->id }}">

                                @csrf
                                @method('DELETE')
                                <x-delete-button>Delete</x-delete-button>
                            </form>
                        </div>

                    </td>
            @endforeach
        </table>

    </div>
@endsection

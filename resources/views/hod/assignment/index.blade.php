@extends('layouts.hod.app')
@section('Page Title', 'All Assignments')

@section('title', 'CAS')

@section('content')
<div class="w-full">
    <table class="w-full " id="myTable">
        <thead class="bg-dark-gray">
            <tr class="*:text-left bg-dark-gray h-14 border">
                <th class="pl-4">S.No.</th>
                <th>Name</th>
                <th>Date</th>
                <th>Subject</th>
                <th>Section</th>
                <th>CAS Type</th>
                <th>Term</th>
                <th class="align-center-important" data-dt-order="disable">Actions</th>
            </tr>
        </thead>
        @foreach ($assignments as $assignment)
        <tr class="h-14 border-b-2 hover:bg-dark-gray">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $assignment->name }}</td>
            <td>{{ $assignment->date_assigned }}</td>
            <td>{{ $assignment->subjectTeacher->subject->name }}</td>

            <td>{{ $assignment->subjectTeacher->section->name }}</td>
            <td>{{ $assignment->casType->name }}</td>
            <td>{{ $assignment->term->name }}</td>

            <td class="pr-4">

                <a href="{{ route('hodAssignments.view', $assignment->id) }}"
                    class="px-4 py-[0.3rem] border border-custom-black bg-custom-black text-white hover:text-custom-black hover:bg-transparent transition-colors rounded-md">View</a>


            </td>
        </tr>
        @endforeach
    </table>

</div>
@endsection
@extends('layouts.hod.app')

@section('Page Title', 'View Assignment')

@section('title')
    Marks of {{ $assignment->name }} : {{ $assignment->subjectTeacher->section->name }}
@endsection

@section('content')
    <div class="px-4 py-4 w-full ">
        <form id="form" method="POST">
            @csrf

            {{-- CAS FORM CONTAINER TO CREATE ASSIGNMENT --}}
            <div class="casFormContainer flex gap-4">
                <div class="flex flex-col">
                    <label for="assignmentName" class="text-sm text-custom-black">Name</label>
                    <input disabled class="border border-custom-black rounded-sm px-3 py-1" value="{{ $assignment->name }}">
                </div>

                <div class="flex flex-col">
                    <label for="date" class="text-sm text-custom-black">Date</label>
                    <input disabled class="border border-custom-black rounded-sm px-3 py-1"
                        value="{{ $assignment->date_assigned }}">
                </div>

                <div class="flex flex-col">
                    <label for="fullMarks" class="text-sm text-custom-black">Full Marks</label>
                    <input class="border border-custom-black rounded-sm px-3 py-1 w-24 grow"
                        value="{{ $assignment->casType->full_marks }}" disabled>
                </div>

                <div class="flex flex-col">
                    <label for="casType" class="text-sm text-custom-black">CAS Type</label>
                    <input class="border border-custom-black rounded-sm px-3 py-1 grow"
                        value="{{ $assignment->casType->name }}" disabled>

                    </input>
                </div>


            </div>




            {{-- SECTION FOR STUDENT MARKS --}}
            <div class="mt-5">
                <table class="table-auto w-full">
                    <thead class="bg-dark-gray">
                        <tr class="border-b-2 h-10">
                            <th class="px-2 text-left">Roll No</th>
                            <th class="px-2 text-left">Name</th>
                            <th class="px-2 text-left">Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cas as $casOne)
                            <tr class="h-14 border-b-2 hover:bg-dark-gray ">
                                <td class="px-2 text-left">{{ $casOne->student->roll_number }}</td>
                                <td class="px-2 text-left">{{ $casOne->student->name }}</td>
                                <td class="px-2 text-left">
                                    {{ $casOne->mark }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection

@section('script')

@endsection

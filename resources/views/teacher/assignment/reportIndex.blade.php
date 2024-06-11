@extends('layouts.teacher.app')

@section('Page Title', 'CAS Report')



@section('title')
    <div>CAS Report of - <span class="text-custom-black font-normal">{{ $latestSubjectTeacher->subject->name }}
            <span class="text-sm">{{ $latestSubjectTeacher->section->name }}</span></span>
    </div>


@endsection

@section('content')
    <div class="w-full flex flex-col gap-2">

        {{-- Form Container --}}
        <div class="pt-3 pb-2 px-2">
            <form method="POST" action="{{ route('teacherCasReport.search') }}">
                @csrf
                @method('POST')

                {{-- Filters for search --}}
                <div class="text-base font-normal flex gap-2">

                    {{-- Subject teacher filter --}}
                    <select name="subjectTeacher" id="subjectTeacher"
                        class="border-2 text-black border-dark-orange px-2 rounded-sm selectSubject text-base">


                        {{-- Place holder option --}}
                        <option value="{{ null }}" selected class="bg-white text-black selectOptionSubject">
                            --Select
                            Subject--
                        </option>

                        {{-- Looping through subject teachers --}}
                        @foreach ($subjectTeachers as $subjectTeacher)
                            <option value="{{ $subjectTeacher->id }}" class="bg-white text-black">
                                {{ $subjectTeacher->subject->name }} --
                                {{ $subjectTeacher->section->name }}</option>
                        @endforeach


                    </select>

                    {{-- Term Filter --}}
                    <select name="term" id="term"
                        class="border-2 text-black border-dark-orange px-2 rounded-sm selectTerm text-base">

                        {{-- Select option placeholder --}}
                        <option value="{{ null }}" selected class="bg-white text-black selectOptionTerm">--Select
                            Term--
                        </option>

                        {{-- Looping through terms --}}
                        @foreach ($terms as $term)
                            <option value="{{ $term->id }}" class="bg-white text-black">
                                {{ $term->name }} --
                                Grade {{ $term->grade->name }}</option>
                        @endforeach


                    </select>

                    {{-- CAS Type filter --}}
                    <select name="casType" id="casType"
                        class="border-2 text-black border-dark-orange px-2 rounded-sm selectCasType text-base">


                        <option value="{{ null }}" selected class="bg-white text-black selectOptionCasType">
                            --Select
                            CAS Type--
                        </option>


                        @foreach ($casTypes as $casType)
                            <option value="{{ $casType->id }}" class="bg-white text-black">
                                {{ $casType->name }} -- {{ $casType->school->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="px-2 bg-dark-orange text-white rounded-md text-base py-[0.3rem]">Generate</button>
                </div>
            </form>
        </div>


        {{-- Table of student marks --}}
        <div class="border overflow-x-scroll">

            <table class="table-auto w-full">
                <thead class="bg-dark-gray sticky top-0 z-20">
                    <tr class="h-6">

                        <th class="text-left pl-4 w-[35px]">S.No.</th>
                        <th class="text-left w-1/6 pl-4">Names</th>

                        {{-- Looping through cas type names --}}
                        @foreach ($cas as $casType => $assignments)
                            <th colspan="{{ count($assignments) }}" class="border border-neutral-500">{{ $casType }}
                            </th>
                        @endforeach
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>

                        {{-- Looping through assignment names --}}
                        @foreach ($cas as $casType => $assignments)
                            @foreach ($assignments as $assignmentJson => $casMarks)
                                <th class="text-xs font-normal text-gray-700 border border-neutral-500">
                                    {{ json_decode($assignmentJson)->name }}</th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>

                <tbody class="text-sm">

                    @foreach ($students as $student)
                        <tr class="h-8 hover:bg-dark-gray">

                            <td class="pl-4 w-[35px]">{{ $student->roll_number }}</td>

                            <td class="w-1/6 pl-4">{{ $student->name }}</td>


                            {{-- Looping through casTypes, assignments, casMarks and mapping with student ids --}}
                            @foreach ($cas as $casType => $assignments)
                                @foreach ($assignments as $assignmentName => $casMarks)
                                    @foreach ($casMarks as $casMark)
                                        @if ($casMark->student_id == $student->id)
                                            <td class="text-center border-x border-neutral-500">{{ $casMark->mark }}</td>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach

                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>

    </div>
@endsection


@section('script')
    <script>
        $(".selectTerm").change(function() {
            $(".selectOptionTerm").hide();
        })

        $(".selectSubject").change(function() {
            $(".selectOptionSubject").hide();
        })

        // $(".selectCasType").change(function() {
        //     $(".selectOptionCasType").hide();
        // })
    </script>
@endsection

@extends('layouts.hos.app')

@section('Page Title', 'Edit Exam Marks')

@section('title')
    <div class="flex flex-col">
        <p>Marks of {{ $subject->grade->name }} - {{ $subject->name }} </p>
        <span class="text-sm font-normal text-custom-black">{{ $term->name }}</span>
    </div>

    <div name="markType" class="bg-dark-orange text-white px-3 py-3 rounded-md markType text-sm font-normal">
        EXAM
    </div>

@endsection

@section('content')
    <div class="w-full min-h-fit ">
        <form id="form" method="POST" action="{{ route('hosExams.update', [$term->id, $subject->id]) }}">
            @csrf
            @method('POST')


            {{-- TABLE FOR EXAM MARKS --}}
            <table class="table-auto w-full" id="examTable">

                <thead class="bg-dark-gray">
                    <tr class="border-b-2 h-14">
                        <th class="px-2 pl-24 w-1/5 text-left">Roll No</th>
                        <th class="px-2 text-left">Name</th>
                        <th class="px-2 text-left">Marks</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($exams as $exam)
                        <input type="hidden" name="exams[]" value="{{ $exam->id }}">
                        <tr class="h-14 border-b-2 hover:bg-dark-gray">

                            <td class="px-2 pl-24 text-left">{{ $exam->studentExam->student->roll_number }}</td>
                            <td class="px-2 text-left">{{ $exam->studentExam->student->name }}</td>
                            <td class="px-2 text-left">
                                <input type="number" min=0 max={{ $fullMark }} step=0.1 name="examMarks[]" required
                                    value="{{ old('examMarks.' . $loop->iteration - 1, $exam->mark) }}"
                                    class="border border-custom-black rounded-sm px-3 py-1 grow w-16">
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="py-2 px-2 text-left">
                            <button type="submit"
                                class="bg-dark-orange px-[0.8rem] py-1 border border-dark-orange text-white rounded-sm place-self-end hover:bg-white hover:text-dark-orange transition-colors"
                                id="saveExamForm">Save</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection

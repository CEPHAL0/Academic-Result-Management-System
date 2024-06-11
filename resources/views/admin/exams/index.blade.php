@extends('layouts.admin.app')

@section('title', 'Exams')

@section('content')


    {{-- REPLACE 1 with the subjectTeacher ID --}}
    <a href="{{ route('exam.create', '1') }}" class="btn btn-outline-success">Create Exam</a>

    <table class="table table-striped table-hover table-bordered mt-2">
        <thead>
            <tr>
                <th>Exam ID</th>
                <th>Student Name</th>
                <th>Symbol No</th>
                <th>Term Name</th>
                <th>Subject</th>
                <th>Checked By</th>
                <th>Grade Section</th>
                <th>Exam Type</th>
                <th>Marks</th>
                <th>Date of Exam</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exams as $exam)
                <tr>
                    <td>{{ $exam->id }}</td>
                    <td>{{ $exam->studentExam->student->name }}</td>
                    <td>{{ $exam->studentExam->symbol_no }}</td>
                    <td>{{ $exam->term->name }}</td>
                    <td>{{ $exam->subjectTeacher->subject->name }}</td>
                    <td>{{ $exam->subjectTeacher->teacher->name }}</td>
                    <td>{{ $exam->studentExam->student->section->grade->name }}
                        {{ $exam->studentExam->student->section->name }}
                    </td>
                    <td>{{ $exam->type }}</td>
                    <td>{{ $exam->mark }}</td>
                    <td>{{ $exam->date }}</td>
                    <td>
                        <a href="{{ route('exam.edit', $exam->id) }}" class="btn btn-outline-primary">Edit</a>

                        <form action="{{ route('exam.destroy', $exam->id) }}" method="POST" id="delete-{{ $exam->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger mt-2 d-inline-block">Delete</button>
                        </form> <br>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

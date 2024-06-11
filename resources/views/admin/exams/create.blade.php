@extends('layouts.admin.app')

@section('tile', 'Enter Exam Marks')

@section('content')

    <div>{{ $subjectTeacher->subject->name }} {{ $subjectTeacher->teacher->name }}</div>

    <form action="{{ route('exam.store', $subjectTeacher->id) }}" method="POST">
        @csrf
        <label for="date">Choose the Date of Exam: </label>
        <input type="date" name="date" value="{{ old('date') }}">

        <select name="type">
            <option value="{{ null }}">-- Select --</option>
            @if (old('type') == 'THEORY')
                <option value="THEORY" selected>Theory</option>
                <option value="PRACTICAL">Practical</option>
            @elseif(old('type') == 'PRACTICAL')
                <option value="THEORY">Theory</option>
                <option value="PRACTICAL" selected>Practical</option>
            @else
                <option value="THEORY">Theory</option>
                <option value="PRACTICAL">Practical</option>
            @endif
        </select>

        <table class="table table-bordered table-hover table-striped mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Symbol Number</th>
                    <th>Marks</th>
                </tr>
            </thead>
            @foreach ($students as $student)
                <tr>
                    <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->roll_number }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->section->name }}</td>
                    <td> <input type="text" name="symbol_nos[]" value="{{ old('symbol_nos.' . $loop->iteration - 1) }}">
                    </td>
                    <td> <input type="number" name="marks[]" value="{{ old('marks.' . $loop->iteration - 1) }}">
                    </td>
                </tr>
            @endforeach

        </table>
        <button type="submit" class="btn btn-outline-success">Submit Marks</button>
    </form>


@endsection

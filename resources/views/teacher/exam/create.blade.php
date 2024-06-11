@extends('layouts.teacher.app')

@section('title', 'Enter Marks')

@section('content')
    <form action="{{ route('teacher-exam-mark.store', ['id' => $subject_teachers->id]) }}" method="POST">
        @csrf
        <label for="term">Select the term: </label>
        <select name="term" id="term">
            @foreach ($terms as $term)
                <option value="{{ $term->id }}">{{ $term->name }}</option>
            @endforeach
        </select>

        <table class="table table-bordered table-hover table-striped mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Symbol Number</th>
                    <th>Marks</th>
                </tr>
            </thead>
            @foreach ($students as $student)
                <tr>
                    <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->roll_number }}</td>
                    <td>{{ $student->name }}</td>
                    <td> <input type="text" name="symbol_nos[]" value="{{ old('symbol_nos.' . $loop->iteration - 1) }}">
                    </td>
                    <td> <input type="number" name="marks[]" min=0 step=0.1
                            value="{{ old('marks.' . $loop->iteration - 1) }}">
                    </td>
                </tr>
            @endforeach

        </table>
        <button type="submit" class="btn btn-outline-success">Submit Marks</button>
    </form>
@endsection

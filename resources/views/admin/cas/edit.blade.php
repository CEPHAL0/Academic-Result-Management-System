@extends('layouts.admin.app')
@section('title', 'Create CAS')
@section('content')
    <form action="{{ route('cas.update', ['ca' => $cas->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="student_id">Select the Student: </label>
        <select name="student_id" id="student_id">
            @foreach ($students as $student)
                @if ($student->id == $cas->student->id)
                    <option value="{{ $student->id }}" selected>{{ $student->name }}</option>
                @else
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endif
            @endforeach
        </select>

        <br>
        <label for="assignment_id">Select the Assignment: </label>
        <select name="assignment_id" id="assignment_id">
            @foreach ($assignments as $assignment)
                @if ($assignment->id == $cas->assignment->id)
                    <option value="{{ $assignment->id }}" selected>{{ $assignment->name }}</option>
                @else
                    <option value="{{ $assignment->id }}">{{ $assignment->name }}</option>
                @endif
            @endforeach
        </select>

        <br>
        <label for="mark">Enter the marks: </label>
        <input type="number" name="mark" value="{{ $cas->mark }}">

        <br>
        <label for="remarks">Enter the remarks:</label> <br>
        <textarea name="remarks" id="remarks" cols="30" rows="3">{{ $cas->remarks }}</textarea>
        <br>
        <button type="submit">Update CAS</button>
    </form>
@endsection

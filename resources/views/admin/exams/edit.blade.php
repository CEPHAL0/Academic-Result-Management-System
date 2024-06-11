@extends('layouts.admin.app')

@section('title', 'Create Department')

@section('content')
    <form action="{{ route('exam.update', $exam->id) }}" method="POST">
        @csrf
        <div>Student: {{ $exam->studentExam->student->name }}</div>

        <div>Section: {{ $exam->studentExam->student->section->name }}</div>

        <label for="type">Select the Subject Type</label>
        <select name="type" id="type">
            @if ($exam->type == 'THEORY')
                <option value="THEORY" selected>Theory</option>
                <option value="PRACTICAL">Practical</option>
            @else
                <option value="PRACTICAL" selected>Practical</option>
                <option value="THEORY">Theory</option>
            @endif
        </select>

        <br><br>
        <label for="symbol_no">Enter the Symbol No: </label>
        <input type="text" name="symbol_no" value="{{ $exam->studentExam->symbol_no }}">

        <br><br>
        <label for="mark">Enter the Marks: </label>
        <input type="number" name="mark" value="{{ $exam->mark }}">

        <br><br>
        <label for="date">Choose the Date of Exam: </label>
        <input type="date" name="date" value="{{ $exam->date }}">

        <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
@endsection

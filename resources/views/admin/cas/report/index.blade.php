@extends('layouts.admin.app')

@section('title', 'CAS Report')

@section('content')

    <form action="{{ route('cas.reportSearch') }}">
        @csrf
        <select name="subject_teacher_id" id="subject_teacher" class="mb-2 form-control-sm">
            <option value="{{ null }}">-- Select Subject --</option>
            @foreach ($subjectTeachers as $subjectTeacher)
                <option value="{{ $subjectTeacher->id }}">
                    {{ $subjectTeacher->subject->name }}
                    {{ $subjectTeacher->section->grade->name }}:{{ $subjectTeacher->section->name }}
                </option>
            @endforeach
        </select>

        <select name="student_id" id="student_id" class="form-control-sm mb-2">
            <option value="{{ null }}" selected>-- Select Student --</option>
            @foreach ($allStudents as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-outline-primary btn-sm mb-2s">Get Report</button>
    </form>

    <table class="table table-border table-hover table-striped">
        <tr>
            <th>Roll</th>
            <th>Student Name</th>
            @forelse ($assignments as $assignment)
                <th>{{ $assignment->name }}</th>
            @empty
                <th></th>
            @endforelse
        </tr>
        @forelse ($students as $student)
            <tr>
                <td>{{ $student->roll_number }}</td>
                <td>{{ $student->name }}</td>
                @foreach ($assignments as $assignment)
                    <td>
                        @php
                            $cas = $assignment->cas->firstWhere('student_id', $student->id);
                        @endphp
                        {{ $cas ? $cas->mark : '-' }}
                    </td>
                @endforeach
            </tr>
        @empty
            <tr></tr>
        @endforelse
    </table>

@endsection

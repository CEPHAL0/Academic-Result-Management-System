@extends('layouts.teacher.app')

@section('title','Dashboard')

@section('content')
    <a href="{{route('teacher-exam-mark.create',$subjectTeacher->id)}}">
        <button>Create Marks</button>
    </a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>S.N</th>
            <th>Student</th>
            @forelse($terms as $term)
                <th>{{$term->name}}</th>
            @empty
                <th>No Terms Found</th>
            @endforelse
        </tr>
        </thead>
        <tbody>
        @foreach($exammarks as $exammark)

                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$exammark->studentExam}}</td>
                    <td>{{$exammark->mark}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
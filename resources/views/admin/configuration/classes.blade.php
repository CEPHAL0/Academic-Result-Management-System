@extends('layouts.admin.app')

@section('Page Title', 'Home')

@section('title', 'My Classes')


@section('content')

<div class="w-full  overflow-y-scroll m-5 h-max-80 ">
    <div>
        <p class="text-center py-3 text-lg font-bold">CAS Marks</p>
        <div
            class="px-12  py-5 flex flex-wrap  gap-x-14 gap-y-5 items-center justify-center content-center overflow-x-scroll hide-scrollbar">
            @foreach ($classes as $class)
            <a class="bg-dark-gray xl:h-40 xl:w-64 h-24 w-56 flex flex-col items-center justify-center rounded-md border border-dark-gray hover:border-black shadow-lg"
                href="{{ route('cas.create', $class->id) }}">
                <p class="font-bold text-md">{{ $class->subject->grade->name }} {{ $class->section->name }}</p>
                <p class="font-bold text-lg">{{ $class->subject->name }}</p>
            </a>
            @endforeach
        </div>
    </div>

</div>

{{-- <div>
    <h5 class="text-center">Exam Marks</h5>
    <div class="container">
        @foreach ($classes as $class)
        <a class="card" href="{{ route('exam.create', $class->id) }}">
            <p class="class">{{ $class->subject->grade->name }} {{ $class->section->name }}</p>
            <p class="subject">{{ $class->subject->name }}</p>
        </a>
        @endforeach
    </div>
</div> --}}
@endsection
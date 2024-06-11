@extends('layouts.admin.app')
@section('Page Title', 'Add Subject Teacher')

@section('title', 'Create Subject Teacher')

@section('content')
    <div class="w-full">

        <div class="w-full flex justify-center items-center mt-8">
            <form action="{{ route('subject-teachers.store') }}" method="post" class="w-1/2">
                @csrf
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="subject" class="text-lg font-semibold text-custom-black">Choose the Subject:</label>
                        <select name="subject_id" id="subjectSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="{{null}}">--Select Subject--</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}:
                                    {{ $subject->grade->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="teacher" class="text-lg font-semibold text-custom-black">Select the Teacher:</label>
                        <select name="teacher_id" id="teacherSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="{{null}}">--Select Teacher--</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="section" class="text-lg font-semibold text-custom-black">Select the Section:</label>
                        <select name="section_id" id="sectionSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="{{null}}">--Select Section--</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}: {{ $section->grade->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end ">
                        <x-link-button>
                            Add Subject Teacher
                        </x-link-button>
                    </div>
                </div>
            </form>

        </div>

@endsection
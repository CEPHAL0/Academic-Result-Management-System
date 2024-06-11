@extends('layouts.hos.app')
@section('Page Title', 'Edit Subject Teacher')

@section('title', 'Edit Subject Teacher')

@section('content')
    <div class="w-full">

        <div class="w-full flex justify-center items-center mt-8">
            <form action="{{ route('hosSubjectTeachers.update', $subjectTeacher->id) }}" method="POST" class="w-1/2">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-4">

                    <div class="flex flex-col gap-2">
                        <label for="subject" class="text-lg font-semibold text-custom-black">Choose the Subject:</label>

                        <select name="subject_id" id="subjectSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                            @foreach ($subjects as $subject)
                                @if ($subject->id == $subjectTeacher->subject_id)
                                    <option value="{{ $subject->id }}" selected>{{ $subject->name }} -- Grade
                                        {{ $subject->grade->name }}</option>
                                @else
                                    <option value="{{ $subject->id }}">{{ $subject->name }} -- Grade
                                        {{ $subject->grade->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="teacher" class="text-lg font-semibold text-custom-black">Select the Teacher:</label>
                        <select name="teacher_id" id="teacherSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            @foreach ($teachers as $teacher)
                                @if ($teacher->id == $subjectTeacher->teacher_id)
                                    <option value="{{ $teacher->id }}" selected>{{ $teacher->name }}</option>
                                @else
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="section" class="text-lg font-semibold text-custom-black">Section:</label>

                        <select name="section_id" id="sectionSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                            @foreach ($sections as $section)
                                @if ($section->id == $subjectTeacher->section_id)
                                    <option value="{{ $section->id }}" selected>{{ $section->name }}:
                                        {{ $section->grade->name }}
                                    </option>
                                @else
                                    <option value="{{ $section->id }}">{{ $section->name }}: {{ $section->grade->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end ">
                        <x-link-button>
                            Update Teacher
                        </x-link-button>
                    </div>
                </div>
            </form>

        </div>

@endsection
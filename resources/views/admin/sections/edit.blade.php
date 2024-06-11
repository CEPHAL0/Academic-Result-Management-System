@extends('layouts.admin.app')
@section('Page Title', 'Edit Section')

@section('title', 'Edit Section')

@section('content')
    <div class="w-full">
        <div class="w-full flex justify-center items-center mt-8">


            <form action="{{ route('sections.update', $section->id) }}" method="post" class="w-1/2">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-4">

                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Enter the Section Name:</label>

                        <input type="text" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ $section->name }}" required />
                    </div>

                    <div class="flex flex-col gap-2">

                        <label for="school_id" class="text-lg font-semibold text-custom-black">Enter the Grade:</label>

                        <select name="grade_id" id="gradeSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                            <option value="{{ null }}" selected>--Select Grade--</option>
                            @foreach ($grades as $grade )
                                @if($grade->id == $section->grade->id)
                                    <option value="{{ $grade->id }}" selected>{{ $grade->name }}</option>
                                @else
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endif
                            @endforeach
                        </select>

                    </div>

                    <div class="flex flex-col gap-2">

                        <label for="class_teacher_id" class="text-lg font-semibold text-custom-black">Enter the Class Teacher:</label>

                        <select name="class_teacher_id" id="teacherSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                            <option value="{{ null }}" selected>--Select Class Teacher--</option>

                            @foreach ($classTeachers as $classTeacher)
                                @if($classTeacher->id == $section->classTeacher->id)
                                    <option value="{{ $classTeacher->id }}" selected>{{ $classTeacher->name }}</option>
                                @else
                                    <option value="{{ $classTeacher->id }}">{{ $classTeacher->name }}</option>
                                @endif
                            @endforeach

                        </select>

                    </div>

                    <div class="flex justify-end ">
                        <x-link-button>
                            Update Section
                        </x-link-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
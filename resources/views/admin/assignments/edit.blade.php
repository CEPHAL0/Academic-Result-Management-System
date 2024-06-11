@extends('layouts.admin.app')

@section('Page Title', 'Edit Assignments')

@section('title', 'Create Assignment')

@section('content')
<div class="w-full">
    <div class="w-full flex justify-center items-center mt-8">
        <form action="{{ route('assignments.update') }}" method="post" class="w-1/2">
            @csrf

            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-lg font-semibold text-custom-black">Enter the name of
                        Assignment:</label>
                    <input type="text" name="name" id="name"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ $assignment->name }}" required />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="subject_teacher_id" class="text-lg font-semibold text-custom-black">Choose the Subject
                        Teacher:</label>
                    <select name="subject_teacher_id" id="subject_teacher_id"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                        <option value="{{null}}">--Select Subject Teacher--</option>
                        @foreach ($subject_teachers as $subject_teacher)
                        <option value="{{ $subject_teacher->id }}">{{ $subject_teacher->teacher->name }}:
                            {{ $subject_teacher->subject->name }}
                            {{ $subject_teacher->subject->grade->name }}-{{ $subject_teacher->section->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="date_assigned" class="text-lg font-semibold text-custom-black">Choose the Date of
                        Assignment:</label>
                    <input type="date" name="date_assigned" id="date_assigned"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ $assignment->date_assigned }}" required />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="description" class="text-lg font-semibold text-custom-black">Enter the Description of
                        assignment: </label>
                    <textarea name="description" id="description" cols="20" rows="10"
                        class="outline-orange-500 border-2 border-dark-gray">
                        {{ $assignment->description }}
                    </textarea>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="cas_type_id" class="text-lg font-semibold text-custom-black">Choose the CAS Type:
                    </label>
                    <select name="cas_type_id" id="cas_type_id"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                        <option value="{{null}}">--Select CAS Type--</option>
                        @foreach ($cas_types as $cas_type)
                        @if ($cas_type->id == $assignment->casType->id)
                        <option value="{{ $cas_type->id }}" selected>{{ $cas_type->name }}:
                            {{ $cas_type->school->name }}
                        </option>
                        @else
                        <option value="{{ $cas_type->id }}">{{ $cas_type->name }}:
                            {{ $cas_type->school->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="full_marks" class="text-lg font-semibold text-custom-black">Enter the Full Marks:
                    </label>
                    <input type="number" name="full_marks" id="full_marks"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{$assignment->full_marks}}">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="term_id" class="text-lg font-semibold text-custom-black">Choose the Term:
                    </label>
                    <select name="term_id" id="term_id"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                        <option value="{{null}}">--Select the Term--</option>

                        @foreach ($terms as $term)
                        <option value="{{ $term->id }}">{{ $term->name }}: {{ $term->grade->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end  ">
                    <x-link-button>
                        Update Assignment
                    </x-link-button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
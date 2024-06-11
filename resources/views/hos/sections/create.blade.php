@extends('layouts.hos.app')
@section('Page Title', 'Add Section')

@section('title', 'Add Section')

@section('content')
    <div class="w-full">
        <div class="w-full flex justify-center items-center mt-8">


            <form action="{{ route('hosSections.store') }}" method="post" class="w-1/2">
                @csrf
                @method('POST')
                <div class="flex flex-col gap-4">

                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Name</label>

                        <input type="text" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('name') }}" required />
                    </div>

                    <div class="flex flex-col gap-2">

                        <label for="school_id" class="text-lg font-semibold text-custom-black">Grade</label>

                        <select name="grade_id" id="gradeSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                            <option value="{{ null }}" selected>--Select Grade--</option>

                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach

                        </select>

                    </div>

                    <div class="flex flex-col gap-2">

                        <label for="class_teacher_id" class="text-lg font-semibold text-custom-black">Class Teacher</label>

                        <select name="class_teacher_id" id="teacherSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                            <option value="{{ null }}" selected>--Select Class Teacher--</option>

                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach

                        </select>

                    </div>

                    <div class="flex justify-end ">
                        <x-link-button>
                            Create Section
                        </x-link-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
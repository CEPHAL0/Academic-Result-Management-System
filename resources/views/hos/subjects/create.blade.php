@extends('layouts.hos.app')
@section('Page Title', 'Add Subject')

@section('title', 'Add Subject')

@section('content')
<div class="w-full">
    <div class="w-full flex justify-center items-center mt-8 ">


        <form action="{{ route('hosSubjects.store') }}" method="post" class="px-20 w-full">
            @csrf
            @method('POST')

            <div class="flex flex-col gap-8 ">

                <div class="flex gap-6 w-full justify-center *:w-1/3">

                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Name:</label>

                        <input type="text" name="name" id="name"
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                            value="{{ old('name') }}" required />
                    </div>

                    <div class="flex flex-col gap-2">

                        <label for="subject_code" class="text-lg font-semibold text-custom-black">Subject Code:</label>

                        <input type="text" name="subject_code" id="subject_code"
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                            value="{{ old('subject_code') }}" required />
                    </div>
                </div>

                <div class="flex gap-6 w-full justify-center *:w-1/3">
                    <div class="flex flex-col gap-2">

                        <label for="department_id" class="text-lg font-semibold text-custom-black">Department:</label>


                        <select name="department_id" id="departmentSelect"

                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                            <option value="{{ null }}">--Select Department--</option>

                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="flex flex-col gap-2">

                        <label for="type" class="text-lg font-semibold text-custom-black">Type:</label>

                        <select name="type" id="selectSearch"

                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                            <option value="{{ null }}">--Select Type--</option>
                            <option value="MAIN">Main</option>
                            <option value="ECA">ECA</option>
                            <option value="CREDIT">Credit</option>
                        </select>

                    </div>
                </div>

                <div class="flex w-full gap-6 justify-center *:w-1/3">

                    <div class="flex flex-col gap-2">

                        <label for="grade_id" class="text-lg font-semibold text-custom-black">Grade:</label>


                        <select name="grade_id" id="gradeSelect"

                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange grow">

                            <option value="{{ null }}">--Select Grade--</option>

                            @foreach ($grades as $grade)
                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="flex flex-col gap-2">

                        <label for="credit_hr" class="text-lg font-semibold text-custom-black">Credit Hour:</label>

                        <input type="text" inputmode="numeric" name="credit_hr" id="credit_hr"
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                            value="{{ old('credit_hr') }}" required />

                    </div>
                </div>

                <div class="flex justify-end">

                    <x-link-button>
                        Create Subject
                    </x-link-button>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection
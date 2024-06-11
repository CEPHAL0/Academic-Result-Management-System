@extends('layouts.admin.app')

@section('Page Title', 'Create Subject')

@section('title', 'Create Subject')

@section('content')
    <div class="w-full">
        <div class="w-full flex justify-center items-center mt-8">
            <form action="{{ route('subjects.store') }}" method="post" class="w-1/2">
                @method('POST')
                @csrf
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Enter the name of
                            subject:</label>
                        <input type="text" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('name') }}" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="type" class="text-lg font-semibold text-custom-black">Choose the Subject Type:</label>
                        <select name="type" id="selectSearch"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="">--Select the Subject--</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="subject_code" class="text-lg font-semibold text-custom-black">Enter the Subject
                            Code:</label>
                        <input type="text" name="subject_code" id="subject_code"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('subject_code') }}" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="department_id" class="text-lg font-semibold text-custom-black">Choose the
                            Department:</label>
                        <select name="department_id" id="departmentSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="">--Select the Department--</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="grade" class="text-lg font-semibold text-custom-black">Choose the Grade:</label>
                        <select name="grade_id" id="gradeSelect"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="">--Select the Grade--</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="credit_hr" class="text-lg font-semibold text-custom-black">Enter the Credit
                            Hours:</label>
                        <input type="string" name="credit_hr" id="credit_hr"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('credit_hr') }}" required />
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
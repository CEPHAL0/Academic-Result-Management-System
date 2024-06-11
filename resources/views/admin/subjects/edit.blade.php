@extends('layouts.admin.app')

@section('Page Title', 'Edit Subject')

@section('title', 'Edit Subject')

@section('content')
    <div class="w-full">
        <div class="w-full flex justify-center items-center mt-8">
            <form action="{{ route('subjects.update',$subject->id) }}" method="post" class="w-1/2">
                @method('PUT')
                @csrf
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Enter the name of
                            subject:</label>
                        <input type="text" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ $subject->name }}" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="type" class="text-lg font-semibold text-custom-black">Choose the Subject Type:</label>

                        <select name="type" id="selectSearch"

                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="{{null}}">--Select the Subject--</option>
                            @foreach ($types as $type)
                                @if ($type == $subject->type)
                                    <option value="{{ $type }}" selected>{{ $type }}</option>
                                @else
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="subject_code" class="text-lg font-semibold text-custom-black">Enter the Subject
                            Code:</label>
                        <input type="text" name="subject_code" id="subject_code"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ $subject->subject_code }}" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="department_id" class="text-lg font-semibold text-custom-black">Choose the
                            Department:</label>

                        <select name="department_id" id="departmentSelect"

                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="{{null}}">--Select the Department--</option>
                            @foreach ($departments as $department)
                                @if ($department->id == $subject->department_id)
                                    <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                @else

                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="grade" class="text-lg font-semibold text-custom-black">Choose the Grade:</label>

                        <select name="grade_id" id="gradeSelect"

                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="{{null}}">--Select the Grade--</option>
                            @foreach ($grades as $grade)
                                @if ($grade->id == $subject->grade_id)
                                    <option value="{{ $grade->id }}" selected>{{ $grade->name }}</option>
                                @else
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="credit_hr" class="text-lg font-semibold text-custom-black">Enter the Credit
                            Hours:</label>
                        <input type="string" name="credit_hr" id="credit_hr"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{$subject->credit_hr}}" required />
                    </div>



                    <div class="flex justify-end ">
                        <x-link-button>
                            Update Subject
                        </x-link-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
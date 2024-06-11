@extends('layouts.admin.app')
@section('Page Title', 'Edit Grade')

@section('title', 'Edit Grade')

@section('content')
    <div class="w-full ">
        <div class="w-full flex justify-center items-center mt-8">
            <form action="{{ route('grades.update', $grade->id) }}" method="post" class="w-1/2">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-4">


                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Enter the Grade:</label>
                        <input type="number" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ $grade->name }}" required />
                    </div>


                    <div class="flex flex-col gap-2">

                        <label for="school_id" class="text-lg font-semibold text-custom-black">Choose the School:</label>

                        <select name="school_id" id="selectSearch"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="{{null}}">--Select School--</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}" @if ($grade->school_id == $school->id) selected @endif>
                                    {{ $school->name }}</option>
                            @endforeach

                        </select>

                    </div>

                    {{-- <div class="flex flex-col gap-2">

                        <label for="end_date" class="text-lg font-semibold text-custom-black">Select the End of
                            Date:</label>

                        <input type="date" name="end_date" id="end_date"
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                            value="{{ $grade->end_date }}" required />
                    </div> --}}

                    <div class="flex justify-end ">
                        <x-link-button>
                            Update Grade
                        </x-link-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
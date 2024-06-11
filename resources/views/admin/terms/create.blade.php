@extends('layouts.admin.app')
@section('Page Title', 'Add New Term')

@section('title', 'Add New Term')

@section('content')
    <div class="w-full ">
        <div class="w-full flex justify-center items-center mt-8">
            <form action="{{ route('terms.store') }}" method="post" class="w-1/2">
                @csrf
                @method('POST')
                <div class="flex flex-col gap-4">

                    <div class="flex flex-col gap-2">
                        <label for="term_name" class="text-lg font-semibold text-custom-black">Enter the Term Name:</label>
                        <input type="text" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('term_name') }}" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="start_date" class="text-lg font-semibold text-custom-black">Enter the Start
                            date:</label>
                        <input type="date" name="start_date" id="start_date"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('start_date') }}" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="end_date" class="text-lg font-semibold text-custom-black">Enter the End date:</label>
                        <input type="date" name="end_date" id="end_date"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('end_date') }}" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="result_date" class="text-lg font-semibold text-custom-black">Enter the Result
                            date:</label>
                        <input type="date" name="result_date" id="result_date"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('result_date') }}" required />
                    </div>
                    <div class="flex flex-col gap-2 cursor-pointer">
                        <label for="grades" class="text-base font-semibold text-custom-black">Choose the Grades:</label>
                        <select name="grade_id[]" id="selectSearch" multiple data-placeholder="--Select the Grade--">
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end  ">
                        <x-link-button>
                            Add Term
                        </x-link-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
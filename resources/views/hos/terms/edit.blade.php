@extends('layouts.hos.app')
@section('Page Title', 'Edit Term')

@section('title', 'Edit Term')

@section('content')
<div class="w-full">
    <div class="w-full flex justify-center items-center mt-8">
        <form action="{{ route('hosTerms.update', $term->id) }}" method="post" class="w-1/2">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="term_name" class="text-lg font-semibold text-custom-black">Enter the Term Name:</label>
                    <input type="text" name="name" id="name"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ $term->name }}" required />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="start_date" class="text-lg font-semibold text-custom-black">Enter the Start
                        date:</label>
                    <input type="date" name="start_date" id="start_date"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ $term->start_date }}" required />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="end_date" class="text-lg font-semibold text-custom-black">Enter the End date:</label>
                    <input type="date" name="end_date" id="end_date"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ $term->end_date }}" required />
                </div>
                <div class="flex flex-col gap-2">
                    <label for="result_date" class="text-lg font-semibold text-custom-black">Enter the Result date:</label>
                    <input type="date" name="result_date" id="result_date"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ $term->result_date }}" required />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="grade_id" class="text-lg font-semibold text-custom-black">Choose the Grade:</label>
                    <select name="grade_id" id="grade_id"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                        <option value="{{ null }}">--Select Grade--</option>
                        @foreach ($grades as $grade)
                        @if ($grade->id == $term->grade_id)
                        <option value="{{ $grade->id }}" selected>{{ $grade->name }}</option>
                        @else
                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <x-link-button>
                        Update Term
                    </x-link-button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

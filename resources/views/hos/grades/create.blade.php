@extends('layouts.hos.app')
@section('Page Title', 'Add Grade')

@section('title', 'Add Grade')

@section('content')
<div class="w-full">
    <div class="w-full flex justify-center items-center mt-8">


        <form action="{{ route('hosGrades.store') }}" method="post" class="w-1/2">
            @csrf
            @method('POST')
            <div class="flex flex-col gap-4">

                <div class="flex flex-col gap-2">
                    <label for="name" class="text-lg font-semibold text-custom-black">Enter the Grade:</label>
                    <input type="number" name="name" id="name"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ old('name') }}" required />
                </div>

                <div class="flex flex-col gap-2">

                    <label for="school_id" class="text-lg font-semibold text-custom-black">Enter the School:</label>

                    <div class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                        {{ $school->name }}
                    </div>

                    <input type="hidden" name="school_id" value="{{ $school->id }}">

                </div>

                {{-- <div class="flex flex-col gap-2">

                    <label for="end_date" class="text-lg font-semibold text-custom-black">Select the End of
                        Date</label>

                    <input type="date" name="end_date" id="end_date"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ old('end_date') }}" required />
                </div> --}}

                <div class="flex justify-end ">
                    <x-link-button>
                        Create Grade
                    </x-link-button>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection
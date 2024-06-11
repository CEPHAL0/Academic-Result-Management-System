@extends('layouts.hos.app')
@section('Page Title', 'Edit CAS Type')

@section('title')
<div class="flex flex-col">
    <p>Edit CAS Type </p>
    <span class="text-sm font-normal text-custom-black">{{ $school->name }}</span>
</div>
@endsection

@section('content')
<div class="w-full py-4">
    <div class="w-full flex justify-center items-center">

        <form action="{{ route('hosCasTypes.update', $casType->id) }}" method="POST" class="w-1/3">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-4">

                <div class="flex flex-col gap-2">
                    <label for="name" class="text-base font-semibold text-custom-black">Name</label>
                    <input type="text" name="name" id="name"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ old('name', $casType->name) }}" required />
                </div>

                <input type="hidden" value="{{ $school->id }}" name="school_id">


                {{-- <div class="flex flex-col gap-2">

                    <label for="full_marks" class="text-base font-semibold text-custom-black">Full
                        Marks</label>

                    <input type="number" name="full_marks" id="full_marks"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ old('full_marks', $casType->full_marks) }}" required />
                </div> --}}

                <div class="flex flex-col gap-2">
                    <label for="weightage" class="text-base font-semibold text-custom-black">Weightage</label>
                    <input type="number" name="weightage" id="weightage"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ old('weightage', $casType->weightage) }}" required />
                </div>

                <div class="flex justify-end ">
                    <x-link-button>
                        Update CAS Type
                    </x-link-button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
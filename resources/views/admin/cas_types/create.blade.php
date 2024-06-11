@extends('layouts.admin.app')
@section('Page Title', 'Add CAS Types')

@section('title', 'Add CAS Types')

@section('content')
<div class="w-full">
    <div class="w-full flex justify-center items-center mt-8">
        <form action="{{ route('cas-types.store') }}" method="post" class="w-1/2">
            @csrf
            <div class="flex flex-col gap-4">


                <div class="flex flex-col gap-2">
                    <label for="name" class="text-lg font-semibold text-custom-black">Enter the name of CAS
                        Type:</label>
                    <input type="text" name="name" id="name"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ old('name') }}" required />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="school_id" class="text-lg font-semibold text-custom-black">Choose the School:</label>
                    <select name="school_id" id="selectSearch"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">

                        <option value="{{ null }}">--Select School--</option>

                        @foreach ($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="flex flex-col gap-2">
                    <label for="weightage" class="text-lg font-semibold text-custom-black">Enter the weightage of CAS
                        Type:</label>

                    <input type="text" name="weightage" id="weightage"
                        class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                        value="{{ old('weightage') }}" required />
                </div>

                <div class="flex justify-end ">
                    <x-link-button>
                        Add CAS Type
                    </x-link-button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
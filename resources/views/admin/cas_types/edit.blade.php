@extends('layouts.admin.app')
@section('Page Title', 'Edit CAS Types')

@section('title', 'Edit CAS Types')

@section('content')

    <div class="w-full">

        <div class="w-full flex justify-center items-center mt-8">

            <form action="{{ route('cas-types.update', $cas_type->id) }}" method="post" class="w-1/2">

                @csrf
                @method('PUT')
                <div class="flex flex-col gap-4">

                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Enter the name of CAS
                            Type:</label>
                        <input type="text" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ $cas_type->name }}" required />
                    </div>

                    <div class="flex flex-col gap-2">

                        <label for="school_id" class="text-lg font-semibold text-custom-black">Choose the School:</label>

                        <select name="school_id" id="selectSearch"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="">--Select School--</option>
                            @foreach ($schools as $school)
                                @if ($school->id == $cas_type->school->id)
                                    <option value="{{ $school->id }}" selected>{{ $school->name }}</option>
                                @else
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endif
                            @endforeach

                        </select>

                    </div>


                    <div class="flex flex-col gap-2">

                        <label for="weightage" class="text-lg font-semibold text-custom-black">Enter the weightage of CAS
                            Type:</label>

                        <input type="text" name="weightage" id="weightage"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ $cas_type->weightage }}" required />
                    </div>

                    <div class="flex justify-end">
                        <x-link-button>
                            Update CAS Type
                        </x-link-button>
                    </div>

                </div>

            </form>

        </div>
    </div>
@endsection
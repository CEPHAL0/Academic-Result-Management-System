@extends('layouts.admin.app')
@section('Page Title', 'Add School')

@section('title', 'Add School')

@section('content')
    <div class="w-full">
        <div class="w-full flex justify-center items-center mt-8 ">
            <form action="{{ route('schools.store') }}" method="post" class="w-1/2">
                @csrf
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Enter the Name of
                            School:</label>
                        <input type="text" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('name') }}" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="head_of_school_id" class="text-lg font-semibold text-custom-black">Choose the Head of
                            School:</label>
                        <select name="head_of_school_id" id="selectSearch"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            @foreach ($users as $user)
                                @if ($user->id == old('head_of_school_id'))
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="theory_weightage" class="text-lg font-semibold text-custom-black">Enter the Theory
                            Weightage:</label>
                        <input type="text" name="theory_weightage" id="theory_weightage"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('theory_weightage') }}" required />
                    </div>

                    {{-- <div class="flex flex-col gap-2">
                        <label for="cas_weightage" class="text-lg font-semibold text-custom-black">Enter the CAS
                            Weightage:</label>
                        <input type="number" name="cas_weightage" id="cas_weightage"
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                            value="{{ old('cas_weightage') }}" required />
                    </div> --}}

                    <div class="flex justify-end  ">
                        <x-link-button>
                            Add School
                        </x-link-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
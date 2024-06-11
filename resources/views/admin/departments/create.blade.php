@extends('layouts.admin.app')
@section('Page Title', 'Add Department')

@section('title', 'Add Department')

@section('content')
    <div class="w-full">
        <div class="w-full flex justify-center items-center mt-8">
            <form action="{{ route('departments.store') }}" method="post" class="w-1/2">
                @csrf
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Enter the name of
                            Department:</label>
                        <input type="text" name="name" id="name"
                               class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                               value="{{ old('name') }}" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="head_of_department_id" class="text-lg font-semibold text-custom-black">Choose Head of
                            Department:</label>
                        <select name="head_of_department_id" id="selectSearch"
                                class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange">
                            <option value="{{null}}">--Select Head of Department--</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="flex justify-end  ">
                        <x-link-button>
                            Add Department
                        </x-link-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
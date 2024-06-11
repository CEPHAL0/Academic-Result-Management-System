@extends('layouts.admin.app')
@section('Page Title', 'Add User')

@section('title', 'Add User')

@section('content')
    <div class="w-full">

        <div class="w-full flex justify-center items-center mt-8">
            <form action="{{ route('users.store') }}" method="post" class="w-1/2" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-lg font-semibold text-custom-black">Enter the Name:</label>
                        <input type="text" name="name" id="name"
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                            value="{{ old('name') }}" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-lg font-semibold text-custom-black">Enter the Email:</label>
                        <input type="email" name="email" id="email"
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                            value="{{ old('email') }}" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="role" class="text-lg font-semibold text-custom-black">Choose the Roles:</label>
                        <div
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange overflow-auto max-h-40">
                            @foreach ($roles as $role)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                        class="form-checkbox h-5 w-5 text-dark-orange">
                                    <span class="font-semibold mr-2 ml-1 uppercase">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>

                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="signature" class="text-lg font-semibold text-custom-black flex flex-col">Upload
                            Signature: <span class="text-xs text-gray-600 font-normal">Less
                                than 2MB</span></label>
                        <input type="file" name="signature" id="signature"
                            class="border-2 border-dark-gray rounded-md p-2 focus:outline-none focus:border-dark-orange"
                            required />
                    </div>
                    <div class="flex justify-end">
                        <x-link-button>
                            Add User
                        </x-link-button>
                    </div>
            </form>
        </div>
    </div>
@endsection

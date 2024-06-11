@extends('layouts.hos.app')
@section('Page Title', 'Section')

@section('title')
    <p>SECTIONS</p>
    <a href="{{ route('hosSections.create') }}"
        class="bg-dark-orange text-white text-base px-4 py-2 rounded-md font-normal">Add
        Section</a>

@endsection

@section('content')
    <div class="w-full">


        <table class="w-full table-auto" id="myTable">
            <thead class="bg-dark-gray ">
                <tr class="h-14">

                    <th class="pl-6 text-left text-base font-bold text-custom-black w-1/6">S.No.</th>
                    <th class="text-left text-base font-bold text-custom-black ">Name
                    </th>
                    <th class="text-center text-base font-bold text-custom-black px-1">Grade
                    </th>
                    <th class="text-left text-base font-bold text-custom-black ">Class Teacher
                    </th>
                    <th class="text-center pr-4 text-base font-bold text-custom-black align-center-important" data-dt-order="disable">Action
                    </th>
                </tr>
            </thead>

            <tbody class="divide-gray-200 ">
                @foreach ($sections as $section)
                    <tr class="border-b-2 h-16 hover:bg-dark-gray">

                        <td class="pl-8">{{ $loop->iteration }}</td>
                        <td>{{ $section->name }}</td>
                        <td class="text-center w-1/5">{{ $section->grade->name }}</td>
                        <td>{{ $section->classTeacher->name }}</td>
                        <td class="text-center">

                            <div class="flex gap-2 justify-center">
                                
                                <form action="{{ route('hosSections.destroy', $section->id) }}" method="post" id="delete-{{ $section->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <x-delete-button>Delete</x-delete-button>
                                </form>
                                <a href="{{ route('hosSections.edit', $section->id) }}">
                                    <x-edit-button>Edit</x-edit-button>
                                </a>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection

@extends('layouts.admin.app')
@section('Page Title', 'Grade')

@section('title')
    <p>GRADES</p>

    <a href="{{ route('grades.create') }}" class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add
        Grade</a>

@endsection

@section('content')
    <div class="w-full  ">


        <table class="w-full table-auto" id="myTable">
            <thead class="bg-tableHead-gray ">
            <tr class="h-14">

                <th class="text-center text-base font-bold text-custom-black ">Grade
                </th>
                <th class=" text-base font-bold text-custom-black ">School Name
                </th>
                <th class="text-center text-base font-bold text-custom-black align-center-important"
                    data-dt-order="disable">Action
                </th>
            </tr>
            </thead>
            <tbody class=" divide-gray-200 ">
            @foreach ($grades as $grade)
                <tr class="border-b-2 h-16 hover:bg-dark-gray">
                    <td>{{ $grade->name }}</td>
                    <td>{{ $grade->school->name }}</td>
                    {{-- <td>{{ $grade->end_date }}</td> --}}
                    <td class="text-center  ">
                        <div class="flex gap-2 justify-center">
                            <form action="{{ route('grades.destroy', $grade->id) }}" id="delete-{{ $grade->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <x-delete-button>Delete</x-delete-button>
                            </form>
                            <a href="{{ route('grades.edit', $grade->id) }}">
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
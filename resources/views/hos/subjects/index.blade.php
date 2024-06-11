@extends('layouts.hos.app')
@section('Page Title', 'Subject')

@section('title')
<p>SUBJECTS</p>
<a href="{{ route('hosSubjects.create') }}"
    class="bg-dark-orange text-white text-base px-4 py-2 rounded-md font-normal">Add
    Subject</a>

@endsection

@section('content')
<div class="w-full">


    <table class="w-full table-auto" id="myTable">
        <thead class="bg-dark-gray ">
            <tr class="h-14">

                <th class="pl-6  text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">Name
                </th>
                <th class="text-center  text-base font-bold text-custom-black ">Grade
                </th>
                <th class="text-left text-base font-bold text-custom-black ">Type
                </th>
                <th class="text-center text-base font-bold text-custom-black ">Subject Code
                </th>

                <th class="text-center text-base font-bold text-custom-black ">Credit Hr
                </th>
                <th class="text-center -base font-bold text-custom-black align-center-important"
                    data-dt-order="disable">Action
                </th>
            </tr>
        </thead>

        <tbody class="divide-gray-200 ">
            @foreach ($subjects as $subject)
            <tr class="border-b-2 h-14 hover:bg-dark-gray">
                <td class="pl-8 ">{{ $loop->iteration }}</td>
                <td>{{ $subject->name }}</td>


                <td>{{ $subject->grade->name }}</td>
                <td class="font-bold">{{ $subject->type }}</td>
                <td>{{ $subject->subject_code }}</td>

                <td>{{ $subject->credit_hr }}</td>
                <td>

                    <div class="flex gap-2 justify-center">
                        <form action="{{ route('hosSubjects.destroy', $subject->id) }}" method="post" id="delete-{{ $subject->id}}">
                            @csrf
                            @method('DELETE')
                            <x-delete-button>Delete</x-delete-button>
                        </form>
                        <a href="{{ route('hosSubjects.edit', $subject->id) }}">
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
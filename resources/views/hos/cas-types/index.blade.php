@extends('layouts.hos.app')
@section('Page Title', 'CAS Types')

@section('title')
<p>CAS TYPES</p>


<a href="{{ route('hosCasTypes.create') }}"
    class="bg-dark-orange text-white font-normal text-base px-4 py-3 rounded-md">Add
    CAS Type</a>


@endsection

@section('content')
<div class="w-full">
    <table class="w-full table-auto" id="myTable">

        <thead class="bg-dark-gray ">
            <tr class="*:h-14">
                <th class="pl-6   text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">CAS Type
                </th>
                <th class="text-center px-1 text-base font-bold text-custom-black ">Full Marks
                </th>
                <th class="text-left text-base font-bold text-custom-black ">School
                </th>
                <th class="text-center text-base font-bold text-custom-black ">Weightage
                </th>
                <th class="text-center text-base font-bold text-custom-black align-center-important" data-dt-order="disable">Action
                </th>
            </tr>
        </thead>

        <tbody class=" divide-gray-200 ">
            @foreach ($casTypes as $cas_type)
            <tr class="border-b-2 *:h-16 hover:bg-dark-gray">
                <td class="pl-8  ">{{ $loop->iteration }}</td>
                <td>{{ $cas_type->name }}</td>
                <td class="text-center">{{ $cas_type->full_marks }}</td>
                <td>{{ $cas_type->school->name }}</td>
                <td class="text-center">{{ $cas_type->weightage }}</td>
                <td class="text-center">
                    <div class="flex gap-2 justify-center">
                        <form action="{{ route('hosCasTypes.destroy', $cas_type->id) }}" method="POST" id="delete-{{ $cas_type->id }}">
                            @csrf
                            @method('DELETE')
                            <x-delete-button>Delete</x-delete-button>
                        </form>
                        <a href="{{ route('hosCasTypes.edit', $cas_type->id) }}">
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
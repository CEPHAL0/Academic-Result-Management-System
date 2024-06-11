@extends('layouts.hos.app')
@section('Page Title', 'Term')

@section('title')
<p>TERMS</p>
<a href="{{ route('hosTerms.create') }}"
    class="bg-dark-orange text-white text-base px-4 py-2 rounded-md font-normal">Add
    Term</a>

@endsection

@section('content')
<div class="w-full">


    <table class="w-full table-auto" id="myTable">
        <thead class="bg-dark-gray ">
            <tr class="h-14">

                <th class="pl-6 text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">Name
                </th>
                <th class="text-base font-bold text-custom-black ">Grade
                </th>
                <th class="text-base font-bold text-custom-black ">Start Date
                </th>
                <th class="text-base font-bold text-custom-black ">End Date
                </th>
                <th class="text-base font-bold text-custom-black ">Result Date
                </th>

                <th class="text-base font-bold text-custom-black align-center-important" data-dt-order="disable">Action
                </th>
            </tr>
        </thead>

        <tbody class="divide-gray-200 ">
            @foreach ($terms as $term)
            <tr class="border-b-2 h-16 hover:bg-dark-gray">

                <td class="pl-8  ">{{ $loop->iteration }}</td>
                <td >{{ $term->name }}</td>
                <td>{{ $term->grade->name }}</td>
                <td>{{ $term->start_date }}</td>
                <td>{{ $term->end_date }}</td>
                <td>{{ $term->result_date }}</td>
                <td>

                    <div class="flex gap-2 justify-center">
                        <form action="{{ route('hosTerms.destroy', $term->id) }}" method="post" id="delete-{{ $term->id}}">
                            @csrf
                            @method('DELETE')
                            <x-delete-button>Delete</x-delete-button>
                        </form>
                        <a href="{{ route('hosTerms.edit', $term->id) }}">
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
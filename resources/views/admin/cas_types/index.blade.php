@extends('layouts.admin.app')
@section('Page Title', 'CAS Types')

@section('title')
    <p>CAS TYPES</p>
    <a href="{{ route('cas-types.create') }}"
       class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add
        CAS Type</a>

@endsection

@section('content')
    <div class="w-full  ">
        <table class="w-full table-auto" id="myTable">
            <thead class="bg-tableHead-gray ">

            <tr class="*:h-14">
                <th class="pl-6 text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">CAS Evaluation Name
                </th>
                <th class="text-left text-base font-bold text-custom-black ">School
                </th>
                <th class="text-center text-base font-bold text-custom-black ">Weightage
                </th>
                <th class="text-center text-base font-bold text-custom-black align-center-important " data-dt-order="disable">Action
                </th>
            </tr>
            </thead>
            <tbody class=" divide-gray-200 ">
            @foreach ($cas_types as $cas_type)
                <tr class="border-b-2 hover:bg-dark-gray *:h-16">
                    <td class="pl-8">{{ $loop->iteration }}</td>
                    <td>{{ $cas_type->name }}</td>
                    <td>{{ $cas_type->school->name }}</td>
                    <td class="text-center">{{ $cas_type->weightage }}</td>
                    <td>
                        <div class="flex gap-2 justify-center">
                            <form action="{{ route('cas-types.destroy', $cas_type->id) }}"id="delete-{{ $cas_type->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <x-delete-button>Delete</x-delete-button>
                            </form>
                            <a href="{{ route('cas-types.edit', $cas_type->id) }}">
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
@extends('layouts.admin.app')
@section('Page Title', 'Schools')

@section('title')

<p>SCHOOLS</p>
<a href="{{ route('schools.create') }}" class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add
    School</a>

@endsection

@section('content')
<div class="w-full ">
    <table class="w-full" id="myTable">
        <thead class="bg-tableHead-gray ">
            <tr class="*:h-16">
                <th class="pl-6 text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">Name
                </th>
                <th class="text-left text-base font-bold text-custom-black ">Head of School
                </th>
                <th class="text-center text-base font-bold text-custom-black ">Theory Weightage
                </th>
                <th class="text-center text-base font-bold text-custom-black align-center-important " data-dt-order="disable">Action
                </th>
            </tr>
        </thead>
        <tbody class=" divide-gray-200 ">
            @foreach ($schools as $school)
            <tr class="border-b-2 *:h-16 hover:bg-dark-gray">
                <td class="pl-8 ">{{ $loop->iteration }}</td>
                <td>{{ $school->name }}</td>
                <td>{{ $school->headOfSchool->name }}</td>
                <td class="text-center">{{ $school->theory_weightage }}</td>
                <td>
                    <div class="flex gap-2 justify-center">
                        <form action="{{ route('schools.destroy', $school->id) }}" method="post" id="delete-{{ $school->id }}">
                            @csrf
                            @method('DELETE')
                            <x-delete-button>Delete</x-delete-button>
                        </form>
                        <a href="{{ route('schools.edit', $school->id) }}">
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
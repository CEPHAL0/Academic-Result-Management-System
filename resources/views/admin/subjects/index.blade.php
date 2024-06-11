@extends('layouts.admin.app')

@section('Page Title', 'Subjects')
@section('title')

    <p>SUBJECTS </p>
    <div>
        <a href="{{ route('subjects.create') }}"
           class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add
            Subject</a>
    </div>
@endsection

@section('content')
    <div class="w-full ">

        <table class="w-full" id="myTable">
            <thead class="bg-tableHead-gray ">
            <tr class="*:h-14">
                <th class="pl-6 text-left text-base font-bold text-custom-black ">S.No.</th>
                <th class="text-left text-base font-bold text-custom-black ">Name
                </th>
                <th class="text-left text-base font-bold text-custom-black ">Type
                </th>
                <th class="text-left text-base font-bold text-custom-black ">Subject Code
                </th>
                <th class="text-center text-base font-bold text-custom-black ">Grade
                </th>
                <th class="text-center text-base font-bold text-custom-black ">Credit Hours
                </th>

                <th class=" text-center text-base font-bold text-custom-black align-center-important" data-dt-order="disable">Action
                </th>
            </tr>
            </thead>

            <tbody class=" divide-gray-200 ">
            @foreach ($subjects as $subject)
                <tr class="border-b-2 *:h-16 hover:bg-dark-gray">
                    <td class="pl-8">{{ $loop->iteration }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ ucfirst(strtolower($subject->type)) }}</td>
                    <td>{{ $subject->subject_code }}</td>
                    <td class="text-center">{{ $subject->grade->name }}</td>
                    <td class="text-center">{{ $subject->credit_hr }}</td>
                    <td class=" text-center">
                        <div class="flex gap-2 justify-center">
                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="post" id="delete-{{ $subject->id }}">
                                @csrf
                                @method('DELETE')
                                <x-delete-button>Delete</x-delete-button>
                            </form>
                            <a href="{{ route('subjects.edit', $subject->id) }}">
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
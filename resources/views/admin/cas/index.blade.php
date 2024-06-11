@extends('layouts.admin.app')

@section('Page Title', 'CAS')
@section('title')

<p>CAS Marks</p>
<div>
    {{-- <a href="{{ route('cas.create') }}"
        class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add
        CAS</a> --}}
</div>

@endsection

@section('content')
<div class="w-full  ">
    <table class="w-full table-auto">
        <thead class="bg-tableHead-gray">
            <tr class="*h:h-14">
                <th class="pl-6 text-left text-base font-bold text-custom-black">S.No.</th>
                <th class="py-4 text-left text-base font-bold text-custom-black">Student</th>
                <th class="text-left text-base font-bold text-custom-black">Assignment</th>
                <th class="text-left text-base font-bold text-custom-black">Subject Teacher</th>
                <th class="text-left text-base font-bold text-custom-black">Mark</th>
                <th class="text-left text-base font-bold text-custom-black">Remarks</th>
                <th class="text-center text-base font-bold text-custom-black">Action</th>
            </tr>
        </thead>
        <tbody class="divide-gray-200">
            @foreach ($cas as $cas_element)
            <tr class="border-b-2 *:h-16">
                <td class="pl-6">{{ $loop->iteration }}</td>
                <td>{{ $cas_element->student->name }}</td>
                <td>{{ $cas_element->assignment->name }}</td>
                <td>{{ $cas_element->assignment->subjectTeacher->teacher->name }}</td>
                <td>{{ $cas_element->assignment->subjectTeacher->subject->name}}</td>
                <td>{{ $cas_element->mark }}</td>
                <td>{{ $cas_element->remarks }}</td>
                <td class="text-center">
                    <div class="flex gap-2 justify-center">
                        <form action="{{ route('cas.destroy', $cas_element->id) }}" method="post" id="delete-{{ $cas_element->id }}">
                            @csrf
                            @method('DELETE')
                            <x-delete-button>Delete</x-delete-button>
                        </form>
                        <a href="{{ route('cas.edit', $cas_element->id) }}">
                            <x-edit-button>Edit</x-edit-button>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            @if ($cas->isEmpty())
            <tr>
                <td colspan="12" class="text-center text-2xl font-semibold py-4">No CAS Found</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
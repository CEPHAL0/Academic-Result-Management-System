@extends('layouts.hos.app')

@section('Page Title', 'Exam')

@section('title', 'Exam')

@section('content')
    <div class="w-full ">
        <table class="w-full table-auto" id="myTable">
            <thead class="bg-dark-gray ">
                <tr class="bg-dark-gray *:h-14 border">
                    <th class="pl-6 text-left">S.No.</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Subject</th>
                    <th>Grade</th>
                    <th>Start Date</th>
                    <th class="text-center align-center-important" data-dt-order="disable">Action</th>
                </tr>
            </thead>

            @foreach ($terms as $term)
                @foreach ($subjects->where('grade_id', $term->grade_id) as $subject)
                    <tr class="*:h-16 border-b-2 hover:bg-dark-gray">
                        <td class="pl-8">{{ $loop->iteration }}</td>
                        <td>{{ $term->name }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->grade->name }}</td>
                        <td>{{ $term->start_date }}</td>

                        <td class="flex gap-2 justify-center items-center ">
                            <form action="{{ route('hosExams.delete', [$term->id, $subject->id]) }}" method="POST"
                                id="delete-{{ json_encode([$term->id, $subject->id]) }}">
                                @csrf
                                @method('DELETE')
                                <x-delete-button>Delete</x-delete-button>
                            </form>

                            <a href="{{ route('hosExams.edit', [$term->id, $subject->id]) }}">
                                <x-edit-button>Edit</x-edit-button>
                            </a>

                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>

    </div>
@endsection

@extends('layouts.teacher.app')

@section('Page Title', 'Exam')

@section('title')
    <p>Exam</p>
@endsection

@section('content')
    <div class=" w-full">
        <table class="w-full table-auto" id="myTable">
            <thead class="bg-dark-gray">
                <tr class="*:text-left bg-dark-gray h-14 border  ">
                    <th>S.No</th>
                    <th class="">Name</th>
                    <th class="align-center-important">Start Date</th>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th class="align-center-important" data-dt-order="disable">Action</th>
                </tr>
            </thead>

            @foreach ($terms as $term)
                @foreach ($subjects->where('grade_id', $term->grade_id) as $subject)
                    <tr class="h-16 border-b-2">
                        <td>{{ $loop->iteration }}</td>
                        <td class="">{{ $term->name }}</td>
                        <td class="align-center-important">{{ $term->start_date }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $term->grade->name }}</td>

                        <td class="text-center">
                            <a href="{{ route('teacherExams.view', [$term->id, $subject->id]) }}"
                                class="px-4 py-2 border border-custom-black bg-custom-black text-white hover:text-custom-black hover:bg-transparent transition-colors rounded-md">View</a>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>

    </div>
@endsection

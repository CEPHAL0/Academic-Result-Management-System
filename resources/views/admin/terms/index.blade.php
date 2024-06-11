@extends('layouts.admin.app')
@section('Page Title', 'Terms')


@section('title')
    <p>Terms</p>

    <a href="{{ route('terms.create') }}" class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Add
        New Term</a>

@endsection

@section('content')

    <div class="w-full ">
        <table class="w-full table-auto" id="myTable">
            <thead class="bg-tableHead-gray">
                <tr class="*:h-14">
                    <th class=" pl-6 py-6 text-left text-base font-bold text-custom-black ">S.No.</th>
                    <th class="text-left text-base font-bold text-custom-black ">Name
                    </th>
                    <th class="text-left text-base font-bold text-custom-black ">Start Date
                    </th>
                    <th class="text-left text-base font-bold text-custom-black ">End Date
                    </th>
                    <th class="text-left text-base font-bold text-custom-black ">Result Date
                    </th>
                    <th class="text-left text-base font-bold text-custom-black ">Grade
                    </th>
                    <th class="text-left text-base font-bold text-custom-black ">Result
                    </th>
                    <th class=" text-center text-base font-bold text-custom-black align-center-important"
                        data-dt-order="disable">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="  divide-gray-200 ">
                @foreach ($terms as $term)
                    <tr class=" border-b-2 h-16 hover:bg-dark-gray">
                        <td class=" pl-8  ">{{ $loop->iteration }}</td>
                        <td>{{ $term->name }}</td>
                        <td>{{ $term->start_date }}</td>
                        <td>{{ $term->end_date }}</td>
                        <td>{{ $term->result_date }}</td>
                        <td>{{ $term->grade->name }}</td>
                        @if ($term->is_result_generated == 1)
                            <td>
                                <form action="{{ route('downloadResult', $term) }}" method="get">
                                    @csrf
                                    <button
                                        class="bg-dark-orange text-white font-normal text-base px-3 py-2 rounded-md">Generate</button>
                                </form>
                            </td>
                        @else
                            <td class="text-gray-400 text-sm">Not available</td>
                        @endif
                        <td class="w-1/6   pr-4">
                            <div class="flex gap-2 justify-center">
                                <form action="{{ route('terms.destroy', $term->id) }}" id="delete-{{ $term->id }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <x-delete-button>Delete</x-delete-button>
                                </form>
                                <a href="{{ route('terms.edit', $term->id) }}">
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

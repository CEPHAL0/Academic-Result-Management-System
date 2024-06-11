@extends('layouts.admin.app')
@section('Page Title', 'Bulk Upload Students')
@section('title', 'Bulk Upload Students')

@section('content')

    @if (session()->has('failures'))
        <table class="table table-danger">
            <tr>
                <th>Row</th>
                <th>Attribute</th>
                <th>Errors</th>
                <th>Value</th>
            </tr>
            @foreach (session()->get('failures') as $validation)
                <tr>
                    <td>{{ $validation->row() }}</td>
                    <td>{{ $validation->attribute() }}</td>
                    <td>
                        <ul>
                            @foreach ($validation->errors() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        {{ $validation->values()[$validation->attribute()] }}
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    <div class="w-full">
        <div>
            <a href="{{ route('student.bulkSample') }}">
                <button
                    class="bg-dark-orange shadow-2xl text-white font-semibold text-lg px-4 py-3 rounded-md float-end m-4">Download
                    Sample</button>
            </a>
        </div>

        <form action="{{ route('student.bulkUpload') }}" method="POST" name="myform" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-4  mt-8 justify-center items-center">
                <div class="flex flex-col gap-2">
                    <label for="student_csv" class="block text-lg font-semibold text-custom-black">CSV file:</label>
                    <input type="file" name="student_csv" id="student_csv"
                        class="border-2 border-dark-orange py-2 px-4 rounded-md w-full" required>

                </div>
                <div class="flex flex-col gap-2">
                    <label for="zipFile" class="text-lg font-semibold text-custom-black">ZIP file:</label>
                    <input type="file" name="zipFile" id="zipFile"
                        class="border-2 border-dark-orange py-2 px-4 rounded-md w-full" required>
                </div>
                <div class="flex justify-end pb-6 float-end mt-4  ">
                    <x-link-button>
                        Upload Students
                    </x-link-button>

                </div>
            </div>
        </form>
    </div>

@endsection

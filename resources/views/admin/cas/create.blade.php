@extends('layouts.admin.app')

@section('title')
<p>Create CAS : {{ $subjectTeacher->teacher->name }} - {{ $subjectTeacher->section->name }}</p>
@endsection
@section('content')
    <div class="py-4 w-full object-contain">
        <form action="{{ route('cas.store', $subjectTeacher->id) }}" method="POST">
            @csrf
            <div class="w-full flex gap-4 px-4">
                <div class="flex flex-col w-[15rem]">
                    <label for="assignment_name"  class="text-sm text-custom-black">Assignment Name </label>
                    <input type="text" class="border border-custom-black rounded-sm px-3 py-1 grow" name="assignment_name" required value="{{ old('assignment_name') }}">
                </div>
                {{-- <input type="hidden" name="subjectTeacher" value="{{ $subjectTeacher->id }}"> --}}
                <div class="flex flex-col">
                    <label for="date_assigned"  class="text-sm text-custom-black">Date </label>
                    <input type="date" name="date_assigned" id="date_assigned" class="border border-custom-black rounded-sm px-3 py-1" required value="{{ old('date_assigned') }}">
                </div>
                <div class="flex flex-col">
                    <label for="full_marks"  class="text-sm text-custom-black">Full Marks</label>
                    <input type="number" name="full_marks" id="full_marks" required value="{{ old('full_marks') }}" class="border border-custom-black rounded-sm px-3 py-1">
                </div>
                <div class="flex flex-col">
                    <label for="cas_type"  class="text-sm text-custom-black">CAS Type</label>
                    <select name="cas_type" id="cas_type" class="border border-custom-black rounded-sm px-3 py-2">
                        <option value="{{ null }}" selected>--Select CAS Type--</option>
                        @foreach ($casTypes as $casType)
                            @if (old('cas_type') == $casType->id)
                                <option value="{{ $casType->id }}" selected>{{ $casType->name }}: {{ $casType->school->name }}
                                </option>
                            @else
                                <option value="{{ $casType->id }}">{{ $casType->name }}: {{ $casType->school->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <table class="table-auto w-full mt-3">
                <thead class="bg-dark-gray">
                    <tr class="border-b-2 h-10">
                        <th class="px-2 pl-24 w-1/4 text-left">Student ID</th>
                        <th class="px-2 text-left">Roll Number</th>
                        <th class="px-2 text-left">Name</th>
                        <th class="px-2 text-left">Marks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="h-14 border-b-2">
                            <td class="px-2 pl-24 text-left">{{ $student->id }}</td>
                            <td class="px-2 text-left">{{ $student->roll_number }}</td>
                            <td class="px-2 text-left">{{ $student->name }} - {{ $student->section->name }}</td>
                            <input type="hidden" name="students[]" value="{{ $student->id }}">
                            <td><input type="number" name="marks[]" min=0 value="{{ old('marks.' . $loop->iteration - 1) }}"  class="border border-custom-black rounded-sm px-3 py-1 grow w-16">
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="py-2 text-left">
                            <button type="submit" class="bg-custom-black px-[0.8rem] py-1 border border-custom-black text-white rounded-sm place-self-end hover:bg-white hover:text-custom-black transition-colors">Assign Marks</button>
                        </td>
                    </tr>
                </tbody>
            </table>
           
        </form>
    </div>


@endsection

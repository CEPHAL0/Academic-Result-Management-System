@extends('layouts.teacher.app')

@section('Page Title', 'Edit Assignment')

@section('title')

    <div class="flex flex-col">
        <p> Marks of {{ $assignment->name }} :
            {{ $assignment->subjectTeacher->section->name }}</p>
        <span class="text-sm font-normal text-gray-500">{{ $assignment->subjectTeacher->subject->name }}</span>
    </div>

@endsection

@section('content')
    <div class="px-4 py-4 w-full ">
        <form id="form" method="POST">
            @csrf
            @method('POST')
            {{-- CAS FORM CONTAINER TO CREATE ASSIGNMENT --}}
            <div class="casFormContainer flex gap-4">
                <div class="flex flex-col w-20">
                    <label for="assignmentName" class="text-sm text-custom-black">Week</label>
                    <input type="number" name="assignment_name" required
                        class="border border-custom-black rounded-sm px-3 py-1"
                        value="{{ explode(' ', $assignment->name)[1] ?? '' }}">
                </div>

                <div class="flex flex-col">
                    <label for="date" class="text-sm text-custom-black">Date</label>
                    <input type="date" name="date_assigned" class="border border-custom-black rounded-sm px-3 py-1"
                        value="{{ old('date_assigned', $assignment->date_assigned) }}" required>
                </div>



                <div class="flex flex-col">
                    <label for="casType" class="text-sm text-custom-black">CAS Type</label>
                    <select name="cas_type" id="cas_type" class="border border-custom-black rounded-sm px-3 py-1 grow">
                        <option value="{{ null }}">--Select--</option>
                        @foreach ($casTypes as $casType)
                            @if (old('cas_type') == $casType->id || $assignment->cas_type_id == $casType->id)
                                <option value="{{ $casType->id }}" selected>{{ $casType->name }} -- Full Marks :
                                    {{ $casType->full_marks }}</option>
                            @else
                                <option value="{{ $casType->id }}">{{ $casType->name }} -- Full Marks :
                                    {{ $casType->full_marks }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                {{-- INPUT FIELD TO CHANGE WHEN CLICKED SAVE OR SAVE AND SUBMIT --}}
                <input type="hidden" name="submitted" id="submitted" value="0">
            </div>




            {{-- SECTION FOR STUDENT MARKS --}}
            <div class="mt-5">
                <table class="table-auto w-full">
                    <thead class="bg-dark-gray">
                        <tr class="border-b-2 h-10">
                            <th class="px-2 text-left">Roll No</th>
                            <th class="px-2 text-left">Name</th>
                            <th class="px-2 text-left">Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cas as $casOne)
                            <input type="hidden" name="students[]" value="{{ $casOne->student->id }}">
                            <tr class="h-14 border-b-2">
                                <td class="px-2 text-left">{{ $casOne->student->roll_number }}</td>
                                <td class="px-2 text-left">{{ $casOne->student->name }}</td>
                                <td class="px-2 text-left">


                                    <input type="number" name="marks[]" min=0 step=0.1
                                        value="{{ (float) old('marks.' . $loop->iteration - 1, $casOne->mark) }}"
                                        class="border border-custom-black rounded-sm px-3 py-1 grow w-16">


                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="py-2 px-2 text-left">
                                <button type="submit"
                                    class="bg-dark-orange px-[0.8rem] py-1 border border-dark-orange text-white rounded-sm place-self-end hover:bg-white hover:text-dark-orange transition-colors"
                                    id="saveForm">Save</button>

                                <button
                                    class="bg-custom-black px-[0.8rem] py-1 border border-custom-black text-white rounded-sm place-self-end hover:bg-white hover:text-custom-black transition-colors"
                                    id="saveAndSubmitForm">Save & Submit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $("#saveForm").click(function() {
            $("#form").attr("action", "{{ route('teacherAssignments.updateAndSave', (int) $assignment->id) }}")
        })

        // $("#saveAndSubmitForm").click(function() {
        //     alert("Are you Sure ?");
        //     $("#form").attr("action",
        //         "{{ route('teacherAssignments.updateAndStore', (int) $assignment->id) }}");
        // })

        $("#saveAndSubmitForm").click(function(e) {
            e.preventDefault();
            $("#form").attr("action", "{{ route('teacherAssignments.updateAndStore', (int) $assignment->id) }}");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#form").submit();
                }
            });

        })
    </script>



@endsection

@extends('layouts.teacher.app')

@section('Page Title', 'Add Marks')

@section('title')
<div class="flex flex-col">
    <p>Marks of {{ $subjectTeacher->section->name }}</p>
    <span class="text-sm font-normal text-gray-500">{{ $subjectTeacher->subject->name }}</span>
</div>

<select name="markType" class="bg-dark-orange text-white px-3 py-3 h-fit rounded-md markType text-base font-normal">
    <option value="cas" class="bg-white text-black" selected>CAS</option>
    <option value="exam" class="bg-white text-black">Exam</option>
</select>

@endsection

@section('content')
<div class="py-3 w-full">
    <form id="form" method="POST">
        @csrf
        @method('POST')

        {{-- EXAM CONTAINER TO CHOOSE TERM --}}
        <div class="examFormContainer hidden px-4">
            <div class="flex gap-3">

                <select name="term_id" class="border border-custom-black rounded-sm px-3 py-2 w-fit" id="selectSearch">
                    @foreach ($terms as $term)
                    <option value="{{ $term->id }}">{{ $term->name }}
                    </option>
                    @endforeach
                </select>

                <div class="text-sm text-custom-black flex items-end font-semibold"> Full Marks:
                    {{ $examFullMarks }}</div>
            </div>
        </div>

        {{-- CAS FORM CONTAINER TO CREATE ASSIGNMENT --}}
        <div class="casFormContainer flex gap-4 px-4">
            <div class="flex flex-col w-24">
                <label for="assignmentName" class="text-sm text-custom-black">Week</label>
                <input type="number" inputmode="numeric" name="assignment_name"
                    class="border border-custom-black rounded-sm px-3 py-1 grow" value="{{ old('assignment_name') }}">
            </div>

            <div class="flex flex-col">
                <label for="date" class="text-sm text-custom-black">Date</label>
                <input type="date" name="date_assigned" class="border border-custom-black rounded-sm px-3 py-1 grow"
                    value="{{ old('date_assigned') }}">
            </div>


            <div class="flex flex-col w-2/6">
                <label for="casType" class="text-sm text-custom-black">CAS Type</label>
                <select name="cas_type" id="cas_type" class="border border-custom-black rounded-sm px-3 py-1 grow">
                    <option value="{{ null }}">--Select--</option>
                    @foreach ($casTypes as $casType)
                    @if (old('cas_type') == $casType->id)
                    <option value="{{ $casType->id }}" selected>{{ $casType->name }} :
                        {{ $casType->full_marks }}</option>
                    @else
                    <option value="{{ $casType->id }}">{{ $casType->name }} -- Full Marks :
                        {{ $casType->full_marks }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>

        </div>




        {{-- SECTION FOR STUDENT MARKS --}}
        <div class="mt-5">



            {{-- TABLE FOR CAS MARKS --}}
            <table class="table-auto w-full" id="casTable">
                <thead class="bg-dark-gray">
                    <tr class="border-b-2 h-14">
                        <th class="pl-6 text-left">Roll No</th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Marks</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($students as $student)
                    <input type="hidden" name="students[]" value="{{ $student->id }}">
                    <tr class="h-14 border-b-2 hover:bg-dark-gray">
                        <td class="p-8 text-left">{{ $student->roll_number }}</td>
                        <td class="text-left">{{ $student->name }}</td>
                        <td class="text-left">
                            <input type="number" min=0 step=0.1 name="marks[]"
                                value="{{ old('marks.' . $loop->iteration - 1) }}"
                                class="border border-custom-black rounded-sm px-3 py-1 grow w-16">
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="py-2 text-left">
                            <button type="submit"
                                class="bg-dark-orange px-[0.8rem] py-1 border border-dark-orange text-white rounded-sm place-self-end hover:bg-white hover:text-dark-orange transition-colors"
                                id="saveForm">Save</button>
                            <br>
                            <button type="submit"
                                class="mt-2 bg-custom-black px-[0.8rem] py-1 border border-custom-black text-white rounded-sm place-self-end hover:bg-white hover:text-custom-black transition-colors"
                                id="saveAndSubmitForm">Save & Submit</button>
                        </td>
                    </tr>
                </tbody>
            </table>



            {{-- TABLE FOR EXAM MARKS --}}
            <table class="table-auto w-full hidden" id="examTable">
                <thead class="bg-dark-gray">
                    <tr class="border-b-2 h-14">
                        <th class="pl-6 text-left">Roll No</th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Marks</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($studentExams as $studentExam)
                    <input type="hidden" name="studentExams[]" value="{{ $studentExam->id }}">
                    <tr class="h-14 border-b-2 hover:bg-dark-gray">
                        <td class="pl-8 text-left">{{ $studentExam->roll_number }}</td>

                        <td class="text-left">{{ $studentExam->name }}</td>

                        <td class="text-left">
                            <input type="number" min=0 step=0.1 max={{ $examFullMarks }} name="examMarks[]" required
                                value="{{ old('examMarks.' . $loop->iteration - 1) }}"
                                class="border border-custom-black rounded-sm px-3 py-1 grow w-16">
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="py-2 text-left">
                            <button type="submit"
                                class="bg-dark-orange px-[0.8rem] py-1 border border-dark-orange text-white rounded-sm place-self-end hover:bg-white hover:text-dark-orange transition-colors"
                                id="saveExamForm">Save</button>
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
    $('.markType').change(
            function() {
                let value = $(this).children("option:selected").val();
                $('.title').attr('value', String(value));
                if (value == "exam") {
                    $(".examFormContainer").show();
                    $(".casFormContainer").hide();
                    $("#casTable").hide();
                    $("#examTable").show();
                    $("#saveAndSubmitForm").hide();


                } else {
                    $(".casFormContainer").show();
                    $(".examFormContainer").hide();
                    $("#casTable").show();
                    $("#examTable").hide();
                    $("#saveAndSubmitForm").show();
                }
            }
        )


        // SAVE CAS MARKS (NOT STORE)
        $("#saveForm").click(function() {
            $("#form").attr("action", "{{ route('teacherForms.saveCas', (int) $subjectTeacher->id) }}");
            $("#form").submit();
        })


        // STORE CAS MARKS PERMANENTLY
        // $("#saveAndSubmitForm").click(function() {
        //     alert("Are you Sure ?");
        //     $("#form").attr("action",
        //         "{{ route('teacherForms.storeCas', (int) $subjectTeacher->id) }}");
        //     $("#form").submit();


        // })
        $("#saveAndSubmitForm").click(function(e) {
            e.preventDefault();
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
                    $("#form").attr("action",
                        "{{ route('teacherForms.storeCas', (int) $subjectTeacher->id) }}");
                    $("#form").submit();
                }
            });
        })


        // STORE EXAM MARKS PERMANENTLY
        $("#saveExamForm").click(function() {
            $("#form").attr("action", "{{ route('teacherForms.storeExam', (int) $subjectTeacher->id) }}");
            // $("#form").submit();
        })
</script>
@endsection
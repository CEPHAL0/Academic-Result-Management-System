@extends('layouts.hod.app')

@section('Page Title', 'Add Marks')

@section('title')
<p>Marks of {{ $subjectTeacher->section->name }}</p>

<select name="markType" id="" class="bg-dark-orange text-white px-3 rounded-md markType text-sm font-normal">
    <option value="cas" class="bg-white text-black" selected>CAS</option>

</select>

@endsection

@section('content')
<div class="py-4 w-full object-contain">
    <form id="form" method="POST">
        @csrf

        {{-- EXAM CONTAINER TO CHOOSE TERM --}}
        <div class="examFormContainer hidden px-4">
            <div class="flex gap-3">

                <select name="term_id" class="border border-custom-black rounded-sm px-3 py-2 w-fit">
                    @foreach ($terms as $term)
                    <option value="{{ $term->id }}">{{ $term->name }}
                    </option>
                    @endforeach
                </select>

                <div class="text-sm text-custom-black flex items-end"> Full Marks:
                    {{ $examFullMarks }}</div>
            </div>
        </div>

        {{-- CAS FORM CONTAINER TO CREATE ASSIGNMENT --}}
        <div class="casFormContainer flex gap-4 px-4">
            <div class="flex flex-col w-20">
                <label for="assignmentName">Week</label>
                <input type="number" inputmode="numeric" name="assignment_name"
                    class="border border-custom-black rounded-sm px-3 py-1" value="{{ old('assignment_name') }}">
            </div>
            <div class="flex flex-col">
                <label for="date">Date</label>
                <input type="date" name="date_assigned" class="border border-custom-black rounded-sm px-3 py-1"
                    value="{{ old('date_assigned') }}">
            </div>

            <div class="flex flex-col">
                <label for="casType">CAS Type</label>
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
        <div class="mt-5 max-h-80 overflow-y-scroll overflow-x-hidden">

            {{-- TABLE FOR CAS MARKS --}}
            <table class="table-auto w-full" id="casTable">
                <thead class="bg-dark-gray">
                    <tr class="border-b-2 h-10">
                        <th class="px-2 pl-24 w-1/4 text-left">Roll No</th>
                        <th class="px-2 text-left">Name</th>
                        <th class="px-2 text-left">Marks</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($students as $student)
                    <input type="hidden" name="students[]" value="{{ $student->id }}">
                    <tr class="h-14 border-b-2">
                        <td class="px-2 pl-24 text-left">{{ $student->roll_number }}</td>
                        <td class="px-2 text-left">{{ $student->name }}</td>
                        <td class="px-2 text-left">
                            <input type="number" name="marks[]" value="{{ old('marks.' . $loop->iteration - 1) }}"
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
                    <tr class="border-b-2 h-10">
                        <th class="px-2 pl-24 text-left">Roll No</th>
                        <th class="px-2 text-left">Name</th>
                        <th class="px-2 text-left">Marks</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($studentExams as $studentExam)
                    <input type="hidden" name="studentExams[]" value="{{ $studentExam->id }}">
                    <tr class="h-14 border-b-2">
                        <td class="px-2 pl-24 text-left">{{ $studentExam->roll_number }}</td>
                        <td class="px-2 text-left">{{ $studentExam->name }}</td>
                        <td class="px-2 text-left">
                            <input type="number" min=0 max={{ $examFullMarks }} name="examMarks[]" required
                                value="{{ old('examMarks.' . $loop->iteration - 1) }}"
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
            $("#form").attr("action", "{{ route('hodForms.saveCas', (int) $subjectTeacher->id) }}");
            $("#form").submit();
        })


        // STORE CAS MARKS PERMANENTLY
        $("#saveAndSubmitForm").click(function() {
            $("#form").attr("action", "{{ route('hodForms.storeCas', (int) $subjectTeacher->id) }}");
            $("#form").submit();
        })



        // STORE EXAM MARKS PERMANENTLY
        $("#saveExamForm").click(function() {
            $("#form").attr("action", "{{ route('hodForms.storeExam', (int) $subjectTeacher->id) }}");
            $("#form").submit();
        })
</script>
@endsection
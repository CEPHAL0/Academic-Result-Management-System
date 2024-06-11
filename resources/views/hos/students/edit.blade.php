@extends('layouts.hos.app')
@section('Page Title', 'Edit Student')

@section('title', 'Edit Student')

@section('content')
<div class="w-full">
    <form action="{{ route('hosStudents.update', $student->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <section class="py-4 px-6 flex w-full gap-5">
            {{-- From here student details will start --}}
            <div class="w-1/2  ">
                <h1 class="text-xl font-semibold">Student Details</h1>
                <hr class="border border-custom-black mt-2">

                <section class="py-4 flex gap-4">

                    <div class="w-full flex flex-col gap-2">

                        <div class="flex flex-col">
                            <label for="name" class="text-sm text-start">Name</label>
                            <input type="text" name="name" id="name" value="{{ $student->name }}"
                                class="w-full mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2"
                                required>
                        </div>

                        <div class="flex flex-row justify-start w-full gap-3 ">
                            <div class="flex flex-col w-1/2">
                                <label for="emis_no" class="text-sm text-start">EMIS no.</label>
                                <input type="text" name="emis_no" id="emis_no" value="{{ $student->emis_no }}"
                                    class="w-full mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2 "
                                    required>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <label for="reg_no" class="text-sm text-start">Reg no.</label>
                                <input type="text" name="reg_no" id="reg_no" value="{{ $student->reg_no }}"
                                    class="w-full mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2"
                                    required>
                            </div>
                        </div>

                        <div class="w-full gap-4 flex">
                            <div class="flex flex-col w-1/2">
                                <label for="roll_number" class="text-sm text-start">Roll no.</label>
                                <input type="number" name="roll_number" id="roll_number"
                                    value="{{ $student->roll_number }}"
                                    class="w-full mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2">
                            </div>

                            <div class="flex flex-col gap-2 w-1/2">
                                <label for="section_id" class="text-sm text-start"> Section</label>
                                <select name="section_id" id="selectSearch"
                                    class="w-full text-sm border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md mt-1 h-11">
                                    @if ($student->section_id == null)
                                    @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" selected>{{ $section->name }}
                                    </option>
                                    @endforeach
                                    @else
                                    @foreach ($sections as $section)
                                    @if ($section->id == $student->section->id)
                                    <option value="{{ $section->id }}" selected>{{ $section->name }}
                                    </option>
                                    @else
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="self-center">
                        <label for="doc" class="cursor-pointer">
                            <div class="flex flex-col items-center ">
                                <div id="preview"
                                    class="w-32 h-40 flex justify-center  border border-dashed border-custom-black bg-gray-200 rounded-md ">
                                    <img src="{{ asset('storage/students/' . $student->image) }}"
                                        alt="{{ $student->name }}" id="img" name="image"
                                        class="rounded-md flex justify-center items-center object-contain  " required>
                                </div>
                                <input type="file" name="image" id="doc" hidden />
                        </label>
                        <p class="text-center text-[0.75rem] text-custom-black mt-5">Upload Size 5 MB </p>
                    </div>

                </section>

                <section>
                    <div class="flex  gap-3 w-full py-4 ">
                        <div class="flex flex-col w-full">
                            <label for="email" class="text-sm text-start">Email</label>
                            <input type="email" name="email" id="email" value="{{ $student->email }}"
                                class="w-full mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2 "
                                required>
                        </div>
                        <div class="flex flex-col w-1/2">
                            <label for="date_of_birth" class="text-sm text-start">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                value="{{ $student->date_of_birth }}"
                                class="w-full text-sm mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2 "
                                required>
                        </div>
                    </div>
                </section>

                <section>
                    <h1 class="text-2xl font-semibold">Student Status</h1>
                    <hr class="border border-custom-black mt-2">

                    <div class="my-3 flex gap-3 w-full">
                        <select name="status"
                            class="w-full text-sm border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md mt-1 h-11">
                            <option value="ACTIVE" @if ($student->status == 'ACTIVE') selected @endif>Active</option>
                            <option value="DROPPED_OUT" @if ($student->status == 'DROPPED_OUT') selected @endif>Dropped
                                Out</option>
                        </select>

                    </div>


                </section>
            </div>


            {{-- From here parents details will start --}}
            <div class="w-1/2 ">
                <h1 class="text-xl font-semibold">Parents Details</h1>
                <hr class="border border-custom-black mt-2">

                <section class="py-4 ">

                    <div class="w-full flex flex-col gap-2">

                        <div class=" flex flex-col">
                            <label for="mother_name" class="text-start text-sm">Mother's Name</label>
                            <input type="text" name="mother_name" id="mother_name" value="{{ $student->mother_name }}"
                                class="w-full mt-2 text-sm border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2"
                                required>
                        </div>

                        <div class="flex flex-row justify-start w-full gap-3 ">
                            <div class="flex flex-col w-1/2">
                                <label for="mother_contact" class="text-sm text-start">Mother's Contact</label>
                                <input type="tel" name="mother_contact" id="mother_contact"
                                    value="{{ $student->mother_contact }} "
                                    class="w-full mt-2 text-sm border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2 "
                                    required>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <label for="mothers_profession" class="text-sm text-start">Mother's
                                    Profession</label>
                                <input type="text" name="mothers_profession" id="mothers_profession"
                                    value="{{ $student->mothers_profession }}"
                                    class="w-full text-sm mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2">
                            </div>
                        </div>

                        <div class=" flex flex-col">
                            <label for="father_name" class="text-sm text-start">Father's Name</label>
                            <input type="text" name="father_name" id="father_name" value="{{ $student->father_name }}"
                                class="w-full text-sm mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2"
                                required>
                        </div>

                        <div class="flex flex-row justify-start w-full gap-3 ">
                            <div class="flex flex-col w-1/2">
                                <label for="father_contact" class="text-sm text-start">Father's Contact</label>
                                <input type="tel" name="father_contact" id="father_contact"
                                    value="{{ $student->father_contact }}"
                                    class="w-full text-sm mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2 ">
                            </div>
                            <div class="flex flex-col w-1/2">
                                <label for="fathers_profession" class="text-sm text-start">Father's
                                    Profession</label>
                                <input type="text" name="fathers_profession" id="fathers_profession"
                                    value="{{ $student->fathers_profession }}"
                                    class="w-full text-sm mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2"
                                    required>
                            </div>
                        </div>

                        <div class=" flex flex-col">
                            <label for="guardian_name" class="text-sm text-start">Guardian's Name</label>
                            <input type="text" name="guardian_name" id="guardian_name"
                                value="{{ $student->guardian_name }}"
                                class="w-full text-sm mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2">
                        </div>

                        <div class="flex flex-row justify-start w-full gap-3 ">
                            <div class="flex flex-col w-1/2">
                                <label for="guardian_contact" class="text-sm text-start">Guardian's
                                    Contact</label>
                                <input type="tel" name="guardian_contact" id="guardian_contact"
                                    value="{{ $student->guardian_contact }}"
                                    class="w-full text-sm mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2 "
                                    required>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <label for="guardians_profession" class="text-sm text-start">Guardian's
                                    Profession</label>
                                <input type="text" name="guardians_profession" id="guardians_profession"
                                    value="{{ $student->guardians_profession }}"
                                    class="w-full text-sm mt-2 border-[3px] border-dark-gray focus:outline-none focus:border-dark-orange rounded-md p-2"
                                    required>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <div class="mr-10 flex justify-end">
            <button type="submit"
                class="mb-10 bg-dark-orange font-semibold text-lg shadow-2xl text-white w-1/6 p-2 rounded-md focus:outline-none hover:bg-custom-black transition duration-300 ease-in-out ">
                Submit
            </button>
        </div>

    </form>
</div>

@section('script')
<script>
    //script for getting image preview
        const inpFile = document.getElementById('doc');
        const previewContainer = document.getElementById('preview');
        const previewImage = previewContainer.querySelector('img');

            inpFile.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    previewImage.style.display = 'block';

                    reader.addEventListener('load', function() {
                        previewImage.setAttribute('src', this.result);
                    });

                reader.readAsDataURL(file);
            } else {
                previewImage.style.display = null;
                previewImage.setAttribute('src', '');
            }
        });
</script>
@endsection

@endsection
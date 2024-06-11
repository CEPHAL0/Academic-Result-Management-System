{{-- Navbar on the side of the screen --}}

<nav
        class="sidenavbar flex flex-col w-[160px] h-screen overflow-y-scroll py-6 hide-scrollbar bg-custom-black items-center *:text-white gap-12 ">
    <a href="/">
        <img src="{{ asset('assets/images/deerwalk_logo.svg') }}" alt="" class="sifal_logo_circle">
        <img src="{{ asset('assets/images/deerwalk_logo_full.svg') }}" alt="" class="sifal_logo_full hidden">
    </a>
    <button class="hamburger_button">
        <img src="{{ asset('assets/icons/hamburger_icon.svg') }}" alt="hamburger_icon">
    </button>

    {{-- Nav Bar Links --}}
    <div class="flex flex-col gap-8 ">

        <a class="flex gap-2 items-center" href="{{ route('hosDashboard.index') }}">
            <img src="{{ asset('assets/icons/dashboard_icon.svg') }}" alt="dashboard_icon">
            <p class="hidden sidenavbar-items-description">Dashboard</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('hosGrades.index') }}">
            <img src="{{ asset('assets/icons/grade_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">Grade</p>
        </a>


        <a class="flex gap-2 items-center" href="{{ route('hosStudents.index') }}">
            <img src="{{ asset('assets/icons/students_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">Student</p>
        </a>


        <a class="flex gap-2 items-center" href="{{ route('hosSubjects.index') }}">
            <img src="{{ asset('assets/icons/subject.svg') }}" alt="" class="ml-1">
            <p class="hidden sidenavbar-items-description">Subject</p>
        </a>


        <a class="flex gap-2 items-center" href="{{ route('hosSubjectTeachers.index') }}">
            <img src="{{ asset('assets/icons/teachers_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">Teacher</p>
        </a>


        <a class="flex gap-2 items-center" href="{{ route('hosTerms.index') }}">
            <img src="{{ asset('assets/icons/term.svg') }}" alt="" class="ml-1">
            <p class="hidden sidenavbar-items-description ml-1">Term</p>
        </a>


        {{-- <a class="flex gap-2 items-center" href="/">
            <img src="{{ asset('assets/icons/planner_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">Planner</p>
        </a> --}}


        <a class="flex gap-2 items-center" href="{{ route('hosCasTypes.index') }}">
            <img src="{{ asset('assets/icons/CAStype.svg') }}" alt="" class="ml-1">
            <p class="hidden sidenavbar-items-description">CAS Type</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('hosSections.index') }}">
            <img src="{{ asset('assets/icons/section.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description ml-1">Section</p>
        </a>



        <a class="flex gap-2 items-center" href="{{ route('hosExams.index') }}">
            <img src="{{ asset('assets/icons/exam.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description ml-1">Exam</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('hosAssignments.index') }}">
            <img src="{{ asset('assets/icons/assignment_icon.svg') }}" alt="" class="mr-1">
            <p class="hidden sidenavbar-items-description">Assignment</p>
        </a>


    </div>
</nav>
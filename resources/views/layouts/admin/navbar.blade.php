{{-- Navbar on the side of the screen --}}

<nav
    class="sidenavbar flex flex-col w-[160px] h-screen overflow-y-scroll py-6 hide-scrollbar items-center *:text-white gap-12  min-h-screen">
    <a href="/">
        <img src="{{ asset('assets/images/deerwalk_logo.svg') }}" alt="" class="sifal_logo_circle">
        <img src="{{ asset('assets/images/deerwalk_logo_full.svg') }}" alt="" class="sifal_logo_full hidden">
    </a>
    <button class="hamburger_button">
        <img src="{{ asset('assets/icons/hamburger_icon.svg') }}" alt="hamburger_icon">

    </button>

    {{-- Nav Bar Links --}}
    <div class="flex flex-col gap-8">
        <a class="flex gap-2 items-center" href="/">
            <img src="{{ asset('assets/icons/dashboard_icon.svg') }}" alt="dashboard_icon">
            <p class="hidden sidenavbar-items-description">Dashboard</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('users.index') }}">
            <img src="{{ asset('assets/icons/user.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">User</p>
        </a>
        <a class="flex gap-2 items-center" href="{{ route('schools.index') }}">
            <img src="{{ asset('assets/icons/school_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">School</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('departments.index') }}">
            <img src="{{ asset('assets/icons/department.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">Department</p>
        </a>


        <a class="flex gap-2 items-center" href="{{ route('grades.index') }}">
            <img src="{{ asset('assets/icons/grade_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">Grade</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('sections.index') }}">
            <img src="{{ asset('assets/icons/section.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">Section</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('terms.index') }}">
            <img src="{{ asset('assets/icons/term.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">Term</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('cas-types.index') }}">
            <img src="{{ asset('assets/icons/CAStype.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">CAS-Type</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('subjects.index') }}">
            <img src="{{ asset('assets/icons/subject.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">Subject</p>
        </a>

        <a class="flex gap-2 items-center" href="{{ route('subject-teachers.index') }}">
            <img src="{{ asset('assets/icons/teachers_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">Teacher</p>
        </a>



        <a class="flex gap-2 items-center" href="{{ route('students.index') }}">
            <img src="{{ asset('assets/icons/students_icon.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">Student</p>
        </a>

        {{-- <a class="flex gap-2 items-center" href="{{ route('cas.index')}}">
            <img src="{{ asset('assets/icons/cas.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">CAS</p>
        </a> --}}

        {{--   
        <a class="flex gap-2 items-center" href="{{route('exam.index')}}">
            <img src="{{ asset('assets/icons/exam.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">Exam</p>
        </a> --}}

        {{-- <a class="flex gap-2 items-center" href="{{ route('assignments.index')}}">
            <img src="{{ asset('assets/icons/assignment.svg') }}" class="ml-1" alt="">
            <p class="hidden sidenavbar-items-description">Assignment</p>
        </a> --}}

        {{-- <a class="flex gap-2 items-center" href="/">
            <img src="{{ asset('assets/icons/planner_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">Planner</p>
        </a> --}}

    </div>
</nav>

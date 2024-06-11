{{-- Navbar on the side of the screen --}}

<nav
        class="flex flex-col w-[160px] overflow-y-scroll py-6 hide-scrollbar  items-center *:text-white gap-12 sidenavbar  min-h-screen h-full">
    <a href="{{ route('hodDashboard.index') }}">
        <img src="{{ asset('assets/images/deerwalk_logo.svg') }}" alt="" class="sifal_logo_circle">
        <img src="{{ asset('assets/images/deerwalk_logo_full.svg') }}" alt="" class="sifal_logo_full hidden">
    </a>
    <button class="hamburger_button">
        <img src="{{ asset('assets/icons/hamburger_icon.svg') }}" alt="hamburger_icon">

    </button>

    {{-- Nav Bar Links --}}
    <div class="flex flex-col gap-8">
        <a class="flex gap-2 items-center" href="{{ route('hodDashboard.index') }}">
            <img src="{{ asset('assets/icons/dashboard_icon.svg') }}" alt="dashboard_icon">
            <p class="hidden sidenavbar-items-description">Dashboard</p>
        </a>
        <a class="flex gap-2 items-center" href="{{ route('hodExams.index') }}">
            <img src="{{ asset('assets/icons/exam.svg') }}" alt="" class="ml-1">
            <p class="hidden sidenavbar-items-description">Exam Marks</p>
        </a>
        <a class="flex gap-2 items-center" href="{{ route('hodAssignments.index') }}">
            <img src="{{ asset('assets/icons/assignment_icon.svg') }}" alt="">
            <p class="hidden sidenavbar-items-description">Assignments</p>
        </a>
    </div>
</nav>
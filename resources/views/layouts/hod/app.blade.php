<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/side-navbar.css') }}">

    {{-- Datatables stylesheet --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />

    {{-- Select2 stylesheet --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>@yield('Page Title')</title>
    @vite('resources/css/app.css')

    @yield('headScript')

</head>

<body>
<div class="flex">

    <div class="bg-custom-black sticky top-0 left-0 h-screen">
        @include('layouts.hod.navbar')
    </div>

    <main class="px-10 pb-10 w-full flex flex-col gap-4 bg-background-gray">
        @include('layouts.hod.topnavbar')

        <div class="bg-white rounded-md shadow-md pt-5 flex flex-col h-full justify-start">


            <div class="px-10 border-b-[1px] border-black py-3 flex justify-between text-2xl font-bold">
                @yield('title')
            </div>


            @include('sweetalert::alert')


            <div class="flex">
                @yield('content')
            </div>
        </div>
    </main>

</div>


</body>

{{-- Side Navbar scripts to collapse or view --}}
<script>
    const dropBtn = document.querySelector('.dropdownBtn');

    const dropMenu = document.querySelector('.dropdownMenu');

    const hamburger_button = document.querySelector('.hamburger_button');

    const sidenavbar = document.querySelector('.sidenavbar');

    const sifal_logo_full = document.querySelector('.sifal_logo_full');

    const sifal_logo_circle = document.querySelector('.sifal_logo_circle');

    const sidenavbarItemsDescriptions = document.querySelectorAll('.sidenavbar-items-description');

    dropBtn.addEventListener('click', function() {
        dropMenu.classList.toggle("hidden");
    });

    hamburger_button.addEventListener('click', function() {

        sidenavbar.classList.toggle("items-center");
        sidenavbar.classList.toggle("px-10");
        sidenavbar.classList.toggle("min-w-[300px]");
        sifal_logo_circle.classList.toggle('hidden');
        sifal_logo_full.classList.toggle('hidden');

        sidenavbarItemsDescriptions.forEach(link => {
            link.classList.toggle("hidden");
        })
    })
</script>

{{-- JQUERY --}}
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

<script>
    let table = new DataTable('#myTable', {
        responsive: true,
        autoWidth: false
    });
</script>

@yield('script')
{{-- Select2 script --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#selectSearch').select2({
            width: 'auto',
        });
        $('#gradeSelect').select2({
            width: 'auto',
        });
        $('#teacherSelect').select2({
            width: 'auto',
        });
        $('#departmentSelect').select2({
            width: 'auto',
        });
        $('#subjectSelect').select2({
            width: 'auto',
        });
        $('#sectionSelect').select2({
            width: 'auto',
        });
    });
</script>

</html>
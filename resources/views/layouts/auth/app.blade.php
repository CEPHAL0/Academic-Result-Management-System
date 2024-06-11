<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/side-navbar.css') }}">
    <title>@yield('Page Title')</title>
    @vite('resources/css/app.css')

</head>

<body>


    <main class="px-10 pb-10 w-full flex flex-col gap-4 ">
        @include('layouts.teacher.topnavbar')

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



</body>

{{-- Side Navbar scripts to collapse or view --}}
<script>
    const dropBtn=document.querySelector('.dropdownBtn');
        
        const dropMenu=document.querySelector('.dropdownMenu');

        const hamburger_button = document.querySelector('.hamburger_button');

        const sidenavbar = document.querySelector('.sidenavbar');

        const sifal_logo_full = document.querySelector('.sifal_logo_full');

        const sifal_logo_circle = document.querySelector('.sifal_logo_circle');

        const sidenavbarItemsDescriptions = document.querySelectorAll('.sidenavbar-items-description');

        dropBtn.addEventListener('click', function(){
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

@yield('script')

</html>
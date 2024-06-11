<header class="flex flex-col items-end  mt-2 gap-[0.1rem]" id="navbar">

    <button class="dropdownBtn flex items-center justify-center gap-4">
        <div class="flex flex-col items-end">
            <p class="text-xl font-bold border">{{ auth()->user()->name }}</p>
            <p class="text-sm">HoS</p>
        </div>
        <div>
            <img src="{{ asset('assets/icons/dropdown_icon.svg') }}" alt="drp_img">
        </div>
    </button>

    <div
        class="hidden flex items-start justify-center flex-col dropdownMenu absolute bg-topNavbar top-16 font-medium z-50">

        <div class="w-full text-white hover:bg-dark-orange hover:text-dark-gray">
            <a href="/change-password" class="flex flex-row gap-x-2 p-2 ">
                <img src="{{ asset('assets/icons/changePassword.svg') }}" alt="changePassword_Icon">
                Change Password</a>
        </div>

        <div class="w-full text-white hover:bg-dark-orange hover:text-dark-gray ">
            <form action="{{ route('logout') }}" method="post" class="flex  flex-row gap-x-2 p-2">

                @csrf
                <button type="submit" class="w-full text-start flex gap-2">
                    <img src="{{ asset('assets/icons/logout.svg') }}" class="ml-[6px]" alt="logout_icon">
                    Logout
                </button>
            </form>
        </div>

    </div>
</header>

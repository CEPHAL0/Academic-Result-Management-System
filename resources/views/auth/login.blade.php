<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.cdnfonts.com/css/switzer" rel="stylesheet">
    {{--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    --}}
    @vite('resources/css/app.css')
</head>

<body>
    <main class="login_background min-h-screen h-fit">
        <div class="backdrop_filter flex  backdrop-blur-sm  justify-between h-full">


            <div class="w-1/2"><img class="h-16 ml-4 mt-4" src="assets/images/sifalschoollogo.png" alt="">
            </div>


            <div class="h-auto w-[26rem] border flex rounded-md bg-white m-auto  py-5 ">

                <form action="{{ route('login') }}" method="post" class="w-full">
                    @csrf
                    <div class="px-10 flex flex-col justify-center gap-4 py-5">
                        <p class="text-4xl font-bold">Welcome Back</p>
                        <div class="flex flex-col gap-1">

                            <label for="" class="form-label font-bold">Role</label>

                            <select name="role" id="role" class="border border-black py-2 px-2 rounded-md *:">
                                <option value="admin">Admin</option>
                                <option value="teacher" selected>Teacher</option>
                                <option value="hod">HOD</option>
                                <option value="hos">HOS</option>
                            </select>

                            @error('role')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="" class="font-bold">Email</label>
                            <input type="email" name="email" class="border-dark-gray py-2 px-2 border-2 rounded-md"
                                id="" placeholder="Enter your email">
                            @error('email')
                            <span class="text-red-500 ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="exampleFormControlTextarea1" class="font-bold">Password</label>

                            <div class="relative">
                                <img src="assets/images/hide_icon.png" alt="" id="eye"
                                    class="absolute h-4 right-2 bottom-1/3">

                                <input type="password" name="password"
                                    class="rounded-md w-full border-2 border-dark-gray py-2 px-2" id="pass"
                                    placeholder="Enter your password">

                            </div>
                            @error('password')
                            <span class="text-red-500 ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <a href="/forgot-password" class="forgot_password">Forgot Password?</a>
                        </div>
                        <div class="flex flex-col"><button type="submit"
                                class="w-full text-white font-semibold bg-dark-orange py-2 rounded-md">Log
                                In</button>
                        </div>
                    </div>
                </form>

            </div>

            <script>
                let eye = document.getElementById('eye');
                    let password = document.getElementById('pass');
                    eye.onclick = function() {
                        if (password.type == "password") {
                            password.type = "text";
                            eye.src = "assets/images/view_icon.png";
                        } else {
                            password.type = "password";
                            eye.src = "assets/images/hide_icon.png";
                        }
                    }
            </script>

        </div>
    </main>

</body>

</html>
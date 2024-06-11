<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
</head>

<body>
    <main class="login_background">
        <div class="backdrop_filter flex lg:flex-row flex-col  h-full backdrop-blur-sm">
            <div class="w-1/2"><img class="h-16 ml-4 mt-4" src="assets/images/sifalschoollogo.png" alt="">
            </div>
            <div class="lg:w-1/2 w-fit flex lg:px-32">
                <div class="flex rounded-md min-h-[35rem] bg-white m-auto px-10  py-5 xl:w-full xl:h-[75%]">
                    <form action="{{ route('password.update') }}" method="post" class="w-full">
                        @csrf
                        <div class="px-10 flex flex-col justify-center gap-5 py-5 h-full">
                            <p class="text-4xl font-bold">Change Password</p>
                            
                            <div class="flex flex-col">
                                <label for="" class="font-bold pb-3">Email</label>
                                <input type="email" name="email"
                                    class="border-dark-gray py-2 px-2 border-2 rounded-md" id=""
                                    placeholder="Enter your email">
                                @error('email')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label for="exampleFormControlTextarea1" class="font-bold pb-3">Password</label>
                                <div class="relative">
                                    <img src="assets/images/hide_icon.png" alt="" id="eye"
                                        class="absolute h-4 right-2 bottom-1/3">
                                    <input type="password" name="password"
                                        class="rounded-md w-full border-2 border-dark-gray py-2 px-2" id="pass"
                                        placeholder="Enter your password">
                                </div>
                                @error('password')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label for="exampleFormControlTextarea1" class="font-bold pb-3">Password</label>
                                <div class="relative">
                                    <img src="assets/images/hide_icon.png" alt="" id="re_eye"
                                        class="absolute h-4 right-2 bottom-1/3">
                                    <input type="password" name="password_confirmation"
                                        class="rounded-md w-full border-2 border-dark-gray py-2 px-2" id="repass"
                                        placeholder="Confirm your password">
                                </div>
                                @error('password_confirmation')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col mt-4"><button type="submit"
                                    class="w-full text-white font-semibold bg-dark-orange py-2 rounded-md">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    
        <script>
            let eye = document.getElementById('eye');
            let password = document.getElementById('pass');
            let reeye = document.getElementById('re_eye');
            let repassword = document.getElementById('repass');
            eye.onclick = function() {
                if (password.type == "password") {
                    password.type = "text";
                    eye.src = "assets/images/view_icon.png";
                } else {
                    password.type = "password";
                    eye.src = "assets/images/hide_icon.png";
                }
            }
            reeye.onclick = function() {
                if (repassword.type == "password") {
                    repassword.type = "text";
                    reeye.src = "assets/images/view_icon.png";
                } else {
                    repassword.type = "password";
                    reeye.src = "assets/images/hide_icon.png";
                }
            }
        </script>
    </main>


</body>
</html>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    {{--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    --}}
</head>

<body>
    <main class="login_background">
        <div class="backdrop_filter flex lg:flex-row flex-col  h-full backdrop-blur-sm">
            <div class="w-1/2"><img class="h-16 ml-4 mt-4" src="assets/images/sifalschoollogo.png" alt="">
            </div>
            <div class="h-max w-[26rem] border flex rounded-md bg-white m-auto ">
                <div class="flex rounded-mdbg-white m-auto w-full">
                    <form action="{{ route('password.request') }}" method="post" class="w-full">
                        @csrf
                        <div class=" flex flex-col justify-center gap-4 p-10 py-24">
                            <p class="text-4xl font-bold">Reset Password</p>
                            <p>Enter your email or phone number to get back into your account</p>
                            <div class="text-xs text-green-600 mx-auto">
                                @if (session('status'))
                                {{ session('status') }}
                                @endif
                                {{-- We have emailed your password reset link. --}}
                            </div>
                            <div class="flex flex-col">
                                <label for="" class="font-bold pb-3">Email</label>
                                <input type="email" name="email" class="border-dark-gray py-2 px-2 border-2 rounded-md"
                                    id="" placeholder="Enter your email">
                                @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col"><button type="submit"
                                    class="w-full text-white font-semibold bg-dark-orange py-2 rounded-md">Send
                                    reset
                                    link</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </main>
</body>

</html>
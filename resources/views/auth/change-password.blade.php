@extends('layouts.teacher.app')
@section('Page Title', 'Change Password')
@section('title', 'Change Password')

@section('content')
    <div class="bg-white  mx-auto w-full flex justify-center h-fit pb-10">
        <section class="shadow-xl w-[25rem] rounded-md p-4">

            <div class="flex  m-auto w-full">
                <form action="/user/password" method="post" class="w-full">
                    @csrf
                    @method('PUT')
                    <div class="px-10 flex flex-col justify-center gap-5 py-5 h-full">

                        <div class="flex flex-col mt-3">
                            <label for="current_password" class="form-label mb-0 pb-3 font-bold">Old
                                Password*{{ \Auth::user()->role }}</label>
                            <div class="relative">
                                <img src="assets/images/hide_icon.png" alt="" id="current-eye"
                                     class="absolute h-4 right-2 bottom-1/3">
                                <input type="password" class="rounded-md w-full border-2 border-dark-gray py-2 px-2"
                                       id="current_password" placeholder="Enter old password" name="current_password" required>
                            </div>
                            <p class="text-red-500">{{ $errors->updatePassword->first('current_password') }}</p>
                        </div>
                        <div class="flex flex-col">
                            <label for="password" class="form-label mb-0 pb-3 font-bold">New
                                Password*</label>
                            <div class="relative">
                                <img src="assets/images/hide_icon.png" alt="" id="eye"
                                     class="absolute h-4 right-2 bottom-1/3">
                                <input type="password" class="rounded-md w-full border-2 border-dark-gr%ay py-2 px-2"
                                       id="password" placeholder="Enter new password" name="password" required>
                            </div>
                            <p class="text-red-500">{{ $errors->updatePassword->first('password') }}</p>
                        </div>
                        <div class="flex flex-col">
                            <label for="password_confirmation" class="form-label mb-0 pb-3 font-bold">Confirm
                                Password*</label>
                            <div class="relative">
                                <img src="assets/images/hide_icon.png" alt="" id="re-eye"
                                     class="absolute h-4 right-2 bottom-1/3">
                                <input type="password" name="password_confirmation"
                                       class="rounded-md w-full border-2 border-dark-gray py-2 px-2" id="re_password"
                                       placeholder="Confirm new password" required>
                                <p class="text-red-500">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col mt-6"><button type="submit"
                                                                class="w-full text-white font-semibold bg-dark-orange py-2 rounded-md">Change
                                Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        let eye = document.getElementById('eye');
        let c_eye = document.getElementById('current-eye');
        let reeye = document.getElementById('re-eye');
        let password = document.getElementById('password');
        let current_password = document.getElementById('current_password');
        let confirm_password = document.getElementById('re_password');
        eye.onclick = function() {
            if (password.type == "password") {
                password.type = "text";
                eye.src = "assets/images/view_icon.png";
            } else {
                password.type = "password";
                eye.src = "assets/images/hide_icon.png";
            }
        }
        c_eye.onclick = function() {
            if (current_password.type == "password") {
                current_password.type = "text";
                c_eye.src = "assets/images/view_icon.png";
            } else {
                current_password.type = "password";
                c_eye.src = "assets/images/hide_icon.png";
            }
        }
        reeye.onclick = function() {
            if (confirm_password.type == "password") {
                confirm_password.type = "text";
                reeye.src = "assets/images/view_icon.png";
            } else {
                confirm_password.type = "password";
                reeye.src = "assets/images/hide_icon.png";
            }
        }
    </script>
@endsection
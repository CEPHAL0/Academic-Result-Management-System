<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::loginView(function () {
            return view('auth.login');
        });
        Fortify::requestPasswordResetLinkView(function (){
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request){
            return view('auth.reset-password',['request'=>$request]);
        });
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);

        Fortify::authenticateUsing(function(Request $request){
            $user = User::where('email', $request->email)->first();
            if(!$user) {
                throw ValidationException::withMessages([
                    "role" => "Invalid Credentials"
                ]);
            }
            if (!$user->hasRole($request->role)){
                throw ValidationException::withMessages([
                    "role"=>"Invalid Credentials",
                ]);
            }

            if($user && Hash::check($request->password, $user->password)){
                Session::put('login_role',$request->role);
                return $user;
            }else{
                throw ValidationException::withMessages([
                    "role"=>"Invalid Credentials"
                ]);
            }
        });
    }
}

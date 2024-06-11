<?php

namespace App\Http\Responses;

use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Validation\ValidationException;
 
class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $home = "";

        switch ($request->role) {
            case 'admin':
                $home = "/home";
                break;
            case 'teacher':
                $home = "/teacher";
                break;
            case 'hod':
                $home = "/hod";
                break;
            case 'hos':
                $home = '/hos';
                break;        
        }

        if($home == ""){
            Auth::logout();
            throw new Exception("Invalid Credentials");
        }
        return redirect()->intended($home);
    }
}
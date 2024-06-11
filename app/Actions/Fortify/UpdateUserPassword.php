<?php

namespace App\Actions\Fortify;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update($user, array $input)
    {
        try{
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(function ($validator) use ($user, $input) {
            if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
            if(Hash::check($input['password'], $user->password)){
                $validator->errors()->add('password', __('The old password and new password must be different.'));
            }
        })->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
            'change_password_status' => '1',
            'last_password_change_datetime' => date('Y-m-d H:i:s'),
        ])->save();

        return Redirect::to('/dashboard')->with('toast_success', 'Password changed successfully.');
        }
        catch(\Exception $e){
            return Redirect::back()->with('toast_error', 'Something went wrong. Please try again.');
        }
    }
}

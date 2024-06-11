<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserCredentailMail;
use Illuminate\Http\Request;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::select('id', 'name', 'email')->with('roles:id,name')->whereNot("name", "System Admin")->get()->sortBy("name");
            return view('admin.users.index', ["users" => $users]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error" => "Failed to retrieve users"]);
        }
    }

    public function create()
    {
        try {
            $roles = Role::all();
            return view('admin.users.create', compact("roles"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error" => "Failed to create user"]);
        }
    }

    public function store(UserRequest $request)
    {
        $input = $request->validated();

        $initialPassword = Str::random(8);

        $input['password'] = bcrypt($initialPassword);
        $roles = $input['roles'];
        $user_roles = [];

        // Attach selected roles to the user
        try {

            $username = $input["name"];

            $extension = $request->file('signature')->getClientOriginalExtension();

            $fileName = $username . '_' . Carbon::now()->timestamp . '.' . $extension;

            //                Storage::putFileAs('images/user_signatures', $input['signature'], $fileName);

            $path = $input["signature"]->storeAs("signatures", $fileName, 'public');

            $input["signature"] = $fileName;

            $result = User::create($input);



            $result->roles()->attach($input['roles']);

            foreach ($roles as $role) {
                array_push($user_roles, Role::select('name')->where('id', $role)->first()->name);
            }
            Mail::to($result->email)->send(new UserCredentailMail($result, $user_roles, $initialPassword));

            return redirect(route("users.index"))->with("success", "User Created Successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to create User"]);
        }
    }

    public function show(User $user, int $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.show', ["user" => $user]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to update User"]);
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::all();
            return view('admin.users.edit', ["user" => $user, "roles" => $roles]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error" => "User not found"]);
        }
    }

    public function update(UserRequest $request, $id)
    {
        $input = $request->validated();
        try {
            $user = User::findOrFail($id);

            if ($request->hasFile("signature")) {
                $fileName = $user->signature;

                Storage::delete("public/signatures/" . $user->signature);

                $username = $input["name"];

                $extension = $request->file('signature')->getClientOriginalExtension();

                $fileName = $username . '_' . Carbon::now()->timestamp . '.' . $extension;



                $path = $input["signature"]->storeAs("signatures", $fileName, 'public');

                $input["signature"] = $fileName;
            }

            $user->update($input);

            $user->roles()->sync($input['roles']);

            return redirect(route('users.index'))->with('success', 'User updated successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to update User"]);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where("id", $id)->whereNot("name", "System Admin")->firstOrFail();


            $roles = $user->roles;
            // dd($roles);
            $user->roles()->detach();
            $user->delete();
            Storage::delete("public/signatures/" . $user->signature);

            return redirect(route('users.index'))
                ->with('success', 'User deleted successfully');
        } catch (Exception $e) {
            if (isset($roles)) {
                $user->roles()->sync($roles);
            }
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error" => "Failed to delete user"]);
        }
    }
}

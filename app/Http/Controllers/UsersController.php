<?php

namespace App\Http\Controllers;

use App\Base\Core;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['super'])->except('profile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $staffs = User::where('id', '<>', auth()->id())
            ->where(function ($query) {
                $find = request()->find;
                $find = explode(" ", $find ?? '');

                foreach ($find as $find) {
                    $query->where('first_name', 'LIKE', "%$find%")
                        ->orWhere('last_name', 'LIKE', "%$find%")
                        ->orWhere('email', 'LIKE', "%$find%");
                }
            })
            ->where("rank", "=", $request->routeIs("dash.staffs.*") ? 1 : 0)
            ->orderBy('last_name')->paginate(20);

        $staffs->withQueryString();
        // dd($staffs);
        return view('dash.users.staffs', [
            'users' => $staffs,
            'title' => "Manage Staffs" ,
        ]);
    }

    public function profile(Request $request)
    {
        if ($request->isMethod('POST')) {
            return $this->update($request, auth()->user());
        }
        return $this->edit(auth()->user());
    }

    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore((int)$user->id),],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'permission' => ['nullable'],
            'wa_phone' => ['nullable'],
            'brand_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'phone' => ['nullable'],
            'dp' => ['image', 'required_with:save-photo'],
        ], [
            'dp.required_with' => "Select a valid picture and try again"
        ], [
            'dp' => 'Profile Picture',
            'save-photo' => 'Upload Picture'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $validator->validated();

        if ($request->hasFile('dp')) {
            $dp = $data['dp'];
            $ext = $dp->extension();


            File::ensureDirectoryExists(Storage::path(User::DP_DIR), 0775);

            $user->del_pic();

            $path = $dp->storeAs(
                User::DP_DIR,
                $user->pic_real_name($ext)
            );
            // $user->del_pic();
            if ($path && $user->has_pic($ext)) {
                Core::add_message('Upload successful', ALERT_SUCCESS, 'Profile Picture Changed');
            }
        }
        // dd($data, $request->all());
        // dd($user, $data);
        $permission = $user->permission;
        if (isset($data['permission'])) {
            $perm = [
                'manage_property',
                'manage_type',
            ];

            if (auth()->user()->rank > 1) {
                $perm =[...$perm,
                    'manage_staffs',
                    'manage_users',
                    'delete_property',
                ];
            }


            foreach ($perm as $p) {
                $permission[$p] = in_array($p, $data['permission'] ?? []);
            }
        }

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'brand_name' => $data['brand_name'],
            'email' => $data['email'],
            'permission' => $permission,
            'phone' => $data['phone'],
            'wa_phone' => $data['wa_phone'],
        ]);

        if ($data['password']) {
            $res_pass = $user->update([
                'password' => Hash::make($data['password'])
            ]);

            if ($res_pass) {
                Core::add_message('Password has been updated for ' . $user->name, ALERT_SUCCESS, "Password Changed");
            }
        }

        if (!$user->isDirty()) {
            Core::add_message('Account has been updated', ALERT_SUCCESS, "Success");
            return redirect(($user->id === auth()->id()) ?
                route('main.dash.staffs.profile') : (route('main.dash.staffs.index') ));
        }

        return redirect()->back()->withInput();
    }

    public function edit(User $user)
    {
        // dd($user);
        return view('auth.register', [
            'user' => $user,
            // 'title' => "",
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->rank == 0 && Gate::allows('manage-users') || $user->rank == 1 && Gate::allows('manage-Staffs')) {
            # code...
            $name = $user->name ?? "staff";
            if ($user->delete()) {
                Core::add_message("Account {$name} has been permanently deleted", ALERT_SUCCESS, "Success");
            } else {
                Core::add_message("Account does not exist", ALERT_DANGER, "Error");
            }
        } else {
            abort(403);
        }
        return redirect()->back();
    }
}

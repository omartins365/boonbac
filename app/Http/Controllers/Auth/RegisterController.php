<?php

namespace App\Http\Controllers\Auth;

use App\Base\Core;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Models\User;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        if (! routeIsCustomer()) {
            $this->middleware(['auth']);
        }
        $this->middleware(['guest:customer']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'permission' => ['nullable'],
            'brand_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'phone' => ['nullable'],
            'wa_phone' => ['nullable'],
            'type' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $perm = [
            'manage_user',
            'create_user'
        ];

        $permission = $data['permission'] ?? [];

        if (auth()->user()?->rank > 1) {
            $perm = Arr::collapse([$perm, [
                'manage_staffs',
                'manage_users',
                'delete_user',
            ]]);
        }
        // dd($data, in_array('delete_user', $data['permission'] ?? []), $perm);
        foreach ($perm as $p) {

            $permission[$p] = in_array($p, $permission);
        }

        $rank = (Gate::allows('manage_staffs') && $data['type'] === 'staff') ? 1 : 0;


        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'brand_name' => $data['brand_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'wa_phone' => $data['wa_phone'],
            'password' => Hash::make($data['password']),
            'permission' => $permission,
            'rank' => $rank,
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        if (routeIsCustomer()) {

            return $this->registerCustomer($request);
        }

//        dd("nr");
        $data = $this->validator($request->all())->validate();

        // event(new Registered(
        $user = $this->create($data);

        // )));
//        event(new Registered($user));
//         $this->guard()->login($user);

        // if ($response = $this->registered($request, $user)) {
        //     return dd($response);
        // }
        if (! $user->exists) {
            // dd($user);

            Core::add_message("Staff account could not be created", ALERT_DANGER, "Error");
            return redirect()->back()->withInput()->withErrors("Could not create users");
        }
        else {
            // $user->more = [
            //     'api_key' => $user->createToken(uniqid($user::class . '-'), ['get-products', 'create-user'])->plainTextToken
            // ];
            // $user->save();
            Core::add_message($user->name . "'s account has been created", ALERT_SUCCESS, "Success");
        }
        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect()->back();
    }
    function registerCustomer(Request $request)
    {
        $ucr = new StoreCustomerRequest(request: $request->all());
        $data = Validator::make($request->all(), $ucr->rules(), $ucr->messages(), $ucr->attributes())->validate();
        // dd($data, $request->all());
        $ref_id = $request->cookie('ref');

        $customer = Customer::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'display_name' => $data['display_name'] ?? '',
            'email' => $data['email'],
            // 'phone' => $data['phone'],
            // 'wa_phone' => $data['wa_phone'],
            'password' => Hash::make($data['password']),
//            'pin' => Hash::make($data['pin']),
//            'referrer_id' => $ref_id,
        ]);
        event(new Registered($customer));
        // )));

        // $this->guard()->login($customer);

        // if ($response = $this->registered($request, $customer)) {
        //     return dd($response);
        // }
        if (! $customer->exists) {
            // dd($customer);

            Core::add_message("Account could not be created", ALERT_DANGER, "Error");
            return $request->wantsJson()
                ? new JsonResponse([], 201) : redirect()->back()->withInput()->withErrors("Could not create account");
        }
        else {
            $customer->api_key = $customer->createToken(uniqid($customer::class . '-'), ['get-products', 'authenticate-user', 'update-user', 'perform-transactions'])->plainTextToken;
            $customer->save();
            Core::add_message($customer->name . "'s account has been created", ALERT_SUCCESS, "Success");
            $this->guard()->login($customer);
            return $request->wantsJson()
                ? new JsonResponse([], 201) : redirect()->intended(route('customer.dashboard.home'))->withoutCookie('ref');
        }

    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view((routeIsCustomer()) ? 'customer.auth.register' : 'auth.register');
    }
    protected function guard()
    {
        return routeIsCustomer()?Auth::guard('customer'):Auth::guard();
    }
}

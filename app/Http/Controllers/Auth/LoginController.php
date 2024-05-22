<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');

        $this->middleware('guest:customer')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View customer     */
    public function showLoginForm(Customer $customer)
    {
        return view((routeIsCustomer())?'customer.auth.login':'auth.login', ['customer'=>$customer]);
    }
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (!routeIsCustomer()){
                if ($this->attemptLogin($request)) {
                    if ($request->hasSession()) {
                        $request->session()->put('auth.password_confirmed_at', time());
                    }

                    return $this->sendLoginResponse($request);
                }
        }else {

            if ($this->attemptCustomerLogin($request)) {
                if ($request->hasSession()) {
                    $request->session()->put('customer.auth.password_confirmed_at', time());
                }

                return $this->sendLoginResponse($request);
            }
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
//    public function redirectPath()
//    {
//        return routeIsMain()? route('main.dash.index'): route('customer.dashboard.home');
//    }

    public function attemptCustomerLogin(Request $request){
        return Auth::guard('customer')->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }

    // public function showCustomerLoginForm()
    // {
    //     return view('customer.auth.login', ['url' => route('customer.login-view'), 'title'=>'Customer']);
    // }

    public function customerLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('customer')->attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->intended(route('customer.dashboard.home'));
        }

        return back()->withInput($request->only('email', 'remember'));
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {

        Auth::guard(routeIsCustomer()?'customer':null)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    protected function guard()
    {
        return routeIsCustomer()?Auth::guard('customer'):Auth::guard();
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
//        dd(routeIsCustomer());
        if (routeIsMain()){
            $this->middleware('auth');
        } else {
            $this->middleware('auth:customer');
        }
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view(routeIsCustomer()?'customer.auth.verify':'auth.verify');
    }
    public function verified(Request $request)
    {
        alertSuccess('Email has been verified');
        return redirect(routeIsCustomer()?route('customer.dashboard.home'):$this->redirectPath());
    }

//    public function verify(Request $request)
//    {dd($request);
//        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
//            throw new AuthorizationException;
//        }
//
//        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
//            throw new AuthorizationException;
//        }
//
//        if ($request->user()->hasVerifiedEmail()) {
//            return $request->wantsJson()
//                ? new JsonResponse([], 204)
//                : redirect($this->redirectPath());
//        }
//
//        if ($request->user()->markEmailAsVerified()) {
//            event(new Verified($request->user()));
//        }
//
//        if ($response = $this->verified($request)) {
//            return $response;
//        }
//
//        return $request->wantsJson()
//            ? new JsonResponse([], 204)
//            : redirect($this->redirectPath())->with('verified', true);
//    }
}

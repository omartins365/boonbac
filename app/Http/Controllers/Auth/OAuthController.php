<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller {

    protected $providers = [
        'google',
        'facebook'
    ];

    public function redirectToAuthProvider( $driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            $intended = request()->session()->get('url.intended', null);
            if (empty($intended) || $intended === route('login')) {
                request()->session()->put('url.intended', url()->previous("/"));
            }
            // dd(url()->previous("/"),request()->session()->get('url.intended', null));
            return Socialite::driver($driver)->redirect();
        }
        catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }


    public function handleAuthProviderCallback($driver)
    {
        try {
            /**
             * @var \Laravel\Socialite\Two\GoogleProvider|\Laravel\Socialite\Two\FacebookProvider $provider
             */
            $provider = Socialite::driver($driver);
            $user = ($driver == "facebook") ? $provider->fields([
                'name',
                'first_name',
                'last_name',
                'email',
                'gender',
                'verified',
                 'link'
            ])->user()
                : $provider->with(["person.fields(emailAddresses, names)"])
                ->user();
        }
        catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty($user)
            ? $this->sendFailedResponse("No id returned from {$driver} provider.")
            : $this->loginOrCreateAccount( $driver, $user);
    }

    public static function sendSuccessResponse()
    {
        alertSuccess("You are now logged in.");
//        Core::save_response(4);
        return redirect()->intended();
    }

    protected function sendFailedResponse($msg = null)
    {
        alertWarning($msg ?: 'Unable to login, please try again.');
        return redirect(route('login'));
    }

    protected function loginOrCreateAccount( $driver, $user)
    {

                if (!empty($user?->email)) {

                    switch ($driver) {
                        case 'facebook':
                            $first_name = $user->offsetGet('first_name');
                            $last_name = $user->offsetGet('last_name');
                            break;

                        case 'google':
                            $first_name = $user->offsetGet('given_name');
                            $last_name = $user->offsetGet('family_name');
                            break;

                        // You can also add more provider option e.g. linkedin, twitter etc.

                        default:
                            $first_name = null;
                            $last_name = null;
                    }

                    $user = User::where('email', $user->email)->first();

                    if (!$user) {

                        $dd = [
                            'username' => $user->getNickname()??$first_name ?? $user->getName(),
                            'gender' => $user->offsetGet('gender'),
                            'email' => $user->getEmail(),
                            'password' => null,
                        ];
                        $user = User::create($dd);
                        event(new Registered($user));
                        alertSuccess('Your account has been created');
                    }

                    if ($user && $user->exists) {

                      
                        // return apiError(errors: $user);

                        Auth::guard()->login($user, true);


                        return $this->sendSuccessResponse();
                    }
                } else {
                    // The Google user's email address is not available
                    alertDanger("email address is not available with your {$driver} account or permission was denied.");
                }

//                alertDanger("Something went wrong, please try again");
            return $this->sendFailedResponse();

    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

}

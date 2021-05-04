<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Socialite;
use Log;
use Symfony\Component\HttpFoundation\Session\Session;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirect($provider)
    {
       //dd(config('services.facebook'));
       Log::info(config('services.facebook'));
       return Socialite::driver($provider)->redirect();
    }

    public function callback($provider){
            $userSocial =   Socialite::driver($provider)->stateless()->user();
            $user       =   User::where(['login' => $userSocial->getEmail()])->first();
            if($user){
                $this->guard()->login($user);
            }else{
                $user = User::create([
                    'nom'          => $userSocial->getName(),
                    'login'         => $userSocial->getEmail(),
                    'password'   => $userSocial->getId(),
                    'source'    => $provider
                ]);
                $this->guard()->login($user);
            }
            return redirect()->route('home');
    }
}

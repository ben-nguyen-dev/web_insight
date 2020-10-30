<?php

namespace App\Http\Controllers\Auth;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Services\RegistrationService;
use Illuminate\Support\Facades\Cookie;

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
    protected $login_service;
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
    public function __construct(RegistrationService $login_service)
    {
        $this->middleware('guest')->except('logout');
        $this->login_service = $login_service;
    }

    public function username()
    {
        return 'user_name';
    }
    public function sendFailedLoginResponse(Request $request) {
        return back()->with('warning', 'Account or password is incorrect');
    }
    protected function authenticated(Request $request, $user)
    {
        if (!$user->user_active) {
            if (!$this->login_service->checkExpires($user)) {
                $user->user_token = $this->login_service->regenerateToken($user);
            }
            $user->activation_link =  route('user.activate', $user->user_token);
            $this->login_service->sendMail($user->toArray());
            auth()->logout();
            return back()->with('warning', 'Your Account is not active. Please check email');
        }
        if($user) {
            $check = $this->login_service->checkUserRole($user, RoleEnum::ROLE_COMPANY_ADMIN);
            if($check && !$user->is_verified) {
                auth()->logout();
                return back()->with('warning', 'Your Account is not verify.');
            }
        }
        return redirect()->intended($this->redirectPath())->cookie('laravel_login', true, 2*60);
       
    }

    protected function logout() {
        Cookie::queue(Cookie::forget('laravel_login'));
        auth()->logout();
        return redirect()->intended($this->redirectPath());
    }
}

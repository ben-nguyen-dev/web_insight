<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Services\PasswordService;
use Validator;

class ResetPasswordController extends Controller
{
    private $service;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(PasswordService $service)
    {
        $this->service = $service;
    }

    public function showResetForm(Request $request, $token = null)
    {
        $user_name = $this->service->getEmailByToken($token);
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'user_name' => $user_name]
        );
    }

    public function reset(Request $request) {
        $this->validate($request, [
            'token' => 'required',
            'user_name' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        $email = $request->user_name;
        $response = $this->service->resetPassword($request);
        
        if($response && $response['status']) {
            return back()->withInput(['user_name' => $email])
                ->with(['success' => $response['message']]);
    
        } else {
            return back()->withInput(['user_name' => $email])
                ->with(['error' => $response['message'] ? $response['message'] : 'Do not reset password.']);
        }
    }
}

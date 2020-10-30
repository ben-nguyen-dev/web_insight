<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Services\PasswordService;
class ForgotPasswordController extends Controller
{

    private $service;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    public function __construct(PasswordService $service)
    {
        $this->service = $service;
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['user_name' => 'required|email']);

        $email = $request->user_name;
        $response = $this->service->forgotPassword($request);
        
        if($response && $response['status']) {
            return back()->withInput(['user_name' => $email])
                ->with(['success' => $response['message']]);
    
        } else {
            return back()->withInput(['user_name' => $email])
                ->with(['error' => $response['message'] ? $response['message'] : 'Do not send reset link email.']);
        }
    }


}

<?php
namespace App\Services; 
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class PasswordService {


    public function forgotPassword ($request) {
        $registerService = new RegistrationService();
        $email = $request->user_name;
        $user = User::where('user_name', $email)->first();
        if($user) {
            $passwordReset = PasswordReset::create(
                [
                    'email' => $email,
                    'token' => $registerService->getToken()
                ]
            );
            if(!$passwordReset) {
                return ["status" => false, "message" => 'Do not reset password for email: ' . $email];
            }
    
            $link = route ('password.reset', $passwordReset->token);
            $this->sendMail($email, $link);
        }
        
        return ["status" => true, "message" => 'We send new token to your email. Please check mail to continue!'];
    
    }

    private function sendMail ($emailTo, $link) {
        $data = array('name' => $emailTo, 'reset_pass_link' => $link);
        Mail::send('mail.forgot_password', $data, function($message) use ($emailTo) {
            $message->to($emailTo, $emailTo)
            ->subject('Reset password');
            $message->from('publicinsight.brs@gmail.com', 'Public Insight');
            });
    }

    public function getEmailByToken($token) {
        $password_reset = PasswordReset::where(['token' => $token])->first();
        return $password_reset ? $password_reset->email : '';
    }

    public function resetPassword ($request) {
        $user_name = $request->user_name;
        $token = $request->token;
        $check = PasswordReset::where([
            'email' => $user_name,
            'token' => $token
        ])->first();
        if(!$check) {
            return ["status" => false, "message" => 'Invalid token.'];
        }
        $user = User::where('user_name', $user_name)->first()
                ->update(['password' => Hash::make($request->password)]);
        if(!$user) {
            return ["status" => false, "message" => 'Do not update password for user: ' . $user_name];
        }
        return ["status" => true, "message" => 'Reset password success.'];
    }
}
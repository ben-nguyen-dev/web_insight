<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Validator;
use App\Services\RegistrationService;
use App\Http\Controllers\Controller;

class RegisterApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $register_service;
    public function __construct(RegistrationService $register_service)
    {
        // $this->middleware('auth');
        $this->register_service = $register_service;
    }

    public function registration (Request $request) {
        if ($request->ajax()) {
            $input = explode("&", $request->employee);
            foreach ($input as $value) {
                $rows = explode("=",urldecode($value));
                if ($rows[0] == "tags" ) {
                    $employee[$rows[0]][] = $rows[1];
                } else {
                    $employee[$rows[0]] = $rows[1];
                }
            }
            $validationRule = [
                'company'        => 'required',
                'email'          => "required|email",
                'password'       => 'required|min:8|confirmed',
                'company_number' => 'required',
                'phone_number'   => 'required|numeric|min:6',
                'full_name'      => 'required',
                'title'          => 'required',
                'company_name'   => 'required',
                'company_address'=> 'required',
                'company_postnumber'   => 'required',
                'company_postoffice'   => 'required',
                'company_country' => 'required'
            ];
            $validator = Validator::make($employee, $validationRule);
    
            if ($validator->fails()) {
                $response = [ "status" => false, "error" => $validator->errors()->all()];
            } else {
                $data = $this->register_service->createEmployee($employee);
                if ($data) {
                    $this->register_service->sendMail($data->toArray());
                    $response = [ "status" => true, "data" => $data ];
                } else {
                    $response = [ "status" => false, "message" => 'Create Employee is not success' ];
                }
            }
            return $response;
        }
    }
    public function activation (Request $request) {
        $token = $request->code;
        $user = $this->register_service->checkUser($token);
        if ($user) {
            if (!$user->user_active) {
                if ($this->register_service->checkExpires($user)) {
                    $user = $this->register_service->getUserToken($token);
                    return redirect()->route('login')->with('message', 'Your Account is actived!');
                } else {
                    $user->user_token = $this->register_service->regenerateToken($user);
                    $user->activation_link = route('user.activate', $user->user_token);
                    $this->register_service->sendMail($user->toArray());
                    return redirect()->route('login')->with('message', 'Token activation is expired. Please check mail!');
                }
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function checkCompanyExists (Request $request) {
        $input = $request->all();
        $company_id = $this->register_service->checkCompanyExists($input);
        if($company_id) {
            return ["status" => true, "message" => "Company account is registered. Please contact company admin to invited user."];
        }
        return ["status" => false];
    }

    public function checkEmailExists (Request $request) {
        $input = $request->all();
        $validationRule = [
            'email' => 'required|email'
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "error" => $validator->errors()->all()];
        } 
        return $this->register_service->checkEmailExists($input);
    }

    public function checkVerificationCodeExits(Request $request) {
        $code = $request->code;
        $email = $request->email;
        $checkCode = $this->register_service->checkVerificationCode($email, $code);
        if ($checkCode) {
            return response()->json([
                "status"  => true,
                "message" => "Verification code success"
            ]);
        }
        return response()->json([
            "status"  => false,
            "message" => "Verification code fail"
        ]);
    }
    public function getCompaniesData (Request $request) {
        $input = $request->all();
        $validationRule = [
            'company_number' => 'required'
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "error" => $validator->errors()->all()];
        } 
        return $this->register_service->getCompaniesData($input);
    }
}

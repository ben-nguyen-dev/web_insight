<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Models\Role;
use App\Services\BaseService;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
class HomeController extends Controller
{
    private $service,$userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BaseService $service, UserServices $userService)
    {
        $this->service = $service;
        $this->userService = $userService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $checkAdmin = $this->service->checkUserRole($user, RoleEnum::ROLE_ADMIN);
        $inforUser  = $this->userService->getInforUser();
        $departmentUser = $this->userService->getUserInCompany();
        $inforCompany  = $this->userService->getInforCompany();
        if($checkAdmin) {
            return redirect()->route('manage.companies');
        }
        return view('home')->with([
                'checkAdmin' => $checkAdmin, 
                'inforUser' => $inforUser,
                'departmentUser' => $departmentUser,
                'inforCompany'   => $inforCompany
                ]);
    }

    public function updateInformationUser(Request $request) {
        $input = explode("&", $request->edit_user);
        foreach ($input as $value) {
            $rows = explode("=",urldecode($value));
            $user[$rows[0]] = $rows[1];
        }
        $validationRule = [
            'name'         => 'required',
            'job_title'    => 'required',
            'phone_number' => 'required|min:8|max:15',
            'linked_in'    => 'required|url'
        ];
        $customMessages = [
            'name.required'          => 'The Namn field is required.',
            'job_title.required'     => 'The Yrkestitel field is required',
            'phone_number.required'  => 'The Telefonnummer field is required',
            'phone_number.min'       => 'The Telefonnummer must be at least 8 characters.',
            'phone_number.max'       => 'The Telefonnummer may not be greater than 15 characters.',
            'linked_in.required'     => 'The Linkedinprofil field is required.',
            'linked_in.url'          => 'The Linkedinprofil in format is invalid.',
        ];
        $validator = Validator::make($user, $validationRule, $customMessages);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error'  => $validator->errors()->all()
            ]);
        } else {
            $info_user = $this->userService->updateProfile($user);
            if ($info_user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Updated success.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Update fail.'
                ]);
            }
        }
    }
    public function changePassword(Request $request) {
        $input = explode("&", $request->password);
        foreach ($input as $value) {
            $rows = explode("=",urldecode($value));
            $pass[$rows[0]] = $rows[1];
        }
        $validationRule = [
            'old_password'      => 'required',
            'password'          => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ];
        $customMessages = [
            'old_password.required' => 'The Old Password field is required.',
            'password.required'     => 'The New Password field is required',
            'password.confirmed'    => 'The New Password confirmation does not match.',
            'password.min'           => 'The New Password must be at least 8 characters.',
            'password_confirmation.required' => 'The Confirm New Password field is required.',
        ];
        $validator = Validator::make($pass, $validationRule,$customMessages);
        if ($validator->fails()) {
            $response = [ "status" => false, "error" => $validator->errors()->all()];
        } else {
            try {
                $check_update = $this->userService->updatePassword($pass);
                if ($check_update) {
                    $response = [
                        "status" => true,
                        "message" => "Updated Success"
                    ];
                }
            } catch(\Exception $e) {
                $response = [
                    "status" => false,
                    "error" => [$e->getMessage()]
                ];
            }
        }   
        return response()->json($response);
    }

    public function updateChangeEmail(Request $request) {
        $validationRule = [
            'email' => 'required|email',
            'code'  => 'required'
        ];
        $customMessages = [
            'email.required' => 'The Email field is required.',
            'email.email'    => 'The Email must be a valid Email address.',
            'code.required' => 'The Code verify field is required.',
        ];
        $validator = Validator::make($request->toArray(), $validationRule, $customMessages);
        if ($validator->fails()) {
            $response = [ "status" => false, "error" => $validator->errors()->all()];
        } else {
            $email = $request->email;
            $code  = $request->code;
            $check_update = $this->userService->updateChangeEmail($email, $code);
            if ($check_update) {
                $response = [
                    'status'  => true,
                    'message' => 'Updated Success'
                ];
            } else {
                $response = [
                    'status'  => false,
                    'error' => ['Update Failed. Please review Verification Code']
                ];
            }
        }
        return response()->json($response);
    }

    public function setCodeVerify(Request $request) {
        $validationRule = [
            'email' => 'email',
        ];
        $customMessages = [
            'email.email'    => 'The Email must be a valid Email address.',
        ];
        $validator = Validator::make($request->toArray(), $validationRule, $customMessages);
        if ($validator->fails()) {
            $response = [ "status" => false, "error" => $validator->errors()->all()];
        } else {
            $email = $request->email;
            try {
                $code_verify = $this->userService->setCodeVerify($email);
                if ($code_verify) {
                    $response = [
                        'status' => true,
                        'email'  => $email
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'error'  => 'Please enter email address match your company'
                    ];
                }
            } catch(\Exception $e) {
                $response = [
                    'status' => false,
                    'error'  => $e->getMessage()
                ];
            }   
        }
        return response()->json($response);
    }
}

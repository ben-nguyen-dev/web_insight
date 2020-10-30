<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Services\UserServices;
use Validator;

class ManagerUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user_service;
    public function __construct(UserServices $user_service)
    {
        // $this->middleware('auth');
        $this->user_service = $user_service;
    }
    public function getAllUsers(Request $request) {
        $users = $this->user_service->getUserInCompany();
        return view('CompanyAdmin.manager_user')->with('users', $users);
    }

    public function sendMailUser(Request $request) {
        $validationRule = [
            'email' => 'required|email',
            'role'  => 'required'
        ];
        $validator = Validator::make($request->toArray(), $validationRule);
        if ($validator->fails()) {
            $data = [
                'status' => false,
                'message'  => $validator->errors()->all()
            ];
        } else {
            $email = $request->email;
            $role  = $request->role;
            $check_invite_user = $this->user_service->departmentInviteUser($email,$role);
            if ($check_invite_user) {
                $data = [
                    'status' => true,
                    'message' => ['Invite success. Please checked email!']
                ];
            } else {
                $data = [
                    'status'  => false,
                    'message' => ['Invite fail!']
                ];
            }
        }
        return response()->json($data);
    }

    public function showInviteUserForm (Request $request, $token = null) {
        $email = $this->user_service->getEmailByToken($token);
        if($email) {
            return view('invite_user')->with(['token' => $token, 'user_name' => $email]);
        }
        abort(404);
    }

    public function inActiveUser(Request $request) {
        $user_id = $request->arr_check;
        $checkActive = $this->user_service->inActiveUser($user_id);
        if ($checkActive) {
            return response()->json([
                'status'  => true,
                'message' => 'Updated success'
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Updated failed'
            ]);
        }
    }
    
    public function showDeleteSoftUser() {
        $showUserDelete = $this->user_service->showDeleteUser();
        if ($showUserDelete) {
            $viewDeleteUser = view('CompanyAdmin.manager_deletesoft_user')->with('showUser', $showUserDelete);
            return response()->json([
                'status'  => true,
                'message' => $viewDeleteUser->render()
            ]);
        }
        return response()->json([
            'status'  => false,
            'message' => 'Get User Delete Fail'
        ]);
    }

    public function addRoleCompanyAdmin($user_id) {
        $checkMakeRole = $this->user_service->MakeRoleCompanyAdmin($user_id);
        if ($checkMakeRole) {
            return redirect()->route('manager.users');
        } else {
            return back()->with('Update fail');
        }
    }
    public function removeRoleCompanyAdmin($user_id) {
        $checkRemove = $this->user_service->RemoveRoleCompanyAdmin($user_id);
        if ($checkRemove) {
            return redirect()->route('manager.users');
        } else {
            return back()->with('Update fail');
        }
    }

    public function ActiveUser(Request $request) {
        $user_id = $request->arr_check;
        $checkActive = $this->user_service->ActiveUser($user_id);
        if ($checkActive) {
            return response()->json([
                'status'  => true,
                'message' => 'Updated success'
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Updated Failed'
            ]);
        }
    }
    public function inviteUser (Request $request) {
        $input = $request->all();
        $this->validate($request, [
            'token' => 'required',
            'full_name' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        
        $response = $this->user_service->inviteUser($input);
        if($response) {
            if($response['status']) {
                Auth::login($response['user']);
                return redirect()->route('home');
            }
            return back()->with(['warning' => $response['message']]);
        }
    }
    public function deleteSoftUser(Request $request) {
        $user_id = $request->user_id;
        $check_delete = $this->user_service->deleteSoftUser($user_id);
        if ($check_delete) {
            return back()->with('success', 'Deleted Success!');
        }
        return back()->with('warning', 'Deleted Failed!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Services\RegistrationService;
use App\Services\SystemAdminService;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Exception;

class SystemAdminController extends Controller
{
    private $service;
    private $user_service;
    private $registrationService;

    public function __construct(SystemAdminService $service, UserServices $user_service, RegistrationService $registrationService)
    {
        $this->service = $service;
        $this->user_service = $user_service;
        $this->registrationService = $registrationService;
    }

    public function getCompanies () {
        $companies = $this->service->getCompanies();
        return view('systemAdmin.manage_companies')->with('companies', $companies);
    }

    public function getCompanyDepartments (Request $request, $id = '') {

        if (!$id) {
            return [ "status" => false, "message" => 'The id field is required'];
        } 
        $company = $this->service->getCompany($id);
        $departments = $this->service->getCompanyDepartments($id);
        $user = Auth::user();
        return view('systemAdmin.manage_company_departments')->with(['user' => $user, 'company' => $company, 'departments' => $departments]);
    }

    //API
    public function updateIsVerifiedCompany (Request $request) {
        $input = $request->all();
        $validationRule = [
            'id' => 'required'
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        return $this->service->updateIsVerifiedForCompany($input);
    }


    public function updateIsVerifiedUser (Request $request) {
        $input = $request->all();
        $validationRule = [
            'id' => 'required'
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        return $this->service->updateIsVerifiedForUser($input);
    }

    public function moveUsers (Request $request) {
        $input = $request->all();
        $validationRule = [
            'user_id_list' => 'required',
            'old_department_id' => 'required',
            'new_department_id' => 'required'
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        $result = $this->service->moveUsersToOtherDeparment($input);
        if(!$result['status']) {
            return $result;
        }
        $view_html = view('systemAdmin.user_list_department')->with(['current_department' => $input['old_department_id'], 'departments' => $result['departments']])->render();
        return response()->json([
            'status' => true,
            'message' => 'Move users to deparment success!',
            'view_html' => $view_html
        ]); 
    }

    public function inviteCompanyAdmin (Request $request) {

        $input = $request->all();
        $validationRule = [
            'email' => 'required',
            'department_id' => 'required',
            'user_id' => 'required'
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        return $this->service->inviteCompanyAdmin($input);
    }

    public function createDepartment (Request $request) {
        $input = $request->all();
        $validationRule = [
            'department_name' => 'required',
            'company_id' => 'required',
        ];
        $validator = Validator::make($input, $validationRule);
        $company_id = $input["company_id"];
        if ($validator->fails()) {
            return redirect()->route('manage.company.departments',$company_id)->with('error', 'Create department failed.');
        } else {
            $result =  $this->service->createDepartment($input);
            if($result && $result["status"]) {
                return redirect()->route('manage.company.departments',$company_id)->with('success', $result["message"]);
            }
            return redirect()->route('manage.company.departments', $company_id)->with('error', $result["message"]);
        }
    }

    public function addRoleCompanyAdmin($user_id) {
        $check = $this->user_service->MakeRoleCompanyAdmin($user_id);
        if ($check) {
            return back()->with('success', 'Add role Company admin successful.');
        } else {
            return back()->with('error', 'Add role Company admin failed.');
        }
    }
    public function removeRoleCompanyAdmin($user_id) {
        $check = $this->user_service->RemoveRoleCompanyAdmin($user_id);
        if ($check) {
            return back()->with('success', 'Remove role Company admin successful.');
        } else {
            return back()->with('error', 'Remove role Company admin failed.');
        }
    }

    public function getTags (Request $request) {
        $tags = $this->service->getTags();
        return view('systemAdmin.manage_tags')->with('tags', $tags);
    }

    public function updateTag (Request $request) {
        $input = $request->all();
        $validationRule = [
            'id' => 'required',
            'name' => 'required',
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        return $this->service->updateTag($input);
    }

    public function createTag (Request $request) {
        $input = $request->all();
        $validationRule = [
            'name' => 'required',
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        return $this->service->createTag($input);
    }

    public function deleteTag(Request $request) {
        $input = $request->all();
        $validationRule = [
            'id' => 'required',
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        return $this->service->deleteTag($input);
    }

    public function refreshCompanyInfo($company_number) {
        $input['company_number'] = $company_number;
        $data = $this->registrationService->getCompaniesData($input);
        if($data && !$data["status"]) {
            return back()->with('error', $data["message"]);
        }
        $result = $this->service->refreshCompanyInfo($data);
        if($result && $result["status"]) {
            return back()->with('success', $result["message"]);
        }
        if($result && $result["status"]) {
            return back()->with('error', $result["message"]);
        }
    }

    public function updateCPVCode (Request $request) {
        $input = $request->all();
        $validationRule = [
            'company_id' => 'required',
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        return $this->service->updateCpv($input);
    }

    public function showCreateCompanyForm (Request $request) {
        return view('systemAdmin.create_company');
    }

    public function createCompany (Request $request) {
        $input = $request->all();
        $validationRule = [
            'company_number' => 'required',
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        $result = $this->service->createCompany($input);
        if($result && $result["status"]) {
            return back()->with('success', $result["message"]);
        }
        if($result && !$result["status"]) {
            return back()->with('error', $result["message"]);
        }
    }

    public function addConsultant (Request $request) {
        $input = $request->all();
        $validationRule = [
            'email' => 'required|email',
            'user_name' => 'required',
            'password' => 'required',
            'department_id' => 'required',
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        } 
        return $this->service->addConsultant($input);
    }

    public function showProfilePage ($id) {
        $user = $this->service->getUserById($id);
        $check_role = $this->service->checkUserRole($user, RoleEnum::ROLE_CONSULTANT);
        if(!$check_role) {
            abort(404);
        }
        $profile_page = $this->service->findProfilePageByUser($id);
        return view('systemAdmin.profile_page_for_consultant')->with(['user_id' => $id, 'profile_page' => $profile_page]);
    }

    public function updateProfilePage (Request $request) {
        $input = $request->all();
        $validationRule = [
            'profile_title' => 'required',
            'user_id' => 'required'
        ];
        $validator = Validator::make($input, $validationRule);
    
        if ($validator->fails()) {
            return [ "status" => false, "message" => $validator->errors()->all()];
        }
        $result = $this->service->updateProfilePage($input);
        if($result && $result["status"]) {
            return back()->with('success', $result["message"]);
        }
        if($result && !$result["status"]) {
            return back()->with('error', $result["message"]);
        }
    }
}

<?php

namespace App\Services;

use App\Enum\AddressEnum;
use App\Enum\RoleEnum;
use App\Models\AddressRecord;
use App\Models\Company;
use App\Models\CpvRecord;
use App\Models\Department;
use App\Models\Employment;
use App\Models\InviteUserRecord;
use App\Models\NameRecord;
use App\Models\ProfilePage;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Mail;

class SystemAdminService extends BaseService
{

    public function checkUserRole($user, $user_role)
    {
        if (!$user_role) {
            $user_role  = RoleEnum::ROLE_ADMIN;
        }
        if ($user) {
            $roles = [];
            foreach ($user->roles as $role) {
                array_push($roles, $role->name);
            }
            if (in_array($user_role, $roles)) {
                return true;
            }
        }
        return false;
    }

    public function getCompanies()
    {
        $result = array();
        $companies = Company::select('id', 'registration_number', 'is_verified')->get();
        foreach ($companies as $company) {
            $item = $company->toArray();
            $item['name'] = $this->getCompanyName($company);
            $address_record = AddressRecord::where(['company_id' => $company->id, 'is_active' => true])->first();
            $item['address'] = $address_record ? ($address_record->line1 . ' ' . $address_record->city . ' ' . $address_record->country) : '';
            array_push($result, $item);
        }
        return $result;
    }

    public function updateIsVerifiedForCompany($input)
    {
        $company_id = $input['id'];
        $company = Company::where('id', $company_id)->first();
        if (!$company) {
            return ["status" => false, "message" => "Do not find company with id: " . $company_id];
        }

        $company_name = $this->getCompanyName($company);
        $new_is_verified = !$company->is_verified;
        $company->is_verified = $new_is_verified;
        $check = $company->save();
        if (!$check) {
            return ["status" => false, "message" => "Do not update field is_verified for company: " . $company_name];
        }
        return ["status" => true, "is_verified" => $new_is_verified, "message" => "Company " . $company_name . ($new_is_verified ? " is verified." : " is not verified")];
    }

    public function getCompany($id)
    {
        $result = [];
        $company = Company::where('id', $id)->first();
        if ($company) {
            $result['id'] = $company->id;
            $result['company_number'] = $company->registration_number;
            $result['company_is_verified'] = $company->is_verified;
            $result['company_is_consultant'] = $company->is_consultant;
            $name_record = $company->nameRecords()->where('is_active', true)->first();
            $result['company_name'] = $name_record->name;
            $sni_record = $company->SniRecords->where('is_active', true)->first();
            $result['company_sni_code'] = $sni_record ? $sni_record->sni : '';
            $cpv_record = $company->CpvRecords->where('is_active', true)->first();
            $result['company_cpv_code'] = $cpv_record ? $cpv_record->cpv : '';
            $result['company_website'] = $company->website;
            $result['company_phone_number'] = $company->phone_number;
            $result['company_email'] = $company->email;
            $e_invoice = $company->electronicInvoices()->where('is_active', true)->first();
            $result['company_e_invoice'] = $e_invoice ? $e_invoice->e_invoice : '';
            $result['company_linked_in'] = $company->linked_in;
            $domains = $company->domainRecords()->where('is_active', true)->get();
            $result['company_domains'] = $domains;
            $tags = $company->tags()->where('is_active', true)->get();
            $result['company_tags'] = $tags;
            $office_address = $company->addressRecords()->where(['is_active' => true, 'type' => AddressEnum::OFFICE_ADDRESS])->first();
            $result['office_address'] = $office_address;
            $invoice_address = $company->addressRecords()->where(['is_active' => true, 'type' => AddressEnum::INVOICE_ADDRESS])->first();
            if ($invoice_address && !$this->checkSameAddress($office_address, $invoice_address)) {
                $result['second_address'] = $invoice_address;
            }
            $visiting_address = $company->addressRecords()->where(['is_active' => true, 'type' => AddressEnum::VISITING_ADDRESS])->first();
            if ($visiting_address && !$this->checkSameAddress($office_address, $visiting_address)) {
                $result['second_address'] = $visiting_address;
            }
        }
        return $result;
    }

    public function getCompanyName($company)
    {
        if (is_string($company)) {
            $company = Company::where('id', $company)->first();
        }
        if ($company) {
            $name_record = $company->nameRecords()->where(['is_active' => true])->first();
        }
        return isset($name_record) ? $name_record->name : '';
    }

    public function getCompanyDepartments($id)
    {
        $company = Company::where('id', $id)->first();
        if (!$company) {
            return ["status" => false, "message" => "Do not find company with id: " . $id];
        }
        $result = [];
        $departments = $company->departments;
        foreach ($departments as $department) {
            $item['department'] = $department;
            $item['users'] = $this->getUsersByDepartment($department);
            array_push($result, $item);
        }
        return $result;
    }

    public function getUsersByDepartment($department)
    {
        $result = [];
        $employments = $department->employments;
        if ($employments && count($employments) > 0) {
            foreach ($employments as $employment) {
                $item = [];
                $item['work_email'] = $employment->work_email;
                $item['work_phone'] = $employment->work_phone;
                $item['job_title'] = $employment->job_title;
                $user = $employment->user;
                if ($user) {
                    $item['id'] = $user->id;
                    $item['full_name'] = $user->full_name;
                    $item['is_actived'] = $user->user_active;
                    $item['is_verified'] = $user->is_verified;
                    $roles = $user->roles;
                    $role_array = [];
                    foreach ($roles as $role) {
                        array_push($role_array, $role->name);
                    }
                    $item['roles'] = $role_array;
                }

                array_push($result, $item);
            }
        }

        return $result;
    }

    public function updateIsVerifiedForUser($input)
    {
        $user_id = $input['id'];
        $user = User::where('id', $user_id)->first();
        if (!$user) {
            return ["status" => false, "message" => "Do not find company with id: " . $user_id];
        }

        $new_is_verified = !$user->is_verified;
        $user->is_verified = $new_is_verified;
        $check = $user->save();
        if (!$check) {
            return ["status" => false, "message" => "Do not update field is_verified for user: " . $user->user_name];
        }
        return ["status" => true, "is_verified" => $new_is_verified, "message" => "User " . $user->user_name . ($new_is_verified ? " is verified." : " is not verified")];
    }

    public function moveUsersToOtherDeparment($input)
    {
        $user_id_list = $input['user_id_list'];
        $old_department_id = $input['old_department_id'];
        $new_department_id = $input['new_department_id'];
        $department = Department::where('id', $new_department_id)->first();
        if (!$department) {
            return ["status" => false, "message" => "Do not find department with id: " . $new_department_id];
        }
        $employments = $department->employments;
        $i = 0;
        foreach ($user_id_list as $id) {
            $user = User::where('id', $id)->first();
            if (!$user) {
                return ["status" => false, "message" => "Do not find user with id: " . $id];
            }
            $employment = Employment::where(['user_id' => $id, 'department_id' => $old_department_id])->first();
            $employment->department_id = $new_department_id;
            $employment->save();
            if ($employments->count() == 0 && $i == 0) {
                $check = $this->checkUserRole($user, RoleEnum::ROLE_COMPANY_ADMIN);
                if (!$check) {
                    $user_role = Role::where('name', RoleEnum::ROLE_USER)->first();
                    $company_admin_role = Role::where('name', RoleEnum::ROLE_COMPANY_ADMIN)->first();
                    $role = UserRole::where(['user_id' => $id, 'role_id' => $user_role->id])->first();
                    if ($role) {
                        $role->update(['role_id' => $company_admin_role->id]);
                    } else {
                        UserRole::create([
                            'id' => $this->quickRandom(),
                            'user_id' => $id,
                            'role_id' => $company_admin_role->id
                        ]);
                    }
                }
            }
            $i++;
        }
        $department_list = [];
        $departments = Department::where('company_id', $department->company_id)->get();
        foreach ($departments as $department) {
            $item['department'] = $department;
            $item['users'] = $this->getUsersByDepartment($department);
            array_push($department_list, $item);
        }
        return ["status" => true, "message" => "Move users to deparment '" . $department->name . "' success.", "departments" => $department_list];
    }

    public function inviteCompanyAdmin($input)
    {
        $registerService = new RegistrationService();
        $email = $input['email'];
        $user = User::where('user_name', $email)->first();
        $department_id = $input['department_id'];
        $department = Department::where('id', $department_id)->first();
        if ($user) {
            return ["status" => false, "message" => "User is existed."];
        }
        if (!$department) {
            return ["status" => false, "message" => "Department is not exists."];
        }
        $invite_user_record = InviteUserRecord::create([
            'email' => $email,
            'token' => $registerService->getToken(),
            'user_id' => $input['user_id'],
            'department_id' => $department_id
        ]);
        if (!$invite_user_record) {
            return ["status" => false, "message" => 'Do not invite company admin for email: ' . $email];
        }


        $company = $department->company;
        $name_record = $company->nameRecords()->where('is_active', true)->first();
        $company_name = $name_record ? $name_record->name : '';
        $link = route('user.invite.request', $invite_user_record->token);
        $this->sendMail($email, $department->name, $company_name, $link);
        return ["status" => true, "message" => 'Invite company admin success for email: ' . $email];
    }

    private function sendMail($emailTo, $department_name, $company_name, $link)
    {
        $data = array('name' => $emailTo, 'department_name' => $department_name, 'company_name' => $company_name, 'invite_user_link' => $link);
        Mail::send('mail.invite_company_admin', $data, function ($message) use ($emailTo) {
            $message->to($emailTo, $emailTo)
                ->subject('Invite company admin');
            $message->from('publicinsight.brs@gmail.com', 'Public Insight');
        });

        if (Mail::failures()) {
            return ["status" => false, "message" => "Do not send mail invite company admin for email: " . $emailTo];
        }
    }
    public function createDepartment($input)
    {
        $name = $input['department_name'];
        $company_id  = $input['company_id'];

        $existsDepartment = Department::where('name', $name)->first();
        if ($existsDepartment) {
            return ["status" => false, "message" => "Department: " . $name . ' is existed.'];
        }
        $department = Department::create([
            'id' => $this->quickRandom(),
            'name' => $name,
            'company_id' => $company_id,
            'default_department' => false,
        ]);
        if ($department) {
            return ["status" => true, "message" => "Create successful department: " . $name];
        }
        return ["status" => false, "message" => "Create failed department: " . $name];
    }
    public function getTags()
    {
        return Tag::get();
    }

    public function updateTag($input)
    {
        $tag = Tag::where('id', $input['id'])->first();
        if (!$tag) {
            return ["status" => false, "message" => "Do not find tag: " . $input['id']];
        }
        $tag->update(['name' => $input['name']]);
        if (isset($input['is_active'])) {
            $tag->update(['is_active' => $input['is_active'], 'removed_date' => null]);
        };
        return ["status" => true, "message" => "Update successful tag: " . $input['name']];
    }

    public function createTag($input)
    {
        $existsTag = $tag = Tag::where('name', $input['name'])->first();
        if ($existsTag) {
            return ["status" => false, "message" => "Tag: " . $input['name'] . " is existed."];
        }
        $tag = Tag::create([
            'id' => $this->quickRandom(),
            'name' => $input['name'],
            'is_active' => true,
            'removed_date' => null
        ]);
        if ($tag) {
            return ["status" => true, "message" => "Create success tag: " . $input['name']];
        };
        return ["status" => false, "message" => "Create failed tag: " . $input['name']];
    }

    public function deleteTag($input)
    {
        $tag = Tag::where('id', $input['id'])->first();
        if (!$tag) {
            return ["status" => false, "message" => "Do not find tag: " . $input['id']];
        }
        $tag->update(['is_active' => false, 'removed_date' => Carbon::now()]);
        return ["status" => true, "message" => "Delete successful tag: " . $input['id']];
    }

    public function refreshCompanyInfo($data)
    {
        $info = $data["data"];
        if ($info) {
            $company = Company::where(['registration_number' => $info->ORGNR])->first();
            if (!$company) {
                return ["status" => false, "message" => "Do not find company with number: " . $info->ORGNR];
            }
            $company->update([
                'email' => $info->EMAIL_ADRESS,
                'phone_number' => $info->TELEPHONE,
            ]);
            $company->nameRecords()->where('is_active', 1)->first()->update(['name' => $info->NAME]);
            $company->addressRecords()
                ->where(['is_active' => 1, 'type' => AddressEnum::OFFICE_ADDRESS])->first()
                ->update([
                    'line1' => $info->ADDRESS,
                    'post_code' => $info->ZIPCODE,
                    'city' => $info->TOWN,
                ]);
            return ["status" => true, "message" => "Refresh successful for company " . $info->ORGNR];
        }
    }

    public function updateCpv($input)
    {
        $company_id = $input["company_id"];
        $company = Company::where('id', $company_id)->first();
        if (!$company) {
            return ["status" => false, "message" => "Do not find company with id: " . $company_id];
        }
        if (!isset($input["newCpv"])) {
            $company->CpvRecords()->delete();
            return ["status" => true, "message" => "Update CPV code successful for company: " . $company_id];
        };

        $newCpv = $input["newCpv"];
        $exists_cpv = $company->CpvRecords()->where(['company_id' => $company_id, 'cpv' => $newCpv])->first();
        if ($exists_cpv) {
            if (!$exists_cpv->is_active) {
                $exists_cpv->update(['is_active' => true]);
            }
        } else {
            $cpv = CpvRecord::create([
                'id' => $this->quickRandom(),
                'company_id' => $company_id,
                'cpv' => $newCpv,
                'added_date' => Carbon::now(),
                'is_active' => true
            ]);
            $company->CpvRecords()->where('id', '!=', $cpv->id)->delete();
        }
        return ["status" => true, "message" => "Update CPV code successful for company: " . $company_id];
    }

    public function createCompany($input)
    {
        $exists_company = Company::where('registration_number', $input["company_number"])->first();
        if ($exists_company) {
            return ["status" => false, "message" => "Company number: " . $input["company_number"] . " is existed."];
        }
        $get_company = $this->getCompaniesData($input);
        if ($get_company && $get_company["status"]) {
            $data = $get_company["data"];
            $company = Company::create([
                'id'                  => $this->quickRandom(),
                'type'                => '',
                'registration_number' => $data->ORGNR,
                'email'               => is_object($data->EMAIL_ADRESS) ? '' : $data->EMAIL_ADRESS,
                'phone_number'        => $data->TELEPHONE,
                'linked_in'           => '',
                'website'             => '',
                'is_consultant'       => true
            ]);
            if ($company) {
                $company_name = $data->NAME;
                $department = Department::create([
                    'id' => $this->quickRandom(),
                    'name' => 'general department',
                    'company_id' => $company->id,
                    'default_department' => true
                ]);
                $name_record = NameRecord::create([
                    'id'                  => $this->quickRandom(),
                    'company_id'          => $company->id,
                    'name'                => $company_name,
                    'added_date'          => Carbon::now(),
                    'is_active'           => true,
                ]);
                $address_record = AddressRecord::create([
                    'id'                  => $this->quickRandom(),
                    'company_id'          => $company->id,
                    'line1'               => $data->ADDRESS,
                    'line2'               => '',
                    'city'                => $data->TOWN,
                    'post_code'           => $data->ZIPCODE,
                    'country'             => 'Sweden',
                    'type'                => AddressEnum::OFFICE_ADDRESS,
                    'is_active'           => true,
                ]);
                return ["status" => true, "message" => "Create successful company: " . $company_name];
            }
        }
        return ["status" => false, "message" => "Create failed company number: " . $input["company_number"]];
    }
    public function addConsultant($input)
    {
        $exists_user = User::where('user_name', $input["email"])->first();
        if ($exists_user) {
            return ["status" => false, "message" => "User: " . $input["email"] . " is existed."];
        }
        $department = Department::where('id', $input["department_id"])->first();
        $employments = $department->employments;
        $user = User::create([
            'id'         => $this->quickRandom(),
            'user_name'  => $input["email"],
            'password'   => Hash::make($input['password']),
            'first_name' => '',
            'last_name'  => '',
            'full_name'  => $input["user_name"],
            'avatar'     => NULL,
            'user_token' => $this->getToken(),
            'user_active' => true,
            'is_verified' => true
        ]);

        $consultant_role = Role::where('name', RoleEnum::ROLE_CONSULTANT)->first();
        $company_admin_role = Role::where('name', RoleEnum::ROLE_COMPANY_ADMIN)->first();
        if ($user && $department) {
            $employment = Employment::create([
                'id'                            => $this->quickRandom(),
                'department_id'                 => $input["department_id"],
                'user_id'                       => $user->id,
                'job_title'                     => '',
                'job_description'               => '',
                'work_email'                    => isset($input['email']) ? $input['email'] : '',
                'work_phone'                    => '',
                'public_procurement_experience' => 0,
                'office_address'                => '',
                'current_employment'            => true,
                'start_date'                    => Carbon::now(),
                'phone_number'                  => '',
                'linked_in'                     => '',
            ]);
            UserRole::create([
                'id' => $this->quickRandom(),
                'user_id' => $user->id,
                'role_id' => $consultant_role->id
            ]);
            if ($employments && count($employments) == 0 || !$employments) {
                UserRole::create([
                    'id' => $this->quickRandom(),
                    'user_id' => $user->id,
                    'role_id' => $company_admin_role->id
                ]);
            }
            return ["status" => true, "message" => "Add successful consultant: " . $input["email"]];
        }
        return ["status" => false, "message" => "Add failed consultant: " . $input["email"]];
    }
    
    public function getUserById ($id) {
        return User::where('id', $id)->first();
    }

    public function findProfilePageByUser ($user_id) {
        $user = User::where('id', $user_id)->first();
        if(!$user) {
            return null;
        }
        return $user->profilePages()->where('removed_date', null)->first();
    }

    public function updateProfilePage ($input) {
        $user_id = $input["user_id"];
        $user = User::where('id', $user_id)->first();
        if(!$user) {
            return ["status" => false, "message" => "User " . $user_id . " is not exists."];
        }
        $check_role = $this->checkUserRole($user, RoleEnum::ROLE_CONSULTANT);
        if(!$check_role) {
            return ["status" => false, "message" => "User " . $user_id . " do not have permission."];
        }
        $profile_page = ProfilePage::create([
            'id' => $this->quickRandom(),
            'user_id' => $user_id,
            'profile_title' => $input["profile_title"], 
            'profile_description' => isset($input["profile_description"]) ? $input["profile_description"] : '', 
            'location' => isset($input["profile_location"]) ? $input["profile_location"] : '', 
            'status' => isset($input["profile_status"]) ? $input["profile_status"] : 'publish', 
            'added_date' => Carbon::now(), 
            'removed_date' => null
        ]);
        if($profile_page) {
            $profile_pages = $user->profilePages()->whereNotIn('id', [$profile_page->id])->update(['removed_date' => Carbon::now()]);
            return ["status" => true, "message" => "Update successful profile page: " . $input["profile_title"]];
        }

    }
}

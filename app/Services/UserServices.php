<?php
namespace App\Services;

use App\Enum\RoleEnum;
use App\Models\ChangeEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Employment;
use App\Models\InviteUserRecord;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Services\BaseService;

class UserServices extends BaseService {  
    public function getUserInCompany (){
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $employee = $user->employments()->where('current_employment',1)->first();
        $deparment = $employee->deparment;
        if ($this->checkUserRole($user, RoleEnum::ROLE_COMPANY_ADMIN)) {
            $get_Employees = $deparment->employments()->where('current_employment',1)
                                   ->select('user_id')->get();
            foreach ($get_Employees as $list) {
                if ($id != $list->user_id) {
                    $arr_idUser[] = $list->user_id;
                }
            }
            if (isset($arr_idUser)) {
                $users = User::whereIn('id',$arr_idUser)->orderBy('created_at','desc')
                ->paginate(10);
                foreach ($users as $user) {
                    foreach($user->roles as $role) {
                        $role_name[] = $role['name'];
                    }
                    $user->employee = $user->employments()->where('current_employment',1)->first();
                    if (isset($role_name) && in_array(RoleEnum::ROLE_COMPANY_ADMIN, $role_name)) {
                        $user->is_companyAdmin = true;
                    } else {
                        $user->is_companyAdmin = false;
                    }
                }
                return $users;
            }
            return null;
        }
        return null;
    }
    public function getInforUser() {
        $user = Auth::user();
        if ($user) {
            $user->employee = $user->employments()->where('current_employment',1)->first();
            return $user;
        }
        return false;
    }
    public function updateProfile($user) {
        $current_user = Auth::user();
        $name = (!empty( $user['name'])) ? explode(" ", $user['name']) : '';
        if (isset($current_user)) {
            $check_update = User::where([
                'id' => $current_user->id
            ])->update([
                'first_name' => isset($name[0]) ? $name[0] : '',
                'last_name'  => !empty($name) ? $name[count($name) - 1] : '',
                'full_name'  => $user['name']
            ]);
            if ($check_update) {
                Employment::where([
                    'user_id' => $current_user->id,
                    'current_employment' => 1
                ])->update([
                    'job_title' =>  $user['job_title'],
                    'phone_number' =>  $user['phone_number'],
                    'linked_in'    => $user['linked_in']
                ]);
                return true;
            }
            return false;
        }
        return false;
    }

    public function updatePassword($password) {
        $current_user = Auth::user();
        if ($current_user) {
            $user = User::where('id', $current_user->id)->first();
            if ($user) {
                $checkpass = Hash::check($password['old_password'],$user->password);
                if ($checkpass) {
                    User::where([
                        'id' => $current_user->id
                    ])->update([
                        'password' =>Hash::make($password['password'])
                    ]);
                  return true;
                } else {
                    throw new \Exception('Input Old Password Fail');
                }
            }
            throw new \Exception('Update Failed');
        }
        return false;
    }

    public function setCodeVerify($email) {
        $current_user = Auth::user();
        if (isset($current_user)) {
            $user = User::where([
                'id'        => $current_user->id,
                'user_name' => $email
                ])->first(); 
            if (!$user) {
                $fourdigitrandom = rand(1000,9999); 
                $arr_user['code']= $fourdigitrandom;
                $arr_user['email'] = $email;
                $checksendMail = $this->sendMailCodeVerify($arr_user);
                if ($checksendMail) {
                    ChangeEmail::updateOrCreate(
                        [
                        'user_id'     => $current_user->id,
                        'new_email'   => $email,
                        ],
                        ['code_verify' => $fourdigitrandom]
                    );
                    return true;
                } else {
                    throw new \Exception('SendMail failed');
                }
            }
            throw new \Exception('Email already exists');
        }
    }

    public function updateChangeEmail($email, $code) {
        $current_user = Auth::user();
        if (isset($current_user)) {
            $user = ChangeEmail::where([
                    'user_id'      => $current_user->id,
                    'new_email'    => $email,
                    'code_verify'  => $code
                ])->first();
            if ($user) {
                User::where([
                    'id'        => $current_user->id,
                    'user_name' => $current_user->user_name,
                ])->update([
                    'user_name'   => $email
                ]);
                $user->update([
                    'code_verify' => NULL
                ]);
                return true;
            }
            return false;
        }
        return false;
    }

    public function getInforCompany() {
        $current_user = Auth::user();
        if (isset($current_user)) {
            $employee = Employment::where([
                                'user_id' => $current_user->id,
                                'current_employment' => 1
                            ])->first();
            $deparment = $employee->deparment;
            $company = $deparment->company;
            $name_record = $company->nameRecords()->where('is_active', 1)
                                   ->whereNull('removed_date')->select('name')->first();
            $address  = $company->addressRecords()->where('is_active', 1)
                                ->select('line1','post_code', 'city','country','type')->orderby('type','asc')->get();
            $info_company =  [
                'name'         => $name_record->name,
                'registration_number' => $company->registration_number,
                'email'        => $company->email,
                'phone_number' => $company->phone_number,
                'linked_in'    => $company->linked_in,
                'website'      => $company->website,
                'address'      => $address,
                'tags'         => $company->tags
            ];
            return $info_company;
        }
    }
    public function sendMailCodeVerify($user) {
        Mail::send('mail.mail_code_verify', $user, function($message) use ($user) {
            $message->to($user['email'], 'Public Insight 1')
            ->subject('Change Email Code Verify');
            $message->from('publicinsight.brs@gmail.com', 'Public Insight');
            });
        if ( count(Mail::failures()) > 0 ) {
            return false;
        } else {
            return true;
        }
    } 
    public function getEmailByToken ($token) {
        $record = InviteUserRecord::where('token', $token)->first();
        return $record ? $record->email : null;
    }
    public function departmentInviteUser ($email, $role) {
        $id = Auth::user()->id;
        $employee = Employment::where('user_id', $id)->first();
        $deparment = $employee->deparment;
        $info_user = User::where([
            'user_name'    => $email
        ])->first();

        if ($info_user) {
            $employee_dapartment = $info_user->employments()->where('current_employment', 1)
                                ->select('department_id')->get();
            foreach ($employee_dapartment as $empl) {
                $arr_department[] = $empl->department_id;
            }
            if (isset($arr_department) && in_array($deparment->id, $arr_department)) {
                return false;
            } else {
                if ($role == \App\Enum\RoleEnum::ROLE_COMPANY_ADMIN) {
                    $user = InviteUserRecord::updateOrCreate(
                        ['email' => $email, 'user_id' => Auth::user()->id],
                        [
                            'token'   => $this->setToken(),
                            'expired' => 1,
                            'role_name' => $role,
                            'department_id' => $deparment->id
                        ]);
                } else {
                    $user = InviteUserRecord::updateOrCreate(
                        ['email' => $email, 'user_id' => Auth::user()->id],
                        [
                            'token'   => $this->setToken(),
                            'expired' => 1,
                            'role_name' => $role
                        ]);
                }
                $user->activation_link = route('user.invite.request', $user->token);
                return $this->sendMailInviteUser($user->toArray());
            }
        } else {
            if ($role == \App\Enum\RoleEnum::ROLE_COMPANY_ADMIN) {
                $user = InviteUserRecord::updateOrCreate(
                    ['email' => $email, 'user_id' => Auth::user()->id],
                    [
                    'token'   => $this->setToken(),
                    'expired' => 1,
                    'role_name' => $role,
                    'department_id' => $deparment->id
                    ]);
            } else {
                $user = InviteUserRecord::updateOrCreate(
                    ['email' => $email, 'user_id' => Auth::user()->id],
                    [
                    'token'   => $this->setToken(),
                    'expired' => 1,
                    'role_name' => $role
                    ]);
            }
            $user->activation_link = route('user.invite.request', $user->token);
            return $this->sendMailInviteUser($user->toArray());
        }
    }
    public function inActiveUser($user_id) {
        $current_user = Auth::user();
        if ($this->checkUserRole($current_user,RoleEnum::ROLE_COMPANY_ADMIN)) {
             $user = User::whereIn('id', $user_id)->get();
            if ($user) {
                User::whereIn('id', $user_id)->update(['user_active' => 0]);
                return true;
            }
        } else {
            return false;
        }
    }

    public function showDeleteUser() {
        $current_user = Auth::user();
        if ($this->checkUserRole($current_user,RoleEnum::ROLE_COMPANY_ADMIN)) {
            $employ = $current_user->employments()->where('current_employment',1)->first();
            $deparment = $employ->deparment;
            $employees = $deparment->employments;
            foreach ($employees as $empl) {
                $arr_user[] = $empl->user_id;
            }
            if (isset($arr_user)) {
                $deleteUser = User::onlyTrashed()->whereIn('id',$arr_user)
                                ->orderBy('created_at', 'desc')->paginate(10);
                return $deleteUser;
            }
            return false;
       } else {
           return false;
       }
    }

    public function RemoveRoleCompanyAdmin($user_id) {
        $current_user = Auth::user();
        if ($this->checkUserRole($current_user,RoleEnum::ROLE_ADMIN) || $this->checkUserRole($current_user,RoleEnum::ROLE_COMPANY_ADMIN)) {
            $user = User::findOrFail($user_id);
            if ($user) {
                $count_role = UserRole::where([
                    'user_id' => $user->id,
                ])->count();
                if ($count_role == 1) {
                    $role = Role::where('name',RoleEnum::ROLE_USER)->first();
                    $role_user = UserRole::where([
                        'user_id' => $user_id,
                    ])->update([
                        'role_id' => $role->id
                    ]);
                    return true;
                } else {
                    $role = Role::where('name',RoleEnum::ROLE_COMPANY_ADMIN)->first();
                    $role_user = UserRole::where([
                        'user_id' => $user_id,
                        'role_id' => $role->id
                    ])->delete();
                    return true;
                }
            }
            return false;
        } else {
            return false;
        }
    }
    public function MakeRoleCompanyAdmin($user_id) {
        $current_user = Auth::user();
        if ($this->checkUserRole($current_user,RoleEnum::ROLE_ADMIN) || $this->checkUserRole($current_user,RoleEnum::ROLE_COMPANY_ADMIN)) {
            $user = User::findOrFail($user_id);
            if ($user) {
                $role = Role::where('name',RoleEnum::ROLE_COMPANY_ADMIN)->first();
                $role_user = UserRole::create([
                    'id' => $this->quickRandom(),
                    'user_id' => $user_id,
                    'role_id' => $role->id
                ]);
                if ($role_user) {
                    return true;
                }
                return false;
            }
            return false;
        } else {
            return false;
        }
    }

    public function ActiveUser($user_id) {
        $current_user = Auth::user();
        if ($this->checkUserRole($current_user,RoleEnum::ROLE_COMPANY_ADMIN)) {
            $user = User::whereIn('id', $user_id)->get();
            if ($user) {
                User::whereIn('id', $user_id)->update(['user_active' => 1]);
                return true;
            }
        } else {
            return false;
        }
    }
    public function setToken() {
        $token = Str::random(60);
        return hash('sha256', $token);
    }
    public function sendMailInviteUser($user) {
        Mail::send('mail.mail_invite_user', $user, function($message) use ($user) {
            $message->to($user['email'], 'Public Insight 1')
            ->subject('Active Account ');
            $message->from('publicinsight.brs@gmail.com', 'Public Insight');
            });
        if (count(Mail::failures()) > 0) {
            return false;
        }
        return true;
    }
    public function inviteUser ($input) {
        
        $record = InviteUserRecord::where([
            'token' => $input['token']])->first();
        if(!$record || $this->checkTokenExpired($record)) {
            return ["status" => false, "message" => "Invalid token."];
        }

        $user_name = $record->email;
        $admin_user = $record->admin;
        $department = $record->department;
        
        $employment = Employment::where(['user_id' => $admin_user->id])->first(); 
        
        $user = User::create([
            'id' => $this->quickRandom(),
            'user_name' => $user_name,
            'password'   => Hash::make($input['password']),
            'full_name'  => isset($input['full_name']) ? $input['full_name'] : '',
            'user_token' => $this->setToken(),
            'user_active' => true,
            'is_verified' => true
        ]);
        
        if($user) {
            $userRole = Role::where(['name' => RoleEnum::ROLE_USER])->first();
            if($department) {
                $company_admin_role = Role::where(['name' => RoleEnum::ROLE_COMPANY_ADMIN])->first();
            } 
            $new_employment = Employment::create([
                'id'                            => $this->quickRandom(),
                'department_id'                 => $department ? $department->id : $employment->department_id,
                'user_id'                       => $user->id,
                'job_title'                     => '',
                'job_description'               => '',
                'work_email'                    => $user_name,
                'work_phone'                    => '',
                'public_procurement_experience' => 0,
                'office_address'                => '',
                'current_employment'            => true,
                'start_date'                    => Carbon::now(),
                'phone_number'                  => '',
                'linked_in'                     => '',
            ]);
            if($userRole) {
                UserRole::create([
                    'id' => $this->quickRandom(),
                    'user_id' => $user->id,
                    'role_id' => isset($company_admin_role) ? $company_admin_role->id : $userRole->id
                ]);
            }
            
            if(isset($new_employment)) {
                return ["status" => true, "message" => 'Invite successful user: ' . $user_name, "user" => $user];
            }
            
        }
        return ["status" => false, "message" => "Do not invite user."];
    }

    public function checkTokenExpired($invite_user_record) {
        return strtotime($invite_user_record->created_at) + 60 * 60 * $invite_user_record->expired < time();
    }
    public function deleteSoftUser($UserId) {
        $user = User::find($UserId)->first();
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
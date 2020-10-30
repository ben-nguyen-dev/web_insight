<?php
namespace App\Services;

use App\Enum\AddressEnum;
use App\Enum\RoleEnum;
use App\Models\AddressRecord;
use App\Models\User;
use App\Models\Tag;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employment;
use App\Models\UserRole;
use App\Models\ConfirmEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\NameRecord;
use App\Models\Role;
use App\Models\CompanyTag;
use DB;

class RegistrationService extends BaseService{
    
    public function createEmployee($input) {
        DB::beginTransaction();
        try {
            $name = (!empty( $input['full_name'])) ? explode(" ", $input['full_name']) : '';
            $checkCompanyExists = $this->checkCompanyExists($input);
            $userRole = Role::where(['name' => RoleEnum::ROLE_USER])->first();
            $companyAdminRole = Role::where(['name' => RoleEnum::ROLE_COMPANY_ADMIN])->first();
            
            if(!$checkCompanyExists) {
                $company = Company::create([
                    'id'                  => $this->quickRandom(),
                    'type'                => '',
                    'registration_number' => isset($input['company_number']) ? $input['company_number'] : '',
                    'email'               => isset($input['company_email']) && is_string($input['company_email']) ? $input['company_email'] : '',
                    'phone_number'        => isset($input['company_phone_number']) ? $input['company_phone_number'] : '',
                    'linked_in'           => isset($input['company_linked_in']) ? $input['company_linked_in'] : '',
                    'website'             => isset($input['company_website']) ? $input['company_website'] : '',
                ]);
                if($company) {
                    $department_name = 'general department';
                    $department = Department::create([
                        'id' => $this->quickRandom(),
                        'name' => $department_name,
                        'company_id' => $company->id,
                        'default_department' => true
                    ]);
                }
            } 

            $user = User::create([
                'id'         => $this->quickRandom(),
                'user_name'  => $input['email'],
                'password'   => Hash::make($input['password']),
                'first_name' => isset($name[0]) ? $name[0] : '',
                'last_name'  => !empty($name) ? $name[count($name) - 1] : '',
                'full_name'  => isset($input['full_name']) ? $input['full_name'] : '',
                'avatar'     => isset($input['avatar']) ? $input['avatar'] : NULL,
                'user_token' => $this->getToken(),
                'is_verified'=> false
            ]);         

            UserRole::create([
                'id' => $this->quickRandom(),
                'user_id' => $user->id,
                'role_id' => $checkCompanyExists ? $userRole->id : $companyAdminRole->id
            ]);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return false;
        }
        
        $department_id = $department ? $department->id : $this->getDefaultDepartment($checkCompanyExists);

        $employment = Employment::create([
            'id'                            => $this->quickRandom(),
            'department_id'                 => $department_id,
            'user_id'                       => $user->id,
            'job_title'                     => isset($input['title']) ? $input['title'] : '',
            'job_description'               => isset($input['description']) ? $input['description'] : '',
            'work_email'                    => isset($input['email']) ? $input['email'] : '',
            'work_phone'                    => isset($input['phone_number']) ? $input['phone_number'] : '',
            'public_procurement_experience' => isset($input['procurement_experience']) ? (int) $input['procurement_experience'] : 0,
            'office_address'                => isset($input['office_address']) ? $input['office_address'] : '',
            'current_employment'            => isset($input['current_employment']) ? (boolean)$input['current_employment'] : true,
            'start_date'                    => Carbon::now(),
            'phone_number'                  => isset($input['phone_number']) ? $input['phone_number'] : '',
            'linked_in'                     => isset($input['linked_in']) ? $input['linked_in'] : '',
        ]);
        if (!empty($input['tags'])) {
            foreach ($input['tags'] as $tag) {
                $tag = Tag::where(['name' => $tag, 'removed_date' => null])->select('id')->first();
                if($tag) {
                    CompanyTag::create([
                        'id' => $this->quickRandom(),
                        'company_id' => $company->id,
                        'tag_id' => $tag->id
                    ]);
                }
            }
        }
        $confirm_email = ConfirmEmail::where([
            'email'        => $input['email'],
        ])->first();

        if ($confirm_email) {
            ConfirmEmail::where([
                'email'        => $input['email'],
            ])->delete();
        }
        if(isset($company)) {
            $name_record = NameRecord::create([
                'id'                  => $this->quickRandom(),
                'company_id'          => $company->id,
                'name'                => isset($input['company_name']) ? $input['company_name'] : '',
                'added_date'          => Carbon::now(),
                'is_active'           => true,
            ]);
            $address_record = AddressRecord::create([
                'id'                  => $this->quickRandom(),
                'company_id'          => $company->id,
                'line1'               => isset($input['company_address']) ? $input['company_address'] : '',
                'line2'               => '',
                'city'                => isset($input['company_postoffice']) ? $input['company_postoffice'] : '',
                'post_code'           => isset($input['company_postnumber']) ? $input['company_postnumber'] : '',
                'country'             => isset($input['company_country']) ? $input['company_country'] : '',
                'type'                => AddressEnum::OFFICE_ADDRESS,
                'is_active'           => true,
            ]);
            $this->sendMailToSale($user, $company, $name_record);
        }

        $user->activation_link = route('user.activate', $user->user_token);
        
        return $user;
    }
    public function checkUser($token) {
        $user = User::where([
            'user_token'  => $token,
        ])->select('user_name','user_token','expires','created_at')->first();
        return $user;
    }
    public function getUserToken($token) {
        $user = $this->checkUser($token);
        if ($user && $this->checkExpires($user)) {
            User::where([
                'user_token'  => $token,
                'user_active' => 0
            ])->update([
                'user_active' => 1
            ]);
            return $user;
        }
    }
    public function sendMail ($user) {
        Mail::send('mail.mail_active_user', $user, function($message) use ($user) {
            $message->to($user['user_name'], 'Public Insight 1')
            ->subject('Active Account ');
            $message->from('publicinsight.brs@gmail.com', 'Public Insight');
            });
    }
    public function checkExpires($user) {
        return strtotime($user->created_at) + 60 * $user->expires > time();
    }


    public function regenerateToken($user) {
        $token = $this->getToken();
        User::where([
            'user_token'  => $user->user_token,
            'user_active' => 0
        ])->update([
                'user_token' => $token,
                'created_at' => Carbon::now(),
            ]);
        return $token;
    }


    public function checkCompanyExists ($input) {
        if(isset($input['company_number'])) {
            $company = Company::where(['registration_number' => $input['company_number']])->first();
            if ($company) return $company->id;
        }
        if(isset($input['company_name'])) {
            $company = NameRecord::where(['name' => $input['company_name']])->first();
            if ($company) return $company->company_id;
        } 
        return null;
    }
    
    public function checkEmailExists ($input) {
        $user = User::where(['user_name' => $input['email']])->first();
        if($user) {
            return ["status" => true, "message" => "Email is existed."];
        } else {
            $fourdigitrandom = rand(1000,9999); 
            $arr_user['code']= $fourdigitrandom;
            $arr_user['email'] = $input['email'];
            $checksendMail = $this->sendMailCodeVerify($arr_user);
            if ($checksendMail) {
                ConfirmEmail::updateOrCreate(
                    [
                    'email'   => $input['email']
                    ],
                    ['code_verify' => $fourdigitrandom]
                );
                return [
                    "status" => false,
                ];
            } else {
              return [
                  "status" => true,
                ];
            }
        }
    }

    public function checkVerificationCode($email, $code){
        $user = ConfirmEmail::where([
            'email'        => $email,
            'code_verify'  => $code
        ])->first();
        if ($user) {
            return true;
        }
        return false;
    }
    public function sendMailCodeVerify($user) {
        Mail::send('mail.mail_code_verify', $user, function($message) use ($user) {
            $message->to($user['email'], 'Public Insight 1')
            ->subject(' Email Verification Code');
            $message->from('publicinsight.brs@gmail.com', 'Public Insight');
            });
        if ( count(Mail::failures()) > 0 ) {
            return false;
        } else {
            return true;
        }
    } 
    public function checkPrivateEmail ($email) {
        $private_domain = ['gmail.com', 'outlook.com', 'yahoo.com'];
        $parts = explode('@', $email);
        $domain = array_pop($parts);
        if(in_array($domain, $private_domain)) {
            return true;
        }
        return false;
    }

    public function sendMailToSale ($user, $company, $name_record) {
        $emails = env('SALE_EMAILS');
        $email_array = [];
        if($emails) {
            $email_array = explode(";", $emails);
        }
        if(!$email_array) {
            $email_array = 'uri.brightsoft@gmail.com';
        }
        $data = [
            'user_name' => $user->full_name,
            'email' => $user->user_name,
            'company_number' => $company->registration_number,
            'company_name' => $name_record->name
        ];
        Mail::send('mail.check_user_verify', $data, function($message) use ($email_array) {
            $message->to($email_array)
            ->subject('Verify admin for company');
            $message->from('publicinsight.brs@gmail.com', 'Public Insight');
        });
        if (Mail::failures()) {
            return ["status" => false, "message" => "Do not send mail to sale."];
        }
    }

    public function updateVerifiedForCompanyAdmin ($email) {
        $user = User::where(['user_name' => $email])->first();
        if($user) {
            $is_verified = $user->is_verifed;
            User::where(['user_name' => $email])->update(['is_verified' => !$is_verified]);
        }
    }

    public function getDefaultDepartment ($company_id) {
        $department = Department::where([
            'company_id' => $company_id,
            'default_department' => true
        ])->first();
        return $department ? $department->id : null;
    }
    
    
}
<?php
namespace App\Services;

use App\Enum\AddressEnum;
use App\Models\AddressRecord;
use App\Models\DomainRecord;
use App\Models\Employment;
use App\Models\NameRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Enum\RoleEnum;
use App\Models\ElectronicInvoice;
use App\Models\Tag;
use App\Models\CompanyTag;
use App\Services\BaseService;

class CompanyService extends BaseService {

    public function getCompany() {
        $id = Auth::user()->id;
        $employee = Employment::where(['user_id'=> $id, 'current_employment' => 1])->first();
        $deparment = $employee->deparment;
        $company = $deparment->company;
        $name_record = $company->nameRecords()->where('is_active', 1)
                               ->whereNull('removed_date')->select('name')->first();
        $domain_record = $company->domainRecords()->where('is_active', 1)
                                 ->whereNull('removed_date')->select('name')->get();
        $sni_code = $company->SniRecords()->where('is_active', 1)
                            ->whereNull('removed_date')->select('sni')->get();
        $cpv_code = $company->CpvRecords()->where('is_active', 1)
                            ->whereNull('removed_date')->select('cpv')->get();
        $address  = $company->addressRecords()->where(['is_active' => 1])
                            ->select('line1', 'post_code', 'city', 'country', 'type')->get();
        $e_invoice = $company->electronicInvoices()->where('is_active', 1)
                            ->whereNull('removed_date')->first();
        
        $tags = $company->tags;
        $office_address = $address->where('type', AddressEnum::OFFICE_ADDRESS)->first();
        $invoice_address = $address->where('type', AddressEnum::INVOICE_ADDRESS)->first();
        $visiting_address = $address->where('type', AddressEnum::VISITING_ADDRESS)->first();
        
        $info_company = [
            'name'              => $name_record->name,
            'domains'           => $domain_record,
            'cpv_code'          => $cpv_code,
            'sni_code'          => $sni_code,
            'office_address'    => $office_address,
            'invoice_address'   => $invoice_address,
            'visiting_address'  => $visiting_address,
            'email'             => $company->email,
            'website'           => $company->website,
            'phone_number'      => $company->phone_number,
            'linked_in'         => $company->linked_in,
            'e_invoice'         => $e_invoice ? $e_invoice->e_invoice : '',
            'tags'              => $tags
        ];
        if($e_invoice) {
            $check_e_invoice = $e_invoice->e_invoice == $company->email ? true : false;
            $info_company['check_e_invoice'] = $check_e_invoice;
        }
        if($invoice_address) {
            $check_invoice_address = $this->checkSameAddress ($office_address, $invoice_address);
            $info_company['check_invoice'] = $check_invoice_address;
        }
        if($visiting_address) {
            $check_visiting_address = $this->checkSameAddress ($office_address, $visiting_address);
            $info_company['check_visiting'] = $check_visiting_address;
        }
        return $info_company;
    }


    public function updateCompany($input) {
        
        $user = Auth::user();
        $employee = Employment::where('user_id', $user->id)->first();
        $deparment = $employee->deparment;
        $company = $deparment->company;
        $company_id = $company->id;
        if ($this->checkRoleCompanyAdmin($user)) {
            $domain_list = $input['domain_list'];
            $website = $input['website'];
            $email = $input['email'];
            $check_e_invoice = isset($input['check_e_invoice']) ? $input['check_e_invoice'] : false;
            $e_invoice = $input['e_invoice'];
            $phone_number = $input['phone_number'];
            $linked_in = $input['linked_in'];
            $tag_list = $input['tag_list'];
            $checkbox_invoice_address = isset($input['checkbox_invoice_address']) ? $input['checkbox_invoice_address'] : false;
            $checkbox_visiting_address = isset($input['checkbox_visiting_address']) ? $input['checkbox_visiting_address'] : false;
            $address = $input['address'];
            
            if (!empty($email)) {
                $company->update([
                    'email' => $email
                ]);
            }
            if (!empty($phone_number)) {
                $company->update([
                    'phone_number' => $phone_number
                ]);
            }
            if (!empty($linked_in)) {
                $company->update([
                    'linked_in' => $linked_in
                ]);
            }
            if (!empty($website)) {
                $company->update([
                    'website' => $website
                ]);
            }
            if(isset($domain_list)) {
                $domains = explode(',', $domain_list);
            }
            if (isset($domains) && count($domains) > 0) {
                $arr_domain = [];
                foreach ($domains as $value) {
                    if (isset($value)) {
                        array_push($arr_domain, $value);
                        $check_domain = DomainRecord::where([
                                                    'company_id' => $company_id,
                                                    'name' => $value
                                                ])->first();
                        if (!$check_domain) {
                            DomainRecord::create([
                                'id'         => $this->quickRandom(),
                                'company_id' => $company_id,
                                'name'       => $value,
                                'added_date' => Carbon::now(),
                                'is_active'  => 1,
                            ]);
                        }
                    }
                }
                DomainRecord::whereNotIn('name', $arr_domain)->delete();
            }
            $elect_invoice = $company->electronicInvoices()->where([
                'e_invoice'  => isset($check_e_invoice) && 'on' == $check_e_invoice ? $email : $e_invoice,
            ])->select('id')->first();
            if($elect_invoice) {
                $elect_invoice->update(['is_active' => 1]);
            } else {
                $elect_invoice = ElectronicInvoice::create([
                    'id'         => $this->quickRandom(),
                    'company_id' => $company_id,
                    'e_invoice'  => isset($check_e_invoice) && 'on' == $check_e_invoice ? $email : $e_invoice,
                    'added_date' => Carbon::now(),
                    'is_active'  => 1,
                ]);
            }
            $company->electronicInvoices()->where('id', '!=' , $elect_invoice->id)->update([
                'is_active' => 0
            ]);

            if(isset($tag_list)) {
                $tags = explode(',', $tag_list);
            }
            if(isset($tags) && count($tags) > 0) {
                $arr_tag = [];
                foreach ($tags as $tag) {
                    $get_tag = Tag::where(['name' => $tag, 'removed_date' => null])->first();
                    $company_tag = CompanyTag::where(['company_id' => $company_id, 'tag_id' => $get_tag->id])->first();
                    if(!$company_tag) {
                        $company_tag = CompanyTag::create([
                            'id' => $this->quickRandom(),
                            'tag_id' => $get_tag->id,
                            'company_id' => $company_id,
                        ]);
                    }
                    array_push($arr_tag, $company_tag->id);
                }
                CompanyTag::whereNotIn('id', $arr_tag)->delete();
            }
            if (isset($address) && count($address) > 0) {
                $arr_address = [];
                $officeAddress = $company->addressRecords()->where([
                    'type' => AddressEnum::OFFICE_ADDRESS, 'is_active' => 1
                    ])->first();
                array_push($arr_address, $officeAddress->id);
                foreach ($address as $key => $value) {
                    $check_use_office = 'invoice' == $key ? (boolean) $checkbox_invoice_address : (boolean) $checkbox_visiting_address;
                    if (!$check_use_office && !isset($value['line1']) && !isset($value['post_code']) && !isset($value['city']) && !isset($value['country'])) {
                        continue;
                    }
                    $info_add = [
                        'company_id' => $company_id, 
                        'line1' => $check_use_office ? $officeAddress->line1 : $value['line1'],
                        'post_code' => $check_use_office ? $officeAddress->post_code : $value['post_code'],
                        'city'  =>  $check_use_office ? $officeAddress->city : $value['city'],
                        'country' => $check_use_office ? $officeAddress->country : $value['country'],
                        'type' => $key
                    ];
                    $check_address = AddressRecord::where($info_add)->select('id')->first();
                    if ($check_address) {
                        $check_address->update(['is_active'=> 1]);
                        array_push($arr_address, $check_address->id);
                    } else {
                        $id_addRecord = AddressRecord::create([
                            'id'         => $this->quickRandom(),
                            'company_id' => $company_id,
                            'line1'      => $info_add['line1'],
                            'line2'      => '',
                            'post_code'  => $info_add['post_code'],
                            'city'       => $info_add['city'],
                            'country'    => $info_add['country'],
                            'is_active'  => 1,
                            'type'       => $key
                        ]);
                        array_push($arr_address, $id_addRecord->id);
                    }
                }
                
                $company->addressRecords()->whereNotIn('id', $arr_address)->update([
                    'is_active' => 0
                ]);
            }
        } else {
            throw new \Exception('Update failed. You dont have permission !');
        }
    }

    public function getNameOld() {
        $id = Auth::user()->id;
        $employee = Employment::where('user_id', $id)->first();
        $deparment = $employee->deparment;
        $company = $deparment->company;
        $name_record = $company->nameRecords()->where('is_active', 0)
                                        ->whereNotNull('removed_date')
                                        ->select('name')->get();
        return $name_record;
    }
    
    public function updateNameCompany($name) {
        $id = Auth::user()->id;
        $employee = Employment::where('user_id', $id)->first();
        $deparment = $employee->deparment;
        $company_id = $deparment->company->id;
        if (!empty($name)) {
            $checkname =  NameRecord::where([
                            'company_id' => $company_id,
                            'name'       => $name,
                        ])->first();
            if ($checkname) {
                $updateinActive = $checkname->update([
                    'removed_date' => NULL,
                    'is_active'  => 1
                ]);
                if ($updateinActive) {
                    NameRecord::where('company_id', $company_id)
                                ->where('id', '<>' , $checkname->id)
                                ->update([
                                    'removed_date' => Carbon::now(),
                                    'is_active'  => 0
                                ]);
                }
            } else {
                $updateinActive = NameRecord::where([
                    'company_id' => $company_id,
                    'is_active'  => 1
                ])->update([
                    'removed_date' => Carbon::now(),
                    'is_active'  => 0
                ]);
                if ($updateinActive) {
                    NameRecord::create([
                        'id'         => $this->quickRandom(), 
                        'company_id' => $company_id,
                        'name'       => $name,
                        'added_date' => Carbon::now(),
                        'is_active'  => 1,
                    ]);
                }
            }
            return true;
        }
        return false;
    }

    public function checkRoleCompanyAdmin($user) {
        $roles = $user->roles;
        foreach ($roles as $role) {
            $role_name[] = $role->name;
        }
        if (in_array(RoleEnum::ROLE_COMPANY_ADMIN, $role_name)) {
            return true;
        }
        return false;
    }
}
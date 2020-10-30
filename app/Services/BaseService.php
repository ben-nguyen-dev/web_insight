<?php
namespace App\Services;

use App\Enum\RoleEnum;
use App\Models\Tag;
use SoapClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BaseService {

    public function quickRandom()
    {
        return md5(uniqid(rand(), true));
    }

    public function checkUserRole ($user, $user_role) {
        if($user) {
            $roles = [];
            foreach ($user->roles as $role) {
                array_push($roles, $role->name);
            }
            if(in_array($user_role, $roles)) {
                return true;
            }
        }
        return false;
    }

    public function getTags() {
        return Tag::where(['removed_date' => null])->select('id','name')->get();
    }


    public function checkSameAddress ($office_address, $address) {
        if($office_address && $address) {
            if($office_address->line1 == $address->line1 && $office_address->post_code == $address->post_code &&
            $office_address->city == $address->city && $office_address->country == $address->country) {
                return true;
            }
        }
        return false;
    }

    public function getCompaniesData ($input) {
        $company_number = $input['company_number'];
        
        $wsdl = "https://webservice.creditsafe.se/getdata/getdata.asmx?WSDL";
        $client = new SoapClient($wsdl, array(
            'soap_version' => SOAP_1_2,
            'trace' => true, 
            'exceptions' => 1
        ));

        $params = [
            'GetData_Request' => [
                'account' => [
                    'UserName' => 'CHECKTESTIN', 
                    'Password' => 'KwiW8SY3y', 
                    'TransactionId' => '', 
                    'Language' => 'SWE'
                ],
                'Block_Name' => 'DC_MARKET', 
                'SearchNumber' => $company_number,
                'FormattedOutput' => '1', 
                'LODCustFreeText' => '',
                'Mobile' => '',
                'Email' => ''
            ]
        ];
        $result = $client->__soapCall('GetDataBySecure', array('parameters' => $params));
        
        $data = $result->GetDataBySecureResult;
        if(isset($data->Error)) {
            $error = $data->Error;
            return ["status" => false, "code_error" => $error->Cause_of_Reject, "message" => $error->Reject_text];
        }

        $data_xml = $data->Parameters->any;
        $data_string = simplexml_load_string($data_xml);
        $response = $data_string->NewDataSet->GETDATA_RESPONSE;
        
        return ["status" => true, "data" => $response];
    }

    public function getToken() {
        $token = Str::random(60);
        return hash('sha256', $token);
    }

    public function getCurrentUser () {
        return Auth::user();
    }
}
<?php 

namespace App\Http\Controllers\Api;
use App\Models\Company;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

class CompanyApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function createCompany(Request $request) {

        $input = $request->all();
        $validationRule = [
            "name"      => "required",
            "sni_codes" => "required",
            "cpv_codes" => "required",

        ];
        $validator = Validator::make($input, $validationRule);

        if ($validator->fails()) {
            $response = [ "status" => false, "error" => $validator->errors()->all()];
        } else {
            $compony = Company::create([
                "type"                => isset($input['type']) ? $input['type'] : '',
                'name'                => $input['name'],
                'registration_number' => isset($input['registration_number']) ? $input['registration_number'] : NULl,
                'sni_codes'           => $input['sni_codes'],
                'cpv_codes'           => $input['cpv_codes'],
                'address'             => isset($input['address']) ? $input['address'] : NULL
            ]);
            $response = [ "status" => true, "data" => $compony];
        }

        return response()->json($response);
        
    }
}
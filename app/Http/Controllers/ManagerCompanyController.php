<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Employment;
use App\Models\NameRecord;
use App\Models\DomainRecord;
use App\Services\CompanyService;
use Exception;
class ManagerCompanyController extends Controller {

    protected $company_service;
    public function __construct(CompanyService $company_service)
    {
        // $this->middleware('auth');
        $this->company_service = $company_service;
    }

    public function getInfoCompanies(Request $request) {
        $info_company = $this->company_service->getCompany();
        $tags = $this->company_service->getTags();
        return view('CompanyAdmin.manager_company')->with(['info_company' => $info_company, 'tags' => $tags]);
    }

    public function updateInfoCompanies(Request $request) {
        $input = $request->all();
        $request->validate([
            'phone_number' => 'required|min:8',
            'linked_in'    => 'required|url'
        ]);
        try {
            $this->company_service->updateCompany($input);
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('manager.companies')->with('success','Update success');
    }

    public function getNameCompanyOld(Request $request) {
        $list_name = $this->company_service->getNameOld();
        if ($list_name) {
            return response()->json([
                'status' => true,
                'list_name' => $list_name
            ]);
        }
        return response()->json([
            'status' => false,
        ]);
    }

    public function updateNameCompany(Request $request) {
        $name = $request->change_name;
        $updateName = $this->company_service->updateNameCompany($name);
        if ($updateName) {
            return response()->json([
                'status' => true,
                'name'   => $name
            ]);
        }
        return response()->json([
            'status' => false,
        ]);
    }

}
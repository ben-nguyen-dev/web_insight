@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('css/systemAdmin.css') }}">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
<link rel="stylesheet" href="{{ asset('css/companyAdmin.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('content')
<div class="row">
    @include('systemAdmin.menu')
    <div class="row col-10 justify-content-center right-content">
        <div class="col-md-11 company-departments" id="{{$company['id']}}">
            <input type="hidden" class="user-id" value="{{$user->id}}" />
            <h2 class="text-center">Company name: {{$company['company_name']}}<a href="{{route('company.refresh', $company['company_number'])}}" type="button" class="btn btn-refresh"><i class="fa fa-refresh" aria-hidden="true"></i></a></h2>

            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <h3 class="title">Company infomation</h3>
            <form>
                <div class="form-group row">
                    <label for="companyName" class="col-sm-3 col-form-label">Company name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="companyName" value="{{$company['company_name']}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="companyNumber" class="col-sm-3 col-form-label">Company number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="companyName" value="{{$company['company_number']}}" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="companySniCode" class="col-sm-3 col-form-label">SNI code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="companySniCode" value="{{$company['company_sni_code']}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="companyCpvCode" class="col-sm-3 col-form-label">CPV code</label>
                    <div class="col-sm-9 form-row">
                        <div class="col multiple-form-group input-group">
                            <input type="text" class="form-control" id="companyCpvCode" value="{{$company['company_cpv_code']}}">
                            <input name="cpv_code" class="form-control" type="hidden">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-update-cpv"><i class="fa fa-save"></i></button>
                            </span>
                            </span>
                        </div>
                        <div class="col" style="margin-right:-10px;">
                            <input type="text" class="form-control" placeholder="Auto map CPV code" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group row list-tags">
                    <label for="companyDomains" class="col-sm-3 col-form-label">Domains</label>
                    <div class="col-sm-9">
                        <ul>
                            @if(isset($company['company_domains']) && count($company['company_domains']) > 0)
                            @foreach ($company['company_domains'] as $domain)
                            <li data-html="{{ $domain->name }}"><span> {{ $domain->name }}</span></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="companyWebsite" class="col-sm-3 col-form-label">Website</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="companyWebsite" value="{{$company['company_website']}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="companyEmail" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="companyEmail" value="{{$company['company_email']}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="electronicInvoice" class="col-sm-3 col-form-label">Electronic invoice</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="electronicInvoice" value="{{$company['company_e_invoice']}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phoneNumber" class="col-sm-3 col-form-label">Phone number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="phoneNumber" value="{{$company['company_phone_number']}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="linkedIn" class="col-sm-3 col-form-label">Linked In</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="linkedIn" value="{{$company['company_linked_in']}}" disabled>
                    </div>
                </div>
                <div class="form-group row list-tags">
                    <label for="companyTags" class="col-sm-3 col-form-label">Tags</label>
                    <div class="col-sm-9">
                        <ul>
                            @if(isset($company['company_tags']) && count($company['company_tags']) > 0)
                            @foreach ($company['company_tags'] as $tag)
                            <li data-html="{{ $tag->name }}"><span> {{ $tag->name }}</span></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="companyAddress" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <div class="row address-form">
                            <label class="address-label">Offical address</label>
                            <div class="multiple-form-group input-group">
                                <div class="col-6">
                                    <div class="form-class">
                                        <label>Line 1</label>
                                        <input class="form-control" type="text" value="{{isset($company['office_address']) ? $company['office_address']->line1 : ''}}" style="margin-bottom: 20px;" disabled>
                                    </div>
                                    <div class="form-class">
                                        <label>Postcode</label>
                                        <input class="form-control" type="text" value="{{isset($company['office_address']) ? $company['office_address']->post_code : ''}}" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-class">
                                        <label>City</label>
                                        <input class="form-control" type="text" value="{{isset($company['office_address']) ? $company['office_address']->city : ''}}" style="margin-bottom: 20px;" disabled>
                                    </div>
                                    <div class="form-class">
                                        <label>Country</label>
                                        <input class="form-control" type="text" value="{{isset($company['office_address']) ? $company['office_address']->country : ''}}" style="margin-bottom: 20px;" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($company['second_address']))
                        <div class="row address-form">
                            <label class="address-label"><?php if ($company['second_address']->type == \App\Enum\AddressEnum::INVOICE_ADDRESS) echo 'Office';
                                                            else echo 'Visiting'; ?> address</label>
                            <div class="multiple-form-group input-group">
                                <div class="col-6">
                                    <div class="form-class">
                                        <label>Line 1</label>
                                        <input class="form-control" type="text" value="{{$company['second_address']->line1}}" style="margin-bottom: 20px;" disabled>
                                    </div>
                                    <div class="form-class">
                                        <label>Postcode</label>
                                        <input class="form-control" type="text" value="{{$company['second_address']->post_code}}" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-class">
                                        <label>City</label>
                                        <input class="form-control" type="text" value="{{$company['second_address']->city}}" style="margin-bottom: 20px;" disabled>
                                    </div>
                                    <div class="form-class">
                                        <label>Country</label>
                                        <input class="form-control" type="text" value="{{$company['second_address']->country}}" style="margin-bottom: 20px;" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="companyIsVerified" class="col-sm-3 col-form-label">Company is verified</label>
                    <div class="col-sm-9">
                        <input type="checkbox" class="verify-company companyIsVerified" id="{{$company['id']}}" <?php if ($company['company_is_verified']) echo 'checked'; ?>>
                    </div>
                </div>
                @include('modal')
            </form>

            <h3 class="title">Department list</h3>
            <ul class="nav nav-tabs" role="tablist">
                <?php $first = true; ?>
                @foreach($departments as $department)
                <li class="nav-item">
                    <a data-toggle="tab" role="tab" class="nav-link <?php if (isset($current_department) && $current_department == $department['department']->id || $first) echo 'active'; ?>" href="#department-{{ $department['department']->id }}">{{ $department['department']->name }}</a>
                </li>
                <?php $first = false; ?>
                @endforeach
                @if(!isset($company['company_is_consultant']) || (isset($company['company_is_consultant']) && !$company['company_is_consultant']))
                <li class="nav-item tab-create-department">
                    <a data-toggle="tab" role="tab" class="nav-link btn btn-link btn-create-department" href="#createDepartment">
                        <img width="16" src="{{ asset('/images/add-tab.png') }}">
                    </a>
                </li>
                @endif
            </ul>
            <div id="departmentTabContent" class="tab-content">
                @include('systemAdmin.user_list_department')
                @include('systemAdmin.create_department')
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
<script src='{{ asset('js/systemAdmin.js') }}'></script>
@endsection
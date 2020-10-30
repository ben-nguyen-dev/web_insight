@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" />
    <link rel="stylesheet" href="css/home.css">
@endsection
@section('content')
<div class="container">
        <div class="header-top">
            <div class="row line-bottom">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="my-account" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Mitt konto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Aktiva tjänster</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Alla tjänster</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Sparade ar</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-md-7 col-12 list-left">
                            <div class="account-title line-bottom">
                                <h4 class="name-bold">Hej Namn</h4>
                                <p>I ”mitt konto” kan du se och redigera dina beställningar, uppgifter och kontoinställningar.</p>
                            </div>
                            <div class="account-body line-bottom">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="name-title">
                                            <h4 class="name-bold">Namn:</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-6 col-12">
                                        <div class="value-title">
                                        <p>{{ isset($inforUser->full_name) ? $inforUser->full_name : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="name-title">
                                            <h4 class="name-bold">Yrkestitel:</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-6 col-12">
                                        <div class="value-title">
                                            <p>{{ isset($inforUser->employee->job_title) ? $inforUser->employee->job_title : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="name-title">
                                            <h4 class="name-bold">Telefonnummer:</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-6 col-12">
                                        <div class="value-title">
                                            <p>{{ isset($inforUser->employee->phone_number) ? $inforUser->employee->phone_number : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <h4 class="name-bold">Linkedinprofil:</h4>
                                    </div>
                                    <div class="col-lg-9 col-md-6 col-12">
                                        <div class="value-title">
                                            <p>{{ isset($inforUser->employee->linked_in) ? $inforUser->employee->linked_in : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="" class="link-text" data-toggle="modal" data-target="#edit-information">Redigera</a>
                            </div>
                            <div class="home-login line-bottom">
                                <div class="login-title">
                                    <h4 class="name-bold">Inloggningsuppgifter:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="name-title">
                                            <h4 class="name-bold">E-mailadress:</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-6 col-12">
                                        <div class="value-title">
                                            <p>{{ isset($inforUser->user_name) ? $inforUser->user_name : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="name-title">
                                            <h4 class="name-bold">Lösenord:</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <div class="value-title">
                                            <p class="gray"></p>
                                            <p class="gray"></p>
                                            <p class="gray"></p>
                                            <p class="gray"></p>
                                            <p class="gray"></p>
                                            <p class="gray"></p>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" class="link-text" data-toggle="modal" data-target="#edit-info-user">Redigera E-mail</a>
                                <a href="javascript:void(0)" class="link-text" data-toggle="modal" id ="open-change-password" style="margin-left: 20px;">Redigera Password</a>
                            </div>
                            <div class="info-company">
                                <h4 class="name-bold">Övriga användare från ditt företag</h4>
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    @if (!empty($departmentUser))
                                        @foreach($departmentUser as $key => $department)
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <div class="panel-title">
                                                    <div role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                                        <h4 class="name-bold">{{ $department->full_name }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse-{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <div class="list-info-company">
                                                            <p> {{ $department->user_name }}</p>
                                                            <p> Creative Director </p>
                                                            <p> {{ $department->employee->phone_number }} </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div><!-- panel-group -->
                                @if (\Auth::user()->isAdministrator(\App\Enum\RoleEnum::ROLE_COMPANY_ADMIN))  
                                    <a href="{{ route('manager.users') }}" class="link-text">Bjud in fler</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5 col-12 list-right">
                            <div class="content-right">
                                <h4 class="name-bold">Användaruppgifter</h4>
                                    <h4 class="name-bold">Företag: </h4>
                                    <div class="box-list">
                                        <ul id="list-company">
                                            <li>
                                            <p>{{ $inforCompany['name'] }}</p>
                                            </li>
                                            <li>
                                                <p>{{ $inforCompany['registration_number'] }}</p>
                                            </li>
                                            <li>
                                                <p>Reklam och marknadsföring</p>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6 col-12">
                                                        <div class="name-title">
                                                            <h5 class="name-bold">Registreringsår:</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-md-6 col-12">
                                                        <div class="value-title">
                                                            <p>2011</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6 col-12">
                                                        <div class="name-title">
                                                            <h5 class="name-bold">Årets resultat:</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-md-6 col-12">
                                                        <div class="value-title">
                                                            <p>3529 tkr</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6 col-12">
                                                        <div class="name-title">
                                                            <h5 class="name-bold">Företagsstatus:</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-md-6 col-12">
                                                        <div class="value-title">
                                                            <p>Godkänd <span class="round"></span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6 col-12">
                                                        <div class="name-title">
                                                            <h5 class="name-bold">Telefonnummer:</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-md-6 col-12">
                                                        <div class="value-title">
                                                        <p>{{ $inforCompany['phone_number'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6 col-12">
                                                        <div class="name-title">
                                                            <h5 class="name-bold">Company website:</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-md-6 col-12">
                                                        <div class="value-title">
                                                            <p>{{ $inforCompany['website'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6 col-12">
                                                        <div class="name-title">
                                                            <h5 class="name-bold">Email:</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-md-6 col-12">
                                                        <div class="value-title">
                                                            <p>{{ $inforCompany['email'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-6 col-12">
                                                        <div class="name-title">
                                                            <h5 class="name-bold">Linkedinprofil:</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 col-md-6 col-12">
                                                        <div class="value-title">
                                                            <p>{{ $inforCompany['linked_in'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <h5 class="name-bold">Taggar:</h5>
                                                <div class="list-tags">
                                                    <ul>
                                                        @foreach($inforCompany['tags'] as $tags)

                                                        <li>
                                                            <span>{{ $tags->name }}</span> 
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <h5 class="name-bold">Address:</h5>
                                               @foreach($inforCompany['address'] as $address)
                                                    @if($address->type == \App\Enum\AddressEnum::OFFICE_ADDRESS)
                                                        <div class="address-list">
                                                            <h6 class="name-bold">Official address</h6>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p>{{ $address->line1 }}</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p>{{ $address->city }}</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p>{{ $address->post_code }}</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p>{{ $address->country }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($address->type == \App\Enum\AddressEnum::VISITING_ADDRESS)
                                                    <div class="address-list">
                                                        <h6 class="name-bold">Second address</h6>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <p>{{ $address->line1 }}</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p>{{ $address->city }}</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p>{{ $address->post_code }}</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p>{{ $address->country }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                        <a href="javascript:void(0)" id="read-more" class="link-text">Läs mer</a>
                                    </div>
                                    @if (\Auth::user()->isAdministrator(\App\Enum\RoleEnum::ROLE_COMPANY_ADMIN))
                                        <a href="{{ route('manager.companies') }}" class="link-text float-right" style="margin-top : 20px;">Redigera</a>
                                    @endif
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="edit-information" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Edit Profile</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-edit-profile">
                            <div id="message-profile"></div>
                            <div class="form-group">
                            <label for="exampleInputEmail1">Namn <span class="star-required">*</span> </label>
                                <input type="text" class="form-control" name="name" placeholder="Ange ditt namn" required value="{{ isset($inforUser->full_name) ? $inforUser->full_name : '' }}">
                                <span id="error-name"></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Yrkestitel <span class="star-required">*</span></label>
                                <input type="text" class="form-control" name="job_title" placeholder="Ange ditt Yrkestitel" required value="{{ isset($inforUser->employee->job_title) ? $inforUser->employee->job_title : '' }}">
                                <span id="error-jobtitle"></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telefonnummer <span class="star-required">*</span></label>
                                <input type="text" class="form-control" name="phone_number" placeholder="Ange ditt Telefonnummer" maxlength="15" required value="{{ isset($inforUser->employee->phone_number) ? $inforUser->employee->phone_number : '' }}">
                                <span id="error-phone"></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Linkedinprofil <span class="star-required">*</span></label>
                                <input type="text" class="form-control" name="linked_in" placeholder="Ange ditt Linkedinprofil" required value="{{ isset($inforUser->employee->linked_in) ? $inforUser->employee->linked_in : '' }}">
                                <span id="error-link"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-save" id="edit-profile">Save</button>
                    </div>
                </div>
            </div>
        </div>
           <!-- Modal -->
        <div class="modal fade" id="edit-info-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Change Email</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-change-mail">
                            <div id="message-email"></div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">New Email <span class="star-required">*</span></label>
                                <input type="text" class="form-control" name="email" placeholder="Ange ditt Email" required >
                                <div id="error-email"></div>
                            </div>
                            <div class="form-group" id="code-verify" style="display: none;">
                                <label for="exampleInputEmail1">Verification Code <span class="star-required">*</span></label>
                                <input type="text" class="form-control" name="code" placeholder="Enter code" required >
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success btn-save" id="btn-apply">Apply</button>
                        <button type="button" class="btn btn-primary btn-save" id="submit-change-email" style="display:none;">Save </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Change Password</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-change-password">
                            <div id="message"></div>
                            <div class="form-group">
                            <label for="exampleInputEmail1">Old Password <span class="star-required">*</span></label>
                            <input type="password" class="form-control" name="old_password" placeholder="Ange ditt Password old" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">New Password <span class="star-required">*</span></label>
                                <input type="password" class="form-control" name="password" placeholder="Ange ditt New Password" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirm New Password <span class="star-required">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Ange ditt Confirm Password" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-save" id="edit-password">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/systemAdmin.css') }}">
@endsection
@section('content')
<div class="row">
    @include('systemAdmin.menu')
    <div class="row col-10 justify-content-center create-company">
        <form method="POST" action="{{ route('create.company') }}">
            @csrf
            <h3 class="title">Create company</h3>
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
            <div class="form-group row">
                <label for="companyNumber" class="col-sm-3 col-form-label">Company number <span class="star-required">*</span></label>
                <div class="col-sm-9">
                    <div class="multiple-form-group input-group">
                        <input type="text" class="form-control" id="companyNumber" placeholder="Enter company number" required>
                        <input name="company_number" class="form-control" type="hidden">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-search-company">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="company-info" style="display:none;">
                <h4>Company information</h4>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Company number:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="company_number" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Company name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="company_name" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Company email:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="company_email" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Company phone:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="company_phone" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="companyAddress" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <div class="row address-form">
                            <div class="multiple-form-group input-group">
                                <div class="col-6">
                                    <div class="form-class">
                                        <label>Line 1</label>
                                        <input class="form-control" type="text" name="address_line1" style="margin-bottom: 20px;" disabled>
                                    </div>
                                    <div class="form-class">
                                        <label>Postcode</label>
                                        <input class="form-control" type="text" name="post_code" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-class">
                                        <label>City</label>
                                        <input class="form-control" type="text" name="city" style="margin-bottom: 20px;" disabled>
                                    </div>
                                    <div class="form-class">
                                        <label>Country</label>
                                        <input class="form-control" type="text" name="country" style="margin-bottom: 20px;" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-3 col-9">
                        <button name="submit" type="submit" class="btn btn-primary">Create Company</button>
                    </div>
                </div>
            </div>


        </form>
    </div>
</div>
@endsection

@section('script')
<script src='{{ asset('js/systemAdmin.js') }}'></script>
@endsection
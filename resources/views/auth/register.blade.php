@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection
@section('content')
<div class="main-content">
    <div class="container">
        <div class="justify-content-md-center">
            <form action="" id="register-submit" method="POST">
                <div class="content-box row">
                    <div class="col-12 col-lf">
                        <div class="col-mobile">
                            <div class="top-mobile clearfix d-block d-sm-none">
                                <a href="" class="float-left">
                                <img src="{{ asset('images/info.png')}}" alt="">
                                </a>
                                <a href="" class="float-right">
                                <img src="{{ asset( 'images//x-circle.png' ) }}" alt="" >
                                </a>
                            </div>
                                <h4>Skapa konto</h4>
                                <div class="text-center">
                                    <div class="confirm-mb">
                                        <div class="mb-register-01 active">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                    </div>
                                </div>
                                <h4>Det gör att vi kan matcha och ge dig förslag om passande affärer</h4>
                        </div>
                    </div>
                    <div class="col-12 col-rg">
                        <div class="content-login-right">
                            <div class="block-right">
                                <div class="register-box">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <h3>Ange org.nummer eller sök efter företagsnamn: <span class="star-required">*</span></h3>
                                            <div class="form-group form-register">
                                                <input type="text" class="form-control form-register form-mb-register" name="company">
                                                <button class="btn btn-primary btn-mb-login">
                                                    <span class="icon_search"></span>
                                                </button>
                                                <p id="message-step1" class="text-danger"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <h5> 1 träffar </h5>
                                            <div class="list-bm-item">
                                                <ul class="list-group">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary btn-mb-pr float-right" id = "button-step1">
                                                nästa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-box row">
                    <div class="col-12 col-lf">
                        <div class="col-mobile">
                            <div class="top-mobile clearfix d-block d-sm-none">
                                <a href="" class="float-left">
                                <img src="{{ asset('images/info.png') }}" alt="">
                                </a>
                                <a href="" class="float-right">
                                    <img src="{{ asset('images/x-circle.png') }}" alt="">
                                </a>
                            </div>
                                <h4>Skapa konto</h4>
                                <div class="text-center">
                                    <div class="confirm-mb">
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 active">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                    </div>
                                </div>
                                <h4>Det gör att vi kan matcha och ge dig förslag om passande affärer</h4>
                        </div>
                    </div>
                    <div class="col-12 col-rg">
                        <div class="content-login-right">
                            <div class="block-right">
                                <div class="register-box row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-register02">
                                            <label class="form-text">Namn:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" placeholder="Ange ditt namn" name="full_name" />
                                            <p id="error-step-2-0"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">E-post:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" placeholder="Ange din e-postadress" name="email" />
                                            <p id="error-step-2-1"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-register02">
                                            <label class="form-text">Företagsnamn:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" value="" name="company_name" placeholder="Ange din Företagsnamn"/>
                                            <p id="error-step-2-5"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Org.nummer:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" value="" name="company_number" placeholder="Ange din Org.nummer" />
                                            <p id="error-step-2-6"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Adress:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" value="" name="company_address" placeholder="Ange din Adress"/>
                                            <p id="error-step-2-7"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Postnummer:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" value="" name="company_postnumber" placeholder="Ange din Postnummer" />
                                            <p id="error-step-2-8"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Postort:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" value="" name="company_postoffice" placeholder="Ange din Postort" />
                                            <p id="error-step-2-9"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Land:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" value="" name="company_country" placeholder="Ange din Land" />
                                            <p id="error-step-2-10"></p>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" value="" name="company_email"/>
                                    <input type="hidden" class="form-control" value="" name="company_phone_number"/>
                                    <div class="col-12 btn-md-right">
                                        <button class="btn btn-primary btn-mb-lf">
                                            TILLBAKA
                                        </button>
                                        <button class="btn btn-primary btn-mb-pr" id="button-step2">
                                            nästa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-box row">
                    <div class="col-12 col-lf">
                        <div class="col-mobile">
                            <div class="top-mobile clearfix d-block d-sm-none">
                                <a href="" class="float-left">
                                    <img src="{{ asset('images/info.png') }}" alt="">
                                </a>
                                <a href="" class="float-right">
                                    <img src="{{ asset('images/x-circle.png') }}" alt="">
                                </a>
                            </div>
                                <h4>Nästan färdig</h4>
                                <div class="text-center">
                                    <div class="confirm-mb">
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 active">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                    </div>
                                </div>
                                <h4>Det gör att vi kan matcha och ge dig förslag om passande affärer</h4>
                        </div>
                    </div>
                    <div class="col-12 col-rg">
                        <div class="content-login-right">
                            <div class="block-right">
                                <div class="register-box">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-md-8">
                                            <div id="notify-code"></div>
                                            <div class="form-group form-register02">
                                                <label class="form-text">Verification Code  <span class="star-required">*</span></label>
                                                <input type="text" class="form-control form-mb-st" value="" name="verify_code" placeholder="Ange din verification code" />
                                                <p id="error-step-2-15"></p>
                                            </div>
                                        </div>
                                        <div class="col-12 btn-md-right">
                                            <a class="btn btn-primary btn-mb-lf">
                                                    TILLBAKA
                                            </a>
                                            <button class="btn btn-primary btn-mb-pr" id="btn-confirm-code">
                                                nästa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-box row">
                    <div class="col-12 col-lf">
                        <div class="col-mobile">
                            <div class="top-mobile clearfix d-block d-sm-none">
                                <a href="" class="float-left">
                                <img src="{{ asset('images/info.png') }}" alt="">
                                </a>
                                <a href="" class="float-right">
                                    <img src="{{ asset('images/x-circle.png') }}" alt="">
                                </a>
                            </div>
                                <h4>Förfina din matchning</h4>
                                <div class="text-center">
                                    <div class="confirm-mb">
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 active">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                        <div class="mb-register-01">
                                        </div>
                                    </div>
                                </div>
                                <h4>Hjälp oss förstå ditt företags verksamt</h4>
                        </div>
                    </div>
                    <div class="col-12 col-rg">
                        <div class="content-login-right">
                            <div class="block-right">
                                <div class="register-box row">
                                    <div id="message-notify" class="col-12"></div>
                                    <div class="col-md-6">
                                        <div class="form-group form-register02">
                                            <label class="form-text">Taggar: </label>
                                            <select class="form-control form-mb-st" id="tags" >
                                                <option value="">Ange relevanta taggar</option>
                                                <?php 
                                                if($tags) {
                                                    foreach ($tags as $tag) {
                                                        ?>
                                                        <option value="<?php echo $tag->name; ?>"><?php echo $tag->name; ?></option>
                                                    <?php }
    
                                                } ?>
                                            </select>
                                            <div class="result-taggar">
                                                <ul>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Telefonnummer: <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" placeholder="Ange ditt telefonnummer" name="phone_number" maxlength="15"/>
                                            <p id="error-step-3-1"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Titel:  <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" placeholder="Ange din arbetstitel" name="title" />
                                            <p id="error-step-2-4"></p>
                                        </div>
                                        <div class="content-range clearfix">
                                            <h4>Tidigare erfarhet av offenliga upphandlingar:</h4>
                                            <div class="slider-range" id="slider">
                                                <div class="range-text clearfix">
                                                    <p class="float-left">Ingen</p>
                                                    <p class="float-right">God</p>
                                                </div>
                                            </div>
                                            <input type="hidden" id="experience" name="procurement_experience" value="0"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-register02">
                                            <label class="form-text">Linkedin: <span class="star-required">*</span></label>
                                            <input type="text" class="form-control form-mb-st" placeholder="Klistra in länk till din linkedinprofil" name="linked_in" />
                                            <p id="error-step-3-2"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Password: <span class="star-required">*</span></label>
                                            <input type="password" class="form-control form-mb-st" placeholder="Ange din password" name="password" />
                                            <p id="error-step-2-2"></p>
                                        </div>
                                        <div class="form-group form-register02">
                                            <label class="form-text">Confirm Password:  <span class="star-required">*</span></label>
                                            <input type="password" class="form-control form-mb-st" placeholder="Ange din comfirm password" name="password_confirmation" />
                                            <p id="error-step-2-3"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 btn-md-right">
                                        <button type="reset" class="btn btn-primary btn-mb-lf">
                                            TILLBAKA
                                        </button>
                                        <button class="btn btn-primary btn-mb-pr" id="button-step3">
                                            nästa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-box row">
                    <div class="col-12 col-lf">
                        <div class="col-mobile">
                            <div class="top-mobile clearfix d-block d-sm-none">
                                <a href="" class="float-left">
                                    <img src="{{ asset('images/info.png') }}" alt="">
                                </a>
                                <a href="" class="float-right">
                                    <img src="{{ asset('images/x-circle.png') }}" alt="">
                                </a>
                            </div>
                                <h4>Tack, ditt konto har skapats</h4>
                                <div class="text-center">
                                    <div class="confirm-mb">
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 confirm">
                                        </div>
                                        <div class="mb-register-01 active">
                                        </div>
                                    </div>
                                </div>
                                <h4>Fortsätt ställa in ditt konto för bättre matchningar</h4>
                        </div>
                    </div>
                    <div class="col-12 col-rg">
                        <div class="content-login-right">
                            <div class="block-right">
                                <div class="register-box">
                                    <div class="block-box-slider">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="slider-item item-last">
                                                    <div class="carousel-block active">
                                                        <p class="round"></p>
                                                        <h3>public <span>match</span></h3>
                                                        <h3>Tryck här för att hitta din partner i en upphandling</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="slider-item item-last">
                                                    <div class="carousel-block">
                                                        <p class="round"></p>
                                                        <h3>public <span>works</span></h3>
                                                        <h3>Tryck här för att hitta din anbudskonsult</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js'></script>
<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js'></script>
<script src='{{ asset('js/register.js') }}'></script>    
@endsection
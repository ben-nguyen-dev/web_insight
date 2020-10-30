@extends('layouts.app')
@section('style')
  <link rel="stylesheet" href="{{ asset('css/companyAdmin.css') }}">
@endsection
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Company Information</h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="info-company">
                              @if(session('success'))
                                <div class="alert alert-primary" role="alert">
                                  {{ session('success') }}
                                </div>
                              @endif
                              @if(session('error'))
                                <div class="alert alert-warning" role="alert">
                                  {{ session('error') }}
                                </div>
                              @endif
                                <form action="" method="POST">
                                  @csrf
                                    <div class="form-group row">
                                      <label for="username" class="col-3 col-form-label">Name <span class="star-required">*</span></label> 
                                      <div class="col-9 input-group">
                                        <input name="name" placeholder="Name" class="form-control" disabled class="form-control" required="required" type="text" value="{{ isset($info_company['name']) ? $info_company['name'] : '' }}">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="name" class="col-3 col-form-label">Domains</label> 
                                      <div class="col-9">
                                        <div class="multiple-form-group input-group">
                                          <input id="domains" name="domains[]" placeholder="Enter company domain" class="form-control" type="text">
                                          <input name="domain_list" class="form-control" type="hidden">
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add">+</button>
                                          </span>
                                        </div>
                                        <div class="input-group list-tags form-domains">
                                          <ul>
                                            @if(isset($info_company['domains']) && count($info_company['domains']) > 0)
                                              @foreach ($info_company['domains'] as $domain)
                                                <li data-html="{{ $domain->name }}"><span> {{ $domain->name }}</span> <i class="fa fa-times"></i></li>
                                              @endforeach
                                            @endif
                                          </ul>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group row">
                                      <label for="lastname" class="col-3 col-form-label">SNI</label> 
                                      <div class="col-9 input-group">
                                        <input name="sni_code" placeholder="SNI code" class="form-control" required="required" type="text" disabled value="{{ isset($info_company['sni_code']) && count($info_company['sni_code']) > 0 ? $info_company['sni_code'] : '' }}">
                                      </div>
                                    </div>

                                    <div class="form-group row">
                                      <label for="text" class="col-3 col-form-label">Website</label> 
                                      <div class="col-9">
                                        <input name="website" placeholder="Company Website" class="form-control" required="required" type="text" value="{{ isset($info_company['website']) ? $info_company['website'] : '' }}">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="text" class="col-3 col-form-label">Email</label> 
                                      <div class="col-9">
                                        <input name="email" placeholder="Company Email" class="form-control" required="required" type="text" value="{{ isset($info_company['email']) ? $info_company['email'] : '' }}">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="text" class="col-3 col-form-label">E-invoice</label> 
                                      <div class="col-9">
                                        <input name="check_e_invoice" type="checkbox" <?php if(!isset($info_company['check_e_invoice']) || isset($info_company['check_e_invoice']) && $info_company['check_e_invoice']) echo 'checked'; ?>>
                                        <label>Use the company email</label>
                                        <input name="e_invoice" placeholder="Company E-invoice" class="form-control e-invoice" type="text" value="{{ !isset($info_company['check_e_invoice']) && isset($info_company['e_invoice']) ? $info_company['e_invoice'] : '' }}">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="username" class="col-3 col-form-label">Telefonnummer: <span class="star-required">*</span></label> 
                                      <div class="col-9">
                                        <input name="phone_number" placeholder="Ange ditt telefonnummer" class="form-control" required="required" maxlength="15" type="text" value="{{ isset($info_company['phone_number']) ? $info_company['phone_number'] : '' }}">
                                      <span class="mess-errors"></span>
                                      @if ($errors->has('phone_number'))
                                        <p class="star-required">{{ $errors->first('phone_number') }}</p>
                                      @endif
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="username" class="col-3 col-form-label">Linkedin: <span class="star-required">*</span></label> 
                                      <div class="col-9 ">
                                        <input name="linked_in" placeholder="Klistra in länk till din linkedinprofil" class="form-control" required="required" type="text" value="{{ isset($info_company['linked_in']) ? $info_company['linked_in'] : '' }}">
                                        <span class="mess-errors" id="error-step-3-2"></span>
                                        @if ($errors->has('linked_in'))
                                          <p class="star-required">{{ $errors->first('linked_in') }}</p>
                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="text" class="col-3 col-form-label">Company Taggar</label> 
                                      <div class="col-9">
                                        <select class="form-control" id="tags">
                                          <option value="">Select tag</option>
                                          @if (isset($tags))
                                            @foreach ($tags as $tag)
                                              <option value="{{$tag->name}}"> {{ $tag->name }}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                        <input name="tag_list" class="form-control" type="hidden">
                                        <div class="input-group list-tags form-tags">
                                          <ul>
                                            @if(isset($info_company['tags']) && count($info_company['tags']) > 0)
                                              @foreach ($info_company['tags'] as $tag)
                                                <li data-html="{{ $tag->name }}"><span> {{ $tag->name }}</span> <i class="fa fa-times"></i></li>
                                              @endforeach
                                            @endif
                                          </ul>
                                        </div>
                                      </div>
                                    </div> 

                                    <div class="form-group row">
                                      <label for="select" class="col-3 col-form-label">Address</label> 
                                        <div class="col-9">
                                          <div class="row address-form">
                                            <label class="address-label">Office address</label>
                                            <div class="multiple-form-group input-group">
                                              <div class="col-6">
                                                  <div class="form-class">
                                                    <label>Line 1</label>
                                                    <input name="address[office][line1]" 
                                                        placeholder="Line1" 
                                                        class="form-control" 
                                                        type="text" 
                                                        required
                                                        value = "{{isset($info_company['office_address']) ? $info_company['office_address']->line1 : ''}}"
                                                        style="margin-bottom: 20px;" 
                                                        disabled >
                                                  </div>
                                                  <div class="form-class">
                                                    <label>Postcode</label>
                                                    <input name="address[office][post_code]" 
                                                    placeholder="Postcode" 
                                                    class="form-control" 
                                                    type="text" 
                                                    required
                                                    value = "{{isset($info_company['office_address']) ? $info_company['office_address']->post_code : ''}}"
                                                    disabled >
                                                </div>
                                              </div>
                                              <div class="col-6">
                                                <div class="form-class">
                                                    <label>City</label>
                                                    <input name="address[office][city]" 
                                                        placeholder="City" 
                                                        class="form-control" 
                                                        type="text" 
                                                        required
                                                        value = "{{isset($info_company['office_address']) ? $info_company['office_address']->city : ''}}"
                                                        style="margin-bottom: 20px;"
                                                        disabled >
                                                </div>
                                                <div class="form-class">
                                                  <label>Country</label>
                                                  <input name="address[office][country]" 
                                                      placeholder="Country" 
                                                      class="form-control" 
                                                      type="text" 
                                                      required
                                                      value = "{{isset($info_company['office_address']) ? $info_company['office_address']->country : ''}}"
                                                      style="margin-bottom: 20px;"
                                                      disabled >
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-check-inline">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input checkbox-address" name="checkbox_invoice_address" <?php if(!isset($info_company['check_invoice']) || isset($info_company['check_invoice']) && $info_company['check_invoice']) echo 'checked'; ?>>Use the office address as invoice
                                            </label>
                                          </div>
                                          <div class="form-check-inline">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input checkbox-address" name="checkbox_visiting_address" <?php if(isset($info_company['check_visiting']) && $info_company['check_visiting']) echo 'checked'; ?>>Use the office address as visiting
                                            </label>
                                          </div>
                                          <div class="row address-form invoice-address">
                                            <label class="address-label">Invoice address</label>
                                            <div class="multiple-form-group input-group">
                                              <div class="col-6">
                                                  <div class="form-class">
                                                    <label>Line 1</label>
                                                    <input name="address[invoice][line1]" 
                                                        placeholder="Line1" 
                                                        class="form-control" 
                                                        type="text" 
                                                        required
                                                        value = "{{isset($info_company['check_invoice']) && !$info_company['check_invoice'] && isset($info_company['invoice_address']) ? $info_company['invoice_address']->line1 : ''}}"
                                                        style="margin-bottom: 20px;" >
                                                  </div>
                                                  <div class="form-class">
                                                    <label>Postcode</label>
                                                    <input name="address[invoice][post_code]" 
                                                    placeholder="Postcode" 
                                                    class="form-control" 
                                                    type="text" 
                                                    required
                                                    value = "{{isset($info_company['check_invoice']) && !$info_company['check_invoice'] && isset($info_company['invoice_address']) ? $info_company['invoice_address']->post_code : ''}}"
                                                    >
                                                </div>
                                              </div>
                                              <div class="col-6">
                                                <div class="form-class">
                                                    <label>City</label>
                                                    <input name="address[invoice][city]" 
                                                        placeholder="City" 
                                                        class="form-control" 
                                                        type="text" 
                                                        required
                                                        value = "{{isset($info_company['check_invoice']) && !$info_company['check_invoice'] && isset($info_company['invoice_address']) ? $info_company['invoice_address']->city : ''}}"
                                                        style="margin-bottom: 20px;">
                                                </div>
                                                <div class="form-class">
                                                  <label>Country</label>
                                                  <input name="address[invoice][country]" 
                                                      placeholder="Country" 
                                                      class="form-control" 
                                                      type="text" 
                                                      required
                                                      value = "{{isset($info_company['check_invoice']) && !$info_company['check_invoice'] && isset($info_company['invoice_address']) ? $info_company['invoice_address']->country : ''}}"
                                                      style="margin-bottom: 20px;">
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row address-form visiting-address">
                                            <label class="address-label">Visting address</label>
                                            <div class="multiple-form-group input-group">
                                              <div class="col-6">
                                                  <div class="form-class">
                                                    <label>Line 1</label>
                                                    <input name="address[visiting][line1]" 
                                                        placeholder="Line1" 
                                                        class="form-control" 
                                                        type="text" 
                                                        required
                                                        value = "{{isset($info_company['check_visiting']) && !$info_company['check_visiting'] && isset($info_company['visiting_address']) ? $info_company['visiting_address']->line1 : ''}}"
                                                        style="margin-bottom: 20px;" >
                                                  </div>
                                                  <div class="form-class">
                                                    <label>Postcode</label>
                                                    <input name="address[visiting][post_code]" 
                                                    placeholder="Postcode" 
                                                    class="form-control" 
                                                    type="text" 
                                                    required
                                                    value = "{{isset($info_company['check_visiting']) && !$info_company['check_visiting'] && isset($info_company['visiting_address']) ? $info_company['visiting_address']->post_code : ''}}"
                                                    >
                                                </div>
                                              </div>
                                              <div class="col-6">
                                                <div class="form-class">
                                                    <label>City</label>
                                                    <input name="address[visiting][city]" 
                                                        placeholder="City" 
                                                        class="form-control" 
                                                        type="text" 
                                                        required
                                                        value = "{{isset($info_company['check_visiting']) && !$info_company['check_visiting'] && isset($info_company['visiting_address']) ? $info_company['visiting_address']->city : ''}}"
                                                        style="margin-bottom: 20px;">
                                                </div>
                                                <div class="form-class">
                                                  <label>Country</label>
                                                  <input name="address[visiting][country]" 
                                                      placeholder="Country" 
                                                      class="form-control" 
                                                      type="text" 
                                                      required
                                                      value = "{{isset($info_company['check_visiting']) && !$info_company['check_visiting'] && isset($info_company['visiting_address']) ? $info_company['visiting_address']->country : ''}}"
                                                      style="margin-bottom: 20px;">
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                        
                                      </div>
                                    </div>

                                    <div class="form-group row">
                                      <div class="offset-3 col-9">
                                        <button name="submit" type="submit" class="btn btn-primary btn-submit">Update Company</button>
                                      </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
  <script src="{{ asset('js/company.js') }}"></script>
@endsection
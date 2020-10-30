<?php /* Template Name: Profile */ ?>
<?php get_header(); ?>
<section class="container user-profile">
    <div class="row d-flex">
        <div class="col-md-4 col-lg-3 col-xl-3 d-none d-sm-block d-sm-none d-md-block cols-left">
            <ul id="menu_profile" class="list-group list-group-flush">
                <li class="list-group-item active">
                    <a href="#profile_settings">Profile Settings</a>
                </li>
                <li class="list-group-item">
                    <a href="#company_settings">Company Settings</a>
                </li>
            </ul>
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9 cols-right">
            <?php
                $user_data = get_user_meta($current_user->ID);
                $termAgreed = isset($user_data['term_agreed']) ? $user_data['term_agreed'] : null;
                if($termAgreed  == null || !$termAgreed): ?>
                <div id="form_check_term" class="row">
                    <div class="form-check has-error has-danger">
                        <input class="form-check-input" type="checkbox" id="accepted_term_checkbox"/>
                        <label class="form-check-label term" for="accepted_term_checkbox">
                            I Agree to the <a href="javascript:void(0)" target="_blank">terms and conditions</a> of
                            becoming a <span class="font-weight-bold">Public Insight</span> member
                        </label>
                        <div class="help-block with-errors d-none">
                            <ul class="list-unstyled">
                                <li>Please read terms and conditions above then tick</li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <input type="hidden" id="accepted_term" value="<?php echo $termAgreed ? 1 : 0 ; ?>"/>
            <div class="alert alert-danger print-error-msg-profile" style="display:none">
                <ul></ul>
            </div>
            <form id="frmProfile" class="w-100" method="post" action="<?php echo esc_url(home_url('/save-profile?type=1')); ?>" role="form" data-toggle="validator" novalidate="true">
                <!-- {{ csrf_field() }} -->
                <div id="profile_settings">
                    <div class="d-flex justify-content-between align-items-baseline w-100 header" style="<?php echo $termAgreed ? 'padding-top: 0; margin-top: 5px;' : ''  ?>">
                        <h3 class="title">Profile Settings</h3>
                        <div clas="button-group">
                            <button class="btn btn-outline-dark active btn-sm btn-save hidden" type="submit">Save</button>
                            <button class="btn btn-outline-dark btn-sm btn-cancel hidden" type="button">Cancel</button>
                            <button class="btn btn-outline-secondary btn-sm btn-edit" type="button">Edit</button>
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="form-group">
                            <label class="required">Full name</label>
                            <label class="form-control" data-for="full_name"><?php echo $current_user->display_name; ?></label>
                            <input type="text" class="form-control" name="full_name" value="<?php echo $current_user->display_name; ?>" maxlength="128" placeholder="Full name" required data-error="Please enter your full name"/>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <label class="form-control" data-for="email"><?php echo $current_user->user_email; ?></label>
                            <input type="text" class="form-control" value="<?php echo $current_user->user_email; ?>" data-name="email" readonly="readonly"/>
                        </div>
                    </div>
                </div>
            </form>
            <div class="alert alert-danger print-error-msg-company" style="display:none">
                <ul></ul>
            </div>
            <form id="frmCompany" class="w-100" method="post" action="<?php echo esc_url(home_url('/save-profile?type=2')); ?>" role="form" data-toggle="validator" novalidate="true">
                <!-- {{ csrf_field() }} -->
                <div id="company_settings">
                    <div class="d-flex justify-content-between align-items-baseline w-100 header">
                        <h3 class="title">Company Settings</h3>
                        <div clas="button-group">
                            <button class="btn btn-outline-dark active btn-sm btn-save hidden" type="submit">Save</button>
                            <button class="btn btn-outline-dark btn-sm btn-cancel hidden" type="button">Cancel</button>
                            <button class="btn btn-outline-secondary btn-sm btn-edit" type="button">Edit</button>
                        </div>
                    </div>
                    <section class="w-100">
                        <div class="form-group">
                            <label class="required">Company name</label>
                            <label class="form-control" data-for="company_name"><?php echo isset($user_data['company_name']) ? $user_data['company_name'][0] : ''; ?></label>
                            <input type="text" class="form-control" name="company_name" value="<?php echo isset($user_data['company_name']) ? $user_data['company_name'][0] : ''; ?>" maxlength="256" placeholder="Company name" required data-error="Please enter your company name"/>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="required">Organization number</label>
                            <label class="form-control" data-for="org_number"><?php echo isset($user_data['organization_number']) ? $user_data['organization_number'][0] : ''; ?></label>
                            <input type="text" class="form-control" name="org_number" value="<?php echo isset($user_data['organization_number']) ? $user_data['organization_number'][0] : ''; ?>" placeholder="Organization number" maxlength="64" required data-error="Please enter your organization number"/>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="required">Address line 1</label>
                            <label class="form-control" data-for="address_line1"><?php echo isset($user_data['address_line_1']) ? $user_data['address_line_1'][0] : ''; ?></label>
                            <input type="text" class="form-control" name="address_line1" value="<?php echo isset($user_data['address_line_1']) ? $user_data['address_line_1'][0] : ''; ?>" maxlength="256" placeholder="Address line 1" required data-error="Please enter your address line 1"/>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label>Address line 2</label>
                            <label class="form-control" data-for="address_line2"><?php echo isset($user_data['address_line_2']) ? $user_data['address_line_2'][0] : ''; ?></label>
                            <input type="text" class="form-control" name="address_line2" value="<?php echo isset($user_data['address_line_2']) ? $user_data['address_line_2'][0] : ''; ?>" maxlength="256" placeholder="Address line 2"/>
                        </div>
                        <div class="form-group">
                            <label class="required">Zip code</label>
                            <label class="form-control" data-for="zip_code"><?php echo isset($user_data['zip_code']) ? $user_data['zip_code'][0] : ''; ?></label>
                            <input type="number" class="form-control" name="zip_code" value="<?php echo isset($user_data['zip_code']) ? $user_data['zip_code'][0] : ''; ?>" maxlength="32" placeholder="Zip code" required data-error="Please enter your zip code"/>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="required">City</label>
                            <label class="form-control" data-for="city_name"><?php echo isset($user_data['city']) ? $user_data['city'][0] : ''; ?></label>
                            <input type="text" class="form-control" name="city_name" value="<?php echo isset($user_data['city']) ? $user_data['city'][0] : ''; ?>" maxlength="64" placeholder="City" required data-error="Please enter your city"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </section>

                    <div class="form-group">
                        <label>Use different invoice address</label>
                        <div class="w-100">
                            <?php
                                $checked = isset($user_data['use_different_invoice']) ? $user_data['use_different_invoice'][0] : false;
                                $display = !$checked ? 'display:none' : '';
                            ?>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-dark <?php echo $checked ? 'active' : ''; ?> disabled">
                                    <input type="radio" name="use_different_invoice" value="1" autocomplete="off" disabled <?php echo $checked ? 'checked' : ''; ?> /> Yes
                                </label>
                                <label class="btn btn-outline-dark <?php !$checked ? 'active' : ''; ?> disabled">
                                    <input type="radio" name="use_different_invoice" value="0" autocomplete="off" disabled <?php echo !$checked ? 'checked' : ''; ?> /> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-100">
                    <div id="invoice_settings" style="<?php echo $display; ?>">
                        <div class="d-flex justify-content-between align-items-baseline w-100 header overwrite">
                            <h3 class="title">Invoice Address</h3>
                        </div>
                        <section class="w-100">
                            <div class="form-group">
                                <label class="required">Address line 1</label>
                                <label class="form-control" data-for="invoice_address_line1"><?php echo isset($user_data['invoice_address_line_1']) ? $user_data['invoice_address_line_1'][0] : ''; ?></label>
                                <input type="text" class="form-control" name="invoice_address_line1" value="<?php echo array_key_exists('invoice_address_line_1', $user_data) ? $user_data['invoice_address_line_1'][0] : ''; ?>" maxlength="256" placeholder="Address line 1" data-error="Please enter your address line 1"/>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Address line 2</label>
                                <label class="form-control" data-for="invoice_address_line2"><?php echo isset($user_data['invoice_address_line_2']) ? $user_data['invoice_address_line_2'][0] : ''; ?></label>
                                <input type="text" class="form-control" name="invoice_address_line2" value="<?php echo array_key_exists('invoice_address_line_2', $user_data) ? $user_data['invoice_address_line_2'][0] : ''; ?>" maxlength="256" placeholder="Address line 2"/>
                            </div>
                            <div class="form-group">
                                <label class="required">Zip code</label>
                                <label class="form-control" data-for="invoice_zip_code"><?php echo isset($user_data['invoice_zip_code']) ? $user_data['invoice_zip_code'][0] : ''; ?></label>
                                <input type="number" class="form-control" name="invoice_zip_code" value="<?php echo array_key_exists('invoice_zip_code', $user_data) ? $user_data['invoice_zip_code'][0] : ''; ?>" maxlength="32" placeholder="Zip code" data-error="Please enter your zip code"/>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label class="required">City</label>
                                <label class="form-control" data-for="invoice_city_name"><?php echo isset($user_data['invoice_city_name']) ? $user_data['invoice_city_name'][0] : ''; ?></label>
                                <input type="text" class="form-control" name="invoice_city_name" value="<?php echo array_key_exists('invoice_city_name', $user_data) ? $user_data['invoice_city_name'][0] : ''; ?>" maxlength="64" placeholder="City" data-error="Please enter your city name"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </section>
                    </div>
                    <!-- {{--
                    <div class="d-flex justify-content-between align-items-baseline w-100 header bottom">
                        <h3 class="title">Company Settings</h3>
                        <div clas="button-group">
                            <button class="btn btn-outline-dark active btn-sm btn-save hidden" type="submit">Save</button>
                            <button class="btn btn-outline-dark btn-sm btn-cancel hidden" type="button">Cancel</button>
                            <button class="btn btn-outline-secondary btn-sm btn-edit" type="button">Edit</button>
                        </div>
                    </div>
                    --}} -->
                </div>
            </form>
        </div>
    </div>
    <div id="msgModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModal">Public Insight</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
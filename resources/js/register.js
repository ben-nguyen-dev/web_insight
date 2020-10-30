$(document).ready(function(){
    var resultArr = [];
  
    $(document).on('change', '#tags', function()  {
        $value = $(this).val();
        if ($value != '') {
            if (resultArr.indexOf($value) == -1) {
                resultArr.push($value);
                $html_output = `<li>
                                <div class="list-tagger" data-html=`+ $value +`>
                                    <h4>` + $value.toUpperCase() + `<span><img src='../images/x.png' alt=""></span></h4>
                                </div> 
                                <input type="hidden" name="tags" value=`+ $value +` /> 
                            </li>`;
                $('.result-taggar').find('ul').append($html_output);
                $(this).val('');
            }
        }
    });
    $(document).on("click",".list-tagger h4",function() {
        var value = $(this).parent().data('html');
        resultArr.splice(resultArr.indexOf(value.toString()), 1);
        $(this).parents('ul li').remove();
    });
   
    $('#slider').slider({
        min:0,
        max:100,
        animate: true,
        slide: function( event, ui ) {
             $( "#experience" ).val(ui.value);
        }
    });
    $("input[name='linked_in']").on('keyup', function () {
        $linkin = $(this).val();
        if ($linkin != '') {
          if ($linkin.substring(0, 5) != "https") {
            $('#error-step-3-2').html('Please input https format').css('color', 'red');
          } else {
            $('#error-step-3-2').html('');
          }
        } else {
          $('#error-step-3-2').html('Linkedin is required');
        }
      });
    $(document).on('click','.btn-mb-lf',function(event) {
        event.preventDefault();
        $(this).parents('.content-box').prev().show().next().hide();
    });
    function list_company(value) {
        $html = '';
        if (value != '') {
          $.ajax({
            type:'GET',
            url:"/api/company/getCompaniesData",
            dataType : "json",
            data : {
              company_number: value
            },
            success : function(response) {
              if (response && response.status) {
                element = response.data
                $html = ` <li class="list-group-item item">
                      <div class="box-item">
                          <div class="box-top">
                              <h5 class="element_company_name">` + element.NAME + `</h5>
                              <input type="radio" name="addresss" checked="checked">
                              <span class="box-check"></span>
                          </div>
                          <div class="box-content">
                              <p> <span class="element_org_number">` + element.ORGNR + 
                              `</span> <span class="element_company_postoffice">` + element.TOWN + `
                              </span><br><span class="element_address">` + element.ADDRESS + `
                              </span></p>
                              <input type="hidden" class="element_company_postnumber" value="` + element.ZIPCODE + `"></input>
                              <input type="hidden" class="element_company_country" value="Sweden"></input>
                              <input type="hidden" class="element_company_email" value="` + element.EMAIL_ADRESS + `"></input>
                              <input type="hidden" class="element_company_phone_number" value="` + element.TELEPHONE + `"></input>
                          </div>
                      </div>
                  </li>`; 
                $('.list-bm-item').find('.list-group').html($html);
              } else {
                  $('#message-step1').html(response.message);
              }
            }
          });
  
        }
    }
  
    $(document).on('click', '.box-item', function() {
        const box_check = $(this).find('input[name="addresss"]');
        let company = $("input[name='company']").val();
        if($(box_check).length) {
            if($(box_check).is(':checked') === false) {
                $('.list-group').find('input[name="addresss"]').removeAttr('checked');
                $(box_check).attr('checked', true);
            } else {
                $(box_check).removeAttr('checked');
            }
        }
        
        if($(box_check).is(':checked') == true) {
            const regex = /[a-zA-Z&\/\\#,+()$~%.'":*?<>{}]/g;
            let input_company = $(this).parents('.register-box').find("input[name='company']");
            if (regex.test(company)) {
                let company_name = $(this).find("input[name='addresss']:checked").prev().text();
                input_company.val(company_name);
            } else {
                let company_id = $(this).find("input[name='addresss']:checked").parents('.box-item').find('.box-content p span.element_org_number').text();
                input_company.val(company_id);
            }
        }
    });
  
    $(document).on('input','.form-mb-register', function() {
        if (this.value == '') {
            $html = 'Company is required';
        } else {
            $html = '';
        }
        $('#message-step1').html($html);        
        // list_company(this.value);
        
    });
    $(document).on("click",".btn-mb-login", function(event) {
        event.preventDefault();
        var value_company = $(this).parent().find("input[name='company']").val();
        list_company(value_company);
    });
    function checkRequired(selector, name) {
        $(selector).on("keyup", function() {
            var value = $(this).val();
            if (value == '') {
                $html = name + " is required";
            } else {
                $html = '';
            }
            $(this).next().html($html).css('color', '#ff0000');
        });
    }
    checkRequired("input[name='full_name']", "Namn");
    checkRequired("input[name='title']", "Titel");
    checkRequired("input[name='email']", "E-post");
    checkRequired("input[name='company_name']", "Företagsnamn");
    checkRequired("input[name='company_number']", "Org.nummer");
    checkRequired("input[name='company_address']", "Adress");
    checkRequired("input[name='company_postnumber']", "Postnummer");
    checkRequired("input[name='company_postoffice']", "Postort");
    checkRequired("input[name='company_country']", "Land");
    $("input[name='password']").on("input", function() {
        if (this.value == '') {
            $html = "Password is required";
        } else {
            if (this.value.length < 8) {
                $html = 'Password greater than 8 characters';
            } else {
                $confirm_password = $("input[name='password_confirmation']").val();
                if ($confirm_password != '' && this.value == $confirm_password) {
                    $("input[name='password_confirmation']").next().html('').css('color','#ff0000');
                }
                $html = '';
            }
        }
        $(this).next().html($html).css('color', '#ff0000');
    });
    $("input[name='phone_number']").on('input', function() {
        if (this.value == '') {
            $html = "Telefonnummer is required";
        } else {
            let valueInput = this.value.replace(/[a-zA-Zươ&\/\\#,+()$~%.'":*?<>{}]/g, "");
            if (valueInput == '') {
                this.value = valueInput; 
                return;
            }
            this.value = valueInput;
            if (this.value.length < 8 || this.value.length > 15) {
                $html = "Telefonnummer must contain 8 - 15 numbers";
               } else {
                $html = '';
               }
        }
        $(this).next().html($html).css('color', '#ff0000');
    });
    $("input[name='password_confirmation']").on('keyup', function () {
        $password = $("input[name='password']").val();
        $confirm_password = $("input[name='password_confirmation']").val();
        if ($confirm_password != '') {
            if ($password == $confirm_password) {
                $('#error-step-2-3').html('');
            } else {
                  $('#error-step-2-3').html('The passwords you entered do not match.').css('color', 'red');
            }
        } else {
            $('#error-step-2-3').html('Confirm Password is required').css('color', '#ff0000');
        }
      });
  });
  $(document).on("click", "#button-step1", function(event) {
    event.preventDefault();
    $value = $(".form-register input[name='company']").val();
    if ($value == '') {
        $('#message-step1').html('Company number is required');
    } else {
        $('#message-step1').html(' ');
        let check = false;
        $('.list-group').find('input[name="addresss"]').each(function () {
            if($(this).is(':checked') !== false) {
                check = true;
                const parent = $(this).parents('.list-group-item');
                $("input[name='company_name']").val($(parent).find(".element_company_name").text());
                $("input[name='company_number']").val($(parent).find(".element_org_number").text());
                $("input[name='company_address']").val($(parent).find(".element_address").text());
                $("input[name='company_postoffice']").val($(parent).find(".element_company_postoffice").text());
                $("input[name='company_postnumber']").val($(parent).find(".element_company_postnumber").val());
                $("input[name='company_country']").val($(parent).find(".element_company_country").val());
                $("input[name='company_email']").val($(parent).find(".element_company_email").val());
                $("input[name='company_phone_number']").val($(parent).find(".element_company_phone_number").val());
            }
        });
        if(!check) {
          $('#message-step1').html('Company is required. Please choose item in search result.');
        } else {
          $.ajax({
            type:'GET',
            url:"/api/checkCompanyExists",
            dataType : "json",
            data : {
              company_name: $("input[name='company_name']").val(),
              company_number: $("input[name='company_number']").val()
            },
            success : function(data) {
              if (data && data["status"]) {
                $('#message-step1').html(data["message"]);
              } else {
                  $html = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Please check mail to get verification code.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>`;
                    $('#notify-code').html($html);
                    $('#button-step1').parents('.content-box').next().show().prev().hide();
              }
            }
          });
        }
    }
  });
  $(document).on('click','#btn-confirm-code', function(event) {
    event.preventDefault();
    $code = $(".form-register02 input[name='verify_code']").val();
    $email = $(".form-register02 input[name='email']").val();
    if ($code == '') {
        $('#error-step-2-15').html('Verification Code is required').css('color','red');
    } else {
        $.ajax({
            type : 'GET',
            url : '/api/checkVerificationCode',
            dataType: 'Json',
            data : {
                code : $code,
                email : $email
            },
            success: function(data) {
                if (data.status) {
                    $('#btn-confirm-code').parents('.content-box').next().show().prev().hide();
                }  else {
                    $("#error-step-2-15").html(data.message).css('color', '#ff0000');
                }
            }
        });
    }
  });
  function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }
  $(document).on("click", "#button-step2", function(event) {
    event.preventDefault();
    $email = $(".form-register02 input[name='email']").val(); 
    $name =  $(".form-register02 input[name='full_name']").val();
    $company_name = $(".form-register02 input[name='company_name']").val();  
    $company_number = $(".form-register02 input[name='company_number']").val(); 
    $company_address = $(".form-register02 input[name='company_address']").val(); 
    $company_postnumber = $(".form-register02 input[name='company_postnumber']").val(); 
    $company_postoffice = $(".form-register02 input[name='company_postoffice']").val(); 
    $company_country = $(".form-register02 input[name='company_country']").val(); 
    $errors =[];
  
    if ($name == '') {
        $errors['name'] = 'Namn is required';
    } else {
        $errors['name'] = '';
    }

    if ($email == '') {
        $errors['email'] = 'E-posts is required';
    } else {
        if (validateEmail($email)) {
            $errors['email'] = '';
        } else {
            $errors['email'] = 'This is not a valid email';
        }
    }
  
    if ($company_name == '') {
        $errors['company_name'] =  'Företagsnamn is required';
    } else {
        $errors['company_name'] =  '';
    }
  
    if ($company_number == '') {
        $errors['company_number'] =  'Org.nummer is required';
    } else {
        $errors['company_number'] =  '';
    }
  
    if ($company_address == '') {
        $errors['company_address'] =  'Adress is required';
    } else {
        $errors['company_address'] =  '';
    }
  
    if ($company_postnumber == '') {
        $errors['company_postnumber'] =  'Postnummer is required';
    } else {
        $errors['company_postnumber'] =  '';
    }
  
    if ($company_postoffice == '') {
        $errors['company_postoffice'] =  'Postort is required';
    } else {
        $errors['company_postoffice'] =  '';
    }
  
    if ($company_country == '') {
        $errors['company_country'] =  'Land is required';
    } else {
        $errors['company_country'] =  '';
    }
  
    if ($errors['name'] == '' && $errors['email'] == '' && $errors['company_name'] == ''
        && $errors['company_number'] == '' && $errors['company_address'] == ''
        && $errors['company_postnumber'] == '' && $errors['company_postoffice'] == ''
        && $errors['company_country'] == '') {
            $("#error-step-2-0").html('');
            $("#error-step-2-1").html('');
            $("#error-step-2-5").html('');
            $("#error-step-2-6").html('');
            $("#error-step-2-7").html('');
            $("#error-step-2-8").html('');
            $("#error-step-2-9").html('');
            $("#error-step-2-10").html('');
            $.ajax({
                type:'GET',
                url:"/api/checkEmailExists",
                dataType : "json",
                data : {
                    email : $email
                },
                success : function(data) {
                    if (data && data["status"]) {
                        $("#error-step-2-1").html(data["message"]);
                    } else {
                        $('#button-step2').parents('.content-box').next().show().prev().hide();
                    }
                }
            });
    } else {
        $("#error-step-2-0").html($errors['name']).css('color','red');
        $("#error-step-2-1").html($errors['email']).css('color','red');
        $("#error-step-2-5").html($errors['company_name']).css('color','red');
        $("#error-step-2-6").html($errors['company_number']).css('color','red');
        $("#error-step-2-7").html($errors['company_address']).css('color','red');
        $("#error-step-2-8").html($errors['company_postnumber']).css('color','red');
        $("#error-step-2-9").html($errors['company_postoffice']).css('color','red');
        $("#error-step-2-10").html($errors['company_country']).css('color','red');
    }
  });
  
  $(document).on("click","#button-step3", function(event) {
    event.preventDefault();
    $phone_number = $(".form-register02 input[name='phone_number']").val();
    $linked_in    = $(".form-register02 input[name='linked_in']").val();
    $password = $(".form-register02 input[name='password']").val();
    $confirm_password = $(".form-register02 input[name='password_confirmation']").val();
    $title =  $(".form-register02 input[name='title']").val();
    $error = [];
    if ($phone_number != '') {
        if ($phone_number.length > 6 && $phone_number.length < 15) {
            $error['phone_number'] = '';
        } else {
            $error['phone_number'] = 'Telefonnummer must contain 6 - 15 numbers';
        }
    } else {
        $error['phone_number'] = 'Telefonnummer is required';
    }

    if ($password == '') {
        $error['password'] = 'Password is required';
    } else {
        if ($password.length < 8) {
            $error['password'] = 'Password greater than 8 characters';
        } else {
            $error['password'] = '';
        }
    }

    if ($confirm_password == '') {
        $error['confirm_password'] = 'Confirm Password is required';
    } else {
        if ($password != $confirm_password) {
            $error['confirm_password'] = 'The passwords you entered do not match.';
        } else {
            $error['confirm_password'] = '';
        }
    }

    if ($title == '') {
        $error['title'] =  'Titel is required';
    } else {
        $error['title'] =  '';
    }

    if ($linked_in == '') {
        $error['linked_in'] = 'Linkedin is required';
    } else {
        if ($linked_in.substring(0, 5) != "https") {
            $error['linked_in'] = 'Please input https format';
        } else {
            $error['linked_in'] = '';
        }
    }
    if ($error['phone_number'] == '' && $error['linked_in'] == '' && $error['password'] == ''
        && $error['confirm_password'] == '' && $error['title'] == '') {
        $('#error-step-3-1').html('');
        $('#error-step-3-2').html('');
        $("#error-step-2-4").html('');
        $("#error-step-2-2").html('');
        $("#error-step-2-3").html('');
        $.ajax({
            type:'POST',
            url:"/api/registration",
            dataType : "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                employee : $('#register-submit').serialize(),
            },
            success : function(data) {
                if (data.status == true) {
                    $("#button-step3").parents('.content-box').next().show().prev().hide();
                } else {
                  $("#message-notify").html('');
                  $html = "<div class='alert alert-danger'><ul style='margin:0px;'>"
                              $.each(data.error, function(index, value) {
                                 $html += "<li>"+ value +"</li>"
                              });
                  $html += "</ul></div>";
                  $("#message-notify").append($html);
                }
            }
        });
    } else {
        $('#error-step-3-1').html($error['phone_number']).css('color','red');
        $('#error-step-3-2').html($error['linked_in']).css('color','red');
        $("#error-step-2-2").html($error['password']).css('color','red');
        $("#error-step-2-3").html($error['confirm_password']).css('color','red');
        $("#error-step-2-4").html($error['title']).css('color','red');
    }
  }); 
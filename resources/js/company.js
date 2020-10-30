$(document).ready(function() {
  
  $("input[name='phone_number']").on('input', function () {
      if (this.value == '') {
        $html = "Telefonnummer is required";
      } else {
        var valueInput = this.value.replace(/[a-zA-Zươ&\/\\#,+()$~%.'":*?<>{}]/g, "");
  
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
      $(this).next().html($html);
  });

  $("input[name='linked_in']").on('keyup', function () {
      $linkin = $(this).val();
  
      if ($linkin != '') {
        if ($linkin.substring(0, 5) != "https") {
          $('#error-step-3-2').html('Please input https format');
        } else {
          $('#error-step-3-2').html('');
        }
      } else {
        $('#error-step-3-2').html('Linkedin is required');
      }
    });

  // manager User;
  $(document).on('click', '#active-user', function(event) {
      event.preventDefault();
      $arr_check = [];
      $("input:checkbox[name=user_check]:checked").each(function() {
        $arr_check.push($(this).val());
      });
      if ($arr_check.length > 0) {
          $.ajax({
            url : '/user/activeUser',
            type : 'POST',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
              arr_check : $arr_check
            },
            success: function(data) {
              if (data.status) {
                $html = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${data.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                $('#message-success').html($html);
                $active = '<p style="color:#0070ff;"> Active</p>';
                $("input:checkbox[name=user_check]:checked").each(function() {
                  console.log($(this).parents('tr').find('td:nth-child(3)'));
                  $(this).parents('tr').find('td.user_actve').html($active);
                  $(this).prop('checked',false);
                });

              } else {
                $html = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${data.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                $('#message-success').html($html);
              }
            }
          });
      } else {
        $html = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
               Please choose user
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>`;
        $('#message-success').html($html);
      }
  });
  $(document).on('click', '#inactive-user', function(event) {
    event.preventDefault();
    $arr_check = [];
    $("input:checkbox[name=user_check]:checked").each(function() {
      $arr_check.push($(this).val());
    });
    if ($arr_check.length > 0) {
        $.ajax({
          url : '/user/inactiveUser',
          type : 'POST',
          dataType: "json",
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            arr_check : $arr_check
          },
          success: function(data) {
            if (data.status) {
              $html = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                              ${data.message}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>`;
              $('#message-success').html($html);
              $inactive = ' <p style="color:#ff2a00;"> InActive</p>';
              $("input:checkbox[name=user_check]:checked").each(function() {
                $(this).parents('tr').find('td.user_actve').html($inactive);
                $(this).prop('checked',false);
              });
            } else {
              $html = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                              ${data.message}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>`;
              $('#message-success').html($html);
            }
          }
        });
    } else {
      $html = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
             Please choose user
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>`;
      $('#message-success').html($html);
    }
  });
  $(document).on('click', '#table-show-delete-user .pagination .page-item a', function(event){
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data(page);
   });
   function fetch_data(page) {
    $.ajax({
      type : 'GET',
      url  : '/user/showDeleteUser?page='+page,
      dataType: "json",
      success : function(data) {
        if (data.status) {
          $('#table-show-user').hide();
          $('#table-show-delete-user').show();
          $("#dropdownMenuButton").hide();
          $('.show-table').find('#table-show-delete-user').html(data.message);
        }
      }
    });
   }
  $(document).on('click', '#show-delete', function() {
      var checkbox = $("input:checkbox[name='show-delete']");
      if (checkbox.is(':checked')) {
        var page = 1;
        fetch_data(page);
      } else {
        $("#dropdownMenuButton").show();
        $('#table-show-user').show();
        $('#table-show-delete-user').hide();
      }
  });
  $(document).on('click', '#btn-delete', function() {
    $name = $(this).data('html');
    $id   = $(this).data('id');
    $('#user-name').html($name);
    $('#user_id').val($id);;
    $("#confirm-delete-user").modal('show');
  });
  $(document).on('click', "#submit-delete", function() {
      $("#submit-form-deleteUser").submit();
  });
  $(document).on('click', '#open-modal-invite', function() {
      $('#modal-invite').find("input[name='email']").val('');
      $('#message-success').html('');
      $('#message-error').html('');
      $('#modal-invite').modal('show');
  });
  function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }
  $(document).on('click','#submit-send-mail', function() {
      $(this).parents('#modal-invite').find('#message-error').html('');
      $email = $(this).parents('#modal-invite').find("input[name='email']").val();
      $role  =  $(this).parents('#modal-invite').find("#invite-role").val();
      if ($email != '') {
        if (validateEmail($email)) {
          $.ajax({
            type: "POST",
            url: "/user/email",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
              email : $email,
              role  : $role
            },
            success : function(data) {
                var message = data.message;
                if (data.status) {
                    $html = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    ${message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`;
                    $('#message-success').html($html);
                    $('#modal-invite').modal('hide');
                } else {
                  $('#message-error').html('');
                  $html = "<div class='alert alert-danger'><ul style='margin:0px;'>"
                  $.each(message, function(index, value) {
                                $html += "<li>"+ value +"</li>"
                              });
                  $html += "</ul></div>";
                  $('#message-error').append($html); 
                }
            }
          });
        } else {
          $html = `<div class="alert alert-danger">
                    The Email must be a valid Email address.
                  </div>`;
              $('#message-error').html($html);
        }
      } else {
          $html = `<div class="alert alert-danger">
                      Email is required
                  </div>`;
              $('#message-error').html($html);
      }
  });

  var tagArr = [];
  $('.form-tags').find('ul li').each(function (index, item) {
    tagArr.push($(item).attr('data-html'));
  });

  $(document).on('change', '#tags', function () {
      var value = $(this).val();
      
      if (value != '') {
        if (tagArr.indexOf(value) == -1) {
          tagArr.push(value);
          var html_output = `  <li data-html=`+ value +`><span>`+ value +`</span> <i class="fa fa-times"></i></li>`;
          $('.form-tags').find('ul').append(html_output);
        }
      }
  });
  $(document).on("click", ".form-tags ul li", function () {
      var value = $(this).data('html');
      tagArr.splice(tagArr.indexOf(value.toString()), 1);
      $(this).remove();
  });

  var domainArr = [];
  $('.form-domains').find('ul li').each(function (index, item) {
    domainArr.push($(item).attr('data-html'));
  });

  var addDomain = function () {
    var value = $('input[name="domains[]"]').val();

    if (value != '') {
      if (domainArr.indexOf(value) == -1) {
        domainArr.push(value);
        var html_output = `  <li data-html=`+ value +`><span>`+ value +`</span> <i class="fa fa-times"></i></li>`;
        $('.form-domains').find('ul').append(html_output);
        $('input[name="domains[]"]').val('');
      }
    }
  }
  $("#domains").keypress(function(event) {
    $keyCode = event.which | event.keyCode;
    if ($keyCode == 13) {
      event.preventDefault();
      addDomain();
    }
  });

  $(document).on('click', '.btn-add', addDomain);
  $(document).on("click", ".form-domains ul li", function () {
      var value = $(this).data('html');
      domainArr.splice(domainArr.indexOf(value.toString()), 1);
      $(this).remove();
  });

  if($('input[name="check_e_invoice"]').is(":checked")) {
    $('.e-invoice').hide();
  } else {
    $('.e-invoice').show();
  }

  $(document).on('change', 'input[name="check_e_invoice"]', function () {
    if($(this).is(":checked")) {
      $('.e-invoice').hide();
    } else {
      $('.e-invoice').show();
    }
  }); 

  var displayAddress = function () {
    $('.checkbox-address').each(function (index, item) {
      if('checkbox_invoice_address' == $(item).attr('name')) {
        if($(item).is(':checked')) {
          $(item).val(true);
          $('.invoice-address').hide();
        } else {
          $(item).val(false);
          $('.invoice-address').show();
        }
      } else {
        if($(item).is(':checked')) {
          $(item).val(true);
          $('.visiting-address').hide();
        } else {
          $(item).val(false);
          $('.visiting-address').show();
        }
      }
    })
  }
  displayAddress();

  $(document).on('change', '.checkbox-address', function() {
    var check = 0;
    $('.checkbox-address').each(function (index, item) {
      if($(item).is(':checked')) {
        check ++;
      }
    }) 
    if(!$(this).is(':checked') && check < 1) {
      $(this).prop('checked', true);
    }

    displayAddress();
  });

  $(document).on('click', '.btn-submit', function() {
    if($('.invoice-address').is(':hidden')) {
      $('.invoice-address').find('input').each(function(index, item) {
        $(item).removeClass('form-control');
        $(item).prop('required',false);
      })
    }
    if($('.visiting-address').is(':hidden')) {
      $('.visiting-address').find('input').each(function(index, item) {
        $(item).removeClass('form-control');
        $(item).prop('required',false);
      })
    }
    $('input[name="domain_list"]').val(domainArr);
    $('input[name="tag_list"]').val(tagArr);
  })

});
$(document).ready(function() {
    $(document).on('click', '#accordion .panel-title', function() {
       $(this).toggleClass('changeIcon');
    });
    
    $(document).on('click', '#accordion-right .panel-title', function() {
        $(this).toggleClass('changeIcon');
     });
     
      $(document).on('click',"#read-more", function() {
        $length  = $('#list-company li').length;
         $("#list-company li:hidden").slice(0,$length).show();
         if ($('#list-company li').length == $('#list-company li:visible').length) {
            $html = '<a href="javascript:void(0)" id="show-less" class="link-text">Show less</a>';
            $('.box-list').append($html);
            $(this).hide();
         }
      });

      $(document).on('click', '#show-less' , function() {
         $('#list-company li').slice(6).hide();
         $html = '<a href="javascript:void(0)" id="read-more" class="link-text">Läs mer</a>';
         $('.box-list').append($html);
         $(this).hide();
      });
      function validateEmail(email) {
         var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
         return re.test(email);
       }
      $(document).on('click', "#btn-apply", function(event) {
         event.preventDefault();
         $val = $(this).parents('#edit-info-user').find("input[name='email']").val();
         if ($val == '') {
            $html = 'The Email field is required.';
            $("#error-email").html($html).css("color","#ff0000");
         } else {
            if (validateEmail($val)) {
               $.ajax({
                  type : 'POST',
                  url  : '/home/setCodeVerify',
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  data : {
                     email : $val
                  },
                  success : function(data) {
                     if (data.status) {
                        $("#message-email").html('');
                        $("#error-email").html('');
                        $html = `<i class="fa fa-check mail-check" aria-hidden="true"></i>
                                 <small class="form-text text-muted" style="font-size: 14px;">An email with a verification code was just sent to
                                 </small>
                                 <p  style="font-size: 14px; color: #0070ff;" >`+ data.email +`</p>`;
                        $("#error-email").append($html);
                        $("#code-verify").show();
                        $("#btn-apply").remove();
                        $("#submit-change-email").show();
                     } else {
                        $("#error-email").html('');
                        $html = `<p style="color: rgb(255, 0, 0); margin: 5px 0px 0px;">${data.error}</p>`;
                        $("#error-email").append($html);
                     }
                  }
               });
            } else {
               $html = 'The Email must be a valid Email address.';
               $("#error-email").html($html).css("color","#ff0000");
            }
         }
      });

      $(document).on('click', '#submit-change-email', function(event) {
         event.preventDefault();
         $email = $(this).parents('.modal-content').find("input[name='email']").val();
         $code  = $(this).parents('.modal-content').find("input[name='code']").val();
         $.ajax({
            type : 'POST',
            url  : '/home/chanegEmail',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
               email : $email,
               code  : $code
            },
            success : function (data) {
               if (data.status) {
                  $("#message-email").html('');
                  $html = `<div class='alert alert-success'>
                           ${data.message}   
                        </div>`;
                  $("#message-email").append($html);
                  $("#edit-info-user").modal('hide');
                  $("form#form-change-mail")[0].reset();
                  location.reload();
               } else {
                  $("#message-email").html('');
                  $html = "<div class='alert alert-danger'><ul style='margin:0px;'>"
                              $.each(data.error, function(index, value) {
                                 $html += "<li>"+ value +"</li>"
                              });
                  $html += "</ul></div>";
                  $("#message-email").append($html);
               }
            }
         })
      });


      $(document).on('click','#edit-profile', function() {
        $.ajax({
            url : '/home/updateUser',
            type : 'POST',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
               edit_user : $('#form-edit-profile').serialize()
            },
            success : function(data) {
               if (data.status) {
                  $('#edit-information').modal('hide');
                  location.reload();
               } else {
                  $("#message-profile").html('');
                  $html = "<div class='alert alert-danger'><ul style='margin:0px;'>"
                              $.each(data.error, function(index, value) {
                                 $html += "<li>"+ value +"</li>"
                              });
                  $html += "</ul></div>";
                  $("#message-profile").append($html);
               }
            }
        });
      });   
      $(document).on('click', '#open-change-password', function() {
            $("#modal-change-password").modal('show');
            $("#modal-change-password").find('form#form-change-password')[0].reset();
            $("#message").html('');
      });
      $(document).on('click','#edit-password', function() {
         $.ajax({
            type : 'POST',
            url : '/home/changePassword',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
               password : $('#form-change-password').serialize()
            },
            success : function(data) {
               if (data.status) {
                  $("#message").html('');
                  $html = `<div class="alert alert-primary" role="alert">
                     ${data.message}
                  </div>`;
                  $("#message").append($html);
                  $("#modal-change-password").modal('hide');
               } else {
                  $("#message").html('');
                  $html = "<div class='alert alert-danger'><ul style='margin:0px;'>"
                              $.each(data.error, function(index, value) {
                                 $html += "<li>"+ value +"</li>"
                              });
                  $html += "</ul></div>";
                  $("#message").append($html);
               }
            }
         });
      });
      $("input[name='linked_in']").on('keyup', function () {
         $linkin = $(this).val();
         if ($linkin != '') {
           if ($linkin.substring(0, 5) != "https") {
             $('#error-link').html('Please input https format').css('color', 'red');
           } else {
             $('#error-link').html('');
           }
         } else {
           $('#error-link').html('Linkedinprofil is required').css('color', 'red');
         }
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
     $("input[name='name']").on("input", function() {
         var value = $(this).val();
         if (value == '') {
            $html = "Namn is required";
         } else {
            $html = '';
         }
         $(this).next().html($html).css('color', '#ff0000');
      });
      $("input[name='job_title']").on("input", function() {
         var value = $(this).val();
         if (value == '') {
            $html = "Yrkestitel is required";
         } else {
            $html = '';
         }
         $(this).next().html($html).css('color', '#ff0000');
      });
      $("input[name='email']").on("input", function() {
         var value = $(this).val();
         if (value == '') {
            $html = "The Email field is required.";
         } else {
            $html = '';
         }
         $(this).next().html($html).css('color', '#ff0000');
      });
});
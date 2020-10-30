let ProfileController = {
    initScrollEvent: function () {
        // Cache selectors
        let lastId,
            topMenu = $("#menu_profile"),
            topMenuHeight = topMenu.outerHeight() + 83,
            // All list items
            menuItems = topMenu.find("a"),
            // Anchors corresponding to menu items
            scrollItems = menuItems.map(function () {
                let item = $($(this).attr("href"));
                if (item.length) {
                    return item;
                }
            });

        // Bind click handler to menu items
        // so we can get a fancy scroll animation
        menuItems.click(function (e) {
            let href = $(this).attr("href"),
                offsetTop = href === "#" ? 0 : $(href).offset().top;
            $('html, body').stop().animate({
                scrollTop: offsetTop
            }, 300);
            e.preventDefault();
        });

        // Bind to scroll
        $(window).scroll(function () {
            // Get container scroll position
            let fromTop = $(this).scrollTop() + topMenuHeight;

            // pin menu to top
            if($(this).scrollTop() >= 114) {
                $('#menu_profile').css('top', '10px').css('position', 'fixed');
            }else {
                $('#menu_profile').removeAttr('style');
            }

            // Get id of current scroll item
            let cur = scrollItems.map(function () {
                if ($(this).offset().top < fromTop) {
                    return this;
                }
            });
            // Get the id of the current element
            cur = cur[cur.length - 1];
            let id = cur && cur.length ? cur[0].id : "";

            if (lastId !== id) {
                lastId = id;
                // Set/remove active class
                menuItems
                    .parent().removeClass("active")
                    .end().filter("[href='#" + id + "']").parent().addClass("active");
            }
        });
    },

    initButtonEvent: function() {
        $('.btn-edit').click(function() {
            if($('#accepted_term').val() == '0'){
                $('#accepted_term_checkbox').focus();
                $('#accepted_term_checkbox').closest('.form-check').find('.help-block').removeClass('d-none');
                return;
            }
            let $form = $(this).closest('form');
            $form.find('label.form-control').hide();
            $form.find('input[type="text"]').fadeIn(1000);
            $form.find('input[type="number"]').fadeIn(1000);
            $form.find('input[type="email"]').fadeIn(1000);
            $form.find('.btn-group-toggle label').removeClass('disabled');
            $form.find('input[type="radio"]').prop('disabled', false);
            $form.find('button.btn-save').removeClass('hidden');
            $form.find('button.btn-cancel').removeClass('hidden');
            $form.find('button.btn-save').fadeIn(1000);
            $form.find('button.btn-cancel').fadeIn(1000);
            $form.find('button.btn-edit').hide();
        });

        $('.btn-cancel').click(function() {
            let $form = $(this).closest('form');
            $form.find('label.form-control').fadeIn(1000);
            $form.find('input[type="text"]').hide();
            $form.find('input[type="number"]').hide();
            $form.find('input[type="email"]').hide();
            $form.find('.btn-group-toggle label').addClass('disabled');
            $form.find('input[type="radio"]').prop('disabled', true);
            $form.find('button.btn-save').hide();
            $form.find('button.btn-cancel').hide();
            $form.find('button.btn-edit').fadeIn(1000);
            // Remove error msg
            $form.find('.with-errors').html('');
            $form.find('.has-error').removeClass('has-error has-danger');
        });
    },

    initRadioEvent: function() {
      let radio_name = "input[name='use_different_invoice']";
      let $radio =  $(radio_name);
      // Handle clicked event
      $('label.btn.btn-outline-dark').click(function() {
          // Fix bug: add .active class for disabled
          if($radio.prop('disabled')) {
              let _parent = $(radio_name + ":checked").closest('.btn.disabled');
              _parent.addClass('active');
              return false;
          }
      });

      // Handle on change event
      $radio.change(function() {
          let checked = parseInt($(radio_name + ":checked").val());
          onOfInvoiceAddress(checked);
      });

      // Default get state first load
      let checked = parseInt($(radio_name + ":checked").val());
      onOfInvoiceAddress(checked);

      function onOfInvoiceAddress(flag) {
          let $invoiceSettings = $('#invoice_settings');
          if (flag == 1) {
              $invoiceSettings.find('input:not([name="invoice_address_line2"])').attr('required', 'required');
              $invoiceSettings.fadeIn(1000);
          } else {
              $invoiceSettings.find('input').removeAttr('required');
              $invoiceSettings.hide();
          }
      };
    },

    initCheckboxTerms: function() {
        $('#accepted_term_checkbox').click(function() {
            $('#accepted_term').val($(this).prop('checked') ? 1 : 0);
            if($(this).prop('checked')){
                $(this).closest('.form-check').find('.help-block').addClass('d-none');
            }else {
                $(this).closest('.form-check').find('.help-block').removeClass('d-none');
            }
        });
    },

    printErrorMsg: function(type, msg) {
        let className = '.print-error-msg-' + type;
        $(className).find("ul").html('');
        $(className).css('display','block');
        $.each( msg, function( key, value ) {
            $(className).find("ul").append('<li>'+value+'</li>');
        });
    },

    switchToView: function (type) {
        let object = null;
        if (type == 'profile') {
            object = $('#frmProfile');
        }else {
            // Checked use diff invoice address
            if($('#frmCompany').find("input[name='use_different_invoice']:checked").val() == 1) {
                object = $('#frmCompany');
            }else {
                object = $('#company_settings');
            }
        }

        ProfileController.buildOjbects(object);
    },

    buildOjbects: function($object) {
        let txtInputs = $object.find('input[type="text"]:not([readonly])');
        let txtInputsReadonly = $object.find('input[type="text"][readonly]');
        let numInputs = $object.find('input[type="number"]');

        ProfileController.setToView(txtInputs);
        ProfileController.setToView(txtInputsReadonly, 'readonly');
        ProfileController.setToView(numInputs);

        // Radio box
        $('.btn-group.btn-group-toggle label').addClass('disabled');
        $('.btn-group.btn-group-toggle input[type="radio"]').prop('disabled', true);
    },

    setToView: function (inputs, type) {
        for (let i = 0; i < inputs.length; i++) {
            let _input = $(inputs[i]);
            let _input_name = type !== 'readonly' ? _input.attr('name') : _input.attr('data-name'); // get name attr of input
            _input.hide();
            // Set user name to header
            if (_input_name == 'full_name') {
                $('.container.header .fullname').html(_input.val());
            }
            $('label[data-for="'+_input_name+'"]').html(_input.val()).fadeIn(1000);
        }
    }
};

$(document).ready(function () {
    ProfileController.initScrollEvent();

    // Init checkbox terms and conditions
    ProfileController.initCheckboxTerms();

    // Init button event
    ProfileController.initButtonEvent();

    // Init radio event YES/ NO
    ProfileController.initRadioEvent();

    // Save event
    $('#frmProfile, #frmCompany').submit(function (e) {
        let term = $('#accepted_term').val();
        if (term != 1) {
            $('#accepted_term_checkbox').focus();
            $('#accepted_term_checkbox').closest('.form-check').find('.help-block').removeClass('d-none');
            e.preventDefault();
            return false;
        }

        let id = $(this)[0].id;
        let type = id == 'frmProfile' ? 'profile' : 'company';
        var data = $(this).serialize();
        data = data + '&action=save_profile&term=' + term + '&type=' + type;
            
        $.ajax({
            url: profile_params.ajaxurl,
            data: data,
            type: 'POST',
            beforeSend: function( xhr ){
            },
            success:function(response){
                if(response) {
                    let title = type == 'profile' ? 'Profile Settings' : 'Company Settings';
                    let parent = type == 'profile' ? '#frmProfile' : '#frmCompany';
                    let $modal = $('#msgModal');
                    let $msg = 'The ' + title + ' was updated successfully!';
                    $modal.find('.modal-body').html($msg);
                    $modal.modal({
                        keyboard: false
                    });

                    $('.print-error-msg-' + type).hide();
                    $('#form_check_term').hide();
                    $('#profile_settings .header').css('padding-top', 0).css('margin-top', '5px');
                    // Hidden button
                    $(parent).find('.btn-save').hide();
                    $(parent).find('.btn-cancel').hide();
                    $(parent).find('.btn-edit').fadeIn(1000);
                    // Switch HTML view
                    ProfileController.switchToView(type);
                } else {
                    ProfileController.printErrorMsg(type, response.error);
                }
            },
            error: function onError(error) {
                console.log(error);
            },
        });

        // stop the form from submitting the normal way and refreshing the page
        e.preventDefault();
    });
});
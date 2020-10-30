/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/register.js":
/*!**********************************!*\
  !*** ./resources/js/register.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var resultArr = [];
  $("#tags").keypress(function (event) {
    $keyCode = event.which | event.keyCode;

    if ($keyCode == 13) {
      event.preventDefault();
      $value = $(this).val();

      if ($value != '') {
        if (resultArr.indexOf($value.toLowerCase()) == -1) {
          resultArr.push($value.toLowerCase());
          $html_output = "<li>\n                                    <div class=\"list-tagger\" data-html=" + $value.toLowerCase() + ">\n                                        <h4>" + $value.toUpperCase() + "<span><img src='../images/x.png' alt=\"\"></span></h4>\n                                    </div> \n                                    <input type=\"hidden\" name=\"tags\" value=" + $value.toLowerCase() + " /> \n                                </li>";
          $('.result-taggar').find('ul').append($html_output);
          $(this).val('');
        }
      }
    }
  });
  $(document).on("click", ".list-tagger h4", function () {
    var value = $(this).parent().data('html');
    resultArr.splice(resultArr.indexOf(value.toString().toLowerCase()), 1);
    $(this).parents('ul li').remove();
  });
  $('#slider').slider({
    min: 0,
    max: 100,
    animate: true,
    slide: function slide(event, ui) {
      $("#experience").val(ui.value);
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
      $('#error-step-3-2').html('');
    }
  });
  $(document).on('click', '.btn-mb-lf', function (event) {
    event.preventDefault();
    $(this).parents('.content-box').prev().show().next().hide();
  });

  function list_company(value) {
    if (value != '') {
      $html = " <li class=\"list-group-item item\">\n                <div class=\"box-item\">\n                    <div class=\"box-top\">\n                        <h5>PublicInsight Holding AB</h5>\n                        <input type=\"radio\" name=\"addresss\" checked>\n                        <span class=\"box-check\"></span>\n                    </div>\n                    <div class=\"box-content\">\n                        <p>\n                        555555-5555 Stockholm <br>\n                        Konsultverksamhet\n                        </p>\n                    </div>\n                </div>\n            </li>";
    } else {
      $html = '';
    }

    $('.list-bm-item').find('.list-group').html($html);
  }

  $(document).on('input', '.form-mb-register', function () {
    var value_company = $(this).val();
    list_company(value_company);
  });
  $(document).on("click", ".btn-mb-login", function (event) {
    event.preventDefault();
    var value_company = $(this).parent().find("input[name='company']").val();
    list_company(value_company);
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
      $('#error-step-2-3').html('');
    }
  });
  $(document).on("click", "#button-submit4", function () {
    $.ajax({
      type: 'POST',
      url: "/api/registration",
      dataType: "json",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        employee: $('#register-submit').serialize()
      },
      success: function success(data) {
        if (data.status == true) {
          $("#button-submit4").parents('.content-box').next().show().prev().hide();
        } else {
          alert("Sign up failed.");
        }
      }
    });
  });
});
$(document).on("click", "#button-step1", function (event) {
  event.preventDefault();
  $value = $(".form-register input[name='company']").val();

  if ($value == '') {
    $('#message-step1').html('This is required').css('color', 'red');
  } else {
    $('#message-step1').html(' ');
    $(this).parents('.content-box').next().show().prev().hide();
  }
});

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

$(document).on("click", "#button-step2", function (event) {
  event.preventDefault();
  $email = $(".form-register02 input[name='email']").val();
  $password = $(".form-register02 input[name='password']").val();
  $confirm_password = $(".form-register02 input[name='password_confirmation']").val();
  $errors = [];

  if ($email == '') {
    $errors['email'] = 'E-posts is required';
  } else {
    if (validateEmail($email)) {
      $errors['email'] = '';
    } else {
      $errors['email'] = 'This is not a valid email';
    }
  }

  if ($password == '') {
    $errors['password'] = 'Password is required';
  } else {
    if ($password.length < 6) {
      $errors['password'] = 'Password greater than 6 characters';
    } else {
      $errors['password'] = '';
    }
  }

  if ($confirm_password == '') {
    $errors['confirm_password'] = 'Confirm Password is required';
  } else {
    if ($password != $confirm_password) {
      $errors['confirm_password'] = 'The passwords you entered do not match.';
    } else {
      $errors['confirm_password'] = '';
    }
  }

  if ($errors['email'] == '' && $errors['password'] == '' && $errors['confirm_password'] == '') {
    $("#error-step-2-1").html('');
    $("#error-step-2-2").html('');
    $("#error-step-2-3").html('');
    $(this).parents('.content-box').next().show().prev().hide();
  } else {
    $("#error-step-2-1").html($errors['email']).css('color', 'red');
    $("#error-step-2-2").html($errors['password']).css('color', 'red');
    $("#error-step-2-3").html($errors['confirm_password']).css('color', 'red');
  }
});
$(document).on("click", "#button-step3", function (event) {
  event.preventDefault();
  $phone_number = $(".form-register02 input[name='phone_number']").val();
  $linked_in = $(".form-register02 input[name='linked_in']").val();
  $error = [];

  if ($phone_number == '') {
    $error['phone_number'] = 'Telefonnummer is required';
  } else {
    $error['phone_number'] = '';
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

  if ($error['phone_number'] == '' && $error['linked_in'] == '') {
    $('#error-step-3-1').html('');
    $('#error-step-3-2').html('');
    $(this).parents('.content-box').next().show().prev().hide();
  } else {
    $('#error-step-3-1').html($error['phone_number']).css('color', 'red');
    $('#error-step-3-2').html($error['linked_in']).css('color', 'red');
  }
});

/***/ }),

/***/ 1:
/*!****************************************!*\
  !*** multi ./resources/js/register.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/lucas/publicinsightwp/public_cloud/resources/js/register.js */"./resources/js/register.js");


/***/ })

/******/ });
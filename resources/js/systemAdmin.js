$(document).ready(function() {
    $(".verify-company").click(function() {
        var id = $(this).attr("id");
        $.ajax({
            type: "GET",
            url: "/api/company/updateIsVerified",
            dataType: "json",
            data: {
                id: id
            },
            success: function(data) {
                if (data && data.status) {
                    $(this).attr("checked", data.is_verified);
                }
                showModal("Verify Company", data);
            }
        });
    });

    $(document).on("click", ".verify-user", function() {
        var id = $(this)
            .parent("td")
            .parent(".user-row")
            .attr("id");
        $.ajax({
            type: "GET",
            url: "/api/user/updateIsVerified",
            dataType: "json",
            data: {
                id: id
            },
            success: function(data) {
                if (data && data.status) {
                    $(this).attr("checked", data["is_verified"]);
                }
                showModal("Verify User", data);
            }
        });
    });

    $(document).on("click", ".do-move-users", function() {
        var department_id = $(this)
            .parents()
            .find(".department-item.active .select-department")
            .val();
        var old_department = $(this)
            .parents()
            .find(".department-item.active")
            .attr("id");
        var user_id_list = new Array();
        $(".department-item.active .user-row").each(function(index, element) {
            if (
                $(element)
                    .find(".add-user")
                    .is(":checked")
            ) {
                user_id_list.push($(element).attr("id"));
            }
        });
        if (department_id == "") {
            alert("Please select department.");
            return;
        }
        if (user_id_list.length < 1) {
            alert("Please choose user to move.");
            return;
        }
        $.ajax({
            type: "GET",
            url: "/api/company/department/moveUsers",
            dataType: "json",
            data: {
                user_id_list: user_id_list,
                old_department_id: old_department,
                new_department_id: department_id
            },
            success: function(data) {
                if (data && data.status) {
                    $(".tab-content").html(data.view_html);
                }
                showModal("Move users to other department", data);
            }
        });
    });

    $(document).on("click", ".select-items", function() {
        var check = false;
        if (
            $(".table .user-row")
                .find(".add-user")
                .first()
                .is(":checked")
        ) {
            check = true;
        }
        $(".table .user-row").each(function(index, element) {
            if (check) {
                $(element)
                    .find(".add-user")
                    .prop("checked", false);
            } else {
                $(element)
                    .find(".add-user")
                    .prop("checked", true);
            }
        });
    });

    $("input[name='department_name']").on("input", function() {
        var department_name = $(this).val();
        if (department_name != "") {
            $(".btn-submit-department").prop("disabled", false);
        }
    });

    $(".btn-invite-company-admin").click(function() {
        var email = $("#emailCompanyAdmin").val();
        var user_id = $(".user-id").val();
        var department_id = $(".department-item.active").attr("id");
        if(department_id.indexOf('-')) {
            department_id = department_id.split('-')[1];
        }
        $.ajax({
            type: "GET",
            url: "/api/company/department/inviteCompanyAdmin",
            dataType: "json",
            data: {
                email: email,
                department_id: department_id,
                user_id: user_id
            },
            success: function(data) {
                if (data && data.status) {
                    $("#modalInviteUser-" + department_id + " form").append(
                        '<div class="alert alert-success" role="alert">' +
                            data.message +
                            "</div>"
                    );
                } else {
                    $("#modalInviteUser-" + department_id + " form").append(
                        '<div class="alert alert-danger" role="alert">' +
                            data.message +
                            "</div>"
                    );
                }
            }
        });
    });

    var url = document.location.href;
    if (url.indexOf("/company/list") !== -1) {
        $(".manage-companies").css("background-color", "#333333");
    }
    if (url.indexOf("/tag/list") !== -1) {
        $(".manage-tags").css("background-color", "#333333");
    }
    var height = $(document).height();
    $(".sidebar").css("height", height);

    var showModal = function(title, data) {
        $(".show-modal").click();
        $(".modal-title").html(title);
        if (data.status) {
            $(".success-status").show();
            $(".error-status").hide();
            $(".message").html(data.message);
        } else {
            $(".error-status").show();
            $(".success-status").hide();
            $(".message").html(data.message);
        }
    };

    $(document).on("click", ".btn-update-tag", function() {
        var id = $(this).attr("id");
        var name = $("#modalUpdateTag-" + id)
            .find("#tagName")
            .val();
        var is_active = 0;
        if (
            $("#modalUpdateTag-" + id)
                .find("#isActive")
                .is(":checked")
        ) {
            is_active = 1;
        }
        $(this).prop("disabled", true);
        $.ajax({
            type: "GET",
            url: "/api/tag/update",
            dataType: "json",
            data: {
                id: id,
                name: name,
                is_active: is_active
            },
            success: function(data) {
                var parent = $("#modalUpdateTag-" + id).find(".message");
                if (data && data.status) {
                    $(parent)
                        .find(".alert")
                        .addClass("alert-success");
                } else {
                    $(parent)
                        .find(".alert")
                        .addClass("alert-danger");
                }
                $(parent)
                    .find(".alert")
                    .html(data.message);
                $(parent).show();
            }
        });
    });

    $(document).on("click", ".btn-create-tag", function() {
        var name = $("#modalCreateTag")
            .find("#tagName")
            .val();
        $(this).prop("disabled", true);
        $.ajax({
            type: "GET",
            url: "/api/tag/create",
            dataType: "json",
            data: {
                name: name
            },
            success: function(data) {
                $(this).prop("disabled", false);
                var parent = $("#modalCreateTag").find(".message");
                if (data && data.status) {
                    $(parent)
                        .find(".alert")
                        .addClass("alert-success");
                } else {
                    $(parent)
                        .find(".alert")
                        .addClass("alert-danger");
                }
                $(parent)
                    .find(".alert")
                    .html(data.message);
                $(parent).show();
            }
        });
    });

    $(".modal.create-tag").on("hidden.bs.modal", function() {
        window.location.reload();
    });

    $(document).on("click", ".btn-delete-tag", function() {
        var id = $(this)
            .parent("td")
            .find(".object-id")
            .val();
        $('.show-modal[data-target="#notification-modal-' + id + '"]').click();
    });

    $(document).on("click", ".tag-table #submit-delete", function() {
        var id = $(this)
            .parent(".delete-object")
            .find(".object-id")
            .val();
        $.ajax({
            type: "GET",
            url: "/api/tag/delete",
            dataType: "json",
            data: {
                id: id
            },
            success: function(data) {
                var parent = $("#notification-modal-" + id).find(".message");
                if (data && data.status) {
                    $(parent).addClass("alert alert-success");
                } else {
                    $(parent).addClass("alert alert-danger");
                }
                $(parent).html(data.message);
            }
        });
    });

    $(document).on("click", ".btn-update-cpv", function() {
        var company_id = $(".company-departments").attr("id");
        var newCpv = $("#companyCpvCode").val();
        $.ajax({
            type: "GET",
            url: "/api/company/updateCPVCode",
            dataType: "json",
            data: {
                company_id: company_id,
                newCpv: newCpv
            },
            success: function(data) {
                showModal("Update CPV Code", data);
            }
        });
    });

    $(document).on("click", ".btn-search-company", function() {
        var company_number = $("#companyNumber").val();
        $.ajax({
            type: "GET",
            url: "/api/company/getCompaniesData",
            dataType: "json",
            data: {
                company_number: company_number
            },
            beforeSend: function() {
                $(".company-info").hide();
                $('input[name="company_number"]').val("");
                $('input[name="company_name"]').val("");
                $('input[name="company_email"]').val("");
                $('input[name="company_phone"]').val("");
                $('input[name="address_line1"]').val("");
                $('input[name="post_code"]').val("");
                $('input[name="city"]').val("");
                $('input[name="country"]').val("");
            },
            success: function(response) {
                if (response && response.status) {
                    element = response.data;
                    $(".create-company .alert").hide();
                    $(".company-info").show();
                    $('input[name="company_number"]').val(element.ORGNR);
                    $('input[name="company_name"]').val(element.NAME);
                    var email =
                        typeof element.EMAIL_ADRESS === "object"
                            ? ""
                            : element.EMAIL_ADRESS;
                    $('input[name="company_email"]').val(email);
                    $('input[name="company_phone"]').val(element.TELEPHONE);
                    $('input[name="address_line1"]').val(element.ADDRESS);
                    $('input[name="post_code"]').val(element.ZIPCODE);
                    $('input[name="city"]').val(element.TOWN);
                    $('input[name="country"]').val("Sweden");
                } else {
                    $(".create-company .alert").show();
                    $(".create-company .alert").html(response.error);
                }
            }
        });
    });

    $(".btn-add-consultant").click(function() {
        var email = $("#emailConsultant").val();
        var user_name = $("#userNameConsultant").val();
        var password = $("#passwordConsultant").val();
        var department_id = $(".department-item.active").attr("id");
        if(department_id.indexOf('-')) {
            department_id = department_id.split('-')[1];
        }
        $.ajax({
            type: "GET",
            url: "/api/company/addConsultant",
            dataType: "json",
            data: {
                email: email,
                user_name: user_name,
                password: password,
                department_id: department_id
            },
            success: function(data) {
                if (data && data.status) {
                    $("#modalAddConsultantUser form").append(
                        '<div class="alert alert-success" role="alert">' +
                            data.message +
                            "</div>"
                    );
                } else {
                    $("#modalAddConsultantUser form").append(
                        '<div class="alert alert-danger" role="alert">' +
                            data.message +
                            "</div>"
                    );
                }
            }
        });
    });
    $("#modalAddConsultantUser").on("hidden.bs.modal", function() {
        window.location.reload();
    });

});

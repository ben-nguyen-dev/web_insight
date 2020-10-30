window.NewsflowController = {
    initCopyEvent: function() {
        let checkClicked = 0;
        $(".full-view, .full-view-details, .popup-quick-view")
            .find("#direct_link")
            .on("click", function() {
                let $parentGroup = $(this).closest(".socials");
                let $sharelink = $parentGroup.find(".direct-link");
                if (checkClicked == 0) {
                    $sharelink.addClass("d-flex");
                    $sharelink.find("button").on("click", function() {
                        let ele = $sharelink.find("input");
                        ele.select();
                        document.execCommand("copy");
                        $(this).html("Copied");
                    });
                    checkClicked = 1;
                } else {
                    $sharelink.removeClass("d-flex");
                    $sharelink.find("button").html("Copy");
                    checkClicked = 0;
                }
            });
    },
    initRequestDepthAnalysis: function() {
        let depth_analysis = $(".box3-left .depth-analysis");
        let form = $(depth_analysis).find(".request-depth-analysis");
        let btnSubmit = $(depth_analysis).find(".btn-send-request");
        let result = $(depth_analysis).find(".result");
        let postId = $(depth_analysis)
            .find('input[name="postId"]')
            .val();

        btnSubmit.click(function() {
            form.hide();
            result.hide();

            var data = {
                action: "request_depth_analysis",
                postId: postId ?? "",
                requestMessage: $(depth_analysis).find(".request-message").val()
            };

            $.ajax({
                url: newsflow_params.ajaxurl,
                data: data,
                type: "POST",
                beforeSend: function(xhr) {},
                success: function(response) {
                    if (response) {
                        console.log(response);
                        result.show();
                    }
                },
                error: function onError(error) {
                    console.log(error);
                }
            });
        });
    },

    initFeedback: function() {
        let feedback = $(".function-for-article .form-feedback");
        let $form = $(feedback).find("form");
        let $postIdInput = $(feedback).find('input[name="postId"]');
        let $emailInput = $(feedback).find('input[name="email"]');
        let $messageInput = $(feedback).find("textarea");
        let $btnSubmit = $(feedback).find("button");
        let $loading = $(feedback).find("p#loading");
        let $result = $(feedback).find("p#send_feedback_result");
        $btnSubmit.click(function() {
            $form.hide();
            $result.hide();
            $loading.show();

            var data = {
                action: "init_feedback",
                postId: $postIdInput.val(),
                email: $emailInput.val(),
                message: $messageInput.val()
            };

            $.ajax({
                url: newsflow_params.ajaxurl,
                data: data,
                type: "POST",
                beforeSend: function(xhr) {},
                success: function(result) {
                    if (result) {
                        $result.text("Thank you for your feedback.");
                    }
                },
                error: function onError(error) {
                    console.log(error);
                    $form.show();
                    $result.text(error.responseJSON.message);
                },
                complete: function complete() {
                    $loading.hide();
                    $result.show();
                }
            });
        });
    },

    init: function() {
        this.initCopyEvent();
        this.initRequestDepthAnalysis();
        this.initFeedback();
    }
};
$(document).ready(function() {
    NewsflowController.init();

    $(".box-5 .multiple-items").slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 867,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $(".box3-right p").each(function() {
        if (!$(this).find("img").length) {
            $(this).css("padding", "0px 15px");
        }
    });
    if (jQuery("body").hasClass("logged-in")) {
        $(".btn-loggin").hide();
    }
    $("#menu-open").click(function(event) {
        event.preventDefault();
        $(this).toggleClass('active-menu');
        $(this).parents('.navbar').toggleClass('max-wd');
        if ($(this).is(".active-menu")) {
            $(this).find('a').html('Stäng');
            $(this).prev().hide();
        } else {
            $(this).find('a').html('meny');
            $(this).prev().show();
        }
        $(this).parents('#header').find('.menu-top').fadeToggle();
        $(this).parents('#header').find('.menu-bottom-mb').fadeToggle();
        $(this).parents('#header').find('.menu-bottom-mb .row').toggleClass('menu-wd');
    });
});

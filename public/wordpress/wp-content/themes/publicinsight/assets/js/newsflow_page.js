window.NewsflowController = {
    initCopyEvent: function () {
        let checkClicked = 0;
        $('.full-view, .full-view-details, .popup-quick-view').find('#direct_link').on('click', function () {
            let $parentGroup = $(this).closest('.socials');
            let $sharelink = $parentGroup.find('.direct-link');
            if (checkClicked == 0) {
                $sharelink.addClass('d-flex');
                $sharelink.find('button').on('click', function () {
                    let ele = $sharelink.find('input');
                    ele.select();
                    document.execCommand('copy');
                    $(this).html('Copied');
                });
                checkClicked = 1;
            } else {
                $sharelink.removeClass('d-flex');
                $sharelink.find('button').html('Copy');
                checkClicked = 0;
            }
        });
    },
    initRequestDepthAnalysis: function () {
        let $li = $('.full-view, .full-view-details, .popup-quick-view').find('#request_depth_analysis');
        $li.each(function () {
            let $form = $(this).find('form');
            let $postId = $(this).find('input[name="postId"]').val();
            let $btnCancel = $(this).find('button[name="btnCancel"]');
            let $btnSubmit = $(this).find('button[name="btnSubmit"]');
            let $loading = $(this).find('p#loading');
            let $result = $(this).find('p#request_depth_analysis_result');

            $btnCancel.click(function () {
                $form.hide();
                $loading.hide();
                $result.show();
            });

            $btnSubmit.click(function () {
                $form.hide();
                $result.hide();
                $loading.show();

                var data = {
                    'action': 'request_depth_analysis',
                    'postId': $postId ?? '',
                };
        
                $.ajax({
                    url: newsflow_params.ajaxurl,
                    data: data,
                    type: 'POST',
                    beforeSend: function( xhr ){
                    },
                    success:function(result){
                        if( result ) {
                            console.log(result);
                            $result.text("Number of requests for us to write a depth analysis for this article: " + result.requestDepthAnalysis);
                        }
                    },
                    error: function onError(error) {
                        console.log(error);
                        $result.text("Unexpected error.");
                    },
                    complete: function complete() {
                        $loading.hide();
                        $result.show();
                    }
                });
            });
        });
    },
    initFeedback: function () {
        let $divs = $('.full-view, .full-view-details, .popup-quick-view').find('.form-feedback');
        $divs.each(function () {
            let $form = $(this).find('form');
            let $postIdInput = $(this).find('input[name="postId"]');
            let $emailInput = $(this).find('input[name="email"]');
            let $messageInput = $(this).find('textarea');
            let $btnSubmit = $(this).find('button');
            let $loading = $(this).find('p#loading');
            let $result = $(this).find('p#send_feedback_result');
            $btnSubmit.click(function () {
                $form.hide();
                $result.hide();
                $loading.show();

                var data = {
                    'action': 'init_feedback',
                    'postId': $postIdInput.val(),
                    'email': $emailInput.val(),
                    'message': $messageInput.val()
                };
        
                $.ajax({
                    url: newsflow_params.ajaxurl,
                    data: data,
                    type: 'POST',
                    beforeSend: function( xhr ){
                    },
                    success:function(result){
                        if( result ) {
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
        });
    },

    /**
     * scroll down when at the end of page.
     */
    onScrollDown: function () {
        if ($('.last-page').is(':visible') || this.isLoadingMore) {
            // console.log("End of the list or is in-progress.");
            return;
        }
        
        if($('.full-view-details').is(':visible')) {
            var postId = $('.full-view-details').find('#post-id').val();
        }
        var type = '';
        let url = $(location).attr('href');
        if (url.indexOf("type=") != -1) {
            const getUrl = new URL(url);
            type = getUrl.searchParams.get('type');
        }
        var data = {
			'action': 'loadmore',
			'postId': postId ?? '',
            'page' : newsflow_params.current_page,
            'type' : type
        };

        this.isLoadingMore = true;
        let $self = this;
        $.ajax({
            url: newsflow_params.ajaxurl,
            data: data,
            type: 'POST',
            beforeSend: function( xhr ){
            },
            success:function(result){
                if( result ) {
                    $(".news-flow #right_content").append(result);
                    newsflow_params.current_page++;
                }
            },
            error: function onError(error) {
                console.log(error);
            },
            complete: function complete() {
                $self.isLoadingMore = false;
            }
        });
    },

    lastScrollTop: 0,
    isLoadingMore: false,
    initLoadMore: function () {
        let $self = this;
        $(window).scroll(function (e) {
            let st = $(this).scrollTop();
            if (st > $self.lastScrollTop) {
                if ($(window).scrollTop() >= $(document).height() - $(window).height() - 700) {
                    $self.onScrollDown();
                }
            } else {
                // upscroll code
            }
            $self.lastScrollTop = st;
        });

        setTimeout(function () {
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 700) {
                $self.onScrollDown();
            }
        }, 100);
    },

    init: function () {
        this.initCopyEvent();
        this.initRequestDepthAnalysis();
        this.initFeedback();

        if (!window.PublicInsight || typeof(window.PublicInsight) === undefined) {
            return;
        }

        // Replace IFrame tag, support Responsive
        window.PublicInsight.replaceElementResponsive($('.full-view-details'));
        $quickViews = $('.popup-quick-view');
        $.each($quickViews, function ($index, $view) {
            window.PublicInsight.replaceElementResponsive($($view));
        });

        // Resize popup when resize windows
        new ResizeSensor($('div.news-flow')[0], function () {
            let _width = $('div.news-flow')[0].offsetWidth;
            window.PublicInsight.resizePopupView(_width);
        });

        
    }
};

$(document).ready(function () {
    NewsflowController.init();
    NewsflowController.initLoadMore();
    window.PublicInsight.filterPostByType();
});
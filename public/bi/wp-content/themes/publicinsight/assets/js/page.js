$(document).ready(function () {
    var height = $('.depth-analysis-post').outerHeight(true);
    $('.depth-analysis-articles img').height(height);

    $(document).on('click', '.latest-load-more', function () {
        var data = {
			'action': 'latest_loadmore',
            'latest_page' : newsflow_params.latest_current_page,
        };

        $.ajax({
            url: newsflow_params.ajaxurl,
            data: data,
            type: 'POST',
            beforeSend: function( xhr ){
            },
            success:function(result){
                if( result ) {
                    $(".latest-articles .article-list").append(result);
                    newsflow_params.latest_current_page++;
                    if ($('.last-page').is(':visible')) {
                        $('.btn-load-more').hide();
                    }
                }
            },
        });
    })

    $(document).on('click', '.news-machine-load-more', function () {
        var data = {
			'action': 'news_machine_loadmore',
            'news_machine_page' : newsflow_params.news_machine_current_page,
        };

        $.ajax({
            url: newsflow_params.ajaxurl,
            data: data,
            type: 'POST',
            success:function(result){
                if( result ) {
                    $(".news-machine-list tbody").append(result);
                    newsflow_params.news_machine_current_page++;
                    if ($('.news-machine-last-page').is(':visible')) {
                        $('.news-machine-load-more').hide();
                    }
                }
            },
        });
    })
});
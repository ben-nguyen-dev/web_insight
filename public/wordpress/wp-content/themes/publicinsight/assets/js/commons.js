window.PublicInsight = {
    initMuxVideos: function () {
        let muxVideos = $('.mux-sanity');
        muxVideos.each(function () {
            let source = 'https://stream.mux.com/' + this.id + '.m3u8';
            if(Hls.isSupported()) {
                let hls = new Hls();
                hls.loadSource(source);
                hls.attachMedia(this);
            }
            // hls.js is not supported on platforms that do not have Media Source Extensions (MSE) enabled.
            // When the browser has built-in HLS support (check using `canPlayType`), we can provide an HLS manifest (i.e. .m3u8 URL) directly to the video element through the `src` property.
            // This is using the built-in support of the plain video element, without using hls.js.
            // Note: it would be more normal to wait on the 'canplay' event below however on Safari (where you are most likely to find built-in HLS support) the video.src URL must be on the user-driven
            // white-list before a 'canplay' event will be emitted; the last video event that can be reliably listened-for when the URL is not on the white-list is 'loadedmetadata'.
            else if (this.canPlayType('application/vnd.apple.mpegurl')) {
                this.src = source;
            }
        });
    },
    createQuickView: function (conWidth, object) {
        // Get parent
        let $parent = $(object).closest('article');
        let $popUp = $parent.find('.popup-quick-view');
        $popUp.css('width', conWidth + 'px');
        $popUp.fadeIn(200);

        $parent.css('height', $popUp.outerHeight(true));

        // Set dbclick (for desktop and mobile)
        let touchtime = 0;
        $popUp.find('.close-popup').on('click', function () {
            $popUp.hide();
            $parent.css('height', 'auto');
        });
        $popUp.find('.close-on-click').on("click", function () {
            if (touchtime == 0) {
                // set first click
                touchtime = new Date().getTime();
            } else {
                // compare first click to this click and see if they occurred within double click threshold
                if (((new Date().getTime()) - touchtime) < 500) {
                    // double click occurred
                    $popUp.hide();
                    $parent.css('height', 'auto');
                    touchtime = 0;
                } else {
                    // not a double click so set as a new first click
                    touchtime = new Date().getTime();
                }
            }
        });
    },

    resizePopupView: function (conWidth) {
        let $popups = $('.popup-quick-view');

        for (let i = 0; i < $popups.length; i++) {
            let popup = $($popups[i]);
            if (popup.is(":visible")) {
                let $parent = popup.closest('article');
                // Reset width/ height of popup and article
                popup.css('width', conWidth);
                $parent.css('height', popup.outerHeight());
            }
        }
    },

    loadSearchBoxDesktopEvent: function() {
        let $searchForm = $("form#searchbox_desktop");
        let _tempword = $.trim($searchForm.find('input[name="keyword"]').val());
        let search_clicked = _tempword == '' ? 0 : 1;
        $searchForm.submit(function(e){
            if(search_clicked == 0) {
                e.preventDefault();
                $(this).addClass('active');
                search_clicked = 1;
            }else {
                let _keyword = $(this).find('input[name="keyword"]').val();
                let keyword = $.trim(_keyword);
                if(keyword == '') {
                    e.preventDefault();
                    $(this).removeClass('active');
                    search_clicked = 0;
                }else {
                    //TODO: Searching ...
                    search_clicked = 1;
                }
            }
        });
    },

    initNavMobileEvent: function() {
      $('.navbar-toggler').on('click', function() {
          let navEle = $(this).hasClass('nav-menu') ? '#navbars_profile' : '#navbars';
          $(navEle).removeClass('show');
      });
    },

    redirectTo: function(url) {
        window.location.href = url;
    },

    initProfileEvent: function() {
        let $button = $('.dropdown-menu').find('button');
        $.each($button, function(key, ele) {
            $(ele).on('click', function() {
                let url = $(this).data('href');
                PublicInsight.redirectTo(url);
            });
        });
    },

    replaceElementResponsive: function ($object) {
        $object.find('img').addClass('img-fluid');

        // Replacing the iframe causes it could be loaded twice (Tableau "unexpired ticket" bug)
        /*
        let $iframe = $object.find('iframe');
        for (let i = 0; i< $iframe.length; i ++) {
            let _obj = $($iframe[i]);
            let src = _obj.attr('src');
            let htmlIframe = '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'+src+'" allowfullscreen></iframe></div>';
            _obj.replaceWith(htmlIframe);
        }
        */
    },

    filterPostByType: function () {
        let url = $(location).attr('href');
        const pathname = window.location.origin + $(location).attr('pathname');

        if (url.indexOf("type=") != -1) {
            if(url.indexOf('/calendar') != -1 || url.indexOf('/about') != -1 || url.indexOf('/contact') != -1 || url.indexOf('/subscription') != -1 || url.indexOf('/profile') != -1) {
                $(location).attr('href', pathname);
            }
            const getUrl = new URL(url);
            const type = getUrl.searchParams.get('type');

            const item = $( ".group-news a." + type);
            $( item ).addClass( "filter" );
            $( item ).css("padding", "2px 10px 2px 20px");
            $( item ).find("i.fas").hide();
            $( item ).find("i.close-icon").show();
            $( item ).find("span").text("Show only " + type);
            if(type == 'analysis') {
                $(".group-news").css("padding-left", '0');
            }
            $(".title-msg").hide();
        }
        $(".group-news a").on('click', function() {
            if($( this ).find("i.fas").is(":visible")) {
                const type = $( this ).attr('class');
                if(type != '' && typeof type !== 'undefined') {
                    url = new URL(url);
                    url.searchParams.set('type', type);
                    $(location).attr('href', url);
                }
            } else {
                url = new URL(url);
                url.searchParams.delete('type');
                $(location).attr('href', url);
            }
        });
    },

    //Add loading icon for loading js in admin, mypost page
    addLoadingIcon: function () {
        const url = $(location).attr('href');
        if(url.indexOf('/myposts') != -1 || url.indexOf('/admin') != -1) {
            $('.spinner-border').show();
            $('.spinner-border').css('margin', '20px 0');
        } else {
            $('.loading').removeClass('d-flex');
        }
    }
};

$(document).ready(function () {
    PublicInsight.initMuxVideos();
    // Init event for search box
    PublicInsight.loadSearchBoxDesktopEvent();

    // Init event for nav mobile
    PublicInsight.initNavMobileEvent();

    // Edit profile or logout
    PublicInsight.initProfileEvent();

    PublicInsight.addLoadingIcon();

    const url = $(location).attr('href');
    if(url.indexOf('/calendar') != -1 || url.indexOf('/about') != -1 || url.indexOf('/contact') != -1 || url.indexOf('/subscription') != -1 || url.indexOf('/profile') != -1 || url.indexOf('/admin') != -1) {
        $('.group-news').hide();
    }

    // Get Width default
    let containerWidth = $('div.container')[0].offsetWidth;
    $(document).on("click","#right_content .popup-link a.quick-view",function() {
        if (this.href && this.href !== 'javascript:void(0)') {
            return;
        }
        window.PublicInsight.createQuickView(containerWidth, this);
    });

});
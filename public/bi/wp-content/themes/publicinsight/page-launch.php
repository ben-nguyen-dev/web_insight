<!DOCTYPE html>
<html lang="en-US">
   <head>
      <meta charset="UTF-8">
      <title>PublicInsight</title>
      <link rel='dns-prefetch' href='//s.w.org' />
      <link rel="alternate" type="application/rss+xml" title="PublicInsight &raquo; Feed" href="https://publicinsight.se/index.php/feed/" />
      <link rel="alternate" type="application/rss+xml" title="PublicInsight &raquo; Comments Feed" href="https://publicinsight.se/index.php/comments/feed/" />
      <!-- This site uses the Google Analytics by MonsterInsights plugin v7.12.2 - Using Analytics tracking - https://www.monsterinsights.com/ -->
      <!-- Note: MonsterInsights does not track you as a logged-in site administrator to prevent site owners from accidentally skewing their own Google Analytics data.
         If you are testing Google Analytics code, please do so either logged out or in the private browsing/incognito mode of your web browser. -->
      <script type="text/javascript" data-cfasync="false">
         var mi_version         = '7.12.2';
         var mi_track_user      = false;
         var mi_no_track_reason = 'Note: MonsterInsights does not track you as a logged-in site administrator to prevent site owners from accidentally skewing their own Google Analytics data.\nIf you are testing Google Analytics code, please do so either logged out or in the private browsing/incognito mode of your web browser.';
         
         var disableStr = 'ga-disable-UA-164518967-1';
         
         /* Function to detect opted out users */
         function __gaTrackerIsOptedOut() {
         	return document.cookie.indexOf(disableStr + '=true') > -1;
         }
         
         /* Disable tracking if the opt-out cookie exists. */
         if ( __gaTrackerIsOptedOut() ) {
         	window[disableStr] = true;
         }
         
         /* Opt-out function */
         function __gaTrackerOptout() {
           document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
           window[disableStr] = true;
         }
         
         if ( 'undefined' === typeof gaOptout ) {
         	function gaOptout() {
         		__gaTrackerOptout();
         	}
         }
         
         if ( mi_track_user ) {
         	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
         		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
         		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
         	})(window,document,'script','//www.google-analytics.com/analytics.js','__gaTracker');
         
         	__gaTracker('create', 'UA-164518967-1', 'auto');
         	__gaTracker('set', 'forceSSL', true);
         	__gaTracker('send','pageview');
         } else {
         	console.log( "Note: MonsterInsights does not track you as a logged-in site administrator to prevent site owners from accidentally skewing their own Google Analytics data.\nIf you are testing Google Analytics code, please do so either logged out or in the private browsing/incognito mode of your web browser." );
         	(function() {
         		/* https://developers.google.com/analytics/devguides/collection/analyticsjs/ */
         		var noopfn = function() {
         			return null;
         		};
         		var noopnullfn = function() {
         			return null;
         		};
         		var Tracker = function() {
         			return null;
         		};
         		var p = Tracker.prototype;
         		p.get = noopfn;
         		p.set = noopfn;
         		p.send = noopfn;
         		var __gaTracker = function() {
         			var len = arguments.length;
         			if ( len === 0 ) {
         				return;
         			}
         			var f = arguments[len-1];
         			if ( typeof f !== 'object' || f === null || typeof f.hitCallback !== 'function' ) {
         				console.log( 'Not running function __gaTracker(' + arguments[0] + " ....) because you are not being tracked. " + mi_no_track_reason );
         				return;
         			}
         			try {
         				f.hitCallback();
         			} catch (ex) {
         
         			}
         		};
         		__gaTracker.create = function() {
         			return new Tracker();
         		};
         		__gaTracker.getByName = noopnullfn;
         		__gaTracker.getAll = function() {
         			return [];
         		};
         		__gaTracker.remove = noopfn;
         		window['__gaTracker'] = __gaTracker;
         				})();
         	}
      </script>
      <!-- / Google Analytics by MonsterInsights -->
      <script>
         window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/13.0.0\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/13.0.0\/svg\/","svgExt":".svg","source":{"concatemoji":"https:\/\/publicinsight.se\/wp-includes\/js\/wp-emoji-release.min.js?ver=5.5.1"}};
         !function(e,a,t){var r,n,o,i,p=a.createElement("canvas"),s=p.getContext&&p.getContext("2d");function c(e,t){var a=String.fromCharCode;s.clearRect(0,0,p.width,p.height),s.fillText(a.apply(this,e),0,0);var r=p.toDataURL();return s.clearRect(0,0,p.width,p.height),s.fillText(a.apply(this,t),0,0),r===p.toDataURL()}function l(e){if(!s||!s.fillText)return!1;switch(s.textBaseline="top",s.font="600 32px Arial",e){case"flag":return!c([127987,65039,8205,9895,65039],[127987,65039,8203,9895,65039])&&(!c([55356,56826,55356,56819],[55356,56826,8203,55356,56819])&&!c([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]));case"emoji":return!c([55357,56424,8205,55356,57212],[55357,56424,8203,55356,57212])}return!1}function d(e){var t=a.createElement("script");t.src=e,t.defer=t.type="text/javascript",a.getElementsByTagName("head")[0].appendChild(t)}for(i=Array("flag","emoji"),t.supports={everything:!0,everythingExceptFlag:!0},o=0;o<i.length;o++)t.supports[i[o]]=l(i[o]),t.supports.everything=t.supports.everything&&t.supports[i[o]],"flag"!==i[o]&&(t.supports.everythingExceptFlag=t.supports.everythingExceptFlag&&t.supports[i[o]]);t.supports.everythingExceptFlag=t.supports.everythingExceptFlag&&!t.supports.flag,t.DOMReady=!1,t.readyCallback=function(){t.DOMReady=!0},t.supports.everything||(n=function(){t.readyCallback()},a.addEventListener?(a.addEventListener("DOMContentLoaded",n,!1),e.addEventListener("load",n,!1)):(e.attachEvent("onload",n),a.attachEvent("onreadystatechange",function(){"complete"===a.readyState&&t.readyCallback()})),(r=t.source||{}).concatemoji?d(r.concatemoji):r.wpemoji&&r.twemoji&&(d(r.twemoji),d(r.wpemoji)))}(window,document,window._wpemojiSettings);
      </script>
      <style>
         img.wp-smiley,
         img.emoji {
         display: inline !important;
         border: none !important;
         box-shadow: none !important;
         height: 1em !important;
         width: 1em !important;
         margin: 0 .07em !important;
         vertical-align: -0.1em !important;
         background: none !important;
         padding: 0 !important;
         }
         .elementor-804 .elementor-element.elementor-element-6fd59a2 .elementor-heading-title {
            font-size: 4rem;
         }
         ul.navbar-nav li a.btn-loggin {
            display: block !important;
         }
      </style>
      <link rel='stylesheet' id='admin-bar-css'  href="<?php echo get_stylesheet_directory_uri() . '/assets/pi_home/css/admin-bar.min.css'; ?>" media='all' />
      <link rel='stylesheet' id='twentytwenty-style-css'  href="<?php echo get_stylesheet_directory_uri() . '/assets/pi_home/css/style.css' ?>" media='all' />
      <style id='twentytwenty-style-inline-css'>
         .color-accent,.color-accent-hover:hover,.color-accent-hover:focus,:root .has-accent-color,.has-drop-cap:not(:focus):first-letter,.wp-block-button.is-style-outline,a { color: #d81c4e; }blockquote,.border-color-accent,.border-color-accent-hover:hover,.border-color-accent-hover:focus { border-color: #d81c4e; }button:not(.toggle),.button,.faux-button,.wp-block-button__link,.wp-block-file .wp-block-file__button,input[type="button"],input[type="reset"],input[type="submit"],.bg-accent,.bg-accent-hover:hover,.bg-accent-hover:focus,:root .has-accent-background-color,.comment-reply-link { background-color: #d81c4e; }.fill-children-accent,.fill-children-accent * { fill: #d81c4e; }:root .has-background-color,button,.button,.faux-button,.wp-block-button__link,.wp-block-file__button,input[type="button"],input[type="reset"],input[type="submit"],.wp-block-button,.comment-reply-link,.has-background.has-primary-background-color:not(.has-text-color),.has-background.has-primary-background-color *:not(.has-text-color),.has-background.has-accent-background-color:not(.has-text-color),.has-background.has-accent-background-color *:not(.has-text-color) { color: #f6f2f2; }:root .has-background-background-color { background-color: #f6f2f2; }body,.entry-title a,:root .has-primary-color { color: #000000; }:root .has-primary-background-color { background-color: #000000; }cite,figcaption,.wp-caption-text,.post-meta,.entry-content .wp-block-archives li,.entry-content .wp-block-categories li,.entry-content .wp-block-latest-posts li,.wp-block-latest-comments__comment-date,.wp-block-latest-posts__post-date,.wp-block-embed figcaption,.wp-block-image figcaption,.wp-block-pullquote cite,.comment-metadata,.comment-respond .comment-notes,.comment-respond .logged-in-as,.pagination .dots,.entry-content hr:not(.has-background),hr.styled-separator,:root .has-secondary-color { color: #7d6868; }:root .has-secondary-background-color { background-color: #7d6868; }pre,fieldset,input,textarea,table,table *,hr { border-color: #ddcece; }caption,code,code,kbd,samp,.wp-block-table.is-style-stripes tbody tr:nth-child(odd),:root .has-subtle-background-background-color { background-color: #ddcece; }.wp-block-table.is-style-stripes { border-bottom-color: #ddcece; }.wp-block-latest-posts.is-grid li { border-top-color: #ddcece; }:root .has-subtle-background-color { color: #ddcece; }body:not(.overlay-header) .primary-menu > li > a,body:not(.overlay-header) .primary-menu > li > .icon,.modal-menu a,.footer-menu a, .footer-widgets a,#site-footer .wp-block-button.is-style-outline,.wp-block-pullquote:before,.singular:not(.overlay-header) .entry-header a,.archive-header a,.header-footer-group .color-accent,.header-footer-group .color-accent-hover:hover { color: #cd2653; }.social-icons a,#site-footer button:not(.toggle),#site-footer .button,#site-footer .faux-button,#site-footer .wp-block-button__link,#site-footer .wp-block-file__button,#site-footer input[type="button"],#site-footer input[type="reset"],#site-footer input[type="submit"] { background-color: #cd2653; }.header-footer-group,body:not(.overlay-header) #site-header .toggle,.menu-modal .toggle { color: #000000; }body:not(.overlay-header) .primary-menu ul { background-color: #000000; }body:not(.overlay-header) .primary-menu > li > ul:after { border-bottom-color: #000000; }body:not(.overlay-header) .primary-menu ul ul:after { border-left-color: #000000; }.site-description,body:not(.overlay-header) .toggle-inner .toggle-text,.widget .post-date,.widget .rss-date,.widget_archive li,.widget_categories li,.widget cite,.widget_pages li,.widget_meta li,.widget_nav_menu li,.powered-by-wordpress,.to-the-top,.singular .entry-header .post-meta,.singular:not(.overlay-header) .entry-header .post-meta a { color: #6d6d6d; }.header-footer-group pre,.header-footer-group fieldset,.header-footer-group input,.header-footer-group textarea,.header-footer-group table,.header-footer-group table *,.footer-nav-widgets-wrapper,#site-footer,.menu-modal nav *,.footer-widgets-outer-wrapper,.footer-top { border-color: #dcd7ca; }.header-footer-group table caption,body:not(.overlay-header) .header-inner .toggle-wrapper::before { background-color: #dcd7ca; }
      </style>
      <link rel='stylesheet' id='elementor-frontend-css'  href="<?php echo get_stylesheet_directory_uri() . '/assets/pi_home/css/frontend-legacy.min.css' ?>" media='all' />
      <link rel='stylesheet' id='elementor-frontend-css'  href="<?php echo get_stylesheet_directory_uri() . '/assets/pi_home/css/frontend.min.css' ?>" media='all' />
      <link rel='stylesheet' id='elementor-post-472-css'  href="<?php echo get_stylesheet_directory_uri() . '/assets/pi_home/css/post-472.css' ?>" media='all' />
      <link rel='stylesheet' id='elementor-post-472-css'  href="<?php echo get_stylesheet_directory_uri() . '/assets/pi_home/css/global.css' ?>" media='all' />
      <link rel='stylesheet' id='elementor-post-804-css'  href="<?php echo get_stylesheet_directory_uri() . '/assets/pi_home/css/post-804.css' ?>" media='all' />
      <link rel='stylesheet' id='google-fonts-1-css'  href='https://fonts.googleapis.com/css?family=Inter%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;ver=5.5.1' media='all' />
      <meta name="generator" content="WordPress 5.5.1" />
      <link rel="canonical" href="https://publicinsight.se/" />
      <link rel='shortlink' href='https://publicinsight.se/' />
      <style id="custom-background-css">
         body.custom-background { background-color: #f6f2f2; }
      </style>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
   </head>
   <body class="home page-template-default page page-id-800 logged-in admin-bar no-customize-support custom-background wp-custom-logo singular enable-search-modal missing-post-thumbnail has-no-pagination not-showing-comments show-avatars footer-top-visible elementor-default elementor-template-canvas elementor-kit-472 elementor-page elementor-page-800 elementor-page-804">
      <a class="skip-link screen-reader-text" href="#site-content">Skip to the content</a>		
      <div data-elementor-type="single" data-elementor-id="804" class="elementor elementor-804 elementor-location-single post-800 page type-page status-publish hentry" data-elementor-settings="[]">
         <div class="elementor-section-wrap">
            <?php
               get_header();
            ?>
            <section class="elementor-section elementor-top-section elementor-element elementor-element-8e86291 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="8e86291" data-element_type="section">
               <div class="elementor-container elementor-column-gap-default">
                  <div class="elementor-row">
                     <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-0789ea7" data-id="0789ea7" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                           <div class="elementor-widget-wrap">
                              <div class="elementor-element elementor-element-177685b elementor-aspect-ratio-169 elementor-widget elementor-widget-video" data-id="177685b" data-element_type="widget" data-settings="{&quot;aspect_ratio&quot;:&quot;169&quot;}" data-widget_type="video.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-wrapper elementor-fit-aspect-ratio elementor-open-inline">
                                       <video class="elementor-video" src="<?php echo get_stylesheet_directory_uri() . '/assets/pi_home/video/Pitch-movie-september.m4v'; ?>" controls="" controlsList="nodownload"></video>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="elementor-section elementor-top-section elementor-element elementor-element-48406eb9 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="48406eb9" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
               <div class="elementor-container elementor-column-gap-wide">
                  <div class="elementor-row">
                     <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-698273e4" data-id="698273e4" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                           <div class="elementor-widget-wrap">
                              <div class="elementor-element elementor-element-3107f10e elementor-widget elementor-widget-heading" data-id="3107f10e" data-element_type="widget" data-widget_type="heading.default">
                                 <div class="elementor-widget-container">
                                    <h1 class="elementor-heading-title elementor-size-default"><strong>Ett ekosystem för offentliga affärer</strong></h1>
                                 </div>
                              </div>
                              <section class="elementor-section elementor-inner-section elementor-element elementor-element-325031bc elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="325031bc" data-element_type="section">
                                 <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-row">
                                       <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-32358b17" data-id="32358b17" data-element_type="column">
                                          <div class="elementor-column-wrap elementor-element-populated">
                                             <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-7501fcff elementor-widget elementor-widget-text-editor" data-id="7501fcff" data-element_type="widget" data-widget_type="text-editor.default">
                                                   <div class="elementor-widget-container">
                                                      <div class="elementor-text-editor elementor-clearfix">
                                                         <div><span style="letter-spacing: -0.015em;">Offentlig sektor ska erbjuda en modern välfärd med konkurrens, transparens och rimliga trösklar. Idag präglas den av krångel, inlåsningar, snedvriden konkurrens och en rädsla att göra fel. Vi på PublicInsight möter dessa problem med att tillgängliggöra data och bygga tjänster som sänker trösklar och öppnar upp affärer</span><br /><br /></div>
                                                         <div>Vi ser förutsättningar för kraftig expansion och är beredda att utmana stelbenta marknadsdominanter som skapar tröga och invecklade system med dålig transparens.<span style="letter-spacing: -0.015em;"><br /></span></div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-997daad" data-id="997daad" data-element_type="column">
                                          <div class="elementor-column-wrap elementor-element-populated">
                                             <div class="elementor-widget-wrap">
                                                <div class="elementor-element elementor-element-72d5b8ab elementor-widget elementor-widget-text-editor" data-id="72d5b8ab" data-element_type="widget" data-widget_type="text-editor.default">
                                                   <div class="elementor-widget-container">
                                                      <div class="elementor-text-editor elementor-clearfix">
                                                         <p>Coronavirusets effekter på ekonomin har gjort att vi kortat etableringsfasen då intresset för den offentliga marknaden är rekordstort. Marknaden törstar efter våra tjänster så lanserar vi några av tjänsterna redan under hösten, samtidigt som vi arbetar med att inhämta insikter och behov från våra kunder och användare för fortsatt utveckling. </p>
                                                         <p>Varmt välkommen till  oss på PublicInsight!</p>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </section>
                              <div class="elementor-element elementor-element-dc0452b elementor-widget elementor-widget-text-editor" data-id="dc0452b" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong><span style="text-align: left;"><span style="color: #54595f; font-family: INTER, sans-serif; font-size: medium;"><span style="caret-color: #54595f;"><a href="mailto: pelle@publicinsight.se">Kontakta oss</a> så berättar vi mer! </span></span></span></strong></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="elementor-section elementor-top-section elementor-element elementor-element-301813e elementor-section-height-min-height elementor-section-items-stretch elementor-section-boxed elementor-section-height-default" data-id="301813e" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
               <div class="elementor-container elementor-column-gap-default">
                  <div class="elementor-row">
                     <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-daa20c9" data-id="daa20c9" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                           <div class="elementor-widget-wrap">
                              <div class="elementor-element elementor-element-6598895 elementor-widget elementor-widget-heading" data-id="6598895" data-element_type="widget" data-widget_type="heading.default">
                                 <div class="elementor-widget-container">
                                    <h2 class="elementor-heading-title elementor-size-default">Mycket är sig likt!<br><br>
                                       Vi gör fortfarande affärer<br>
                                       Vi utvecklar fortfarande dialoger<br>
                                       Vi söker fortfarande efter insikter …<br>
                                       <br>… men tillvägagångssättet är förändrat
                                    </h2>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="elementor-section elementor-top-section elementor-element elementor-element-2b03776 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="2b03776" data-element_type="section">
               <div class="elementor-container elementor-column-gap-default">
                  <div class="elementor-row">
                     <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-57c6d43" data-id="57c6d43" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                           <div class="elementor-widget-wrap">
                              <div class="elementor-element elementor-element-6fd59a2 elementor-widget elementor-widget-heading" data-id="6fd59a2" data-element_type="widget" data-widget_type="heading.default">
                                 <div class="elementor-widget-container">
                                    <h3 class="elementor-heading-title elementor-size-default">
                                       Ett ekosystem av tjänster för den offentliga marknaden
                                    </h3>
                                 </div>
                              </div>
                              <div class="elementor-element elementor-element-47634b7 elementor-widget elementor-widget-image" data-id="47634b7" data-element_type="widget" data-widget_type="image.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-image">
                                       <img width="3162" height="1542" src="<?php echo get_stylesheet_directory_uri() . '/assets/image/Skarmavbild-2020-09-06-kl.-22.33.29.png' ?>" class="attachment-full size-full" alt="" loading="lazy"  />											
                                    </div>
                                 </div>
                              </div>
                              <div class="elementor-element elementor-element-7908bed elementor-widget elementor-widget-text-editor" data-id="7908bed" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p>PublicInsights ekosystem erbjuder leverantörer en genväg till den offentliga affären. Väl där skapar vi leveransmöjligheter och kunskapsövertag för våra kunder. Det gör att vi får en attraktiv och dynamisk offentlig marknad som blir lönsam för aktörerna och samhället</p>
                                       <p><strong>Köparna</strong>: Högre kvalitet och trygghet ger ett effektivt nyttjande av skattemedel</p>
                                       <p><strong>Leverantörerna</strong>: Vi skapar affärsmöjligheter, stärker företags förmåga att lämna anbud och hjälper nya aktörer in på marknaden</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="elementor-element elementor-element-5ba0b33 elementor-widget elementor-widget-spacer" data-id="5ba0b33" data-element_type="widget" data-widget_type="spacer.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-spacer">
                                       <div class="elementor-spacer-inner"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="elementor-section elementor-top-section elementor-element elementor-element-4e03b341 elementor-section-height-min-height elementor-section-boxed elementor-section-height-default elementor-section-items-middle" data-id="4e03b341" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;shape_divider_top&quot;:&quot;curve&quot;,&quot;shape_divider_top_negative&quot;:&quot;yes&quot;}">
               <div class="elementor-background-overlay"></div>
               <div class="elementor-shape elementor-shape-top" data-negative="true">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                     <path class="elementor-shape-fill" d="M500,97C126.7,96.3,0.8,19.8,0,0v100l1000,0V1C1000,19.4,873.3,97.8,500,97z"/>
                  </svg>
               </div>
               <div class="elementor-container elementor-column-gap-default">
                  <div class="elementor-row">
                     <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-192c9d9" data-id="192c9d9" data-element_type="column">
                        <div class="elementor-column-wrap">
                           <div class="elementor-widget-wrap">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="elementor-section elementor-top-section elementor-element elementor-element-6405b179 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="6405b179" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;none&quot;}">
               <div class="elementor-container elementor-column-gap-default">
                  <div class="elementor-row">
                     <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-789bf842" data-id="789bf842" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                           <div class="elementor-widget-wrap">
                              <div class="elementor-element elementor-element-f4f31f9 elementor-widget elementor-widget-text-editor" data-id="f4f31f9" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong>Lars Albinsson</strong><br />AI-innovatör och Creative Director<br /><a href="mailto:lars.albinsson@maestro.se">E-post</a><br />+46-70 592 70 45</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="elementor-element elementor-element-22af1e0 elementor-widget elementor-widget-text-editor" data-id="22af1e0" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong>Anna Bostedt</strong><br />Ekonomiansvarig<br /><a href="mailto: anna.bostedt@publicinsight.se">E-post<br /></a>+8-503 898 10</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="elementor-element elementor-element-e858523 elementor-widget elementor-widget-text-editor" data-id="e858523" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong>Fredrik Tamm</strong><br />Koncernchef, strategisk rådgivare<br /><a href="mailto: fredrik.tamm@doublecheck.se">E-post<br /></a>+46-70-712 43 57</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-ab92991" data-id="ab92991" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                           <div class="elementor-widget-wrap">
                              <div class="elementor-element elementor-element-6c091fc elementor-widget elementor-widget-text-editor" data-id="6c091fc" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong>Pelle Asplund</strong><br />CPO<br /><a href="mailto: pelle@publicinsight.se">E-post <br /></a>+46-70-759 13 61</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="elementor-element elementor-element-8ccbd03 elementor-widget elementor-widget-text-editor" data-id="8ccbd03" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong>Petter Larsson</strong><br />Styrelsens ordförande<br /><a href="mailto: petter@publicinsight.se">E-post<br /></a>+46-70-876 86 11</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="elementor-element elementor-element-c034e7a elementor-widget elementor-widget-text-editor" data-id="c034e7a" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong>Amanda Scott</strong><br />Projektledare kommunikation<br /><a href="mailto: amanda@publicinsight.se" target="_blank" rel="noopener">E-post</a><a href="mailto: petter@publicinsight.se"><br /></a>+46-70-736 42 33</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-50937dd" data-id="50937dd" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                           <div class="elementor-widget-wrap">
                              <div class="elementor-element elementor-element-ad4e03a elementor-widget elementor-widget-text-editor" data-id="ad4e03a" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong>Björn Bergström</strong><br />Affärs- och upphandlingsjuridik<br /><a href="mailto:bjorn.bergstrom@ramberglaw.se" target="_blank" rel="noopener">E-post</a><br /><span style="font-size: inherit; letter-spacing: -0.015em; text-align: inherit;">+46-70-508 47 68</span></p>
                                    </div>
                                 </div>
                              </div>
                              <div class="elementor-element elementor-element-5fc7703 elementor-widget elementor-widget-text-editor" data-id="5fc7703" data-element_type="widget" data-widget_type="text-editor.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix">
                                       <p><strong>Diana Pedersen</strong><br />CTO<br /><a href="mailto:diana@publicinsight.se" target="_blank" rel="noopener">E-post</a><br /><span style="font-size: inherit; letter-spacing: -0.015em; text-align: inherit;">+46-70-160 46 13</span></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="elementor-section elementor-top-section elementor-element elementor-element-375c15d elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="375c15d" data-element_type="section">
               <div class="elementor-container elementor-column-gap-default">
                  <div class="elementor-row">
                     <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-0062532" data-id="0062532" data-element_type="column">
                        <div class="elementor-column-wrap elementor-element-populated">
                           <div class="elementor-widget-wrap">
                              <div class="elementor-element elementor-element-da86975 elementor-widget elementor-widget-image" data-id="da86975" data-element_type="widget" data-widget_type="image.default">
                                 <div class="elementor-widget-container">
                                    <div class="elementor-image">
                                       <img width="149" height="149" src="<?php echo get_stylesheet_directory_uri() . '/assets/image/Public-insight-colour-V1@2x.png' ?>" class="attachment-medium_large size-medium_large" alt="" loading="lazy" />											
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
      </div>
      <script type="text/template" id="tmpl-elementor-templates-modal__header">
         <div class="elementor-templates-modal__header__logo-area"></div>
         <div class="elementor-templates-modal__header__menu-area"></div>
         <div class="elementor-templates-modal__header__items-area">
         	<# if ( closeType ) { #>
         		<div class="elementor-templates-modal__header__close elementor-templates-modal__header__close--{{{ closeType }}} elementor-templates-modal__header__item">
         			<# if ( 'skip' === closeType ) { #>
         			<span>Skip</span>
         			<# } #>
         			<i class="eicon-close" aria-hidden="true" title="Close"></i>
         			<span class="elementor-screen-only">Close</span>
         		</div>
         	<# } #>
         	<div id="elementor-template-library-header-tools"></div>
         </div>
      </script>
      <script type="text/template" id="tmpl-elementor-templates-modal__header__logo">
         <span class="elementor-templates-modal__header__logo__icon-wrapper e-logo-wrapper">
         	<i class="eicon-elementor"></i>
         </span>
         <span class="elementor-templates-modal__header__logo__title">{{{ title }}}</span>
      </script>
      <script type="text/template" id="tmpl-elementor-finder">
         <div id="elementor-finder__search">
         	<i class="eicon-search"></i>
         	<input id="elementor-finder__search__input" placeholder="Type to find anything in Elementor">
         </div>
         <div id="elementor-finder__content"></div>
      </script>
      <script type="text/template" id="tmpl-elementor-finder-results-container">
         <div id="elementor-finder__no-results">No Results Found</div>
         <div id="elementor-finder__results"></div>
      </script>
      <script type="text/template" id="tmpl-elementor-finder__results__category">
         <div class="elementor-finder__results__category__title">{{{ title }}}</div>
         <div class="elementor-finder__results__category__items"></div>
      </script>
      <script type="text/template" id="tmpl-elementor-finder__results__item">
         <a href="{{ url }}" class="elementor-finder__results__item__link">
         	<div class="elementor-finder__results__item__icon">
         		<i class="eicon-{{{ icon }}}"></i>
         	</div>
         	<div class="elementor-finder__results__item__title">{{{ title }}}</div>
         	<# if ( description ) { #>
         		<div class="elementor-finder__results__item__description">- {{{ description }}}</div>
         	<# } #>
         </a>
         <# if ( actions.length ) { #>
         	<div class="elementor-finder__results__item__actions">
         	<# jQuery.each( actions, function() { #>
         		<a class="elementor-finder__results__item__action elementor-finder__results__item__action--{{ this.name }}" href="{{ this.url }}" target="_blank">
         			<i class="eicon-{{{ this.icon }}}"></i>
         		</a>
         	<# } ); #>
         	</div>
         <# } #>
      </script>
   </body>
</html>
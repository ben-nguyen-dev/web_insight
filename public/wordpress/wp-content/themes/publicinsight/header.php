<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- ROBOTS -->
		<meta name="googlebot" content="noarchive" />
		<meta name="robots" content="noarchive" />

        <title>Public insight</title>
        
        <link href="/pi/wp-includes/images/favicon.ico" rel="shortcut icon">
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&display=swap" rel="stylesheet">
        <?php wp_head(); ?>

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-T5WG19FJ6V"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-T5WG19FJ6V');
		</script> -->

		<!-- New site -->
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-164518967-2"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-164518967-2');
		</script>
	</head>

	<body <?php body_class(); ?>>

		<?php
        wp_body_open();
        $uri = $_SERVER["REQUEST_URI"];
        $uri = str_replace("/pi", "", $uri);
        if($uri == '/') {
            $page = 'home';
        } else {
            if(false !== strpos($uri, '?')) {
                $page = (explode("?", $uri))[0];
            } else {
                $page = $uri;
            }
        }
		?>

		<header class="fixed-nav-bar">
            <div class="container header">
                <div class="row header-inside top">
                    <div class="col-8 col-lg-6">
                        <div class="logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                                <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png'; ?>" class="img-fluid"/>
                            </a>
                        </div>
                    </div>
                    <div class="col-4 col-lg-6 search-bar d-none d-lg-block text-right">
                        <div class="d-inline-block">
                            <div class="info-profile form-inline">
                                <div class="search-form">
                                <?php
                                    $type = 'desktop';
                                    wpse_get_template_part( 'template-parts/search_from', null, array('type' => $type ));
                                ?>
                                </div>
                                <div class="profile">
                                    <?php if ( is_user_logged_in() ):
                                        global $current_user;
                                        wp_get_current_user(); 
                                        $roles = $current_user->roles;
                                        $check_admin = false;
                                        if(in_array("editor", $roles)) {
                                            $check_admin = true; 
                                        }?>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle" type="button" id="dropdown_profile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Hello, <span class="font-weight-bold fullname"><?php echo $current_user->display_name ?? $current_user->user_email; ?></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_profile" style="z-index: 2000">
                                                <span class="dropdown-menu-arrow"></span>
                                                <button class="dropdown-item btn-light border-bottom" type="button" data-href="<?php echo esc_url(home_url('/profile')); ?>">
                                                    <div class="d-inline-block w130">Profile</div>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </button>
                                                <?php if ( ! $check_admin ): ?>
                                                
                                                    <button class="dropdown-item btn-light border-bottom" type="button" data-href="<?php echo esc_url(home_url('/myposts')); ?>">
                                                        <div class="d-inline-block w130">My posts</div>
                                                        <i class="fa fa-book" aria-hidden="true"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="dropdown-item btn-light border-bottom" type="button" data-href="<?php echo esc_url(home_url('/admin')); ?>">
                                                        <div class="d-inline-block w130">Admin</div>
                                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <button class="dropdown-item btn-light" type="button" data-href="<?php echo esc_url(home_url('/logout')); ?>">
                                                    <div class="d-inline-block w130">Logout</div>
                                                    <i class="fa fa-power-off" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <a class="sign-in" href="<?php echo esc_url(home_url('/login')); ?>">Sign In</a>
                                        <a class="sign-up btn btn-outline-danger" role="button" href="<?php echo esc_url(home_url('/login')); ?>">Become a member</a>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-6 navbar-light toggler-block d-block d-lg-none">
                        <button class="navbar-toggler nav-profile collapsed" type="button" data-toggle="collapse" data-target="#navbars_profile"
                                aria-controls="navbars_profile" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                        </button>
                        <button class="navbar-toggler nav-menu collapsed" type="button" data-toggle="collapse" data-target="#navbars"
                                aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                    </div>
                </div>
                <div class="row header-inside navbar navbar-expand-lg navbar-light">
                    <div class="col-12 col-lg-8 ">
                        <div class="navbar-collapse collapse" id="navbars">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item <?php if($page === 'home') echo 'active'; ?>">
                                    <a class="nav-link" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                                </li>
                                <li class="nav-item <?php if($page === '/newsflow/') echo 'active'; ?>">
                                    <a class="nav-link" href="<?php echo esc_url(home_url('/newsflow')); ?>">Newsflow</a>
                                </li>
                                <li class="nav-item <?php if($page === '/calendar/') echo 'active'; ?>">
                                    <a class="nav-link" href="<?php echo esc_url(home_url('/calendar')); ?>">Calendar</a>
                                </li>
                                <li class="nav-item <?php if($page === '/about/') echo 'active'; ?>">
                                    <a class="nav-link" href="<?php echo esc_url(home_url('/about')); ?>">About</a>
                                </li>
                                <li class="nav-item <?php if($page === '/contact/') echo 'active'; ?>">
                                    <a class="nav-link" href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a>
                                </li>
                                <li class="nav-item <?php if($page === '/subscription/') echo 'active'; ?>">
                                    <a class="nav-link" href="<?php echo esc_url(home_url('/subscription')); ?>">Subscription</a>
                                </li>
                                <li class="nav-item search-mobile d-block d-sm-none d-none d-sm-block d-md-none d-none d-md-block d-lg-none">
                                    <?php 
                                        wpse_get_template_part( 'template-parts/search_from', null, array('type' => 'mobile') ); 
                                    ?>
                                </li>
                            </ul>
                        </div>
                        <div class="d-block d-sm-none d-none d-sm-block d-md-none d-none d-md-block d-lg-none">
                            <div class="navbar-collapse collapse" id="navbars_profile">
                                <ul class="navbar-nav mr-auto">
                                    <?php if ( is_user_logged_in() ): ?>
                                        <li class="nav-item disabled border-bottom bg-light">
                                            <a class="nav-link" href="javascript:void(0);">
                                            Hello, <span class="font-weight-bold fullname"><?php echo $current_user->display_name ?? $current_user->user_email; ?></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{URL::to('profile')}}">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                Profile
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{URL::to('logout')}}">
                                                <i class="fa fa-power-off" aria-hidden="true"></i>
                                                Logout
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo esc_url(home_url('/login')); ?>">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                Sign in
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo esc_url(home_url('/login')); ?>">
                                                <i class="fa fa-user-plus" aria-hidden="true" style="margin-right: 0px;"></i>
                                                Become a member
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 my-2 my-lg-0 group-news">
                        <a href="<?php echo get_category_link_by_slug('news'); ?>" class="news" title="Show only news">
                            <i class="fas fa-square-full short i-small"></i>
                            <i class="close-icon" style="display: none;"></i>
                            <span>News</span>
                        </a>
                        <a href="<?php echo get_category_link_by_slug('comment'); ?>" class="comment" title="Show only comment">
                            <i class="fas fa-square-full comment i-small"></i>
                            <i class="close-icon" style="display: none;"></i>
                            <span>Comment</span>
                        </a>
                        <a href="<?php echo get_category_link_by_slug('analysis'); ?>" class="analysis" title="Show only analysis">
                            <i class="fas fa-square-full analysis i-small"></i>
                            <i class="close-icon" style="display: none;"></i>
                            <span>Analysis</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div id="app">
            <div class="d-flex justify-content-center loading">
                <div class="spinner-border text-primary" role="status" style="display:none;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <input id="wp-header" type="hidden" value="<?php echo wp_create_nonce( 'wp_rest' ); ?>" />
		<?php
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );

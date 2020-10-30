<?php


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

require_once 'vendor/autoload.php';

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

define('ANALYSIS', 'analysis');
define('EXPERT', 'expert');
define('SPONSOR', 'sponsored');
define('NORMAL', 'normal');
define('OAUTH_STATE', 'OAUTH_STATE');
define('OAUTH_ACCESS_TOKEN', 'OAUTH_ACCESS_TOKEN');
define('OAUTH_REFRESH_TOKEN', 'OAUTH_REFRESH_TOKEN');
define('OAUTH_TOKEN_EXPIRED_IN', 'OAUTH_TOKEN_EXPIRED_IN');

function publicinsight_theme_support()
{

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if (!isset($content_width)) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// Add custom image size used in Cover Template.
	add_image_size('pi-main-thumbnail', 720, "", 0);
	add_image_size('pi-large-thumbnail', 550, "", 0);
	add_image_size('pi-medium-thumbnail', 400, "", 0);
	add_image_size('pi-small-thumbnail', 160, "", 0);
	add_image_size('pi-tiny-thumbnail', 96, "", 0);


	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if (get_theme_mod('retina_logo', false)) {
		$logo_width  = floor($logo_width * 2);
		$logo_height = floor($logo_height * 2);
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Twenty, use a find and replace
	 * to change 'publicinsight' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('publicinsight');

	// Add support for full and wide align images.
	add_theme_support('align-wide');

	// Add support for responsive embeds.
	add_theme_support('responsive-embeds');
}

add_action('after_setup_theme', 'publicinsight_theme_support');


/**
 * Register and Enqueue Styles.
 */
function publicinsight_register_styles()
{

	$theme_version = wp_get_theme()->get('Version');

	wp_enqueue_style('publicinsight-style', get_stylesheet_uri(), array(), $theme_version);

	wp_enqueue_style('boostrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array());
	wp_enqueue_style('fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('font-css', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&display=swap', array());
	wp_enqueue_style('slick-css', 'https://kenwheeler.github.io/slick/slick/slick.css', array());
	wp_enqueue_style('slick-theme-css', 'https://kenwheeler.github.io/slick/slick/slick-theme.css', array());
	wp_enqueue_style('page-style', get_template_directory_uri() . '/assets/css/page.css', null, $theme_version, false);
	wp_enqueue_style('style-css', get_stylesheet_directory_uri() . '/assets/css/post.css', array());
	wp_enqueue_style('header-css', get_stylesheet_directory_uri() . '/assets/css/header.css', array());
}

add_action('wp_enqueue_scripts', 'publicinsight_register_styles');

/**
 * Register and Enqueue Scripts.
 */
function publicinsight_register_scripts()
{
	global $wp_query;
	$theme_version = wp_get_theme()->get('Version');
	wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.5.1.min.js');
	// wp_enqueue_script('slim-js', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', array());
	wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array());
	wp_enqueue_script('slick-js', 'https://kenwheeler.github.io/slick/slick/slick.js', array());
	wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/assets/js/main.js', array());

	wp_register_script('page-js', get_template_directory_uri() . '/assets/js/page.js', null, $theme_version, false);
	wp_localize_script('page-js', 'newsflow_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
		'posts' => json_encode($wp_query->query_vars),
		'latest_current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
		'news_machine_current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
	));
	wp_enqueue_script('page-js');
}

add_action('wp_enqueue_scripts', 'publicinsight_register_scripts');


function publicinsight_get_custom_logo($html)
{

	$logo_id = get_theme_mod('custom_logo');

	if (!$logo_id) {
		return $html;
	}

	$logo = wp_get_attachment_image_src($logo_id, 'full');

	if ($logo) {
		// For clarity.
		$logo_width  = esc_attr($logo[1]);
		$logo_height = esc_attr($logo[2]);

		// If the retina logo setting is active, reduce the width/height by half.
		if (get_theme_mod('retina_logo', false)) {
			$logo_width  = floor($logo_width / 2);
			$logo_height = floor($logo_height / 2);

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if (strpos($html, ' style=') === false) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace($search, $replace, $html);
		}
	}

	return $html;
}

add_filter('get_custom_logo', 'publicinsight_get_custom_logo');

if (!function_exists('wp_body_open')) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function publicinsight_skip_link()
{
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __('Skip to the content', 'publicinsight') . '</a>';
}

add_action('wp_body_open', 'publicinsight_skip_link', 5);

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function publicinsight_sidebar_registration()
{

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __('Footer #1', 'publicinsight'),
				'id'          => 'sidebar-1',
				'description' => __('Widgets in this area will be displayed in the first column in the footer.', 'publicinsight'),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __('Footer #2', 'publicinsight'),
				'id'          => 'sidebar-2',
				'description' => __('Widgets in this area will be displayed in the second column in the footer.', 'publicinsight'),
			)
		)
	);
}

add_action('widgets_init', 'publicinsight_sidebar_registration');

//Create new post type: News machine post
add_action('init', 'create_post_type');
function create_post_type()
{
	register_post_type(
		'news_machine_post',
		array(
			'labels' => array(
				'name' => __('News machine Posts'),
				'singular_name' => __('News machine post'),
				'add_new_item' => __('Add News machine post'),
				'edit_item' => __('Edit News machine post')
			),
			'supports' => array(
				'title',
				'excerpt',
				'custom-fields'
			),
			'public' => true,
			'has_archive' => true,
		)
	);
	register_post_type(
		'feedback',
		array(
			'labels' => array(
				'name' => __('Feedbacks'),
				'singular_name' => __('Feedback'),
				'add_new_item' => __('Add new feedback'),
				'edit_item' => __('Edit feedback')
			),
			'supports' => array(
				'custom-fields'
			),
			'public' => true,
			'has_archive' => true,
		)
	);
}

function wpse_get_template_part($slug, $name = null, $data = [])
{
	// here we're copying more of what get_template_part is doing.
	$templates = [];
	$name = (string) $name;

	if ('' !== $name) {
		$templates[] = "{$slug}-{$name}.php";
	}

	$templates[] = "{$slug}.php";

	$template = locate_template($templates, false);

	if (!$template) {
		return;
	}

	if ($data) {
		extract($data);
	}

	include($template);
}

//Load more in Latest post - Newsflow page
function newsflow_latest_loadmore_ajax_handler()
{
	global $post;
	$args = array(
		'post_type' =>  'post',
		'post_status' => 'publish',
		'orderby' => 'post_date',
		'order' => 'DESC',
		'posts_per_page' => 3,
		'paged' => $_POST['latest_page'] + 1
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			setup_postdata($post);
			$post_type = strtolower(get_post_meta(get_the_ID(), 'post_type', true));
			wpse_get_template_part('template-parts/newsflow/latest-article-item', null, array('post_type' => $post_type, 'post_id' => get_the_ID()));

			wp_reset_postdata();
		}
	} else {
		echo "<div class='last-page'/></div>";
	}
	die();
}
add_action('wp_ajax_latest_loadmore', 'newsflow_latest_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_latest_loadmore', 'newsflow_latest_loadmore_ajax_handler');

//Load more in News machine post - Newsflow page
function newsflow_news_machine_loadmore_ajax_handler()
{
	$args = array(
		'post_type' =>  'news_machine_post',
		'post_status' => 'publish',
		'orderby' => 'post_date',
		'order' => 'DESC',
		'posts_per_page' => 5,
		'paged' => $_POST['news_machine_page'] + 1
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			wpse_get_template_part('template-parts/newsflow/news-machine-item', null, array('post_id' => get_the_ID()));
		}
	} else {
		echo "<div class='news-machine-last-page'/></div>";
	}
	die();
}
add_action('wp_ajax_news_machine_loadmore', 'newsflow_news_machine_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_news_machine_loadmore', 'newsflow_news_machine_loadmore_ajax_handler');

function hasDepthAnalysis($post)
{
	$id = get_post_meta($post->ID, 'depth_analysis', true);
	$postDepthAnalysis = get_post($id);
	return isset($post) && isset($postDepthAnalysis) && ANALYSIS == strtolower(get_post_meta($postDepthAnalysis->ID, 'post_type', true));
}

//Request depth analysis
function request_depth_analysis_handler()
{

	$post_id = $_POST['postId'] ? (int)$_POST['postId'] : '';
	$message = $_POST['requestMessage'];
	$request_count = (int) get_field('request_depth_analysis', $post_id) + 1;
	$old_message = get_post_meta($post_id, 'request_depth_analysis_messages', true);
	
	if (get_post_meta($post_id, 'request_depth_analysis', true)) {
		update_post_meta($post_id, 'request_depth_analysis', $request_count);
	} else {
		add_post_meta($post_id, 'request_depth_analysis', $request_count, true);
	}
	if($old_message) {
		$new_message = $old_message . "\n" . $message;
		update_post_meta($post_id, 'request_depth_analysis_messages', $new_message);
	} else {
		add_post_meta($post_id, 'request_depth_analysis_messages', $message);
	}
	echo $request_count;
	die($request_count);
}
add_action('wp_ajax_request_depth_analysis', 'request_depth_analysis_handler');
add_action('wp_ajax_nopriv_request_depth_analysis', 'request_depth_analysis_handler');

//Init feedback
function init_feedback_handler()
{

	$post_id = $_POST['postId'] ? (int)$_POST['postId'] : '';
	$post = get_post($post_id);
	$email = $_POST['email'];
	$message = $_POST['message'];
	$doc = [
		'post_type' => 'feedback',
		'post_title' => $email,
		'post_status' => 'publish',
	];
	$id = wp_insert_post($doc);
	if ($id) {
		add_post_meta($id, 'email', $email);
		add_post_meta($id, 'message', $message);
		add_post_meta($id, 'datetime', date_create(null, new \DateTimeZone('UTC'))->format(DATE_TIME_FORMAT));
		add_post_meta($id, 'post_feedback', $post);
	}
}
add_action('wp_ajax_init_feedback', 'init_feedback_handler');
add_action('wp_ajax_nopriv_init_feedback', 'init_feedback_handler');

//Login in BI
add_action('init', 'startSession', 1);
function startSession()
{
	if (!session_id()) {
		session_start();
	}
}
add_action('parse_request', 'my_custom_url_handler');
function my_custom_url_handler()
{

	$args = [
		'clientId'                => IDP_CLIENT_ID,
		'clientSecret'            => IDP_CLIENT_SECRET,
		'redirectUri'             => REDIRECT_URI,
		'urlAuthorize'            => URL_AUTHORIZE,
		'urlAccessToken'          => URL_ACCESS_TOKEN,
		'urlResourceOwnerDetails' => URL_GET_USER_INFO
	];
	$provider = new GenericProvider($args);

	if ($_SERVER["REQUEST_URI"] == '/bi/login') {

		$options = ['scope' => 'openid email profile'];
		$authorizationUrl = $provider->getAuthorizationUrl($options);

		$_SESSION[OAUTH_STATE] = $provider->getState();
		// Redirect the user to the authorization URL
		header('Location: ' . $authorizationUrl);
		exit;
	}
	if (strpos($_SERVER["REQUEST_URI"], '/auth/callback') !== false) {
		if (empty($_GET['state']) || (isset($_SESSION[OAUTH_STATE]) && $_GET['state'] !== $_SESSION[OAUTH_STATE])) {

			if (isset($_SESSION[OAUTH_STATE])) {
				unset($_SESSION[OAUTH_STATE]);
			}
			wp_redirect(home_url());
			exit();
		} else {
			try {
				$accessToken = $provider->getAccessToken('authorization_code', [
					'code' => $_GET['code']
				]);
				$_SESSION[OAUTH_ACCESS_TOKEN] = $accessToken->getToken();
				$_SESSION[OAUTH_REFRESH_TOKEN] = $accessToken->getRefreshToken();
				$_SESSION[OAUTH_TOKEN_EXPIRED_IN] = $accessToken->getExpires();

				//get user detail from IdP
				$profile = $provider->getResourceOwner($accessToken);
				$array = $profile->toArray();
				$username = $array['name'];
				$password = $array['sub'];
				$email = $array['email'];

				if (email_exists($email)) {
					$user_id = email_exists($email);
				} else {
					$loginName = $username;
					$i = 0;
					$exitName =  get_user_by('login', $username);
					while ($exitName) {
						$i++;
						$loginName = $username . $i;
						$exitName =  get_user_by('login', $loginName);
					}
					$user_id = wp_create_user($loginName, $password, $email);
					if (is_wp_error($user_id))
						exit($user_id->get_error_message());
				}
				wp_set_current_user($user_id);
				wp_set_auth_cookie($user_id);
				wp_redirect(home_url());
				exit();
			} catch (IdentityProviderException $e) {
				exit($e->getMessage());
			}
		}
	}
	if ($_SERVER["REQUEST_URI"] == '/bi/logout') {
		wp_logout();
		wp_redirect(home_url());
		exit;
	}
}

function custom_login()
{
	if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
	} else {
        $protocol = 'http://';
    }

	$current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	
	if(isset($_COOKIE['laravel_login'])) {
		$check = $_COOKIE['laravel_login'];
		$url = home_url('/login');
		if($check && !is_user_logged_in() && $current_url !== $url && strpos($current_url, '/auth/callback') === false
			&& strpos($current_url, 'logout') === false && strpos($current_url, 'loggedout') === false ) {
			exit(wp_redirect( $url ));
		}
	}
	
}

add_action('after_setup_theme', 'custom_login');

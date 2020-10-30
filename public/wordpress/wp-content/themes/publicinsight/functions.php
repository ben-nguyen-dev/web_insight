<?php

const DATE_TIME_FORMAT = "Y-m-d\TH:i:s.v\Z";
const DATE_TIME_FORMAT_Y_M_ONLY = "Y-m-00\T00:00:00.000\Z";
const DATE_TIME_FORMAT_Y_M_D_ONLY = "Y-m-d\T00:00:00.000\Z";
const TEASER_TYPE_SMALL_WITHOUT_IMAGE = 'TEASER_TYPE_SMALL_WITHOUT_IMAGE';
const OAUTH_STATE = "OAUTH_STATE";
const OAUTH_ACCESS_TOKEN = "OAUTH_ACCESS_TOKEN";
const OAUTH_REFRESH_TOKEN = "OAUTH_REFRESH_TOKEN";
const OAUTH_TOKEN_EXPIRED_IN = "OAUTH_TOKEN_EXPIRED_IN";


require_once 'vendor/autoload.php';
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
require get_parent_theme_file_path('api/wp-rest-api.php');
require get_parent_theme_file_path('api/wp-rest-api-function.php');

// $wp_session = WP_Session::get_instance();

function publicinsight_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	// set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'pi-main-thumbnail', 730, "", 0 );
	add_image_size( 'pi-large-thumbnail', 480, "", 0 );
	add_image_size( 'pi-medium-thumbnail', 350, "", 0 );
	add_image_size( 'pi-small-thumbnail', 223, "", 0 );
	add_image_size( 'pi-tiny-thumbnail', 96, "", 0 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
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
	add_theme_support( 'title-tag' );

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
	load_theme_textdomain( 'publicinsight' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );


	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

}

add_action( 'after_setup_theme', 'publicinsight_theme_support' );


add_filter( 'intermediate_image_sizes_advanced', 'prefix_remove_default_images', 100, 1 );
// Remove default image sizes here. 
function prefix_remove_default_images( $sizes ) {
	unset( $sizes['small']); // 150px
	unset( $sizes['medium']); // 300px
	unset( $sizes['medium_large']); // 300px
	unset( $sizes['thumbnail']); // 150px
	unset( $sizes['large']); // 1024px
	unset( $sizes['1536x1536']); // 768px
	unset( $sizes['2048x2048']); // 768px
	return $sizes;
}


/**
 * Register and Enqueue Styles.
 */
function publicinsight_register_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Add CSS.
	wp_enqueue_style('font-css', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css');
	wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );
	wp_enqueue_style('bootstrap-datepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css');
	wp_enqueue_style( 'jquery-ui','//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
	wp_enqueue_style( 'publicinsight-style', get_template_directory_uri() . '/assets/css/app.css', null, $theme_version, false );
	wp_enqueue_style( 'register-style', get_template_directory_uri() . '/assets/css/register.css', null, $theme_version, false );
	if(strpos($_SERVER["REQUEST_URI"], "/calendar") !== false) { 
		wp_enqueue_style('date-range-picker-css', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css');

	}
	if(strpos($_SERVER["REQUEST_URI"], "/myposts") !== false || strpos($_SERVER["REQUEST_URI"], "/admin") !== false) {
		$path    = get_template_directory() . '/build/static/css';
		$files = getDirContents($path);
		
		foreach ($files as $file) {
			wp_enqueue_style( 'react-css-' . $file, get_template_directory_uri() . '/build/static/css/' . $file, array(), $theme_version, false );
		}
	}	
}
add_action( 'wp_enqueue_scripts', 'publicinsight_register_styles' );

		
/**
 * Register and Enqueue Scripts.
 */
function publicinsight_register_scripts() {
	global $wp_query; 

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.3.1.min.js');
	wp_enqueue_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js');
	wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
	wp_enqueue_script('bootstrap-datepicker-js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js', array(), $theme_version, false);
	wp_enqueue_script( 'publicinsight-js', get_template_directory_uri() . '/assets/js/app.js', array(), $theme_version, false );
	$translation_array = array( 'templateUrl' => get_template_directory_uri() );
	wp_localize_script( 'publicinsight-js', 'app', $translation_array );
	wp_enqueue_script('jquery-ui','https://code.jquery.com/ui/1.12.1/jquery-ui.js');
	wp_enqueue_script('jquery-touch','https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js');
	wp_enqueue_script( 'register-js', get_template_directory_uri() . '/assets/js/register.js', array(), $theme_version, false );
	// wp_enqueue_script( 'commons-js', get_template_directory_uri() . '/assets/js/commons.js', array(), $theme_version, false );
	// wp_script_add_data( 'publicinsight-js', 'async', true );
	
	
	//Register script for home page
	if(strpos($_SERVER["REQUEST_URI"], "/") !== false) { 
        wp_register_script( 'homepage-js', get_template_directory_uri() . '/assets/js/home_page.js', array(), $theme_version, false );
		wp_localize_script( 'homepage-js', 'homepage_params', array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
		) );
		wp_enqueue_script( 'homepage-js' );
	}
	//Register script for newsflow page
	if(strpos($_SERVER["REQUEST_URI"], "/newsflow") !== false) { 
        //Add resize element lib
		wp_enqueue_script('resize-js', get_template_directory_uri() . '/assets/js/css-element-queries-1.2.1/src/ResizeSensor.js');
		wp_enqueue_script('element-query-js', get_template_directory_uri() . '/assets/js/css-element-queries-1.2.1/src/ElementQueries.js');
		wp_register_script( 'newsflow-js', get_template_directory_uri() . '/assets/js/newsflow_page.js', array(), $theme_version, false );
		wp_localize_script( 'newsflow-js', 'newsflow_params', array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
			'posts' => json_encode( $wp_query->query_vars ),
			'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		) );
		wp_enqueue_script( 'newsflow-js' );
	}

	//Register script for calendar page
	if(strpos($_SERVER["REQUEST_URI"], "/calendar") !== false) { 
		wp_enqueue_script('moment-js', 'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js');
		wp_enqueue_script('date-range-picker-js', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js');

        wp_register_script( 'calendar-js', get_template_directory_uri() . '/assets/js/calendar_page.js', array(), $theme_version, false );
		wp_localize_script( 'calendar-js', 'calendar_params', array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
		) );
		wp_enqueue_script( 'calendar-js' );
	}

	//Register script for profile page
	if(strpos($_SERVER["REQUEST_URI"], "/profile") !== false) {
		wp_enqueue_script('validator-js','https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js');
		wp_register_script( 'profile-js', get_template_directory_uri() . '/assets/js/profile_page.js', array(), $theme_version, false );
		wp_localize_script( 'profile-js', 'profile_params', array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
		) );
		wp_enqueue_script( 'profile-js' );
	}
	wp_enqueue_script('ckeditor-js','https://cdn.ckeditor.com/4.14.1/standard-all/ckeditor.js');

	//Register script for profile page
	if(strpos($_SERVER["REQUEST_URI"], "/myposts") !== false) {
		wp_register_script( 'user-js', get_template_directory_uri() . '/assets/js/user.js', array(), $theme_version, false );
		wp_localize_script( 'user-js', 'user', array(
			'templateUrl' => get_template_directory_uri(),
		) );
		wp_enqueue_script( 'user-js' );
	}
	if(strpos($_SERVER["REQUEST_URI"], "/admin") !== false) {
		wp_register_script( 'admin-js', get_template_directory_uri() . '/assets/js/admin.js', array(), $theme_version, false );
		wp_localize_script( 'admin-js', 'admin', array(
			'templateUrl' => get_template_directory_uri(),
		) );
		wp_enqueue_script( 'admin-js' );
	}
	if(strpos($_SERVER["REQUEST_URI"], "/myposts") !== false || strpos($_SERVER["REQUEST_URI"], "/admin") !== false) {
		
		$path = get_template_directory() . '/build/static/js';
		$files = getDirContents($path);
		foreach ($files as $file) {
			wp_enqueue_script( 'react-js-' . $file, get_template_directory_uri() . '/build/static/js/' . $file, array(), $theme_version, true );	
		}
	}
}

add_action( 'wp_enqueue_scripts', 'publicinsight_register_scripts' );

function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);
	exec ("find " . $dir . " -type f -exec chmod 0644 {} +");
    foreach ($files as $key => $value) {
		$path = realpath($dir . DIRECTORY_SEPARATOR . $value);
		
		if(strpos($value, '.map') !== false) {
			// unlink($path);
		}
        if (!is_dir($path)) {
			// chmod($path, 0777);
			//read the entire string
			if(strpos($path, '.css') !== false)  {
				$old = '(/static/media';
				$new = '(/pi/wp-content/themes/publicinsight/build/static/media';
				$str = file_get_contents($path);
	
				//replace something in the file string - this is a VERY simple example
				$str = str_replace($old, $new, $str);
	
				//write the entire string
				file_put_contents($path, $str);
				
				$str = file_get_contents($path);
			}
			if(strpos($path, '.js') !== false) {
				$old = 'a.p+"static/media';
				$new = '"' . get_template_directory_uri() . '/build/static/media';
				$str = file_get_contents($path);
	
				//replace something in the file string - this is a VERY simple example
				$str = str_replace($old, $new, $str);
	
				//write the entire string
				file_put_contents($path, $str);
				
				$str = file_get_contents($path);
			}
			
            $results[] = $value;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $value;
        }
    }

    return $results;
}

function publicinsight_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) {
		return $html;
	}

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace( $search, $replace, $html );

		}
	}

	return $html;

}

add_filter( 'get_custom_logo', 'publicinsight_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

//Load more in newsflow page
function newsflow_loadmore_ajax_handler() {
	global $post;
	$post_id = $_POST['postId'] ? (int)$_POST['postId'] : '';
	$max_page = get_option('posts_per_page');
	$args = array( 'post_type' =>  'post', 
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'post__not_in' => array($post_id),
			'order' => 'DESC', 
			'paged' => $_POST['page'] + 1);
	$type = $_POST['type'];
	if( $type && !empty($type) ) {
		$args['meta_key'] = 'post_type';
		$args['meta_value'] = $type;
	}
	$query = new WP_Query($args);

	if( $query->have_posts() ) {
		if($query->found_posts < $max_page) {
			echo "<div class='last-page'></div>";
		}
		$i = 0;
		while( $query->have_posts() ) { 
			$query->the_post(); 
			setup_postdata($post);
			$get_post_type = strtolower(get_post_meta(get_the_ID(), 'post_type', true));
			$get_post_url = get_post_meta(get_the_ID(), 'url_link', true);
			$post_type = $get_post_type == 'news' ? 'short' : $get_post_type;			
			if ($i % 3 == 0) {
            	if($i != 0) {
					echo "</section>";
				}
				echo  "<section class='flows-block'>";
                wpse_get_template_part( 'template-parts/newsflow/head_news', null, array('post_type' => $post_type ));
			} else {
				wpse_get_template_part( 'template-parts/newsflow/sub_news', null, array('post_type' => $post_type ,'get_post_url' => $get_post_url));
			} 
			
			$i ++;
			wp_reset_postdata();
		}
	} else {
		echo "<div class='last-page'/></div>";
	}
	die();
}
add_action('wp_ajax_loadmore', 'newsflow_loadmore_ajax_handler'); 
add_action('wp_ajax_nopriv_loadmore', 'newsflow_loadmore_ajax_handler'); 

//Request depth analysis
function request_depth_analysis_handler() {

	$post_id = $_POST['postId'] ? (int)$_POST['postId'] : '';
	$request_count = (int) get_field('request_depth_analysis', $post_id) + 1;
	add_post_meta( $post_id, 'request_depth_analysis', $request_count, true);
 
	die($request_count);
}
add_action('wp_ajax_request_depth_analysis', 'request_depth_analysis_handler'); 
add_action('wp_ajax_nopriv_request_depth_analysis', 'request_depth_analysis_handler'); 

//Get truncate preamble in home page
function getTruncatedPreamble ($post_excerpt) {
	if (!empty($post_excerpt)) {
		$post_excerpt = getTruncatedWords($post_excerpt, 100);
		echo $post_excerpt;
	}
}

function getTruncatedWords($text, $maxchar, $end='...') {
	if ($text && strlen($text) > $maxchar) {
		$words = preg_split('/\s/', $text);
		$output = '';
		foreach ($words as $word) {
			$length = strlen($output) + strlen($word);
			if ($length > $maxchar) {
				break;
			} else {
				$output .= " " . $word;
			}
		}
		return $output . $end;
	} else {
		return $text;
	}
}

add_action('get_truncated_preamble', 'getTruncatedPreamble');

//Create Event, Feedback, Author a document
add_action( 'init', 'create_post_type' );
function create_post_type() {
  	register_post_type( 'event',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'add_new_item' => __( 'Add new event' ),
				'edit_item' => __( 'Edit event' )
			),
			'supports' => array(
				'title',
				'custom-fields'
			),
			'public' => true,
			'has_archive' => true,
		)
	);
	register_post_type( 'feedback',
		array(
			'labels' => array(
				'name' => __( 'Feedbacks' ),
				'singular_name' => __( 'Feedback' ),
				'add_new_item' => __( 'Add new feedback' ),
				'edit_item' => __( 'Edit feedback' )
			),
			'supports' => array(
				'custom-fields'
			),
			'public' => true,
			'has_archive' => true,
		)
	);	
}

//Request depth analysis
function init_feedback_handler() {

	$post_id = $_POST['postId'] ? (int)$_POST['postId'] : '';
	$post = get_post($post_id);
	$email = $_POST['email'];
	$message = $_POST['message'];
	$doc = [
		'post_type' => 'feedback',
		'post_title' => $email,
		'post_status' => 'publish',
	];
	$id = wp_insert_post( $doc );
	if($id) {
		add_post_meta($id, 'email', $email);
		add_post_meta($id, 'message', $message);
		add_post_meta($id, 'datetime', date_create(null, new \DateTimeZone('UTC'))->format(DATE_TIME_FORMAT));
		add_post_meta($id, 'post_feedback', $post);
	}
}
add_action('wp_ajax_init_feedback', 'init_feedback_handler'); 
add_action('wp_ajax_nopriv_init_feedback', 'init_feedback_handler');

//Get events in month on Home page
function get_events_in_month_handler() {

	$selected_date = date_create( $_GET['selected_date'] );

    $args = array (
        'post_type' => 'event',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
              'key' => 'datetime',
              'value' => $selected_date->format(DATE_TIME_FORMAT_Y_M_ONLY),
              'compare' => '>=',
            ),
            array(
                'key' => 'datetime',
                'value' => $selected_date->modify("first day of next month")->format(DATE_TIME_FORMAT_Y_M_ONLY),
                'compare' => '<',
            )
        ),
        'posts_per_page' =>  8,
        'order' => 'asc'
    );
	$events = get_posts($args);
	$result = array();
	foreach($events as $event) {
		$id = $event->ID;
		$object = [
			'id' => $id,
			'headline' => $event->post_title,
			'date' => get_field('datetime', $id)
		];
		array_push($result, $object);
	}
	echo json_encode($result);
	die();
}
add_action('wp_ajax_events_in_month', 'get_events_in_month_handler');
add_action('wp_ajax_nopriv_events_in_month', 'get_events_in_month_handler');

//Get events in month when change month on Home page
function get_events_in_range_handler ($start_date, $end_date) {
	if(empty($start_date) || empty($end_date)) {
		return null;
	}
    $args = array (
        'post_type' => 'event',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
              'key' => 'datetime',
              'value' => $start_date->format(DATE_TIME_FORMAT_Y_M_D_ONLY),
              'compare' => '>=',
            ),
            array(
                'key' => 'datetime',
                'value' => $end_date->format(DATE_TIME_FORMAT_Y_M_D_ONLY),
                'compare' => '<',
            )
        ),
        'order' => 'asc'
    );
	$events = get_posts($args);
	$currentDates = [];
	$x = clone $start_date;
	for (; $x <= $end_date; $x->add(new DateInterval("P1D"))) {
		$date = [];
		$date['value'] = clone $x;
		$date['events'] = [];
		foreach ($events as $event) {
			if ((new DateTime(get_field('datetime', $event->ID)))->format('Y-m-d') == $date['value']->format('Y-m-d')) {
				$date['events'][] = $event;
			}
		}
		$currentDates[] = $date;
	}
	return $currentDates;
}

function get_events_in_range_group_by_date_handler() {

	$start_date = date_create( $_GET['startDateStr'] );
	$end_date = date_create( $_GET['endDateStr'] );

	$currentDates = get_events_in_range_handler($start_date, $end_date);;
	
	wpse_get_template_part( 'template-parts/calendar/event_list', null, array('currentDates' => $currentDates) );
	die();
}
add_action('wp_ajax_events_in_range', 'get_events_in_range_group_by_date_handler'); 
add_action('wp_ajax_nopriv_events_in_range', 'get_events_in_range_group_by_date_handler');

//Get events in calendar page
function get_events_in_range_in_calendar_page () {
	$today = new DateTime('now');
	$end_date =  clone $today;
	$end_date->add(new DateInterval("P14D"));

	return get_events_in_range_handler($today, $end_date);
}

//Get up coming event in home page
function get_up_coming_events_in_home_page () {
	$now = date_create(null, new \DateTimeZone('UTC'));
    $args = array (
        'post_type' => 'event',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
              'key' => 'datetime',
              'value' => $now->format(DATE_TIME_FORMAT),
              'compare' => '>=',
            ),
            array(
                'key' => 'datetime',
                'value' => $now->modify("+1 month")->format(DATE_TIME_FORMAT),
                'compare' => '<',
            )
        ),
        'posts_per_page' =>  8,
        'order' => 'asc'
    );
	return get_posts($args);
}


spl_autoload_register( function($classname) {

    $class      = str_replace( '\\', DIRECTORY_SEPARATOR, strtolower($classname) ); 
    $classpath  = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class . '.php';
    
    if ( file_exists( $classpath) ) {
        include_once $classpath;
    }
   
} );

//Login with IdP
add_action('init', 'startSession', 1);
function startSession() {
    if(!session_id()) {
        session_start();
    }
}
add_action('parse_request', 'my_custom_url_handler');

function my_custom_url_handler() {

	$args = [
		'clientId'                => IDP_CLIENT_ID,
		'clientSecret'            => IDP_CLIENT_SECRET,
		'redirectUri'             => REDIRECT_URI,
		'urlAuthorize'            => URL_AUTHORIZE,
		'urlAccessToken'          => URL_ACCESS_TOKEN,
		'urlResourceOwnerDetails' => URL_GET_USER_INFO
	];
	$provider = new GenericProvider($args);
	
	if($_SERVER["REQUEST_URI"] == '/pi/login') {

		$options = ['scope' => 'openid email profile'];
		$authorizationUrl = $provider->getAuthorizationUrl($options);
		
		$_SESSION[OAUTH_STATE] = $provider->getState();
		// Redirect the user to the authorization URL
		header('Location: ' . $authorizationUrl);
		exit;
	}
	if(strpos($_SERVER["REQUEST_URI"] , '/auth/callback') !== false) {
		if (empty($_GET['state']) || (isset($_SESSION[OAUTH_STATE]) && $_GET['state'] !== $_SESSION[OAUTH_STATE])) {
			
			if (isset($_SESSION[OAUTH_STATE])) {
				unset($_SESSION[OAUTH_STATE]);
			}
			wp_redirect( home_url() );
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

				if(email_exists($email)) {
					$user_id = email_exists($email);
				} else {
					$loginName = $username;
					$i = 0;
					$exitName =  get_user_by('login', $username);
					while($exitName) {
						$i++;
						$loginName = $username.$i;
						$exitName =  get_user_by('login', $loginName );
					}
					$user_id = wp_create_user( $loginName, $password, $email );
					if ( is_wp_error( $user_id ) )
						exit( $user_id->get_error_message() );
				}
				wp_set_current_user($user_id);
				wp_set_auth_cookie($user_id);
				wp_redirect( home_url() ); 
				exit();

			} catch (IdentityProviderException $e) {
				exit($e->getMessage());
			}
			
		}
	}
	if($_SERVER["REQUEST_URI"] == '/pi/logout') {
		wp_logout();
		wp_redirect( home_url() ); 
		exit;
	}
}

function save_profile_handler() {
	$user = wp_get_current_user();
	if($user) {
		$user_id = $user->ID;
		$new_user = $user->to_array();
		$type = $_REQUEST['type'];
		if('profile' == $type) {
			$term = $_REQUEST['term'];
			$new_user['display_name'] = $_REQUEST['full_name'];
			$new_user['user_email'] = $_REQUEST['email'];
		} else {
			$userdata = array(
				'company_name' => $_REQUEST['company_name'],
				'organization_number' => $_REQUEST['org_number'],
				'address_line_1' => $_REQUEST['address_line1'],
				'address_line_2' => $_REQUEST['address_line2'],
				'zip_code' => $_REQUEST['zip_code'],
				'city' => $_REQUEST['city_name'],
				'use_different_invoice' => $_REQUEST['use_different_invoice'],
			);

			// use different invoice or not
			if ($_REQUEST['use_different_invoice']) {
				$userdata1 = array(
					'invoice_address_line_1' => $_REQUEST['invoice_address_line1'],
					'invoice_address_line_2' => $_REQUEST['invoice_address_line2'],
					'invoice_zip_code' => $_REQUEST['invoice_zip_code'],
					'invoice_city_name' => $_REQUEST['invoice_city_name'],
				);
			} else {
				$userdata1 = array(
					'invoice_address_line_1' => null,
					'invoice_address_line_2' => null,
					'invoice_zip_code' => null,
					'invoice_city_name' => null,
				);
			}
		}
		$userdata = array_merge($userdata, $userdata1);
		if(empty(get_user_meta($user_id, 'term_agreed', true))) {
			$now = date_create(null, new \DateTimeZone('UTC'));
			$userdata['term_agreed'] = $now->format('Y-m-d H:i:s');
			update_user_meta( $user_id, 'term_agreed', $now->format('Y-m-d H:i:s') );	
		}
		
		$new_user['userdata'] = $userdata;
		if(!get_field('profile_completed')){
			$array_user = array_merge($user->to_array(), $userdata);
			$flag = isCompletedProfile($array_user);
			update_user_meta( $user_id, 'profile_completed', $flag );
		}

		$update_user = save_user($new_user);
		if($update_user) {
			die(true);
		}
	}
	
	die(false);
}
add_action('wp_ajax_save_profile', 'save_profile_handler');
add_action('wp_ajax_nopriv_save_profile', 'save_profile_handler');

function set_user_document($user_id) {
	$userItem = get_userdata($user_id);
	$user = array();
	if(!empty($userItem)) {
		$id = $userItem->ID;
		$user['ID'] = $id;
		$user['display_name'] = $userItem->display_name;
		$user['user_pass'] = $userItem->user_pass;
		$user['email'] = $userItem->user_email;
		$user_meta = get_user_meta($id);
		$userdata = array(
			'company_name' => $user_meta['company_name'],
			'organization_number' => $user_meta['organization_number'],
			'address_line_1' => $user_meta['address_line_1'],
			'address_line_2' => $user_meta['address_line_2'],
			'zip_code' => $user_meta['zip_code'],
			'city' => $user_meta['city'],
			'use_different_invoice' => $user_meta['use_different_invoice'],
			'profile_completed' => $user_meta['profile_completed'],
			'term_agreed' => $user_meta['term_agreed'],
		);

		if ($user_meta['use_different_invoice']) {
			$userdata1 = array(
				'invoice_address_line_1' => $user_meta['invoice_address_line_1'],
				'invoice_address_line_2' => $user_meta['invoice_address_line_2'],
				'invoice_zip_code' => $user_meta['invoice_zip_code'],
				'invoice_city_name' => $user_meta['invoice_city_name'],
			);
		} else {
			$userdata1 = array(
				'invoice_address_line_1' => null,
				'invoice_address_line_2' => null,
				'invoice_zip_code' => null,
				'invoice_city_name' => null,
			);
		}
		$user['user_data'] = array_merge($userdata, $userdata1);
	}
	return $user;
}
function save_user($user)
{
	if($user['ID'] == '') {
		$username = $user['display_name'];
		$password = $user['user_pass'];
		$email = $user['user_email'];
		wp_create_user( $username, $password, $email );
		return true;
	} else {
		$doc = [
			'ID' => strval($user['ID']),
			'display_name' => $user['display_name'] ?? '',
			'email' => $user['email'] ?? '',
		];
		$update_user = wp_update_user($doc);
		if(is_wp_error($update_user)) {
			return false;
		}
		if($user['userdata']) {
			foreach ($user['userdata'] as $key=>$value) {
				update_user_meta( $user['ID'], $key, $value );
			}
		}
	}
	return true;
}
function isCompletedProfile($fields) {
	$validFields = ['display_name', 'company_name', 'organization_number', 'address_line_1', 'zip_code', 'city', 'term_agreed'];
	// option if user ticked on `use_different_invoice`
	$validFieldsAddition = ['invoice_address_line_1', 'invoice_address_line_2', 'invoice_zip_code', 'invoice_city_name'];

	$isUsedDiffAddress = isset($fields['use_different_invoice']) ? $fields['use_different_invoice'] : true;

	foreach ($fields as $k => $v) {
		if(in_array($k, $validFields) || ($isUsedDiffAddress && in_array($k, $validFieldsAddition))) {
			// If it has a value is empty, then return false
			if (strlen($v) == 0) {
				return false;
			}
		}
	}

	return true;
}
function validate($fields, $validationRules) {
	$errors = array();
	if(!$fields && $validationRules) {
		foreach($validationRules as $key=>$value) {
			array_push($errors, "Field " . $key . " has validation rule " . $value);
		}
	}
	foreach ($fields as $key=>$value) {
		if(array_key_exists($key, $validationRules)) {
			$rules = $validationRules[$key];
			if(strpos($rules, "|") !== false) {
				$rules = explode("|", $rules);
			}
			if(is_array($rules)) {
				foreach ($rules as $rule) {
					if($rule == "required" && empty($value)) {
						array_push($errors, "Field " . $key . " has validation rule " . $rule);
					}
					if(strpos($rule, "max") !== false && !empty($rule)) {
						if(strpos($rule, ":") !== false) {
							$max_length = (int)explode(':', $rule)[1];
							$str_length = strlen($value);
							if($str_length > $max_length) {
								array_push($errors, "Field " . $key . " has validation rule: " . $rule);
							}
						}
					}
				}
			} else if($rules == "required" && empty($value)) {
				array_push($errors, "Field " . $key . " has validation rule " . $rules);
			} else if(strpos($rules, "max") !== false && !empty($rules)) {
				if(strpos($rules, ":") !== false) {
					$max_length = (int)explode(':', $rules)[1];
					$str_length = strlen($value);
					if($str_length > $max_length) {
						array_push($errors, "Field " . $key . " has validation rule: " . $rules);
					}
				}
			}
			
		}
	}
	return $errors;
}

function generate_featured_image( $image_url, $post_id  ){
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path'])) {
		$file = $upload_dir['path'] . '/' . $filename;
	} else {
		$file = $upload_dir['basedir'] . '/' . $filename;
	}
      
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    set_post_thumbnail( $post_id, $attach_id );
}

function get_publish_time($post) {
	$updatedTime = date_create($post->post_modified);
	$now = date_create();
	$interval = date_diff($updatedTime, $now);
	if ($interval->days) {
		return $updatedTime->format('F d');
	} else if ($interval->h > 1) {
		return $interval->h . ' hours ago';
	} else if ($interval->h == 1) {
		return '1 hour ago';
	} else if ($interval->i > 1) {
		return $interval->i . ' minutes ago';
	} else {
		return '1 minute ago';
	}
}

function wpse_get_template_part($slug, $name = null, $data = []) {
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

function wpb_change_search_url() {
    if ( strpos($_SERVER["REQUEST_URI"], "/search") !== false && ! empty( $_GET['keyword'] ) ) {
        wp_redirect( home_url( "/search/" ) . urlencode( $_GET['keyword'] ) );
        exit();
    }   
}
add_action( 'template_redirect', 'wpb_change_search_url' );

function get_category_link_by_slug ($slug) {
	if($slug && $slug != '') {
		$category = get_category_by_slug($slug);
		if($category) {
			return get_category_link($category);
		}
	}
	return '';
}
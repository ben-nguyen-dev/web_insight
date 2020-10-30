<?php /* Template Name: Admin */ ?>
<?php
    $roles = $current_user->roles;
    $check_admin = false;
    if(in_array("editor", $roles)) {
        $check_admin = true; 
    }
    if($check_admin) {
        get_header();
        get_footer();
    } else {
        header("HTTP/1.1 401 Unauthorized");
	    exit;
    }
?>

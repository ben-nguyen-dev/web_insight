<?php /* Template Name: Myposts */ ?>
<?php
    $roles = $current_user->roles;
    $check_user = false;
    if(!in_array("editor", $roles)) {
        $check_user = true; 
    }
    if($check_user) {
        get_header();
        get_footer();
    } else {
        header("HTTP/1.1 401 Unauthorized");
	    exit;
    }
?>

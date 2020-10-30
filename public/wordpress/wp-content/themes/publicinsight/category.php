<?php get_header(); ?>
<?php
    $category = get_queried_object();
    wpse_get_template_part('page-templates/newsflow', null, array('category' => $category));
?>
<?php get_footer(); ?>
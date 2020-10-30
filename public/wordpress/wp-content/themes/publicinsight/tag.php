<?php get_header(); ?>
<?php
    $tag = get_queried_object();
    wpse_get_template_part('page-templates/newsflow', null, array('tag' => $tag));
?>
<?php get_footer(); ?>
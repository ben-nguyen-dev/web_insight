<?php get_header(); ?>
<div class="container">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            wpse_get_template_part( 'template-parts/newsflow/article_template', null, array('type' => 'view_detail'));
        }
    }  
    ?>
</div>
<?php
    wpse_get_template_part('page-templates/newsflow', null, array('should_direct' => false, 'type' => 'view_detail', 'post_id' => get_the_ID()));
?>
<?php get_footer(); ?>

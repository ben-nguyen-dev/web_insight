<?php

/**
 * Template Name: Newsflow
 * Template Post Type: page
 */
get_header();
?>
<div class="newsflow-page">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    ?>
</div>
<?php get_footer() ?>
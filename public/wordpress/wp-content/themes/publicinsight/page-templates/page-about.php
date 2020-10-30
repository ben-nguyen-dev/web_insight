<?php /* Template Name: About */ ?>
<?php get_header(); ?>
<div class="container">
    <section class="row about-contact-us main-photo">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="background-photo" style="background-image: url('<?php the_post_thumbnail_url('large-thumbnail', array()); ?>');">
            </div>
        </div>
    </section>
    <section class="row about-contact-us main-content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-3">
            <h1><?php echo the_title(); ?></h1>
            <p class="summary wrap text-center"><?php the_excerpt(); ?></p>
            <div class="detail wrap">
                <?php
                   echo get_post_field('post_content');
                ?>
            </div>
        </div>
    </section>
</div>
<?php get_footer(); ?>
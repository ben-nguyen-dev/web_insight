<?php
$number_of_posts = block_value('number-of-posts');
$args = array(
    'post_type' =>  'post',
    'post_status' => 'publish',
    'orderby' => 'post_date',
    'posts_per_page' => $number_of_posts,
);

$query = new WP_Query($args); ?>

<div class="container">
    <div class="justify-content-center">
        <div class="latest-articles">
            <p class="title">Latest articles</p>
            <div class="line"></div>
            <div class="article-list">
                <?php

                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        $query->the_post();
                        $post_type = get_post_meta(get_the_ID(), 'post_type', true);
                			
                        wpse_get_template_part( 'template-parts/newsflow/latest-article-item', null, array('post_type' => $post_type, 'post_id' => get_the_ID()));
			
                    endwhile;
                endif; ?>

            </div>
            <div class="btn-load-more">
                <img class="latest-load-more" src="<?php echo get_template_directory_uri() . '/assets/images/btn-loadmore.png'; ?>" />
            </div>
        </div>
    </div>
</div>
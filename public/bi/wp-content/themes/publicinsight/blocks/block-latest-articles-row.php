<?php
$number_of_posts = block_value('number-of-posts');
$args = array(
    'post_type' =>  'news_machine_post',
    'post_status' => 'publish',
    'orderby' => 'post_date',
    'posts_per_page' => $number_of_posts,
);

$query = new WP_Query($args); ?>
<div class="container news-machine-list">
    <div class="justify-content-center">
        <table class="table">
            <tbody>
                <?php

                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        $query->the_post();
                        wpse_get_template_part( 'template-parts/newsflow/news-machine-item', null, array('post_id' => get_the_ID()));
			
                    endwhile;
                endif; ?>
            </tbody>
        </table>
        <div class="news-machine-load-more">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/btn-loadmore.png'; ?>" />
        </div>
    </div>
</div>
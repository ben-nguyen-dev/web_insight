<?php 
    global $post;
    $type = 'quick-view';
    $post_id = $post_id ?? '';
    $args = array( 'post_type' =>  'post', 
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'exclude' => array($post_id),
            'order' => 'DESC',
        ); 
    if(false !== strpos($_SERVER['REQUEST_URI'], 'type=')) {
        $type = $_GET['type'];
        $args['meta_key'] = 'post_type';
        $args['meta_value'] = $type;
    }

    $query = new WP_Query($args);
    $i = 0;
    if ( $query->have_posts() ) : 
        while ( $query->have_posts() ) : 
            $query->the_post(); 
            setup_postdata($post);
            $get_post_type = strtolower(get_post_meta(get_the_ID(), 'post_type', true));
            $get_post_url = get_post_meta(get_the_ID(), 'url_link', true);
            $post_type = $get_post_type == 'news' ? 'short' : $get_post_type;
            if ($i % 3 == 0) {
                if($i != 0) : ?>
                    </section>
                <?php endif; ?>
                <section class="flows-block">
                <?php
                    wpse_get_template_part( 'template-parts/newsflow/head_news', null, array('post_type' => $post_type, 'get_post_url' => $get_post_url ));
                ?>
            <?php } else {
                wpse_get_template_part( 'template-parts/newsflow/sub_news', null, array('post_type' => $post_type , 'get_post_url' => $get_post_url));
            } 
            $i ++; 
            wp_reset_postdata();
        endwhile; 
    endif;?>
    
    </section>
    <?php
        $max_page = get_option('posts_per_page');
        if($i < $max_page) { ?>
            <div class='last-page'></div>
    <?php } ?>
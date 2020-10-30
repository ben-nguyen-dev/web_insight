<?php 
    global $post;
    $args = array( 'post_type' =>  'post', 
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'order' => 'DESC',
            'posts_per_page' => -1,
        ); 
    $text = '';
    if($keyword) {
        $args['s'] = $keyword;
        $text = 'search "<strong>' . $keyword . '</strong>"';
    }
    $tags = get_tags();
    if($tag && in_array($tag, $tags)) {
        $args['tag'] = $tag->slug;
        $text = 'tag "<strong>' . $tag->name . '</strong>"';
    }
    $categories = get_categories();
    if($category && in_array($category, $categories)) {
        $args['category_name'] = $category->slug;
        $text = 'category "<strong>' . $category->name . '</strong>"';
    }
    if(false !== strpos($_SERVER['REQUEST_URI'], 'type=')) {
        $type = $_GET['type'];
        $args['meta_key'] = 'post_type';
        $args['meta_value'] = $type;
    }
    
    $query = new WP_Query($args);
    
    if($text != '') {
        $message = '<strong>' . $query->found_posts . '</strong> results matching your ' . $text . ' were found';
        ?>
        <div class="title-msg"><?php echo $message; ?> </div>
    <?php } ?>
   
    <div class='last-page'></div>
    <?php    
    if($query->have_posts()) {
        while ( $query->have_posts() ) {
            $query->the_post(); 
            setup_postdata($post);
            $get_post_type = strtolower(get_post_meta(get_the_ID(), 'post_type', true));
            $get_post_url = get_post_meta(get_the_ID(), 'url_link', true);
            $post_type = $get_post_type == 'news' ? 'short' : $get_post_type;
            wpse_get_template_part( 'template-parts/newsflow/sub_news', null, array('post_type' => $post_type , 'get_post_url' => $get_post_url));
            wp_reset_postdata();
        }
    } ?>
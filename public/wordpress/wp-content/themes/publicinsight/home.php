<?php /* Template Name: Home */ ?>
<?php
    get_header();
    
    $featurePosts = get_field('feature_post');

    if(false !== strpos($_SERVER['REQUEST_URI'], 'type=')) {
        $type = $_GET['type'];
        $args['meta_key'] = 'post_type';
        $args['meta_value'] = $type;
        $i = 0;
        foreach ($featurePosts as $featurePost) {
            $get_type = strtolower(get_field('post_type', $featurePost->ID));
            if($type !== $get_type) {
                array_splice($featurePosts, $i, 1);
            } else {
                $i ++;
            }
            if($i == 3) break;
        } 
    }
    $args = array( 'post_type' =>  'post',
            'posts_per_page' => 10,
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'order' => 'DESC'); 
    $posts = get_posts($args);
?>

<section class="container focus-news">
    <div class="row d-flex">
        <div class="col-12 col-lg-8 border-right-news">
            <div class="row head-news">
                <?php 
                    global $should_direct;
                    $should_direct = true;
                    $post = count($featurePosts) > 0 ? $featurePosts[0] : null;
                    get_template_part( 'template-parts/home/head_news' );
                ?>  
            </div>
            <div class="row sub-head-news d-flex">
                <article class="col-12 col-md-6 item">
                    <?php 
                        $post = count($featurePosts) > 1 ? $featurePosts[1] : null;
                        get_template_part( 'template-parts/home/small_teaser_with_top_image' );
                    ?>
                </article>
                <article class="col-12 col-md-6 item">
                    <?php 
                        $post = count($featurePosts) > 2 ? $featurePosts[2] : null;
                        get_template_part( 'template-parts/home/small_teaser_with_top_image' );
                    ?>
                </article>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="row pb-4">
                <div class="col-sm-12 col-md-6 col-lg-12 col-xl-12 block-content left">
                    <div class="header">EVENT CALENDAR</div>
                    <div id="date_picker" class="event-calendar">
                        <!--Display calendar by js here-->
                    </div>
                </div>
                <?php 
                    get_template_part( 'template-parts/home/events' );
                ?>
            </div>
        </div>
    </div>
</section>
<section class="container top-news">
    <div class="row overwrite-row">
        <div class="col-12">
            <div class="block-content main">
                <div class="header">TOP NEWS POPULAR</div>
            </div>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col-12 col-lg-8 border-right-news">
            <?php  
                $post = count($posts) > 0 ? $posts[0] : null;
                get_template_part( 'template-parts/home/top_news' );
            ?>
            <div class="row pt-lg-3 pad-top-3 pad-bot-3 border-bottom-color">
                <?php  
                    $post = count($posts) > 1 ? $posts[1] : null;
                    get_template_part( 'template-parts/home/small_teaser_with_right_image' );
                    $post = count($posts) > 2 ? $posts[2] : null;
                    get_template_part( 'template-parts/home/small_teaser_with_right_image' );
                ?>          
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="row left">
                <?php  
                    $post = count($posts) > 3 ? $posts[3] : null;
                    get_template_part( 'template-parts/home/small_teaser_without_image' );
                    $post = count($posts) > 4 ? $posts[4] : null;
                    get_template_part( 'template-parts/home/small_teaser_without_image' );
                    $post = count($posts) > 5 ? $posts[5] : null;
                    get_template_part( 'template-parts/home/small_teaser_without_image' );
                ?>
            </div>
        </div>
    </div>
</section>
<section class="container other-news">
    <div class="row overwrite-row">
        <div class="col-12">
            <div class="block-content main">
                <div class="header">OTHER NEWS</div>
            </div>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col-sm-12 col-md-6 col-lg-4 border-right-other other-cols-1">
            <?php  
                $post = count($posts) > 6 ? $posts[6] : null;
                get_template_part( 'template-parts/home/small_teaser_with_top_image' );
            ?>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 border-right-other other-cols-2">
            <?php  
                $post = count($posts) > 7 ? $posts[7] : null;
                get_template_part( 'template-parts/home/small_teaser_without_image_large_title' );
                $post = count($posts) > 8 ? $posts[8] : null;
                get_template_part( 'template-parts/home/small_teaser_without_image_large_title' );
            ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4 border-right-other other-cols-3">
            <?php  
                $post = count($posts) > 9 ? $posts[9] : null;
                get_template_part( 'template-parts/home/small_teaser_other_news_with_image' );
            ?>
        </div>
    </div>
</section>

<?php
get_footer();
?>

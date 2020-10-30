<!-- {{--assume we have $post as input--}} -->
<?php  
    if(isset($post)):?>
        <article class="col-12">
            <div class="photo">
                <?php 
                    $get_post_type = strtolower(get_post_meta($post->ID, 'post_type', true));
                    $get_post_url = get_post_meta(get_the_ID(), 'url_link', true);
			        $post_type = $get_post_type == 'news' ? 'short' : $get_post_type;
                    wpse_get_template_part( 'template-parts/teaser_main_image', null, array('post_type' => $post_type, 'should_direct' => true));
                ?>
            </div>
            <div class="content">
                <?php 
                    get_template_part( 'template-parts/teaser_header' );
                ?>
                <h1 class="title wrap">
                    <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin"></i>
                    <?php 
                        wpse_get_template_part( 'template-parts/teaser_headline', null, array('post_type' => $post_type, 'should_direct' => true, 'get_post_url' => $get_post_url));
                    ?>
                </h1>
                <div class="article-desc summary-1 wrap">
                    <a href="<?php echo get_permalink(); ?>">
                        <?php echo the_excerpt(); ?>
                    </a>
                    <?php 
                        get_template_part( 'template-parts/teaser_publish_time' );
                    ?>
                </div>
            </div>
        </article>
    <?php endif; ?>
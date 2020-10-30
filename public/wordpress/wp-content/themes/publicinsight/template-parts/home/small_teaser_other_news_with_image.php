<?php 
    if(isset($post)): 
        $get_post_type = strtolower(get_post_meta($post->ID, 'post_type', true));
        $get_post_url = get_post_meta(get_the_ID(), 'url_link', true);
        $post_type = $get_post_type == 'news' ? 'short' : $get_post_type;
        ?>
        <div class="photo d-md-none d-lg-block">
            <?php 
                get_template_part( 'template-parts/teaser_medium_image' );
            ?>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-12 col-xl-12">
                    <?php 
                        get_template_part( 'template-parts/teaser_header' );
                    ?>
                    <h2 class="title wrap">
                        <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin"></i>
                        <?php 
                            wpse_get_template_part( 'template-parts/teaser_headline', null, array('get_post_url' => $get_post_url));
                        ?>
                    </h2>
                    
                    <div class="article-desc summary-2 wrap">
                        <a href="<?php echo get_permalink(); ?>">
                            <?php echo the_excerpt(); ?>
                        </a>
                        <?php 
                            get_template_part( 'template-parts/teaser_publish_time' );
                        ?>
                    </div>
                </div>
                <div class="col-md-4 d-none d-md-block d-lg-none">
                    <div class="photo">
                        <?php 
                            get_template_part( 'template-parts/teaser_main_image' );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
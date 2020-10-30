<?php 
    if(isset($post)): 
        $get_post_type = strtolower(get_post_meta($post->ID, 'post_type', true));
        $get_post_url = get_post_meta(get_the_ID(), 'url_link', true);
        $post_type = $get_post_type == 'news' ? 'short' : $get_post_type;
        ?>
        <div class="col-12 col-md-6 sub-top-news">
            <article class="row">
                <div class="col-12">
                    <div class="content">
                        <?php 
                            get_template_part( 'template-parts/teaser_header' );
                        ?>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="content">
                        <div class="row">
                            <div class="col-7 col-md-8 col-lg-12 title-photo">
                                <h2 class="title wrap title-h4">
                                    <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin-h4"></i>
                                    <?php 
                                        wpse_get_template_part( 'template-parts/teaser_headline', null, array('post_type' => $post_type, 'should_direct' => true, 'get_post_url' => $get_post_url));
                                    ?>
                                </h2>
                            </div>
                            <div class="col-5 col-md-4 photo d-block d-lg-none">
                                <!-- This image will be show on mobile -->
                                <?php 
                                    wpse_get_template_part( 'template-parts/teaser_main_image', null, array('post_type' => $post_type, 'should_direct' => true));
                                ?>
                            </div>
                        </div>
                        <div class="article-desc summary-2 wrap">
                            <a href="<?php echo get_permalink(); ?>">
                                <?php echo the_excerpt(); ?>
                            </a>
                            <?php 
                                get_template_part( 'template-parts/teaser_publish_time' );
                            ?>  
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 d-none d-lg-block">
                    <!-- This image will be invisible on mobile -->
                    <div class="photo">
                        <?php 
                            get_template_part( 'template-parts/teaser_tiny_image' );
                        ?>
                    </div>
                </div>
            </article>
        </div>
    <?php endif; ?>
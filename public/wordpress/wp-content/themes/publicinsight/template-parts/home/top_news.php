<?php
    if(isset($post)) : 
        $get_post_type = strtolower(get_post_meta($post->ID, 'post_type', true));
        $get_post_url = get_post_meta(get_the_ID(), 'url_link', true);
        $post_type = $get_post_type == 'news' ? 'short' : $get_post_type;
        ?>
        <article class="row border-bottom">
            <div class="col-12 col-md-8">
                <div class="content">
                    <?php 
                        get_template_part( 'template-parts/teaser_header' );
                    ?>
                    <div class="row">
                        <div class="col-7 col-md-12 title-photo">
                            <h2 class="title wrap title-h3">
                                <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin-h3"></i>
                                <?php 
                                    wpse_get_template_part( 'template-parts/teaser_headline',null, array('get_post_url' => $get_post_url) );
                                ?>
                            </h2>
                        </div>
                        <div class="col-5 photo d-block d-sm-none d-none d-sm-block d-md-none">
                            <?php
                                get_template_part( 'template-parts/teaser_main_image' );
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 article-desc summary-2 wrap">
                            <a href="<?php echo get_permalink(); ?>">
                                <?php echo the_excerpt(); ?>    
                            </a>
                            <?php 
                                get_template_part( 'template-parts/teaser_publish_time' );
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This image will be invisible on mobile -->
            <div class="col-12 col-md-4 d-none d-md-block d-lg-none d-none d-lg-block d-xl-none d-none d-xl-block">
                <div class="photo">
                    <?php 
                        global $should_direct;
                        $should_direct = true;
                        get_template_part( 'template-parts/teaser_small_image' );
                    ?>
                </div>
            </div>
        </article>
    <?php endif; ?>
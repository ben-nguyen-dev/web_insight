<?php
    global $post;
    if(isset($post) && !empty($post)):?>
    <article class="sub-news sub-news-container">
        <div class="row">
            <div class="col-12 col-md-8 popup-link">
                <div class="content">
                    <?php 
                        get_template_part( 'template-parts/teaser_header' );
                    ?>
                    <div class="row">
                        <div class="col-7 col-md-12 title-photo">
                            <h2 class="title wrap title-h3">
                                <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin-h3"></i>
                                <?php 
                                    wpse_get_template_part( 'template-parts/teaser_headline', null, array('type' => 'quick-view', 'post_type' => $post_type, 'should_direct' => false, 'get_post_url' => $get_post_url));
                                ?>
                            </h2>
                        </div>
                        <!-- This image will be show on mobile -->
                        <div class="col-5 photo d-block d-md-none">
                            <?php 
                                wpse_get_template_part( 'template-parts/teaser_main_image', null, array('should_direct' => false, 'post_type' => $post_type) );
                            ?>
                        </div>
                    </div>
                    <div class="article-desc summary-2 wrap">
                        <a class="quick-view" href="javascript:void(0)">
                            <?php echo the_excerpt(); ?>
                        </a>
                        <?php 
                            get_template_part( 'template-parts/teaser_publish_time' );
                        ?>
                    </div>
                </div>
            </div>
            <!-- This image will be invisible on mobile -->
            <div class="col-md-4 popup-link d-none d-md-block">
                <div class="photo">
                    <?php 
                        wpse_get_template_part( 'template-parts/teaser_small_image', null, array('should_direct' => false, 'post_type' => $post_type) );
                    ?>
                </div>
            </div>
        </div>
        <!-- {{--Article template for show on popup--}} -->
        <?php 
            wpse_get_template_part( 'template-parts/newsflow/article_template', null, array('type' => 'quick-view') );
        ?>
    </article>
<?php
endif;?>
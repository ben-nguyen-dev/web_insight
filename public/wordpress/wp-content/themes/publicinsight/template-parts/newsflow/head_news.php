<?php 
    global $post;
    if(isset($post) && !empty($post)): ?>
        <article class="head-news head-news-container">
            <div class="photo popup-link">
                <?php 
                    wpse_get_template_part( 'template-parts/teaser_main_image', null, array('should_direct' => false, 'post_type' => $post_type) );
                ?>
            </div>
            <div class="content popup-link">
                <?php 
                    get_template_part( 'template-parts/teaser_header' );
                ?>
                <h2 class="title wrap title-h1">
                    <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin"></i>
                    <?php 
                        wpse_get_template_part( 'template-parts/teaser_headline', null, array('type' => 'quick-view', 'post_type' => $post_type, 'should_direct' => false, 'get_post_url' => $get_post_url));
                    ?>
                </h2>
                <div class="article-desc summary-1 wrap">
                    <a class="quick-view" href="javascript:void(0)">
                        <?php echo the_excerpt(); ?>
                    </a>
                    <?php 
                        get_template_part( 'template-parts/teaser_publish_time' );
                    ?>
                </div>
            </div>
            <!-- {{--Article template for show on popup--}} -->
            <?php 
                wpse_get_template_part( 'template-parts/newsflow/article_template', null, array('type' => 'quick-view') );
            ?>
        </article>
<?php 
endif;?>
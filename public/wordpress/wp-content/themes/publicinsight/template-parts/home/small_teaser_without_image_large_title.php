<?php 
    if(isset($post)): 
        $get_post_type = strtolower(get_post_meta($post->ID, 'post_type', true));
        $get_post_url = get_post_meta(get_the_ID(), 'url_link', true);
        $post_type = $get_post_type == 'news' ? 'short' : $get_post_type;
        ?>
        <article class="content">
            <?php 
                get_template_part( 'template-parts/teaser_header' );
            ?>
            <div class="d-flex title-photo">
                <h2 class="title wrap title-h3">
                    <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin-h4"></i>
                    <?php 
                        wpse_get_template_part( 'template-parts/teaser_headline', null, array('post_type' => $post_type, 'should_direct' => true, 'get_post_url' => $get_post_url));
                    ?>
                </h2>
            </div>
            <div class="article-desc summary-2 wrap">
                <a href="<?php echo get_permalink(); ?>">
                    <?php echo the_excerpt(); ?>
                </a>
                <?php 
                    get_template_part( 'template-parts/teaser_publish_time' );
                ?>
            </div>
        </article>
    <?php endif; ?>
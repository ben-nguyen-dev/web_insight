<div class="container">
    <div class="justify-content-center">
        <div class="feature-posts">
            <?php
            $first_post = block_value('first-feature-post');
            $second_post = block_value('second-feature-post');
            $third_post = block_value('third-feature-post');
            $first_post_type = get_post_meta($first_post->ID, 'post_type', true);
            $second_post_type = get_post_meta($second_post->ID, 'post_type', true);
            $third_post_type = get_post_meta($third_post->ID, 'post_type', true);
            ?>

            <div class="main-feature-posts">
                <?php
                if (has_post_thumbnail($first_post)) { ?>
                    <div class="post-item" style="background-image: url('<?php echo get_the_post_thumbnail_url($first_post, 'pi-large-thumbnail'); ?>')">
                        <div class="heading-inner">
                            <?php if (NORMAL != $first_post_type) : ?>
                                <span class="btn btn-post-type <?php echo $first_post_type; ?>"><?php echo $first_post_type; ?></span>
                            <?php endif; ?>
                            <a href="<?php echo get_permalink($first_post); ?>"><?php echo $first_post->post_title; ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="sub-feature-posts">
                <div class="post-item" style="background-image: url('<?php echo get_the_post_thumbnail_url($second_post, 'pi-medium-thumbnail'); ?>')">
                    <div class="heading-inner">
                        <?php if (NORMAL != $second_post_type) : ?>
                            <span class="btn btn-post-type <?php echo $second_post_type; ?>"><?php echo $second_post_type; ?></span>
                        <?php endif; ?>
                        <a href="<?php echo get_permalink($second_post); ?>"><?php echo $second_post->post_title; ?></a>
                    </div>
                </div>
                <div class="post-item" style="background-image: url('<?php echo get_the_post_thumbnail_url($third_post, 'pi-medium-thumbnail'); ?>')">
                    <div class="heading-inner">
                        <?php if (NORMAL != $third_post_type) : ?>
                            <span class="btn btn-post-type <?php echo $third_post_type; ?>"><?php echo $third_post_type; ?></span>
                        <?php endif; ?>
                        <a href="<?php echo get_permalink($third_post); ?>"><?php echo $third_post->post_title; ?></a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
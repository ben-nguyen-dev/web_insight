<?php
$analysis_post = block_value('analysis-post');
$first_post = block_value('first-depth-analysis-post');
$second_post = block_value('second-depth-analysis-post');
$analysis_post_type = get_post_meta($analysis_post->ID, 'post_type', true);
$first_post_type = get_post_meta($first_post->ID, 'post_type', true);
$second_post_type = get_post_meta($second_post->ID, 'post_type', true);
?>
<div class="depth-analysis-articles">
    <div class="image">
        <img src="<?php echo get_the_post_thumbnail_url($analysis_post, 'pi-main-thumbnail'); ?>" />
    </div>
    <div class="depth-analysis-post">
        <div class="article-item">
            <a class="post-title" href="<?php echo get_permalink($first_post); ?>"><?php echo $analysis_post->post_title; ?></a>
            <div class="post-type-date">
                <?php if ('normal' != $analysis_post_type) : ?>
                    <span class="btn btn-post-type <?php echo $analysis_post_type; ?>"><?php echo $analysis_post_type; ?></span>
                <?php endif; ?>
                <span class="post-date"><?php echo get_the_date('', $analysis_post) . ' at ' . get_the_time('', $analysis_post); ?></span>
            </div>
            <div class="post-excerpt">
                <?php echo $analysis_post->post_excerpt; ?>
            </div>
        </div>
        <div class="depth-analysis">
            <div class="article-item">
                <div class="article-image">
                    <?php echo get_the_post_thumbnail($first_post, 'pi-small-thumbnail'); ?>
                </div>
                <div class="article-content">
                    <span class="post-date"><?php echo get_the_date('', $first_post) . ' at ' . get_the_time('', $first_post); ?></span>
                    <a class="post-title" href="<?php echo get_permalink($first_post); ?>"><?php echo $first_post->post_title; ?></a>
                    <div class="post-type-depth">
                        <?php if ('normal' != $first_post_type) : ?>
                            <span class="btn btn-post-type <?php echo $first_post_type; ?>"><?php echo $first_post_type; ?></span>
                        <?php endif; ?>
                        <div class="type-depth">
                            <i class="icons depth pin"></i>
                            <span class="label-analysis">Depth analysis</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="article-item">
                <div class="article-image">
                    <?php echo get_the_post_thumbnail($second_post, 'pi-small-thumbnail'); ?>
                </div>
                <div class="article-content">
                    <span class="post-date"><?php echo get_the_date('', $second_post) . ' at ' . get_the_time('', $second_post); ?></span>
                    <a class="post-title" href="<?php echo get_permalink($first_post); ?>"><?php echo $second_post->post_title; ?></a>
                    <div class="post-type-depth">
                        <?php if ('normal' != $second_post_type) : ?>
                            <span class="btn btn-post-type <?php echo $second_post_type; ?>"><?php echo $second_post_type; ?></span>
                        <?php endif; ?>
                        <div class="type-depth">
                            <i class="icons depth pin"></i>
                            <span class="label-analysis">Depth analysis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
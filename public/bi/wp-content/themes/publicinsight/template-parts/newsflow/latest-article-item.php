<?php 
$post_id = $post_id ?? '';
?>
<div class="article-item">
    <div class="article-image">
        <?php echo get_the_post_thumbnail($post_id, 'pi-medium-thumbnail'); ?>
    </div>
    <div class="content">
        <a class="post-title" href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
        <div class="post-type-date">
            <?php if (NORMAL != $post_type) : ?>
                <span class="btn btn-post-type <?php echo $post_type; ?>"><?php echo $post_type; ?></span>
            <?php endif; ?>
            <span class="post-date"><?php echo get_the_date(null, $post_id) . ' at ' . get_the_time(null, $post_id); ?></span>
        </div>
        <div class="post-excerpt">
            <?php echo get_the_excerpt($post_id); ?>
        </div>
    </div>
</div>

<?php if (has_post_thumbnail()): ?>
    <a class="<?php echo (isset($post_type) ? $post_type : ''); ?>"
        href="<?php if(isset($should_direct) && $should_direct) echo get_permalink(); else echo "javascript:void(0)"; ?>">
        <?php
            the_post_thumbnail('pi-tiny-thumbnail', array());
        ?>

    </a>
<?php endif; ?>
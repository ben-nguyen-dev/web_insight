<?php
$number_of_posts = block_value('number-of-posts');
$args = array(
    'post_type' =>  'post',
    'post_status' => 'publish',
    'orderby' => 'post_date',
    'posts_per_page' => $number_of_posts,
    'offset' => 3
);

$query = new WP_Query($args);
?>
<div class="container">
    <div class="justify-content-center">
        <div class="third-latest-articles">
            <div class="head-article">
                <?php
                $i = 0;
                if ($query->have_posts()) :
                    while ($query->have_posts() && $i == 0) :
                        $query->the_post();
                        $post_type = get_post_meta(get_the_ID(), 'post_type', true);
                ?>
                        <div class="post-item" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'pi-large-thumbnail'); ?>')">
                            <div class="heading-inner">
                                <?php if (NORMAL != $post_type) : ?>
                                    <span class="btn btn-post-type <?php echo $post_type; ?>"><?php echo $post_type; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a class="title" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                <?php
                        $i++;
                    endwhile;
                endif; ?>
            </div>
            <div class="sub-articles">
                <?php
                $i = 0;
                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        if ($i != 0) :
                            $query->the_post();
                            $post_type = get_post_meta(get_the_ID(), 'post_type', true);
                ?>
                            <div class="article-item">
                                <div class="article-image">
                                    <?php the_post_thumbnail('pi-small-thumbnail'); ?>
                                </div>
                                <div class="article-content">
                                    <a class="post-title" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                                    <div class="post-type-date">
                                        <?php if (NORMAL != $post_type) : ?>
                                            <span class="btn btn-post-type <?php echo $post_type; ?>"><?php echo $post_type; ?></span>
                                        <?php endif; ?>
                                        <span class="post-date"><?php echo get_the_date() . ' at ' . get_the_time(); ?></span>
                                    </div>
                                </div>
                            </div>
                <?php
                        endif;
                        $i ++;
                    endwhile;
                endif; ?>
            </div>
        </div>
    </div>
</div>
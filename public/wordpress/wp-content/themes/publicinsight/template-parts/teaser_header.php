<!-- {{--Include tag and "Depth analysis"--}} -->
<div class="head-cate d-flex justify-content-between">
    <?php 
        $tags = get_the_tags(); 
        if ( !empty($tags) ) {
            $tag_link = get_tag_link( $tags[0]->term_id );?>
            <div><a href="<?php echo $tag_link; ?>"><?php echo $tags[0]->name;?></a></div>
        <?php } 
        $postDepthAnalysis = get_field('depth_analysis');
        if($postDepthAnalysis && !empty($postDepthAnalysis) && 'analysis' == get_field('post_type', $postDepthAnalysis->ID)): 
        ?>
            <div>
                <a href=<?php echo get_post_permalink($postDepthAnalysis->ID); ?>, true)}}>
                    <i class="icons depth pin"></i>
                    <span class="label-analysis">Depth analysis</span>
                </a>
            </div>
        <?php endif; ?>
</div>
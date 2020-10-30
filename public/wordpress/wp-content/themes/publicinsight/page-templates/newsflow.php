<?php /* Template Name: Newsflow */ ?>
<?php
    get_header();
    
    $class_type                  = isset($type) && $type == 'view_detail' ? 'full-view' : '';
    $keyword                     = $keyword ?? '';
    $tag                         = $tag ?? '';
    $category                    = $category ?? '';
?>

<div class="container news-flow <?php echo $class_type; ?>">
    <div class="row d-flex">
        <div id="right_content" class="col-12 col-lg-8 border-right-news">
            <?php 
                $tags = get_tags();
                $post_id = $post_id ?? '';
                if($keyword == '' && !in_array($tag, $tags) && $category == '') {
                    wpse_get_template_part( 'template-parts/newsflow/full_items', null, array('post_id' => $post_id ));
                } else {
                    wpse_get_template_part('template-parts/newsflow/full_items_search', null, array('post_id' => $post_id, 'keyword' => $keyword, 'tag' => $tag, 'category' => $category));
                }
            ?>
        </div>
        <div class="col-12 col-lg-4 right-info">
            <section class="block-content left">
                <?php 
                    get_template_part( 'template-parts/newsflow/related_tags' );
                ?>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();
?>

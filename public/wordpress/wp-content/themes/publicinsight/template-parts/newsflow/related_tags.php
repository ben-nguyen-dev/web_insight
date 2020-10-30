<div class="tag-header">TAGS</div>
<div class="tag-list-group">
    <ul class="list-group list-group-flush">
        <?php
            $tags = get_tags(array(
                'hide_empty' => false
            ));
            foreach($tags as $tag): 
                $tag_link = get_tag_link( $tag->term_id ); ?>
                <li class="list-group-item d-flex">
                    <div class="photo">
                        <a href="<?php echo $tag_link; ?>">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="content">
                        <a href="<?php echo $tag_link; ?>"><?php echo $tag->name; ?></a>
                    </div>
                </li>
            <?php endforeach; ?>
    </ul>
</div>
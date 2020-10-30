<?php
    $externalLink = get_post_meta($post->ID, 'external_links', true);
    if ( !empty($externalLink) ):
        $text = $externalLink['title'];
        $source = $title = $text;
        if(strpos($text, '-')) {
            $arr = explode('-', $text);
            $source = trim($arr[0]);
            $title = trim($arr[1]);
        }
?>
    <div class="article-source">
        <div class="related-link-header">RELATED LINKS</div>
        <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="source-link"><a href="<?php echo str_replace(home_url(), '', $externalLink['url']); ?>" target="_blank"><?php echo $title; ?></a></div>
            <div class="source-name"><?php echo $source; ?></div>
        </li>
        </ul>
    </div>
<?php endif ?>
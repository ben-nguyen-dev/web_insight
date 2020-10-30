<?php
$number_of_posts = block_value('column');
$tags = get_tags();
$row = (int) (count($tags) / $number_of_posts);
?>

<div class="tag-cloud">
    <div class="container">
        <div class="justify-content-center">
            <div class="header">TAG CLOUD</div>
            <div class="line"></div>
            <div class="tag-list">
                <table class="table">
                    <tbody>
                        <?php for ($i = 0; $i < count($tags); $i +=4) : ?>
                            <tr>
                                <?php for ($j = $i; $j < (($i+1) * $number_of_posts); $j++) :
                                    if ($j < count($tags)) : ?>
                                        <td class="border-left-0 border-right-0"><?php echo $tags[$j]->name; ?></td>
                                <?php endif;
                                endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
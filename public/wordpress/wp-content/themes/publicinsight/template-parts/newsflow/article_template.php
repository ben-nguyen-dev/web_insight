<?php
    global $post;
    if(isset($post)):
        $post_id = $post->ID;
        $post_publish_date           = date( 'Y-m-d', strtotime( $post->post_date ) );
        $current_date                = date( 'Y-m-d' );
        
        $type                        = isset($type) ? $type : '';
        $class_type                  = $type == 'view_detail' ? 'full-view-details' : 'popup-quick-view';
        $get_post_type               = strtolower(get_post_meta($post->ID, 'post_type', true));
        $get_post_url                = get_post_meta(get_the_ID(), 'url_link', true);
        $post_type                   = $get_post_type == 'news' ? 'short' : $get_post_type;
        
?>
    <div class="<?php echo $class_type; ?>">
        <input type="hidden" id="post-id" value="<?php echo $post_id; ?>">
        <div class="row d-flex">
            <div class="col-12 col-lg-8 border-right-news close-on-click">
                <div class="row head-news">
                    <article class="col-12">
                    <input type="hidden" id="post-detail-link"
                        value="<?php echo str_replace(home_url(), '', get_permalink()); ?>">
                        <div class="photo">
                            <?php 
                                wpse_get_template_part('template-parts/teaser_main_image', null, array('should_direct' => false, 'post_type' => $post_type));
                            ?>
                        </div>
                        <div class="content-details">
                            <?php 
                                get_template_part( 'template-parts/teaser_header' );
                            ?>
                            <?php if ($class_type == 'full-view-details'): ?>
                                <h1 class="title wrap">
                                    <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin"></i>
                                    <?php echo the_title(); ?>
                                </h1> 
                            <?php else: ?> 
                                <h2 class="title wrap title-h1">
                                    <i class="fas fa-square-full i-small <?php echo $post_type; ?> pin"></i>
                                    <?php 
                                        wpse_get_template_part( 'template-parts/teaser_headline', null, array('type' => 'quick-view', 'post_type' => $post_type, 'should_direct' => false, 'get_post_url' => $get_post_url));
                                    ?>
                                </h2>
                            <?php endif ?>
                            <div class="article-desc summary-1 wrap">
                                <?php
                                    the_content();
                                ?>
                            </div>
                            <?php 
                                get_template_part( 'template-parts/newsflow/external_links' );
                            ?>
                        </div>
                    </article>
                </div>
            </div>
            <?php
                $subject = get_the_title();
                $url = get_permalink();
                $domain = $_SERVER['SERVER_NAME'];
                $authors = get_field('authors', $post_id);
                $authorName = '';
                $authorEmail = '';
                if ( $authors ) {
                    foreach ($authors as $author) {
                        if(isset($author['display_name']) && $author['display_name'] != '') {
                            $authorName = $authorName !== '' ? $authorName . ', '. $author['display_name'] : $author['display_name'];
                        }
                        if(isset($author['user_email']) && $author['user_email'] != '') {
                            $authorEmail = $authorEmail !== '' ? $authorEmail . ', '. $author['user_email'] : $author['user_email'];
                        }  
                    }
                }
                $tags = get_the_tags(); 
                if($tags && $tags[0]) {
                    $tag = $tags[0]->name;
                } else {
                    $tag = '';
                }

            ?>
            
            <div class="col-12 col-lg-4 right-info">
                <section class="block-content left">
                    <div class="close-popup">
                        <a href="javascript:void(0)" title="Close" alt="Close"><i class="icons close"></i></a>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-top-0 border-bottom-0 pt-xl-0 pt-lg-0 pb-0">
                            <div class="font-weight-bold">
                                By <a href="mailto:<?php echo $authorEmail . '?subject=PublicInsight - ' . $subject . '&body=Hi ' . $authorName . ',%0A%0A' . $subject . '%0A' . $url; ?>"
                                onclick="window.open(this.href, 'Share via Email', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800');return false;"
                                target="_blank"><?php echo $authorName; ?></a>
                            </div>
                            <?php 
                                get_template_part( 'template-parts/teaser_publish_time' );
                            ?>
                        </li>
                        <li class="list-group-item border-top-0 py-2">
                            <div class="socials">
                                <div class="logo d-flex">
                                    <div><a href="https://twitter.com/intent/tweet?text=<?php echo $subject . '&url=' . $url . '&via=PublicInsight-' . $tag . '&original_referer=' . $domain; ?>"
                                            onclick="window.open(this.href, 'Share on Twitter', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" title="Share on Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a></div>
                                    <div><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"
                                            onclick="window.open(this.href, 'Share on Facebook', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a></div>
                                    <div><a href="mailto:?subject=<?php echo $subject . '&body=' . $subject . '%0A' . $url; ?>"
                                            onclick="window.open(this.href, 'Share via Email', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800');return false;"
                                            target="_blank" title="Share via Email"><i class="fas fa-envelope"></i></a></div>
                                    <div><a href="javascript:void(0);" id="direct_link" title="Share Link"><i class="fas fa-link"></i></a></div>
                                </div>
                                <div class="input-group direct-link">
                                    <input type="text" class="form-control" readonly="readonly" value="<?php echo $url; ?>"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="button">Copy</button>
                                    </div>
                                </div>
                                <?php if($type != 'view_detail'): ?>
                                    <div class="link pt-3 pb-3">
                                        <a href="<?php echo $url; ?>" target="_blank">Open to new tab<i class="fas fa-external-link-alt ml-1"></i></a>
                                    </div>
                                <?php endif; ?> 
                            </div>
                        </li>
                        <!-- if($post['type'] != "analysis" && !PostUtils::hasDepthAnalysis($post)) -->
                        <?php
                        $id = get_post_meta($post_id, 'depth_analysis', true); 
                        $postDepthAnalysis = get_post($id);
                        if($post_type != "analysis" && $postDepthAnalysis && !empty($postDepthAnalysis) && 'analysis' == strtolower(get_post_meta($postDepthAnalysis->ID, 'post_type', true))): ?>
                            <li id="request_depth_analysis" class="list-group-item">
                                <div class="poll pt-2">
                                    <form onsubmit="return false;">
                                        <input type="hidden" name="postId" value="<?php echo $post_id; ?>"/>
                                        <div class="q">Do you want to let us write a depth analysis for this article?</div>
                                        <div class="answer">
                                            <button name="btnCancel" type="button" class="btn btn-outline-dark btn-lg">No</button>
                                            <button name="btnSubmit" type="button" class="btn btn-outline-dark btn-lg active">Yes</button>
                                        </div>
                                    </form>
                                    <p id="loading" style="display: none">Sending your request...</p>
                                    <p id="request_depth_analysis_result" style="display: none">Number of requests for us to write a depth analysis for this article: <?php echo get_post_meta($post_id, 'request_depth_analysis', true) ?? "0" ?></p>
                                </div>
                            </li>
                        <?php endif; ?>

                        <li class="list-group-item">
                            <div class="form-feedback pt-2">
                                <form onsubmit="return false;">
                                    <div class="form-group">
                                        <label>Feedback</label>
                                        <input type="hidden" name="postId" value="<?php echo $post_id; ?>"/>
                                        <input type="email" class="form-control" id="input-email" name="email" aria-describedby="emailHelp" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" id="description1" rows="5" placeholder="Messages"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-outline-dark active btn-lg w-100">Send</button>
                                </form>
                                <p id="loading" style="display: none">Sending your feedback...</p>
                                <p id="send_feedback_result" style="display: none"></p>
                            </div>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </div> 
<?php endif; ?>
<ul class="list-group list-group-flush">
    <?php
    if (is_user_logged_in()) :
        $post_id = $post->ID;    
        $current_user = wp_get_current_user();   
    ?>
        <li class="list-group-item">
            <div class="form-feedback pt-2">
                <form onsubmit="return false;">
                    <div class="form-group">
                        <label>Feedback</label>
                        <input type="hidden" name="postId" value="<?php echo $post_id; ?>" />
                        <input type="hidden" class="form-control" id="input-email" name="email" value="<?php echo $current_user->user_email; ?>">
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
    <?php endif; ?>
    <li class="list-group-item comment">
        <?php comments_template(); ?>
    </li>

</ul>
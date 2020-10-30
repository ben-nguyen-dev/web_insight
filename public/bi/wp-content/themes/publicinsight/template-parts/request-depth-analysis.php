<?php
$post_id = $post->ID;
if (is_user_logged_in() && $post_type != "analysis" && !hasDepthAnalysis($post)) :
?>

    <div class="depth-analysis-form">
        <input type="hidden" name="postId" value="<?php echo $post_id; ?>" />
        <div class="request-depth-analysis">
            <div class="black slim"></div>
            <div class="request-title">Vi analyserar konsekvenserna av ovan artikel</div>
            <div class="request-content">Våra experter analyserar varje vecka ett antal händelser utifrån våra användares önskemål. Skicka iväg en förfrågan så återkommer vi!</div>
            <textarea class="request-message" placeholder="Meddelande till vår expert: "></textarea>
            <button class="btn btn-lg active btn-send-request">Skicka förfrågan</button>
        </div>
        <div class="result" style="display: none">
            <div class="black slim"></div>
            <div class="result-title">Tack för din förfrågan! </div>
            <div class="result-message">En bekräftelse har skickats till din mail. </div>
            <div class="result-icon">
                <i class="fa fa-thumbs-o-up thanks-icon"></i>
            </div>
        </div>
    </div>
<?php endif; ?>
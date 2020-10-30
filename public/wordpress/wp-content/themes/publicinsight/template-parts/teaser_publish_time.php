<!-- {{--assume we have $post as input--}} -->
<div class="time-ago"><?php echo isset($post) ? get_publish_time($post) : ''; ?></div>
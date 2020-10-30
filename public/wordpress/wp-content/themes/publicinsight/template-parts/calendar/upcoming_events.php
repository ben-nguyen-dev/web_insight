<div class="header">UPCOMING EVENTS</div>
<div class="event-list-group">
    <ul class="list-group list-group-flush">
        <?php 
            if($upcomingEvents && count($upcomingEvents) > 0) {
                foreach($upcomingEvents as $event) { 
                    try {
                        $dateTime = new DateTime(get_field('datetime', $event->ID));
                        $day = $dateTime->format('d');
                        $month = $dateTime->format('F');?>
                        <li class="list-group-item d-flex">
                            <div class="day-event">
                                <div class="d"><?php echo $day; ?></div>
                                <div class="m"><?php echo $month; ?></div>
                            </div>
                            <a href="<?php echo esc_url(home_url('/calendar')); ?>"><?php echo $event->post_title; ?></a>
                        </li>
            <?php } catch (Exception $e) {}
            } 
        }?>
    </ul>
</div>

<div class="col-sm-12 col-md-6 col-lg-12 col-xl-12 block-content left">
    <div class="header">UPCOMING EVENTS</div>
    <div class="event-list-group">
        <p id="upcoming-events-indicator" style="display: none;">Loading...</p>
        <ul id="upcoming-events" class="list-group list-group-flush">
            <?php 
            $events = get_up_coming_events_in_home_page();
            if(isset($events)) {
                foreach($events as $event) {
                    try {
                        $dateTime = new DateTime(get_field('datetime', $event->ID));
                        $day = $dateTime->format('d');
                        $month = $dateTime->format('F');
                        ?>
                        <li class="list-group-item d-flex">
                            <div class="day-event">
                                <div class="d"><?php echo $day; ?></div>
                                <div class="m"><?php echo $month; ?></div>
                            </div>
                            <a href="<?php echo esc_url(home_url('/calendar')); ?>"><?php echo $event->post_title; ?></a>
                        </li>
                    
                    
                <?php } catch (Exception $e) {}
                } 
             } ?>
        </ul>
        <a class="see-more" href="<?php echo esc_url(home_url('/calendar')); ?>">SEE MORE</a>
    </div>
</div>
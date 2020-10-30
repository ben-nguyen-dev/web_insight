<div class="days-list-event">
    <?php
    if($currentDates && count($currentDates) > 0) {
        foreach($currentDates as $date): 
            if(gettype ($date['value']) == "string") {
                $dateTime = new DateTime($date['value']);
                $dateFormat = $dateTime->format('M d, Y');
            }
            else {
                $dateFormat = $date['value']->format('M d, Y');
            }?>
        <div class="day-block">
            <div class="event-header"><?php echo $dateFormat; ?></div>
            <?php if(count($date['events']) == 0) : ?>
                <div class="event">
                    <div class="no-event">No event on this day</div>
                </div>
            <?php else : 
                foreach($date['events'] as $event) : ?>
                <div class="event">
                    <span class="name"><?php echo $event->post_title; ?></span> - <span class="desc"><?php echo get_field('description', $event->ID); ?></span>
                    <div class="time-start">
                        <?php
                            $dateTime = new DateTime(get_field('datetime', $event->ID));
                            echo $dateTime->format('H:i P');
                        ?>
                    </div>
                </div>
                <?php endforeach;
            endif; ?>
        </div>    
        <?php endforeach; 
        }?>
</div>


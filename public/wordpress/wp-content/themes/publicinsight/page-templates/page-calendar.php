<?php /* Template Name: Calendar */ ?>
<?php get_header();?>
<?php 
    $upcomingEvents = get_up_coming_events_in_home_page();

    $currentDates = get_events_in_range_in_calendar_page();
    
?>
<section class="container calendars">
    <div class="row d-flex">
        <div class="col-12 d-block d-lg-none block-content">
            <?php 
                wpse_get_template_part( 'template-parts/calendar/upcoming_events', null, array('upcomingEvents'=> $upcomingEvents) );
            ?>
        </div>
        <div class="col-12 col-lg-8 border-right-news">
            <div class="block-content">
                <div class="header">Event Calendar</div>
            </div>
            <div class="datepicker">
                <input id="daterangepicker1" type="hidden">
                <div id="dateRangePicker" class="embedded-daterangepicker">
                </div>
            </div>
            <div>&nbsp;</div>
            <div id="event_rows">
                <?php
                    wpse_get_template_part( 'template-parts/calendar/event_list', null, array('currentDates' => $currentDates) );
                ?>
            </div>
            <div id="loading" style="display:none;margin-top: 20px;">Loading data..</div>
        </div>
        <div class="col-lg-4 d-none d-lg-block block-content left">
            <?php
                wpse_get_template_part( 'template-parts/calendar/upcoming_events', null, array('upcomingEvents'=> $upcomingEvents) );
            ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
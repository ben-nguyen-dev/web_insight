let HomeController = {
    getMonthName: function(date) {
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        return monthNames[date.getMonth()];
    },

    renderUpcomingEvents: function(upcomingEvents) {
        let liElements = "";
        upcomingEvents = JSON.parse(upcomingEvents);
        for (let i in upcomingEvents) {
            let date = new Date(upcomingEvents[i].date);
            liElements += '<li class="list-group-item d-flex">' +
                '                    <div class="day-event">' +
                '                        <div class="d">' + date.getDate() + '</div>' +
                '                        <div class="m">' + HomeController.getMonthName(date) + '</div>' +
                '                    </div>' +
                '                    <div class="title-event">' +
                '                        <a href="javascript:void(0);">' + upcomingEvents[i].headline + '</a>' +
                '                    </div>' +
                '                </li>'
        }
        $("#upcoming-events").html(liElements);
    },

    updateEventsLoadingState: function(isLoading) {
        document.getElementById("upcoming-events-indicator").style.display = isLoading ? "block" : "none";
        if (isLoading) {
            $("#upcoming-events").html("");
        }
    },
};

$(document).ready(function () {
    (function($){
        $.fn.datepicker.dates['en'].daysMin = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    }(jQuery));
    $('#date_picker').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 'years',
        todayHighlight: true,
        weekStart: 1,
        templates: {
            leftArrow: '<i class="icons i-arrow-left"></i>',
            rightArrow: '<i class="icons i-arrow-right"></i>'
        }
    }).on("changeMonth", function (e) {
        // $("#upcoming-events-indicator").show();
        HomeController.updateEventsLoadingState(true);
        var data = {
            'action': 'events_in_month',
            'selected_date': e.date.toDateString()
        };
        $.ajax({
            url: homepage_params.ajaxurl,
            data: data,
            type: 'GET',
            beforeSend: function( xhr ){
            },
            success:function(result){
                if( result && result.length > 0 ) {
                    HomeController.renderUpcomingEvents(result);
                }
            },
            error: function onError(error) {
                console.log(error);
            },
            complete: function complete() {
                HomeController.updateEventsLoadingState(false);
            }
        });
    });
    
    window.PublicInsight.filterPostByType();

    
});
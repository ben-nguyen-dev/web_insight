let CalendarController = {
    showLoading: function(show) {
      if(show) {
        $(".days-list-event").hide();
        $("#loading").show();
      }
      else {
        $(".days-list-event").show();
        $("#loading").hide();
      }
    },
    loadEvents: function(startDate, endDate) {
      var data = {
        'action': 'events_in_range',
        'startDateStr': startDate.toDate().toDateString(),
        'endDateStr': endDate.toDate().toDateString()
      };
      $.ajax({
          url: calendar_params.ajaxurl,
          data: data,
          type: 'GET',
          beforeSend: function( xhr ){
          },
          success:function(result){
              if( result ) {
                CalendarController.renderEvents(result);
              }
          },
          error: function onError(error) {
              console.log(error);
          },
          complete: function complete() {
            CalendarController.showLoading(false);
          }
      });
    },
    renderEvents: function(data) {
      $("#event_rows").html('');
      $("#event_rows").html(data);
    }
};

// A $( document ).ready() block.
$(document).ready(function () {
    // init daterangepicker 
  var picker = $('#daterangepicker1').daterangepicker({
    "parentEl": "#dateRangePicker",
    "autoApply": true,
    "startDate": moment(),
    "endDate": moment().add(14, 'days')
  });
  // range update listener
  picker.on('apply.daterangepicker', function(ev, picker) {
    // $("#upcoming-events-indicator").show();
    CalendarController.showLoading(true);
    CalendarController.loadEvents(picker.startDate, picker.endDate);
    
  });
  // prevent hide after range selection
  picker.data('daterangepicker').hide = function () {};
  // show picker on load
  picker.data('daterangepicker').show();
    
  window.PublicInsight.filterPostByType();
});
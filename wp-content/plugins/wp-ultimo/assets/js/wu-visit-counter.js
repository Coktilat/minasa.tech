(function($) {
  $(document).ready(function() {

    // Count this visit
    $.get(wu_visit_counter.ajaxurl, {action: 'wu_count_visits'});

  });  
})(jQuery);
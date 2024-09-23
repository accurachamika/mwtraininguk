(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


   // Document Ready
   $(document).ready(function() {
    // Back to top button functionality
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });

    // Click event to scroll to top
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });

    // Alert fade-out after 2 seconds (adjusted the comment to match the time)
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 2000); // Hide after 2 seconds

    // Initialize DataTable
    $('#datatable').DataTable();

    // Sidebar toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });
});


})(jQuery);


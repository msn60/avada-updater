(function ($) {

    $(document).ready(function () {
        var $window = $(window);
        $('.alert').alert();

        $('[data-toggle="tooltip"]').tooltip();

        $('#msn-test-tooltip-options').tooltip(
            {
                title: "<h1><strong>HTML</strong> inside <code>the</code> <em>tooltip</em></h1>",
                html: true,
                placement: "bottom",
                delay: {show: 1000, hide: 500},
                boundary: 'window'
            }
        );

    });

})(jQuery);


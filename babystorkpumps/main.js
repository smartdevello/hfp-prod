jQuery(document).ready(function($) {
    $('#user_login').attr('placeholder', 'email address');
    // Menu toggle
    $('.js-toggleMenu').click(function() {
        $('.js-header').toggleClass('hfp-header--toggle');
    })

    // Begin: Home products carousel
    $('.js-homeProducts').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 92 92"><defs><style>.a1,.b1{fill:none;}.b1{stroke:#08122b;stroke-linecap:round;stroke-linejoin:round;stroke-width:5px;}</style></defs><path class="a1" d="M0,92H92V0H0Z"/><path class="b1" d="M0,61.333,30.667,30.667,0,0" transform="translate(59.417 76.667) rotate(180)"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 92 92"><defs><style>.a2,.b2{fill:none;}.b2{stroke:#08122b;stroke-linecap:round;stroke-linejoin:round;stroke-width:5px;}</style></defs><g transform="translate(92 92) rotate(180)"><path class="a2" d="M0,0H92V92H0Z"/><path class="b2" d="M0,0,30.667,30.667,0,61.333" transform="translate(59.417 76.667) rotate(180)"/></g></svg>'
            ],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    stagePadding: 100,

                    items: 3
                }
            }
        })
        // End: Home products carousel
        // Window load event used just in case window height is dependant upon images
    $(window).bind("load", function() {

        var footerHeight = 0,
            footerTop = 0,
            $footer = $(".hfp-copyrights");

        positionFooter();

        function positionFooter() {

            footerHeight = $footer.height();
            footerTop = ($(window).scrollTop() + $(window).height() - footerHeight) + "px";

            if (($(document.body).height() + footerHeight) < $(window).height()) {
                $footer.css({
                    position: "absolute",
                    bottom: 0
                })
            } else {
                $footer.css({
                    position: "static"
                })
            }

        }

        $(window)
            .scroll(positionFooter)
            .resize(positionFooter)

    });


});

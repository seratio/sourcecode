"use strict";
jQuery(document).on('ready', function () {
    function collapseMenu() {
        jQuery('.menu-item-has-children').prepend('<span class="tg-dropdowarrow"><i class="icon-chevron-right"></i></span>');
        jQuery('.menu-item-has-children span').on('click', function () {
            jQuery(this).next().next().slideToggle(300);
            jQuery(this).parent('.menu-item-has-children').toggleClass('tg-open');
        });
    }
    collapseMenu();
    var _tg_homeslider = jQuery('#tg-homeslider')
    _tg_homeslider.owlCarousel({
        items: 1,
        loop: false,
        dots: true,
        nav: true,
        autoplay: false,
        animateOut: 'fadeOut',
        navText: [
            '<i class="icon-arrow-left"></i>',
            '<i class="icon-arrow-right"></i>',
        ],
        navClass: [
            'tg-btnroundprev',
            'tg-btnroundnext'
        ],
    });
    var _tg_btnsectionscroll = jQuery('.tg-btnsectionscroll');
    _tg_btnsectionscroll.on('click', function (event) {
        event.preventDefault();
        console.log('clicked');
        var offset = 2;
        jQuery('html, body').animate({
            scrollTop: jQuery("#tg-main").offset().top + offset
        }, 2000);
    });
    //jQuery('#tg-navigation ul li a').click(function () {
    //    var _menutarget = jQuery(this).attr('target');
    //    var _anchor = jQuery('.' + _menutarget).offset();
    //    //window.scrollTo(_anchor.left, _anchor.top);
    //    jQuery('body').animate({ scrollTop: _anchor.top }, 1500);
    //    return false;
    //});
    var _tg_upcomingeventcounter = jQuery('.tg-upcomingeventcounter');
    var _newDate1 = moment.utc('2018/01/31 23:59:59');
    _tg_upcomingeventcounter.countdown(_newDate1.toDate(), function (event) {
        var $this = jQuery(this).html(event.strftime(''
            + '<div class="tg-eventcounterholder"><div class="tg-eventcounter"><span>%-D</span><span>Days</span></div></div>'
            + '<div class="tg-eventcounterholder"><div class="tg-eventcounter"><span>%H</span><span>Hours</span></div></div>'
            + '<div class="tg-eventcounterholder"><div class="tg-eventcounter"><span>%M</span><span>Minutes</span></div></div>'
            + '<div class="tg-eventcounterholder"><div class="tg-eventcounter"><span>%S</span><span>Seconds</span></div></div>'
        ));
    });
    $('[data-countdown]').each(function () {
        var $this = $(this);
        var _newDate = moment.utc($(this).data('countdown')).subtract(1, 'hours');

        $this.countdown(_newDate.toDate(), function (event) {
            $this.html(event.strftime('%D Days %H:%M:%S'));
        });
    });
    var _tg_counters = jQuery('#tg-statisticscounters');
    _tg_counters.appear(function () {
        var _tg_counter = jQuery('.tg-counter > h2 > span');
        _tg_counter.countTo();
    });
    var $container = jQuery('.tg-galleryfilterable');
    var $optionSets = jQuery('.tg-optionset');
    var $optionLinks = $optionSets.find('a');
    function doIsotopeFilter() {
        if (jQuery().isotope) {
            var isotopeFilter = '';
            $optionLinks.each(function () {
                var selector = jQuery(this).attr('data-filter');
                var link = window.location.href;
                var firstIndex = link.indexOf('filter=');
                if (firstIndex > 0) {
                    var id = link.substring(firstIndex + 7, link.length);
                    if ('.' + id == selector) {
                        isotopeFilter = '.' + id;
                    }
                }
            });
            jQuery(window).load(function () {
                $container.isotope({
                    itemSelector: '.tg-masonrygrid',
                    filter: isotopeFilter
                });
            });
            $optionLinks.each(function () {
                var $this = jQuery(this);
                var selector = $this.attr('data-filter');
                if (selector == isotopeFilter) {
                    if (!$this.hasClass('tg-active')) {
                        var $optionSet = $this.parents('.option-set');
                        $optionSet.find('.tg-active').removeClass('tg-active');
                        $this.addClass('tg-active');
                    }
                }
            });
            $optionLinks.on('click', function () {
                var $this = jQuery(this);
                var selector = $this.attr('data-filter');
                $container.isotope({ itemSelector: '.tg-masonrygrid', filter: selector });
                if (!$this.hasClass('tg-active')) {
                    var $optionSet = $this.parents('.tg-optionset');
                    $optionSet.find('.tg-active').removeClass('tg-active');
                    $this.addClass('tg-active');
                }
                return false;
            });
        }
    }
    var isotopeTimer = window.setTimeout(function () {
        window.clearTimeout(isotopeTimer);
        doIsotopeFilter();
        var _tg_masnorygallery = jQuery('#tg-masnorygallery');
        _tg_masnorygallery.packery({
            itemSelector: '.tg-masonryitem',
            columnWidth: 0,
        });
    }, 1000);
    jQuery("a[data-rel]").each(function () {
        jQuery(this).attr("rel", jQuery(this).data("rel"));
    });
    jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
        animation_speed: 'normal',
        theme: 'dark_square',
        slideshow: 3000,
        autoplay_slideshow: false,
        social_tools: false
    });
    jQuery(function () {
        jQuery('.tg-gallery').each(function () {
            jQuery(this).hoverdir({
                hoverDelay: 75,
            });
        });
    });
    function themeAccordion() {
        jQuery('.tg-panelcontent').hide();
        jQuery('.tg-accordion h4:first').addClass('active').next().slideDown('slow');
        jQuery('.tg-accordion h4').on('click', function () {
            if (jQuery(this).next().is(':hidden')) {
                jQuery('.tg-accordion h4').removeClass('active').next().slideUp('slow');
                jQuery(this).toggleClass('active').next().slideDown('slow');
            }
        });
    }
    themeAccordion();
    var _tg_themescrollbar = jQuery(".tg-themescrollbar");
    _tg_themescrollbar.mCustomScrollbar({
        axis: "y",
    });
    //var _tg_locationmap = jQuery("#tg-locationmap");
    //_tg_locationmap.gmap3({
    //	marker: {
    //		address: "1600 Elizabeth St, Melbourne, Victoria, Australia",
    //		options: {
    //			title: "Bee Vibrant",
    //			icon: "images/map-marker2.png",
    //		}
    //	},
    //	map: {
    //		options: {
    //			zoom: 16,
    //			scrollwheel: false,
    //			disableDoubleClickZoom: true,
    //		}
    //	}
    //});
    var _tg_testimonialslider = jQuery('.tg-testimonialslider');
    _tg_testimonialslider.owlCarousel({
        items: 1,
        autoplay: true,
        loop: true,
        dots: false,
        nav: false,
        animateOut: 'fadeOut',
    });
    var _tg_relatedpostsslider = jQuery('#tg-relatedpostsslider');
    _tg_relatedpostsslider.owlCarousel({
        loop: true,
        dots: false,
        nav: false,
        autoplay: true,
        margin: 30,
        responsiveClass: true,
        responsive: {
            320: {
                items: 1,
            },
            568: {
                items: 2,
            },
            768: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });
    var _tg_rockstarslider = jQuery('.tg-rockstarslider');
    _tg_rockstarslider.owlCarousel({
        autoplay: false,
        loop: true,
        dots: true,
        nav: false,
        margin: 30,
        responsiveClass: true,
        navText: [
            '<i class="icon-chevron-left"></i>',
            '<i class="icon-chevron-right"></i>',
        ],
        navClass: [
            'tg-btnroundprev',
            'tg-btnroundnext'
        ],
        responsive: {
            0: {
                items: 1,
            },
            569: {
                items: 2,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 2,
            },
            1440: {
                items: 3,
            }
        }
    });
    if (jQuery(window).width() > 1199) {
        jQuery('#tg-sectionscroll').fullpage({
            scrollingSpeed: 1500,
            sectionSelector: '.tg-sectioncontent',
            fixedElements: '#tg-header, #tg-footer',
        });
    }
    jQuery('.tg-selectplan, .tg-btnformpkghide').on('click', function (event) {
        event.preventDefault();
        jQuery(this).parents('.tg-package').toggleClass('tg-formshow');
    });
    jQuery('body').addClass('tg-showpopup');
    jQuery('.close').on('click', function () {
        jQuery('body').removeClass('tg-showpopup');
    });
    //$(".offer-btn").click(function () {
    //    $('.discount-table').slideToggle('slow');
    //});    

    $(document).on('click', "#btn_login, .discount-table a.active", function () {

        $.get('/default/HasICOStarted',
            function (response) {
                if (response === 'True') {
                    window.location.replace('/users/');
                } else {
                    alert(
                        'This feature will be available after 15 September 2017 - when our Pre-ICO campaign officially starts.\nPlease subscribe to get the latest news.');
                    $('#mce-EMAIL').focus();
                }
            });

        return false;
    });

    $('.discount-table tr').each(function (index, tr) {
        var _date = $(tr).find('td:eq(1) div').attr('data-countdown');

        if (moment.utc(_date) >= moment.utc()) {
            $(tr).find('a').addClass('active');
        }
    });

    if (moment.utc() >= moment.utc("2017/10/01 00:01:00")) {
        $('.discount-table a.active').removeClass('active');
    } else {
        $('.discount-table a.active:not(:first)').removeClass('active');
    }
});

$("#form-email").submit(function () {
    if ($(this).find('button[type="submit"]').attr('data-validated') == 'true') {
        $(".captcha-msg").addClass("hidden");
        $.post('/contact.aspx',
            $('#form-email').serialize(),
            function () {
                $('#email-sent').show();
                $('#form-email').trigger("reset");
            });
    } else {
        $(".captcha-msg").removeClass("hidden");
    }

    return false;
});

var onloadCallback = function () {


    grecaptcha.render('reCAPTCHA_div',
        {
            'sitekey': '6LcxjjEUAAAAAFIDV8K7J6qXDxKcX3wAeJhjlS3R',
            'callback': function (response) {
                console.log(response);
                if (response != null && response != "") {
                    $('form button[type="submit"]').attr('data-validated', 'true');
                }
            }
        });

};
$.get('/contact.aspx',
    function (t) {
        $('<input>', {
            type: 'hidden',
            id: 't',
            name: 't',
            value: t
        }).appendTo('#form-email');
    });

onloadCallback();
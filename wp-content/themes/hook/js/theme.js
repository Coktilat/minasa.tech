/* jshint ignore:start */

//THEME MAIN SCRIPTS------------------------------------------

//OLDER BROWSERS CONSOLE SUPPORT
if(!(window.console && console.log)) {
    console={
        log: function(){},
        debug: function(){},
        info: function(){},
        warn: function(){},
        error: function(){}
    };
}

//GLOBAL VARIABLES DECLARATION
var ran_preloader=loading_page=true;
var current_URL=jQuery(location).attr('href');
var smooth_scroll_now=false;
var loaded_google_maps=false;
var first_load=true;
function hook_init() {
    "use strict";
    console.log("INITIALIZE");
    var delayed_anim="";
    var on_top=true;
    var admin_bar_height=0;
    if (jQuery('.hook_theme.admin-bar').length) {
        admin_bar_height=32;
    }
    var height_fix=0;
    pirenko_resize();
    var menu_is_open=false;
    var sidebar_is_open=false;
    var hiddenbar_is_open=false;
    var hidden_folio_is_open=false;
    var mn_normal=theme_options.menu_vertical;
    var mn_collapsed=theme_options.collapsed_menu_vertical;
    var ajax_calls=theme_options.ajax_calls==="1" ? true : false;
    var ls_pos=0;
    var ns_pos=0;
    var hook_header_height=0;
    var fadeout_timing=350;
    var sticky_scroll=parseInt(theme_options.menu_collapse_pixels,10)+600;
    if (theme_options.header_opacity_after==="0" || theme_options.menu_hide_flag==="1" || theme_options.menu_display==="st_hidden_menu") {
        mn_collapsed=0;
    }
    if (theme_options.menu_collapse_flag=="0" && theme_options.menu_display!="st_hidden_menu") {
        mn_collapsed=theme_options.menu_vertical;
    }
    if (theme_options.menu_hide_flag==="0" && theme_options.menu_align==="st_menu_under") {
        if (theme_options.header_opacity_after==="0") {
            mn_collapsed=0;
        }
        else {
            mn_collapsed=parseInt(theme_options.collapsed_menu_vertical,10)+parseInt(theme_options.logo_collapsed_top_margin,10)+37;
        }
    }
    var rows_offset=parseInt(mn_collapsed,10)+10;
    var hide_onscroll=false;
    if (theme_options.menu_hide_flag==="1") {
        hide_onscroll=true;
    }
    var hook_on_mobile=is_mobile()===true ? true : false;
    var hook_is_iPad = navigator.userAgent.match(/iPad/i) != null;
    if (hook_on_mobile) {
        jQuery('html').addClass('hook_on_mobile');
    }
    else {
        jQuery('html').addClass('hook_on_desktop');
    }
    jQuery('#prk_blocks_wrapper').on('click',function() {
        if (!jQuery('html').hasClass('menu_at_top')) {
            prk_toggle_menu();
        }
        else {
            prk_toggle_hidden();
        }
    });
    jQuery('#prk_sidebar_trigger').on('click',function() {
        prk_toggle_sidebar();
    });
    jQuery('#hook_close_hidden,.hook_folio_trigger>a').on('click',function(event) {
        event.preventDefault();
        prk_toggle_folio();
    });
    //FIX FOR MEDIA QUERIES ON SOME BROWSERS
    var scrollbar_width=window.innerWidth-jQuery("body").width();
    if (jQuery.browser.msie) {
        scrollbar_width=scrollbar_width+1;
    }

    //MENU FUNCTIONS
    jQuery('#hook_main_menu').attr('data-width',jQuery('#hook_main_menu .hook-mn').width());
    var resp_width=theme_options.resp_break;
    function deactivate_menu_links() {
        jQuery("#hook_main_menu .hook-mn li,.mobile-menu-ul li,#prk_hidden_bar_inner .menu li").removeClass('active');
        jQuery("#hook_main_menu .hook-mn li,.mobile-menu-ul li,#prk_hidden_bar_inner .menu li").removeClass('active_parent');
    }
    function close_mobile_submenus() {
        jQuery('.mobile-menu-ul li.menu-item-has-children').each(function() {
            if (!jQuery(this).hasClass('active_parent')) {
                jQuery(this).find('.sub-menu').slideUp({
                    'duration':0,
                    easing:'easeOutExpo',
                    step: function(now, fx) {},
                    complete:function() {}
                });
            }
        });
    }
    //ADD SPECIAL CLASSES
    jQuery("#prk_hidden_menu_page .widget_nav_menu>.menu").addClass('prk_popper_menu header_font prk_menu_sized');
    jQuery('.mobile-menu-ul').addClass('prk_popper_menu');
    jQuery('.prk_popper_menu a,#hook_main_menu ul.hook-mn a,#prk_hidden_bar_inner .widget_nav_menu a').each(function() {
        jQuery(this).addClass('hook_anchor');
    });
    jQuery('.hook_folio_trigger>a').removeClass('hook_anchor');
    //MAIN MENU
    jQuery('#hook_main_menu ul.hook-mn').superfish({
        hoverClass:'hook_hover_sub',
        delay:200,
        animation: {height:'show'},
        cssArrows:    false,
        speed:         300,
        speedOut:      100,
        dropShadows:   false,
    });

    jQuery(document).on('click','.hook_maps', function(event) {
        jQuery('.hook_maps iframe').css("pointer-events", "auto");
    });
    jQuery(document).on('mouseleave','.hook_maps', function(event) {
        jQuery('.hook_maps iframe').css("pointer-events", "none");
    });
    //MENU LIKE LINKS
    jQuery(document).on('click',"a.hook_anchor,.hook_anchor a", function(event) {
        if (jQuery(this).attr("target")==="_blank" || jQuery(this).parent().hasClass('regular_load') || event.metaKey) {
            if (jQuery(this).parent().hasClass('notlinked')) {
                event.preventDefault();
                return;
            }
        }
        else {
            event.preventDefault();
            if ((jQuery(this).attr('id')==='hook_back_lnk' || jQuery(this).parent().attr('id')==='hook_to_parent') && jQuery('#hook_main_wrapper').hasClass('hook_showing_ajax')) {
                jQuery('#hook_close_portfolio').trigger('click');
                return;
            }
            if(hook_on_mobile && jQuery(this).hasClass('hook_touch') && !jQuery(this).parents('.portfolio_entry_li.hover_trigger').length) {
                jQuery(this).closest('.recentfolio_ul_wp').find('.portfolio_entry_li').removeClass('hover_trigger');
                jQuery(this).parent().addClass('hover_trigger');
                return;
            }
            var offsetter="";
            var fragment=jQuery(this).attr('href').split('#');
            if (jQuery(this).parent().children('.sub-menu').length) {
                jQuery(this).toggleClass('hook_showing_sub');
                jQuery(this).parent().children('.sub-menu').slideToggle({
                    'duration':500,
                    easing:'easeOutExpo'
                });
            }
            if ((jQuery(this).attr('href')==="#" || fragment[1]==="" || jQuery(this).attr('id')==="hook_home_link") && fragment[0]===current_URL)  {
                offsetter=0;
            }
            else {
                var target=this.hash;
                //window.location.hash = target;
                var $target=jQuery(target);
                //IS IT AN ANCHOR LINK
                if (target!=="") {
                    //IS IT AN EXISITNG ID
                    if ($target.offset()!==undefined) {
                        offsetter=$target.offset().top;
                    }
                }
            }
            if (offsetter!=="") {
                if (menu_is_open===true) {
                    prk_toggle_menu();
                }
                jQuery('html,body').stop().animate({
                        'scrollTop': offsetter-admin_bar_height-mn_collapsed
                    },
                    1200,
                    'easeInOutExpo'
                );
            }
            if (!jQuery(this).parent().hasClass('hook_folio_trigger') && hidden_folio_is_open===true) {
                prk_toggle_folio();
            }
            if (ajax_calls && !jQuery('.hook_theme.admin-bar').length) {
                if (loading_page===false && jQuery(this).attr("href")!=="#" && offsetter==="") {
                    var next_page=jQuery(this).attr("href");
                    loading_page=true;
                    ran_preloader=false;
                    setTimeout(function() {
                        ran_preloader=true;
                    },fadeout_timing);
                    jQuery('#hook_main_menu .hook-mn>li.hook_hover_sub').superfish('hide');
                    deactivate_menu_links();
                    if (jQuery(this).attr('id')!=="hook_home_link") {
                        jQuery(this).parent().addClass('active');
                        if (jQuery(this).parent().parent().hasClass('sub-menu')) {
                            jQuery(this).parent().parent().parent().addClass('active_parent');
                        }
                    }
                    else {
                        jQuery('#hook_main_menu .hook-mn>li>a').each(function() {
                            if (jQuery(this).attr('href')===next_page) {
                                jQuery(this).parent().addClass('active');
                            }
                        });
                    }
                    if ((jQuery(this).parent().hasClass('portfolio_entry_li') && jQuery(this).parent().attr('data-color')!==undefined && jQuery(this).parent().attr('data-color')!=="default") || jQuery('.featured_color.color_trigger').find(jQuery(this)).length) {
                        jQuery('#hook_loader_block,#hook_to_top').css({'background-color':jQuery(this).parent().attr('data-color')});
                    }
                    else {
                        if (jQuery('.blog_entry_li.featured_color').find(jQuery(this)).length) {
                            jQuery('#hook_loader_block,#hook_to_top').css({'background-color':jQuery(this).closest('.blog_entry_li.featured_color').attr('data-color')});
                        }
                        else {
                            jQuery('#hook_loader_block,#hook_to_top').css({'background-color':''});
                        }
                    }
                    jQuery('#hook_main_menu .hook-mn>li').removeClass('hook_hover_sub');
                    jQuery('#hook_main_wrapper').addClass('prk_loading_page');
                    jQuery('#hook_main_wrapper').addClass('prk_wait');
                    jQuery('#prk_main_loader').removeClass('prk_hidden_loader');
                    setTimeout(function() {
                        load_ajax_page(next_page,true);
                        if (hiddenbar_is_open===true) {
                            prk_toggle_hidden();
                            close_mobile_submenus();
                        }
                        if (sidebar_is_open===true) {
                            prk_toggle_sidebar();
                        }
                    },150);
                }
                else {
                    if (hiddenbar_is_open===true && jQuery(this).attr("href")!=="#") {
                        prk_toggle_hidden();
                        close_mobile_submenus();
                    }
                    if (sidebar_is_open===true && jQuery(this).attr("href")!=="#") {
                        prk_toggle_sidebar();
                    }
                }
            }
            else {
                if (offsetter==="") {
                    window.location=jQuery(this).attr("href");
                }
                else {
                    if (hiddenbar_is_open===true && jQuery(this).attr("href")!=="#") {
                        prk_toggle_hidden();
                        close_mobile_submenus();
                    }
                    if (sidebar_is_open===true && jQuery(this).attr("href")!=="#") {
                        prk_toggle_sidebar();
                    }
                }
            }
        }
    });
    function prk_toggle_menu() {
        if (menu_is_open===false) {
            jQuery('#prk_blocks_wrapper').removeClass('hover_trigger');
            menu_is_open=true;
            jQuery('body').addClass('hook_showing_menu');
            jQuery('#body_hider,#prk_hidden_menu').addClass('hook_second_menu_anims');
            jQuery('#prk_blocks_wrapper').addClass('hook_1_anim');
            clearTimeout(delayed_anim);
            delayed_anim=setTimeout(function() {
                jQuery('#prk_blocks_wrapper').addClass('hook_second_menu_anims');
            },350);
            jQuery('#body_hider').stop();
            jQuery('#body_hider').css({'height':'0px','z-index':'991'});
            jQuery('#body_hider').animate({
                    height:jQuery(window).height()-admin_bar_height-hook_header_height
                },
                {
                    easing:'easeOutExpo',
                    duration:400
                }
            );
            jQuery('#prk_hidden_menu').stop();
            jQuery('#prk_hidden_menu').css({'visibility':'visible','opacity':'0'});
            setTimeout(function() {
                jQuery('#prk_hidden_menu').animate({
                        opacity:1
                    },
                    {
                        easing:'linear',
                        duration:200
                    }
                );
            },300);
        }
        else {
            menu_is_open=false;
            jQuery('#prk_hidden_menu,#prk_blocks_wrapper').removeClass('hook_second_menu_anims');
            clearTimeout(delayed_anim);
            jQuery('#body_hider').stop();
            jQuery('#prk_hidden_menu').stop();
            jQuery('#prk_hidden_menu').animate({
                    opacity:0
                },
                {
                    easing:'linear',
                    duration:200
                });
            setTimeout(function() {
                jQuery('#body_hider').animate({
                        height:0
                    },
                    {
                        easing:'easeOutExpo',
                        duration:585
                    });
            },200);
            delayed_anim=setTimeout(function() {
                jQuery('body').removeClass('hook_showing_menu');
                jQuery('#body_hider').removeClass('hook_second_menu_anims');
                jQuery('#prk_blocks_wrapper').removeClass('hook_1_anim');
                jQuery('#prk_hidden_menu').css({'opacity':'','visibility':''});
                jQuery('#body_hider').css({'height':'','z-index':''});
            },800);
        }
    }
    function prk_toggle_hidden() {
        if (hiddenbar_is_open===true) {
            hiddenbar_is_open=false;
            jQuery('#body_hider').stop().animate({
                    opacity:0
                },
                {
                    easing:'linear',
                    duration:200
                }
            );
            setTimeout(function(){
                jQuery('body').removeClass('prk_shifted');
                jQuery('body').removeClass('hook_showing_mobile');
            },150);
            setTimeout(function(){
                jQuery('#body_hider').css({'visibility':'','opacity':''});
                jQuery('body').removeClass('second_anims');
                jQuery('#body_hider').removeClass('second_anims');
                jQuery('#body_hider').removeClass('prk_shifted_hider');
            },500);
        }
        else {
            hiddenbar_is_open=true;
            jQuery('body').addClass('second_anims prk_shifted hook_showing_mobile');
            jQuery('#body_hider').css({'visibility':'visible'});
            jQuery('#body_hider').addClass('prk_shifted_hider second_anims');
            setTimeout(function(){
                jQuery('#body_hider').stop().animate({
                        opacity:1
                    },
                    {
                        easing:'linear',
                        duration:200
                    }
                );
            },600);
        }
    }
    function check_top_menu(resize_flag) {
        if (theme_options.menu_collapse_flag==="1") {
            if(jQuery(window).scrollTop()>=theme_options.menu_collapse_pixels || resize_flag===true) {
                if (on_top===true || resize_flag===true) {
                    on_top=false;
                    jQuery('#hook_header_background,#hook_header_inner,#hook_main_menu,#prk_menu_loupe,#menu_social_nets,#nav-main,#hook_side_menu').addClass('hook_collapsed_menu');
                }
            }
            else {
                if (on_top===false) {
                    on_top=true;
                    jQuery('#hook_header_background,#hook_header_inner,#hook_main_menu,#prk_menu_loupe,#menu_social_nets,#nav-main,#hook_side_menu').removeClass('hook_collapsed_menu');
                }
            }
        }
    }

    //HIDDEN SIDEBAR FUNCTIONS
    jQuery('#body_hider').on('click',function() {
        if (sidebar_is_open===true) {
            prk_toggle_sidebar();
        }
        if (hiddenbar_is_open===true) {
            prk_toggle_hidden();
        }
    });
    function prk_toggle_sidebar() {
        if (sidebar_is_open===false) {
            jQuery('#prk_sidebar_trigger').removeClass('hover_trigger');
            sidebar_is_open=true;
            jQuery('body').addClass('hook_showing_sidebar');
            jQuery('#hook_ajax_container,#hook_header_section,#body_hider,#hook_header_background,#prk_footer_outer,#prk_hidden_bar').addClass('hook_second_sidebar_anims');
            setTimeout(function() {
                jQuery('#body_hider').css({'z-index':'1000'});
                jQuery('#body_hider').stop().animate({
                        opacity:1
                    },
                    {
                        easing:'linear',
                        duration:200
                    }
                );
            },600);
        }
        else {
            sidebar_is_open=false;
            jQuery('#hook_ajax_container,#hook_header_section,#hook_header_background,#prk_footer_outer,#prk_hidden_bar,#body_hider').removeClass('hook_second_sidebar_anims');
            jQuery('#body_hider').stop().animate({
                    opacity:0
                },
                {
                    easing:'linear',
                    duration:200
                }
            );
            setTimeout(function() {
                jQuery('body').removeClass('hook_showing_sidebar');
                jQuery('#body_hider').css({'opacity':'','z-index':''});
            },350);
        }
    }
    jQuery("#prk_hidden_bar_scroller").mCustomScrollbar({
        scrollInertia:450,
        autoHideScrollbar:true,
        scrollButtons:{
            enable:false
        },
    });
    jQuery("#prk_mobile_bar_scroller").mCustomScrollbar({
        scrollInertia:450,
        autoHideScrollbar:true,
        setTop: '0px',
        scrollButtons:{
            enable:false
        },
    });

    function is_on_viewport(elem) {
        if (!jQuery(elem).length) {
            return false;
        }
        else {
            var docViewTop=jQuery(window).scrollTop();
            var docViewBottom=docViewTop + jQuery(window).height();
            var elemTop=jQuery(elem).offset().top;
            var elemBottom=elemTop + jQuery(elem).height();
            return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom));
        }
    }

    //SHARING FUNCTIONS
    function prk_init_sharrre() {
        jQuery('.prk_sharrre_twitter').sharrre({
            share: {
                twitter: true
            },
            template: '<a class="box social_tipped" href="#" data-color="#43b3e5"><div class="share"><span>'+theme_options.twitter_text+'</span><i class="hook_fa-twitter"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
            enableHover: false,
            enableTracking: false,
            click: function(api) {
                api.simulateClick();
                api.openPopup('twitter');
            },
            render: function(api){
            }
        });
        jQuery('.prk_sharrre_facebook').sharrre({
            share: {
                facebook: true
            },
            template: '<a class="box social_tipped" href="#" data-color="#1f69b3"><div class="share"><span>'+theme_options.facebook_text+'</span><i class="hook_fa-facebook"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
            enableHover: false,
            enableTracking: false,
            click: function(api) {
                api.simulateClick();
                api.openPopup('facebook');
            },
            render: function(api){
            }
        });
        jQuery('.prk_sharrre_google').sharrre({
            share: {
                googlePlus: true
            },
            template: '<a class="box social_tipped" href="#" data-color="#222222"><div class="share"><span>'+theme_options.google_text+'</span><i class="hook_fa-google-plus"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
            enableHover: false,
            enableTracking: false,
            click: function(api) {
                api.simulateClick();
                api.openPopup('googlePlus');
            },
            render: function(api){
            }
        });
        var pinterestMedia="";
        jQuery('.prk_sharrre_pinterest').sharrre({
            share: {
                pinterest: true
            },
            buttons: {
                pinterest: {
                    media: pinterestMedia,
                    description: ''
                }
            },
            template: '<a class="box social_tipped" href="#" data-color="#df2126"><div class="share"><span>'+theme_options.pinterest_text+'</span><i class="hook_fa-pinterest-p"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
            enableHover: false,
            enableTracking: false,
            click: function(api) {
                api.simulateClick();
                api.openPopup('pinterest');
            },
            render: function(api){
            }
        });
        jQuery('.prk_sharrre_pinterest').on({
            mouseenter:function() {
                jQuery('#prk_pint').attr('data-desc','');
                jQuery('#prk_pint').attr('data-media',jQuery(this).attr('data-media'));
                if (jQuery('#folio_ttl').length) {
                    jQuery('#prk_pint').attr('data-desc',jQuery('#folio_ttl').html());
                }
                else if(jQuery('#single_blog_title').length) {
                    jQuery('#prk_pint').attr('data-desc',jQuery('#single_blog_title').html());
                }
            },
        });
    }
    //END - SHARING FUNCTIONS


    //ANIMATED HEADLINES FUNCTIONS
    //set animation timing
    var animationDelay=2500,
        //loading bar effect
        barAnimationDelay=3800,
        barWaiting=barAnimationDelay - 3000,
        //letters effect
        lettersDelay=50,
        //type effect
        typeLettersDelay=150,
        selectionDuration=500,
        typeAnimationDelay=selectionDuration + 800,
        //clip effect
        revealDuration=600,
        revealAnimationDelay=1500;

    function initHeadline() {
        jQuery('.prk_text_rotator.per_init').each(function() {
            var $thisi=jQuery(this);
            $thisi.removeClass('per_init');
            //insert <i> element for each letter of a changing word
            singleLetters($thisi.find('.cd-headline.letters').find('b'));
            //initialise headline animation
            animateHeadline($thisi.find('.cd-headline'));
        });
    }

    function singleLetters($words) {
        $words.each(function(){
            var word=jQuery(this),
                letters=word.text().split(''),
                selected=word.hasClass('is-visible');
            var i="";
            for (i in letters) {
                if (letters[i]===" ") {

                    letters[i]=(selected) ? '<i class="in hidenize">i</i>':'<i class="hidenize">i</i>';
                }
                else {
                    letters[i]=(selected) ? '<i class="in">' + letters[i] + '</i>': '<i>' + letters[i] + '</i>';
                }
            }
            var newLetters=letters.join('');
            word.html(newLetters);
        });
    }

    function animateHeadline($headlines) {
        $headlines.each(function(){
            var headline=jQuery(this);
            var duration=jQuery(this).attr('data-speed');
            if(headline.hasClass('loading-bar')) {
                duration=barAnimationDelay;
                setTimeout(function(){ headline.find('.cd-words-wrapper').addClass('is-loading') }, barWaiting);
            } else if (headline.hasClass('clip')){
                var spanWrapper=headline.find('.cd-words-wrapper'),
                    newWidth=spanWrapper.width() + 10
                spanWrapper.css('width', newWidth);
            } else if (!headline.hasClass('type') ) {
                var words=headline.find('.cd-words-wrapper b'),
                    width=0;
                words.each(function(){
                    var wordWidth=jQuery(this).width();
                    if (wordWidth > width) width=wordWidth;
                });
                headline.find('.cd-words-wrapper').css('width', width);
            };

            //trigger animation
            setTimeout(function(){
                hideWord( headline.find('.is-visible').eq(0) )
            }, duration);
        });
    }

    function hideWord($word) {
        var nextWord=takeNext($word);
        var custom_delay=animationDelay;
        if ($word.parents('.cd-headline').attr('data-speed')!==undefined) {
            custom_delay=$word.parents('.cd-headline').attr('data-speed');
        }
        if($word.parents('.cd-headline').hasClass('type')) {
            var parentSpan=$word.parent('.cd-words-wrapper');
            parentSpan.addClass('selected').removeClass('waiting');
            setTimeout(function(){
                parentSpan.removeClass('selected');
                $word.removeClass('is-visible').addClass('is-hidden').children('i').removeClass('in').addClass('out');
            }, selectionDuration);
            setTimeout(function(){ showWord(nextWord, typeLettersDelay) }, typeAnimationDelay);

        } else if($word.parents('.cd-headline').hasClass('letters')) {
            var bool=($word.children('i').length >= nextWord.children('i').length) ? true : false;
            hideLetter($word.find('i').eq(0), $word, bool, lettersDelay);
            showLetter(nextWord.find('i').eq(0), nextWord, bool, lettersDelay);

        }  else if($word.parents('.cd-headline').hasClass('clip')) {
            $word.parents('.cd-words-wrapper').animate({ width : '2px' }, revealDuration, function(){
                switchWord($word, nextWord);
                showWord(nextWord);
            });

        } else if ($word.parents('.cd-headline').hasClass('loading-bar')){
            $word.parents('.cd-words-wrapper').removeClass('is-loading');
            switchWord($word, nextWord);
            setTimeout(function(){ hideWord(nextWord) }, barAnimationDelay);
            setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('is-loading') }, barWaiting);

        } else {
            switchWord($word, nextWord);
            setTimeout(function(){ hideWord(nextWord) }, custom_delay);
        }
    }

    function showWord($word, $duration) {
        if($word.parents('.cd-headline').hasClass('type')) {
            showLetter($word.find('i').eq(0), $word, false, $duration);
            $word.addClass('is-visible').removeClass('is-hidden');
        } else if($word.parents('.cd-headline').hasClass('clip')) {
            $word.parents('.cd-words-wrapper').animate({ 'width' : $word.width() + 10 }, revealDuration, function() {
                setTimeout(function(){ hideWord($word) }, revealAnimationDelay);
            });
        }
    }

    function hideLetter($letter, $word, $bool, $duration) {
        var custom_delay=animationDelay;
        if ($word.parents('.cd-headline').attr('data-speed')!==undefined) {
            custom_delay=$word.parents('.cd-headline').attr('data-speed');
        }
        $letter.removeClass('in').addClass('out');

        if(!$letter.is(':last-child')) {
            setTimeout(function(){ hideLetter($letter.next(), $word, $bool, $duration); }, $duration);
        } else if($bool) {
            setTimeout(function(){ hideWord(takeNext($word)) }, custom_delay);
        }

        if($letter.is(':last-child') && jQuery('html').hasClass('no-csstransitions')) {
            var nextWord=takeNext($word);
            switchWord($word, nextWord);
        }
    }

    function showLetter($letter, $word, $bool, $duration) {
        $letter.addClass('in').removeClass('out');
        var custom_delay=animationDelay;
        if ($word.parents('.cd-headline').attr('data-speed')!==undefined) {
            custom_delay=$word.parents('.cd-headline').attr('data-speed');
        }
        if(!$letter.is(':last-child')) {
            setTimeout(function(){ showLetter($letter.next(), $word, $bool, $duration); }, $duration);
        } else {
            if($word.parents('.cd-headline').hasClass('type')) { setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('waiting'); }, 200);}
            if(!$bool) { setTimeout(function(){ hideWord($word) }, custom_delay) }
        }
    }

    function takeNext($word) {
        return (!$word.is(':last-child')) ? $word.next() : $word.parent().children().eq(0);
    }

    function takePrev($word) {
        return (!$word.is(':first-child')) ? $word.prev() : $word.parent().children().last();
    }

    function switchWord($oldWord, $newWord) {
        $oldWord.removeClass('is-visible').addClass('is-hidden');
        $newWord.removeClass('is-hidden').addClass('is-visible');
    }
    //END ANIMATED HEADLINES FUNCTIONS

    //FOOTER
    var widgets_counter=0;
    jQuery('#prk_footer_inner>.row>.widget').each(function() {
        jQuery(this).addClass(theme_options.widgets_nr);
        widgets_counter++;
        if (widgets_counter>1 && widgets_counter===(12/parseInt(jQuery('#prk_footer').attr('data-layout').replace('small-',''),10))) {
            jQuery(this).after('<div class="clearfix bt_2x"></div>');
            widgets_counter=0;
        }
    });

    //TOGGLE HOVER FUNCTIONS
    jQuery('#prk_blocks_wrapper,#prk_sidebar_trigger').on({
        mouseenter:function() {
            jQuery(this).addClass('hover_trigger');
        },
        mouseleave:function() {
            jQuery(this).removeClass('hover_trigger');
        }
    });

    //MODAL POPUPS
    var closeFn;
    function closeShowingModal() {
        var showingModal=document.querySelector('.modal.show');
        if (!showingModal) return;
        showingModal.classList.remove('show');
        document.body.classList.remove('disable-mouse');
        if (closeFn) {
            closeFn();
            closeFn=null;
        }
    }
    //BLOG ISOTOPE FUNCTIONS
    function load_more_posts(parent_wrapper) {
        var $newEls=[];
        var $appender=jQuery(parent_wrapper).children('.blog_appender');
        if (jQuery(parent_wrapper).children('.masonry_blog').length) {
            var $appended=jQuery(parent_wrapper).children('.masonry_blog');
        }
        else {
            var $appended=jQuery(parent_wrapper).children('.blog_entries');
        }
        jQuery(parent_wrapper).append('<div id="dumper"></div>');
        var $dumper=jQuery('#dumper');
        var pos=1;
        while (pos<=jQuery(parent_wrapper).attr('data-items')) {
            $appender.children('.blog_entry_li:nth-child('+1+')').find('.grid_image').each(function() {
                if (jQuery(this).attr('data-src')!==undefined) {
                    jQuery(this).attr('src',jQuery(this).attr('data-src'));
                }
            });
            $dumper.append($appender.children('.blog_entry_li:nth-child('+1+')'));
            pos++;
        }
        $newEls=$dumper.children();
        setTimeout(function() {
            var img_load=imagesLoaded($dumper);
            img_load.on('always', function() {
                $appended.append($newEls).isotope('appended',$newEls);
                $appended.fitVids();
                setTimeout(function() {
                    jQuery('#ajax_spinner.spinner-icon').removeClass('prk_first_anim');
                    $appended.isotope('layout');
                    //MANAGE COLORS
                    jQuery('.blog_entries').each(function() {
                        var $inner_blog=jQuery(this);
                        $inner_blog.find('.featured_color').each(function() {
                            jQuery(this).find('.squared_date.colorized,.not_zero_color,a.not_zero_color').css({'color':jQuery(this).attr('data-color')});
                            jQuery(this).find('.zero_color a,a.zero_color,.body_colored a,.small_headings_color a').attr('data-color',jQuery(this).attr('data-color'));
                            jQuery(this).find('.blog_fader_grid').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity)});
                            jQuery(this).find('.hook_colored_link>a').attr('data-forced-color',jQuery(this).attr('data-color'));
                            jQuery(this).find('.hook_date_box').css({'background-color':jQuery(this).attr('data-color')});
                        });
                    });
                    jQuery('.masonry_blog').each(function() {
                        var $inner_blog=jQuery(this);
                        $inner_blog.find('.featured_color').each(function() {
                            jQuery(this).find('a.not_zero_color,span.not_zero_color').css({'color':jQuery(this).attr('data-color')});
                            jQuery(this).find('a.zero_color,.zero_color a,.small_headings_color a,a.small_headings_color,.blog_categories a').attr('data-color',jQuery(this).attr('data-color'));
                            jQuery(this).find('.hook_colored_link>a').attr('data-forced-color',jQuery(this).attr('data-color'));
                            jQuery(this).find('.blog_fader_grid').not('.hook_gridy').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity)});
                        });
                        $inner_blog.fitVids();
                    });
                    //UPDATE CONTENT
                    thumbs_update();
                    jQuery(parent_wrapper).find('.blog_load_more').removeClass('loading_posts');
                    jQuery('#dumper').remove();
                    if($appender.is(':empty')) {
                        setTimeout(function(){
                            jQuery(parent_wrapper).find('.blog_load_more').addClass("hook_button_off");
                            var stringer=jQuery(parent_wrapper).find('.blog_load_more').attr("data-no_more");
                            jQuery(parent_wrapper).find('.blog_load_more>a').html(stringer);
                        },1200);
                    }
                },50);
            });
        },10);
    }
    //MEMBER FUNCTIONS
    function init_member() {
        if (jQuery('#member_full_row').attr('data-color')!=="default") {
            var faster_color=jQuery('#member_full_row').attr('data-color');
            jQuery('#member_full_row .prk_button_like,#member_full_row .prk_blockquote.colored_background').css({'background-color':faster_color});
            jQuery('#member_full_row .hook_navigation_singles a').attr({'data-color':faster_color});
            jQuery('#member_full_row').find('.prk_blockquote.plain').css({'border-color':faster_color});
            jQuery('#member_full_row').find('.prk_blockquote.plain .not_zero_color').css({'color':faster_color});
        }
    }
    //BLOG FUNCTIONS
    function init_blog() {
        //EASY FACEBOOK MASONRY
        jQuery('.hook_fb_feed').each(function() {
            if (jQuery(this).find('.efbl_fb_story.thumbnail').length) {
                jQuery(this).addClass('row');
                var $inner_blog=jQuery(this).children('.efbl_feed_wraper');
                $inner_blog.prepend('<div class="grid-sizer"></div>');
                $inner_blog.addClass('masonry_blog per_init');
                $inner_blog.find('.efbl_fb_story').addClass('blog_entry_li');
            }
        });

        //BIG IMAGES AND STACKED
        jQuery('.blog_entries').each(function() {
            var $inner_blog=jQuery(this);
            jQuery(this).parent().find('.filter_blog .b_filter>a').on('click',function(e) {
                e.preventDefault();
                jQuery(this).parent().parent().children('.b_filter').removeClass('active');
                curr_filter_blog=jQuery(this).attr('data-filter').split(' ');
                jQuery(this).parent().addClass('active');
                setTimeout(function(){jQuery(window).trigger("smartresize");},5);
                $inner_blog.isotope({
                    filter: '.'+curr_filter_blog
                });
            });
            $inner_blog.find('.featured_color').each(function() {
                jQuery(this).find('.squared_date.colorized,.not_zero_color,a.not_zero_color').css({'color':jQuery(this).attr('data-color')});
                jQuery(this).find('.zero_color a,a.zero_color,.body_colored a,.small_headings_color a').attr('data-color',jQuery(this).attr('data-color'));
                jQuery(this).find('.blog_fader_grid').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity)});
                jQuery(this).find('.hook_colored_link>a').attr('data-forced-color',jQuery(this).attr('data-color'));
                jQuery(this).find('.hook_date_box').css({'background-color':jQuery(this).attr('data-color')});
            });
            $inner_blog.fitVids();
            $inner_blog.addClass('prk_first_anim');
            var img_load=imagesLoaded($inner_blog);
            img_load.on('always', function() {
                $inner_blog.isotope({
                    itemSelector : '.blog_entry_li',
                    masonry:{columnWidth:'.grid-sizer'},
                    transitionDuration:'0.45s'
                });
                setTimeout(function() {
                    $inner_blog.isotope('layout');
                },30);
            });
        });
        //MASONRY AND GRID
        jQuery('.masonry_blog').each(function() {
            var $inner_blog=jQuery(this);
            if ($inner_blog.attr('data-margin')!==undefined) {
                $inner_blog.find('.blog_entry_li').css({'padding':$inner_blog.attr('data-margin')+'px'});
                $inner_blog.parent().css({'padding':$inner_blog.attr('data-margin')+'px'});
            }
            var $custom_selector=$inner_blog.parent().find('.hook_blog_filter');
            jQuery(this).parent().find('.filter_blog .b_filter>a').on('click',function(e) {
                e.preventDefault();
                jQuery(this).parent().parent().children('.b_filter').removeClass('active');
                curr_filter_blog=jQuery(this).attr('data-filter').split(' ');
                jQuery(this).parent().addClass('active');
                setTimeout(function() {
                    jQuery(window).trigger("smartresize");
                },5);
                $inner_blog.isotope({
                    filter: '.'+curr_filter_blog
                });
            });
            $inner_blog.find('.featured_color').each(function() {
                jQuery(this).find('a.not_zero_color,span.not_zero_color').css({'color':jQuery(this).attr('data-color')});
                jQuery(this).find('a.zero_color,.zero_color a,.small_headings_color a,a.small_headings_color,.blog_categories a').attr('data-color',jQuery(this).attr('data-color'));
                jQuery(this).find('.hook_colored_link>a').attr('data-forced-color',jQuery(this).attr('data-color'));
                jQuery(this).find('.blog_fader_grid').not('.hook_gridy').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity)});
            });
            $inner_blog.fitVids();
            var img_load=imagesLoaded($inner_blog);
            img_load.on('always', function() {
                $inner_blog.removeClass('per_init');
                $inner_blog.isotope({
                    itemSelector : '.blog_entry_li',
                    masonry:{columnWidth:'.grid-sizer'},
                    transitionDuration:'0.45s'
                });
                setTimeout(function() {
                    $inner_blog.isotope('layout');
                    $inner_blog.find('.centerized_child_blog').each(function() {
                        jQuery(this).css({'margin-top':-Math.round(jQuery(this).height()/2)});
                    });
                    if ($inner_blog.hasClass('efbl_feed_wraper')) {
                        $inner_blog.addClass('fb_init');
                    }
                },30);
                $inner_blog.isotope('on','layoutComplete',function() {
                    $inner_blog.find('.centerized_child_blog').each(function() {
                        jQuery(this).css({'margin-top':-Math.round(jQuery(this).height()/2)});
                    });
                });
            });
        });
        jQuery('.recentposts_ul_slider,.recentposts_ul_wp').each(function() {
            var $inner_blog=jQuery(this);
            $inner_blog.fitVids();
            $inner_blog.find('.featured_color').each(function() {
                jQuery(this).find('a.not_zero_color,span.not_zero_color').css({'color':jQuery(this).attr('data-color')});
                jQuery(this).find('a.zero_color,.zero_color a,.small_headings_color a,a.small_headings_color,.blog_categories a').attr('data-color',jQuery(this).attr('data-color'));
                jQuery(this).find('.hook_colored_link>a').attr('data-forced-color',jQuery(this).attr('data-color'));
                jQuery(this).find('.blog_fader_grid').not('.hook_gridy').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity)});
            });
        });

        //SINGLES
        if (jQuery('.hook_blog_single').length) {
            jQuery('.hook_blog_single').fitVids();
            jQuery('.hook_blog_single.featured_color').each(function() {
                var faster_color=jQuery(this).attr('data-color');
                jQuery('#hook_ajax_container').find('.not_zero_color,.not_zero_color a').not('#hook_related_grid a').css({'color':faster_color});
                jQuery('#hook_ajax_container').find('#submit_comment_div>a,#hook_sticky_menu').css({'background-color':faster_color});
                jQuery('#hook_ajax_container').find('.comments_meta_wrapper .not_zero_color a,.pirenko_highlighted,.theme_button a,.zero_color a,a.zero_color,.body_colored a,.small_headings_color a,#hook_sidebar li a,#submit_comment_div>a').not('#hook_related_grid a').attr('data-color',faster_color);
                jQuery('.hook_read a,#single_blog_meta a').attr('data-color',faster_color);
                jQuery('#hook_content').find('.prk_blockquote.plain,.hook_titled.simple_line').css('border-color',faster_color);
                jQuery('#hook_content').find('.prk_blockquote.plain .not_zero_color').css({'color':faster_color});
                jQuery('#submit_comment_div>a').css({'border-color':faster_color});
                jQuery('#hook_sidebar .prk_twt_ul i').on({
                    mouseenter:function() {
                        jQuery(this).css({'color':faster_color});
                    },
                    mouseleave:function() {
                        jQuery(this).css({'color':''});
                    }
                });
            });
        }
    }

    //PORTFOLIO FUNCTIONS
    var curr_filter="p_all";
    var curr_filter_blog="b_all";
    function init_portfolio() {
        jQuery('.hook_folio_filter .p_filter>a').on('click',function(e) {
            e.preventDefault();
            if (jQuery(this).hasClass('multifilter')) {
                curr_filter=jQuery(this).attr('data-filter').split(' ');
                setTimeout(function(){
                    jQuery(window).trigger("smartresize");
                },5);
                //CHECK IF IT IS THE PARENT FILTER
                if (jQuery(this).closest('.inner_filter').length) {
                    //CHILDREN ELEMENTS
                    jQuery(this).closest('.inner_filter').attr('data-current',curr_filter);
                    jQuery(this).parent().parent().children('.p_filter').removeClass('active');
                    jQuery(this).parent().parent().prev().removeClass('active');
                }
                else {
                    //PARENT ELEMENTS
                    jQuery(this).parent().next().attr('data-current','');
                    jQuery(this).parent().next().children('.p_filter').removeClass('active');
                }
                jQuery(this).parent().addClass('active');
                var $thisa=jQuery(this).closest('.recentfolio_ul_wp').children('.folio_masonry');
                if ($thisa.attr('data-load_all')==="true") {
                    load_more_portfolios($thisa.parent(),'true');
                }
                //CREATE STRING OF FILTERS
                var multi_filter="";
                jQuery('.hook_folio_filter .inner_filter').each(function() {
                    if (jQuery(this).attr('data-current')!=='') {
                        multi_filter=multi_filter+'.'+jQuery(this).attr('data-current');
                    }
                });
                $thisa.isotope({
                    filter: multi_filter
                });
            }
            else {
                jQuery(this).parent().parent().children('.p_filter').removeClass('active');
                curr_filter=jQuery(this).attr('data-filter').split(' ');
                jQuery(this).parent().addClass('active');
                setTimeout(function(){
                    jQuery(window).trigger("smartresize");
                },5);
                var $thisa=jQuery(this).parent().parent().parent().parent().parent().children('.folio_masonry');
                if ($thisa.attr('data-load_all')==="true") {
                    load_more_portfolios($thisa.parent(),'true');
                }
                $thisa.isotope({
                    filter: '.'+curr_filter
                });
                setTimeout(function() {
                    var elems = $thisa.isotope('getFilteredItemElements');
                    jQuery($thisa).find('.portfolio_entry_li').removeClass('hook_inactive');
                    jQuery($thisa).find('.portfolio_entry_li').not(jQuery(elems)).addClass('hook_inactive');
                    //console.log (jQuery($thisa).find('.portfolio_entry_li').not(jQuery(elems)));
                },5);
            }
        });
        jQuery('#not_slider').fitVids();
        jQuery('#hook_related_grid').find('.grid_image').each(function() {
            jQuery(this).attr('src',jQuery(this).attr('data-src'));
        });
        var img_load=imagesLoaded('#hook_related_grid');
        img_load.on('always', function() {
            jQuery('#hook_related_grid').find('.centerized_father').each(function() {
                jQuery(this).height(jQuery(this).closest('.portfolio_entry_li').innerHeight());
            });
            jQuery('#hook_related_grid').find('.hook_video-bg').each(function() {
                var $par_video=jQuery(this);
                $par_video.on("play", function () {
                    $par_video.css({'width':''});
                    $par_video.css({'height':''});
                    $par_video.css({'width':$par_video.parent().parent().width()+4});
                    if ($par_video.height()<$par_video.parent().parent().outerHeight()) {
                        $par_video.css({'width':''});
                        $par_video.css({'height':$par_video.parent().parent().outerHeight()});
                    }
                });
            });
            setTimeout(function(){
                jQuery(window).trigger("debouncedresize");
            },5);
        });
        jQuery('.folio_masonry.per_init').each(function() {
            var $container=jQuery(this);
            if (jQuery('.wided_folio').find($container).length || jQuery('.hook_super_width').find($container).length) {
                $container.parent().css({'padding-left':$container.attr('data-pad')+'px','padding-right':$container.attr('data-pad')+'px'});
            }
            $container.removeClass('per_init');
            $container.fitVids({ customSelector: "iframe[src^='https://media.flixel.com']"});
            $container.find('.centerized_father').each(function() {
                jQuery(this).height(jQuery(this).closest('.portfolio_entry_li').height());
            });
            $container.find('.hook_video-bg').each(function() {
                var $par_video=jQuery(this);
                //FORCE VIDEO RESIZE IF AUTOPLAY IS OFF
                $container.find('.hook_video-bg').each(function() {
                    if ($container.closest('.recentfolio_ul_wp').hasClass('hook_autoplay')) {
                        var $par_parent=jQuery(this).closest('.portfolio_entry_li');
                        var $par_video=jQuery(this);
                        var playPromise = $par_video.get(0).play();
                        if (playPromise !== undefined) {
                            playPromise.then(function() {
                                $par_video.get(0).volume=0;
                                $par_video.get(0).play();
                                setTimeout(function() {
                                    $par_video.get(0).pause();
                                    $par_video.get(0).volume=1;
                                },30);
                            }).catch(function(error) {
                                //Show a UI element to let the user manually start playback.
                                if (!$par_parent.find('.prk_play_promise').length) {
                                    $par_parent.addClass('prk_with_promise');
                                    $par_parent.prepend('<div class="prk_play_promise"><svg class="video-overlay-play-button" viewBox="0 0 200 200" alt="Play video"><circle cx="100" cy="100" r="90" fill="none" stroke-width="15" stroke="#fff"/><polygon points="70, 55 70, 145 145, 100" fill="#fff"/></svg></div>');
                                    //$this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').addClass('forced_promise');
                                    $par_parent.find('.prk_play_promise').on('click', function(event) {
                                        $par_video.get(0).play();
                                        $par_parent.removeClass('prk_with_promise');
                                        $par_parent.find('.prk_play_promise').addClass('prk_play_hide');
                                    });
                                }
                            });
                        }

                        //VIDEO ON CACHE BUG FIX
                        /*if ($par_video.get(0).readyState) {
                            if (!$par_video.parent().parent().hasClass('hook_loaded')) {
                                $par_video.css({'width':''});
                                $par_video.css({'height':''});
                                $par_video.parent().parent().addClass('hook_loaded');
                                $par_video.css({'width':$par_video.parent().parent().width()+4});
                                if ($par_video.height()<$par_video.parent().parent().outerHeight()) {
                                    $par_video.css({'width':''});
                                    $par_video.css({'height':$par_video.parent().parent().outerHeight()});
                                }
                            }
                            $par_video.get(0).volume=0;
                            $par_video.get(0).play();
                            setTimeout(function() {
                                $par_video.get(0).pause();
                                $par_video.get(0).volume=1;
                            },30);
                        }*/
                        //HIDE ROLLOVER BACKGROUND
                        jQuery(this).closest('.portfolio_entry_li').find('.grid_colored_block').css({'visibility':'hidden'});
                    }
                });
                $par_video.on("play", function () {
                    $par_video.css({'width':''});
                    $par_video.css({'height':''});
                    $par_video.parent().parent().addClass('hook_loaded');
                    $par_video.css({'width':$par_video.parent().parent().width()+4});
                    if ($par_video.height()<$par_video.parent().parent().outerHeight()) {
                        $par_video.css({'width':''});
                        $par_video.css({'height':$par_video.parent().parent().outerHeight()});
                    }
                });
                //VIDEO ON CACHE BUG FIX
                if ($par_video.get(0).readyState) {
                    if (!$par_video.parent().parent().hasClass('hook_loaded')) {
                        $par_video.css({'width':''});
                        $par_video.css({'height':''});
                        $par_video.parent().parent().addClass('hook_loaded');
                        $par_video.css({'width':$par_video.parent().parent().width()+4});
                        if ($par_video.height()<$par_video.parent().parent().outerHeight()) {
                            $par_video.css({'width':''});
                            $par_video.css({'height':$par_video.parent().parent().outerHeight()});
                        }
                    }
                }
            });

            var initial_filter='*'
            if ($container.attr('data-filter')!==undefined && $container.attr('data-filter')!=="") {
                initial_filter=$container.attr('data-filter');
            }

            $container.isotope({
                itemSelector : '.portfolio_entry_li',
                masonry:{columnWidth:'.grid-sizer'},
                transitionDuration:'0.45s',
                filter: initial_filter,
            });

            //Adjust active filter
            if (initial_filter!=='*') {
                $container.parent().find('.p_filter').removeClass('active');
                curr_filter = initial_filter.substr(1);
                $container.parent().find('.hook_folio_filter').find(initial_filter).parent().addClass('active');
                //jQuery(this).parent().addClass('active');
            }

            var img_load=imagesLoaded($container);
            img_load.on('always', function() {
                if (!$container.hasClass('default_colored_th')) {
                    jQuery('.portfolio_entry_li').each(function() {
                        if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" ) {
                            jQuery(this).find('.grid_colored_block').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity_folio)});
                            jQuery(this).find('.lone_linker a').css({'color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity_folio)});
                            jQuery(this).find('.lone_linker a').attr('data-color',jQuery(this).attr('data-color'));
                            jQuery(this).find('.hook_thumb_tag').css({'background-color':jQuery(this).attr('data-color')});
                        }
                    });
                }
                $container.css({'display':'block'});
                $container.find('.centerized_father').each(function() {
                    jQuery(this).height(jQuery(this).closest('.portfolio_entry_li').height());
                });
                $container.isotope('on','layoutComplete',function() {
                    $container.find('.centerized_father').each(function() {
                        jQuery(this).height(jQuery(this).closest('.portfolio_entry_li').height());
                    });
                });
                setTimeout(function() {
                    jQuery(window).trigger("debouncedresize");
                    $container.addClass('hook_ready');
                    //REMOVE THUMBS SCALE IF THERE'S A VIDEO
                    if ($container.closest('.recentfolio_ul_wp').find('.hook_video-bg').length) {
                        $container.closest('.recentfolio_ul_wp').addClass('hook_vid_folio');
                    }
                },30);
                setTimeout(function() {
                    jQuery(window).trigger("debouncedresize");
                },60);
                setTimeout(function() {
                    //jQuery(window).trigger("debouncedresize");
                },1600);
            });
            jQuery(window).on("debouncedresize", function( event ) {
                $container.isotope('layout');
                if ($container.width() % $container.attr('data-columns') !== 0) {
                    var temp=Math.ceil($container.width() / $container.attr('data-columns')) * $container.attr('data-columns');
                    $container.width(temp);
                }
            });
            jQuery(window).trigger("debouncedresize");
        });
        jQuery('#hook_close_portfolio').attr({'data-color':'default'});

        jQuery('.folio_panels.layout-featured.hook_colored .portfolio_entry_li.featured_color').each(function() {
            var faster_color=jQuery(this).attr('data-color');
            jQuery(this).find('.grid_single_title .body_bk_color,.ghost_theme_button>span').css({'color':faster_color});
            jQuery(this).find('.ghost_theme_button>span').css({'border-color':faster_color});
        });

        //SINGLES
        jQuery('.pirenko_portfolios.featured_color').each(function() {
            var faster_color=jQuery(this).attr('data-color');
            jQuery(this).find('#half-entry-right a').not(jQuery(this).find('#half-entry-right #single_post_sharer a,#half-entry-right .body_colored a,.theme_button a,.colored_theme_button a')).css({'color':faster_color});
            jQuery(this).find('.pirenko_highlighted,.theme_button a,.colored_theme_button a,#half-entry-right .body_colored a').attr('data-color',faster_color);
            jQuery('#prk_full_folio.featured_color #single_entry_content a,#single_blog_meta a,.hook_info_block a.hook_ext').css({'color':faster_color});
            jQuery('#hook_close_portfolio').attr({'data-color':faster_color});
            jQuery('#half-entry-right').find('.colored_theme_button a').css({'background-color':faster_color,'border-color':faster_color});
            jQuery('#hook_sticky_menu').css({'background-color':faster_color});
            jQuery('#hook_ajax_inner').find('.prk_blockquote.plain').css('border-color',faster_color);
            jQuery('#hook_ajax_inner').find('.prk_blockquote.plain .not_zero_color').css({'color':faster_color});
        });
        if (jQuery('#hook_main_wrapper').hasClass('hook_showing_ajax')) {
            jQuery('#single_meta_header a,#hook_related_grid a').not('#hook_to_parent a').addClass('overlayed_anchor per_init');
            jQuery('#hook_to_parent a').addClass('hook_anchor');
        }
        else {
            jQuery('#single_meta_header a,#hook_related_grid a,#hook_to_parent a').addClass('hook_anchor');
        }

        jQuery('.hook_iso_gallery.per_init').each(function() {
            var $container_gals=jQuery(this);
            var iso_gallery_gutter=parseInt($container_gals.attr('data-margin'),10);
            $container_gals.children('.portfolio_entry_li').find('.grid_image').each(function(){
                jQuery(this).attr('src',jQuery(this).attr('data-src'));
            });
            setTimeout(function() {
                var img_load=imagesLoaded($container_gals);
                img_load.on('always', function() {
                    $container_gals.removeClass('per_init');
                    if (iso_gallery_gutter!==0) {
                        $container_gals.css({'margin-right':-iso_gallery_gutter});
                    }
                    else {
                        $container_gals.css({'margin-right':''});
                    }
                    if (!jQuery('#filter_top').length) {
                        $container_gals.css({'margin-top':iso_gallery_gutter});
                    }
                    $container_gals.find('.centerized_father').each(function() {
                        jQuery(this).height(jQuery(this).closest('.portfolio_entry_li').height());
                    });
                    $container_gals.isotope({
                        itemSelector : '.portfolio_entry_li',
                        masonry:{columnWidth:'.grid-sizer'},
                        transitionDuration:'0.45s',
                        //layoutMode: 'fitRows',
                    });
                    $container_gals.find('.centerized_father').each(function() {
                        jQuery(this).height(jQuery(this).closest('.portfolio_entry_li').height());
                    });
                    $container_gals.isotope('on', 'layoutComplete',function() {
                        $container_gals.find('.centerized_father').each(function() {
                            jQuery(this).height(jQuery(this).closest('.portfolio_entry_li').height());
                        });
                    });
                    setTimeout(function() {
                        $container_gals.isotope('layout');
                    },30);
                });
            },15);
        });
    }
    function load_more_portfolios(parent_wrapper,filter_trigger) {
        var $newEls=[];
        var $appender=jQuery(parent_wrapper).children('.folio_appender');
        var $appended=jQuery(parent_wrapper).children('.folio_masonry');
        jQuery(parent_wrapper).append('<div id="dumper"></div>');
        var $dumper=jQuery('#dumper');
        var pos=1;
        if (filter_trigger==="true") {
            jQuery(parent_wrapper).attr('data-items','9999');
        }
        while (pos<=jQuery(parent_wrapper).attr('data-items')) {
            $appender.children('.portfolio_entry_li:nth-child('+1+')').find('.grid_image').each(function(){
                jQuery(this).attr('src',jQuery(this).attr('data-src'));
            });
            $dumper.append($appender.children('.portfolio_entry_li:nth-child('+1+')'));
            pos++;
        }
        $newEls=$dumper.children();
        setTimeout(function() {
            var img_load=imagesLoaded($dumper);
            img_load.on('always', function() {
                $appended.append($newEls).isotope('appended',$newEls);
                $appended.isotope('layout');
                thumbs_update();
                //FORCE VIDEO RESIZE IF AUTOPLAY IS OFF
                $appended.find('.hook_video-bg').each(function() {
                    if ($appended.closest('.recentfolio_ul_wp').hasClass('hook_autoplay')) {
                        var $par_video=jQuery(this);
                        $par_video.on("canplay", function () {
                            $par_video.get(0).volume=0;
                            $par_video.get(0).play();
                            setTimeout(function() {
                                $par_video.get(0).pause();
                                $par_video.get(0).volume=1;
                            },30);
                        });
                        //VIDEO ON CACHE BUG FIX
                        if ($par_video.get(0).readyState) {
                            $par_video.get(0).volume=0;
                            $par_video.get(0).play();
                            setTimeout(function() {
                                $par_video.get(0).pause();
                                $par_video.get(0).volume=1;
                            },30);
                        }
                        //HIDE ROLLOVER BACKGROUND
                        jQuery(this).closest('.portfolio_entry_li').find('.grid_colored_block').css({'visibility':'hidden'});
                    }
                });
                setTimeout(function() {
                    jQuery(window).trigger("debouncedresize");
                },125);
                jQuery(parent_wrapper).find('.pf_load_more').removeClass('loading_posts');
                jQuery('#dumper').remove();
                if($appender.is(':empty')) {
                    setTimeout(function(){
                        jQuery(parent_wrapper).find('.pf_load_more').addClass("hook_button_off");
                        var stringer=jQuery(parent_wrapper).find('.pf_load_more').attr("data-no_more");
                        jQuery(parent_wrapper).find('.pf_load_more>a').html(stringer);
                    },1200);
                }
            });
        },10);
    }
    //END - PORTFOLIO FUNCTIONS

    //SCROLLING FUNCTIONS
    function go_hash(timing,closed_folio) {
        var offsetter="";
        //TRY TO MOVE TO PORTFOLIO IF NEEDED AND POSSIBLE
        if (closed_folio) {
            var $target=jQuery('#hook_ajax_container .recentfolio_ul_wp .hook_active_fl');
            if (target!=="") {
                //IS IT AN EXISITNG ID
                if ($target.offset()!==undefined) {
                    offsetter=$target.offset().top;
                }
            }
            jQuery('#hook_ajax_container .recentfolio_ul_wp .hook_active_fl').removeClass('hook_active_fl');
        }
        else {
            if (window.location.hash==="#" || window.location.hash==="") {
                //DO NOTHING
            }
            else {
                var target=window.location.hash;
                var $target=jQuery(target);
                //IS IT AN ANCHOR LINK
                if (target!=="") {
                    //IS IT AN EXISITNG ID
                    if ($target.offset()!==undefined) {
                        offsetter=$target.offset().top;
                    }
                }
            }
        }
        if (offsetter!=="") {
            jQuery('html,body').stop().animate({
                    'scrollTop': offsetter-admin_bar_height-mn_collapsed
                },
                timing,
                'easeInOutExpo');
        }
    }

    //HACK FOR THUMBS ON TESTIMONIALS
    function create_thumbs(current_slider) {
        if (current_slider.hasClass('with_thumbs')) {
            var $divider=1;
            if (current_slider.parent().hasClass('hook_retina')) {
                $divider=2;
            }
            current_slider.find('.item').each(function(i) {
                current_slider.find('.owl-pagination>.owl-page:nth-child('+parseInt(i+1,10)+')').html('<img src='+jQuery(this).find('img').attr('src')+' width='+jQuery(this).find('img').attr('width')/$divider+' height='+jQuery(this).find('img').attr('height')/$divider+' alt="" />');
            });
        }
    }

    //AJAX EMAIL SEND
    function email_ajax_submit() {
        var prk_form_content=jQuery('.hook_sending_email').serialize();
        var data={
            action: 'mail_before_submit',
            email_wrap: prk_form_content,
            _ajax_nonce:ajax_var.nonce
        };
        jQuery.post(ajax_var.url, data, function(response) {
            jQuery(".hook_sending_email #contact_ok").removeClass('flash');
            jQuery(".hook_sending_email #contact_ok").addClass('forced_opacity');
            if(response==='sent0') {
                jQuery(".hook_sending_email #contact_ok").html(jQuery('.hook_sending_email').attr('data-ok'));
            }
            else {
                jQuery(".hook_sending_email #contact_ok").html(response);
            }
            jQuery('.hook_sending_email').removeClass('hook_sending_email');
        });
        return false;
    }

    //SHOW HIDDEN FOLIO TRIGGER
    function prk_toggle_folio() {
        if (hidden_folio_is_open===false) {
            hidden_folio_is_open=true;
            jQuery('#hook_main_wrapper').addClass('hook_showing_hidden');
            jQuery('#hook_hidden_portfolio .folio_masonry').isotope({
                itemSelector : '.portfolio_entry_li',
                masonry:{columnWidth:'.grid-sizer'},
                transitionDuration:'0s'
            });
            setTimeout(function() {
                jQuery('html,body').animate({scrollTop:0},0);
                jQuery('#hook_main_wrapper').addClass('second_anims');
                jQuery('#hook_hidden_portfolio .folio_masonry').isotope({
                    itemSelector : '.portfolio_entry_li',
                    masonry:{columnWidth:'.grid-sizer'},
                    transitionDuration:'0.45s'
                });
                jQuery(window).trigger("debouncedresize");
            },100);
            setTimeout(function() {
                jQuery('#hook_main_wrapper').addClass('third_anims');
                jQuery('#hook_hidden_portfolio .folio_masonry').isotope('layout');
            },430);
        }
        else {
            hidden_folio_is_open=false;
            jQuery('#hook_main_wrapper').removeClass('third_anims');
            jQuery('html,body').animate({scrollTop:0},100);
            setTimeout(function() {
                jQuery('#hook_main_wrapper').removeClass('second_anims');
            },50);
            setTimeout(function() {
                jQuery('#hook_main_wrapper').removeClass('hook_showing_hidden');
                jQuery('html,body').animate({scrollTop:0},0);
            },380);
        }
    }

    //AJAX PORTFOLIO LOAD FUNCTIONS
    var hook_ajax_folio=jQuery("#hook_ajax_pf_inner");
    function show_new_entry(ajax_page,text) {
        hook_ajax_folio.html('');
        var loaded_html=jQuery(text);
        var new_inner=loaded_html.find('#hook_ajax_inner');
        hook_ajax_folio.append(new_inner);
        jQuery('html,body').animate({scrollTop:0},0);
        jQuery('#hook_main_wrapper').removeClass('prk_wait');
        jQuery('#hook_main_wrapper').removeClass('prk_load_folio');
        jQuery('#hook_main_wrapper').addClass('hook_showing_ajax');
        ended_loading();
    }
    function load_ajax_link(ajax_page,change_history) {
        console.log("LOADING PORTFOLIO");
        jQuery('#prk_main_loader').removeClass('prk_tweaked');
        jQuery.ajax({
            url: ajax_page,
            dataType: 'html',
            async: true,
            success: function (text) {
                //CHANGE HISTORY IF NEEDED
                if (change_history===true && window.history.pushState) {
                    var pageurl=ajax_page;
                    if (pageurl !== window.location) {
                        window.history.pushState({
                            path: pageurl
                        }, '', pageurl);
                    }
                }
                loading_page=false;
                if (ran_preloader===true) {
                    show_new_entry(ajax_page,text);
                }
                else {
                    setTimeout(function() {
                        show_new_entry(ajax_page,text);
                    },fadeout_timing);
                }
            },
            error: function () {
                //SHOW 404 ERROR PAGE IF NEEDED
                window.location.replace(ajax_page);
            }
        });
    }

    //AJAX PAGES LOAD FUNCTIONS
    //WINDOW HISTORY MANAGEMENT
    if (ajax_calls && window.history.pushState) {
        jQuery(window).on({
            popstate:function () {
                if (current_URL!==jQuery(location).attr('href') && first_load===false && location.href.indexOf("#")===-1) {
                    var next_page=jQuery(location).attr('href');
                    window.location=next_page;
                }
            },
        });
    }
    function update_page_meta(text) {
        var new_title=text.find('#hook_ajax_title').text();
        document.title=new_title;
        jQuery('body').removeClass();
        jQuery('body').addClass(text.find('#hook_ajax_classes').attr('class'));
        jQuery('body').addClass(text.find('#hook_ajax_classes').attr('data-hook_class'));
        jQuery('#prk_footer_wrapper').removeClass('hook_no_footer');
    }
    function show_new_page(ajax_page,text) {
        var loaded_html=jQuery(text);
        var new_inner=loaded_html.find('#hook_ajax_inner');
        current_URL=jQuery(location).attr('href');
        if (current_URL.substr(-1)==="#") {
            current_URL=current_URL.slice(0,-1);
        }
        prk_page_content.html('');
        prk_page_content.append(new_inner);
        update_page_meta(loaded_html);
        ended_loading();
    }
    function load_ajax_page(ajax_page,change_history) {
        console.log("LOADING PAGE");
        setTimeout(function() {
            if (loading_page===true) {
                prk_page_content.html('');
            }
            if (menu_is_open===true) {
                prk_toggle_menu();
            }
        },fadeout_timing);
        jQuery('#prk_main_loader').removeClass('prk_tweaked');
        jQuery('#hook_main_wrapper').removeClass('hook_forced_menu');
        jQuery.ajax({
            url: ajax_page,
            dataType: 'html',
            async: true,
            success: function (text) {
                //CHANGE HISTORY IF NEEDED
                if (change_history===true && window.history.pushState) {
                    var pageurl=ajax_page;
                    if (pageurl !== window.location) {
                        window.history.pushState({
                            path: pageurl
                        }, '', pageurl);
                    }
                }
                loading_page=false;
                if (ran_preloader===true) {
                    show_new_page(ajax_page,text);
                }
                else {
                    setTimeout(function() {
                        show_new_page(ajax_page,text);
                    },fadeout_timing);
                }
            },
            error: function () {
                //SHOW 404 ERROR PAGE IF NEEDED
                window.location.replace(ajax_page);
            }
        });
    }

    //THUMBS AND BUTTON FUNTIONS
    function thumbs_update() {
        jQuery('.pf_load_more,.blog_load_more,.blog_hover').on({
            mouseenter:function() {
                if (!hook_on_mobile) {
                    jQuery(this).addClass('hover_trigger');
                    if (jQuery(this).hasClass('portfolio_entry_li') && jQuery(this).closest('.recentfolio_ul_wp').hasClass('hook_autoplay') && jQuery(this).find('.hook_video-bg').length) {
                        if (!jQuery(this).closest('.recentfolio_ul_wp').hasClass('hook_resume')) {
                            jQuery(this).find('.hook_video-bg').get(0).currentTime=0;
                        }
                        var $par_parent=jQuery(this);
                        var $par_video=jQuery(this).find('.hook_video-bg');
                        var playPromise = $par_video.get(0).play();
                        if (playPromise !== undefined) {
                            playPromise.then(function() {
                                $par_video.get(0).play();
                            }).catch(function(error) {
                                //Show a UI element to let the user manually start playback.
                                if (!$par_parent.find('.prk_play_promise').length) {
                                    $par_parent.addClass('prk_with_promise');
                                    $par_parent.prepend('<div class="prk_play_promise"><svg class="video-overlay-play-button" viewBox="0 0 200 200" alt="Play video"><circle cx="100" cy="100" r="90" fill="none" stroke-width="15" stroke="#fff"/><polygon points="70, 55 70, 145 145, 100" fill="#fff"/></svg></div>');
                                    //$this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').addClass('forced_promise');
                                    $par_parent.find('.prk_play_promise').on('click', function(event) {
                                        $par_video.get(0).play();
                                        $par_parent.removeClass('prk_with_promise');
                                        $par_parent.find('.prk_play_promise').addClass('prk_play_hide');
                                    });
                                }
                            });
                        }
                    }
                }
            },
            mouseleave:function() {
                if (!hook_on_mobile) {
                    jQuery(this).removeClass('hover_trigger');
                    if (jQuery(this).hasClass('portfolio_entry_li') && jQuery(this).closest('.recentfolio_ul_wp').hasClass('hook_autoplay') && jQuery(this).find('.hook_video-bg').length) {
                        jQuery(this).find('.hook_video-bg').get(0).pause();
                    }
                }

            }
        });

        jQuery('.portfolio_entry_li a').on({
            mouseenter:function() {
                if (!hook_on_mobile) {
                    jQuery(this).parent().addClass('hover_trigger');
                    if (jQuery(this).closest('.recentfolio_ul_wp').hasClass('hook_autoplay') && jQuery(this).find('.hook_video-bg').length) {
                        if (!jQuery(this).closest('.recentfolio_ul_wp').hasClass('hook_resume')) {
                            jQuery(this).find('.hook_video-bg').get(0).currentTime=0;
                        }
                        var $par_parent=jQuery(this).parent();
                        var $par_video=jQuery(this).find('.hook_video-bg');
                        var playPromise = $par_video.get(0).play();
                        if (playPromise !== undefined) {
                            playPromise.then(function() {
                                $par_video.get(0).play();
                            }).catch(function(error) {
                                //Show a UI element to let the user manually start playback.
                                if (!$par_parent.find('.prk_play_promise').length) {
                                    $par_parent.addClass('prk_with_promise');
                                    $par_parent.prepend('<div class="prk_play_promise"><svg class="video-overlay-play-button" viewBox="0 0 200 200" alt="Play video"><circle cx="100" cy="100" r="90" fill="none" stroke-width="15" stroke="#fff"/><polygon points="70, 55 70, 145 145, 100" fill="#fff"/></svg></div>');
                                    //$this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').addClass('forced_promise');
                                    $par_parent.find('.prk_play_promise').on('click', function(event) {
                                        $par_video.get(0).play();
                                        $par_parent.removeClass('prk_with_promise');
                                        $par_parent.find('.prk_play_promise').addClass('prk_play_hide');
                                    });
                                }
                            });
                        }
                    }
                }
            },
            mouseleave:function() {
                if (!hook_on_mobile) {
                    jQuery(this).parent().removeClass('hover_trigger');
                    if (jQuery(this).closest('.recentfolio_ul_wp').hasClass('hook_autoplay') && jQuery(this).find('.hook_video-bg').length) {
                        jQuery(this).find('.hook_video-bg').get(0).pause();
                    }
                }

            }
        });
        jQuery('.member_colored_block').on({
            mouseenter:function() {
                if (!hook_on_mobile) {
                    jQuery(this).addClass('hover_trigger');
                }
                if (jQuery('.member_ul.cl_mode').find(jQuery(this)).length) {
                    jQuery(this).find('.sh_member_desc').css({'margin-top':-Math.ceil(jQuery(this).find('.sh_member_desc').height()/2)});
                }
            },
            mouseleave:function() {
                if (!hook_on_mobile) {
                    jQuery(this).removeClass('hover_trigger');
                }
            },
        });
        jQuery('.pirenko_portfolios.featured_color a.hook_colored_link,.pirenko_portfolios.featured_color .hook_colored_link>a,.hook_blog_single.featured_color .hook_colored_link>a,a.zero_color,.zero_color a,a.small_headings_color,.small_headings_color a,.pirenko_social a,a.body_colored,.body_colored>a').not('.single_blog_meta_div>.hook_colored_link>a').on({
            mouseenter:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).css({'color':jQuery(this).attr('data-color')});
                }
                jQuery(this).children('.prk_theme_arrows').addClass('hook_hover_arrow');
            },
            mouseleave:function() {
                if (jQuery(this).attr('data-forced-color')!==undefined) {
                    jQuery(this).css({'color':jQuery(this).attr('data-forced-color')});
                }
                else {
                    jQuery(this).css({'color':''});
                }
                jQuery(this).children('.prk_theme_arrows').removeClass('hook_hover_arrow');
            }
        });
        jQuery('.social_links_shortcode a').on({
            mouseenter:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).css({'color':jQuery(this).attr('data-color')});
                    jQuery(this).find('.hook_inner_social').css({'border-color':jQuery(this).attr('data-color')});
                }
            },
            mouseleave:function() {
                if (jQuery(this).attr('data-up-color')!==undefined && jQuery(this).attr('data-up-color')!=="default") {
                    jQuery(this).css({'color':jQuery(this).attr('data-up-color')});
                    jQuery(this).find('.hook_inner_social').css({'border-color':jQuery(this).attr('data-up-color')});
                }
            },
        });
        jQuery('#prk_tags_inner a').addClass('hook_tagged');
        jQuery('.theme_button a').not(jQuery('.theme_button a.hook_tagged')).on({
            mouseenter:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).css({'background-color':jQuery(this).attr('data-color'),'border-color':jQuery(this).attr('data-color')});
                }
            },
            mouseleave:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).css({'background-color':'','border-color':''});
                }
            },
        });
        jQuery('.theme_button a.hook_tagged').on({
            mouseenter:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).css({'color':jQuery(this).attr('data-color'),'border-color':jQuery(this).attr('data-color')});
                }
            },
            mouseleave:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).css({'color':'','border-color':''});
                }
            },
        });
        jQuery('.ghost_theme_button a').on({
            mouseenter:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).css({'border-color':theme_options.active_color,'color':theme_options.buttons_text_color});
                }
            },
            mouseleave:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).css({'border-color':jQuery(this).attr('data-color'),'color':jQuery(this).attr('data-color')});
                }
            },
        });
        jQuery('#hook_main_wrapper .owl-wrapper .ghost_theme_button>span').on({
            mouseenter:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).children('span').css({'background-color':jQuery(this).attr('data-color')});
                    jQuery(this).css({'border-color':jQuery(this).attr('data-color')});
                    if (jQuery(this).attr('data-hover_color')!==undefined) {
                        jQuery(this).css({'color':theme_options.thumbs_text_color});
                    }
                }
            },
            mouseleave:function() {
                if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
                    if (jQuery(this).attr('data-hover_color')!==undefined) {
                        jQuery(this).css({'color':jQuery(this).attr('data-color')});
                    } else {
                        jQuery(this).css({'background-color':'','border-color':''});
                    }
                }
            },
        });
        jQuery('.colored_theme_button a').on({
            mouseenter:function() {

            },
            mouseleave:function() {

            },
        });
        jQuery('.prk_service').on({
            mouseenter:function() {
                if (jQuery(this).attr('data-color')!=="default") {
                    jQuery(this).find('.colored_link_icon').css({'color':jQuery(this).attr('data-color')});
                }
            },
            mouseleave:function() {
                if (jQuery(this).attr('data-default')!=="default") {
                    jQuery(this).find('.colored_link_icon').css({'color':jQuery(this).attr('data-default')});
                }
                else {
                    jQuery(this).find('.colored_link_icon').css({'color':''});
                }
            },
        });
        jQuery('.hook_lback.per_init').each(function() {
            jQuery(this).removeClass('per_init');
            jQuery(this).on('click',function(e) {
                jQuery(this).parent().parent().submit();
            });
        });
        //PORTFOLIO AJAX LINKS
        jQuery("a.overlayed_anchor.per_init").each(function() {
            jQuery(this).removeClass('per_init');
            jQuery(this).on('click',function(e) {
                if (jQuery(this).attr('target')==="_blank") {
                }
                else {
                    e.preventDefault();
                    jQuery('body').removeClass('sticky_hook');
                    if(hook_on_mobile && jQuery(this).hasClass('hook_touch') && !jQuery(this).parents('.portfolio_entry_li.hover_trigger').length) {
                        jQuery(this).closest('.recentfolio_ul_wp').find('.portfolio_entry_li').removeClass('hover_trigger');
                        jQuery(this).parent().addClass('hover_trigger');
                        return;
                    }
                    if (jQuery(this).parent().attr('data-color')!==undefined && jQuery(this).parent().attr('data-color')!=="default") {
                        jQuery('#hook_loader_block,#hook_to_top').css({'background-color':jQuery(this).parent().attr('data-color')});
                    }
                    else {
                        if(jQuery('.hook_vertical_folio .featured_color.color_trigger').find(jQuery(this)).length) {
                            jQuery('#hook_loader_block,#hook_to_top').css({'background-color':jQuery(this).find('.ghost_theme_button>span').attr('data-color')});
                        }
                        else {
                            jQuery('#hook_loader_block,#hook_to_top').css({'background-color':''});
                        }
                    }
                    var next_page=jQuery(this).attr("href");
                    if (!jQuery('#hook_main_wrapper').hasClass('hook_showing_ajax')) {
                        if (jQuery('.hook_vertical_folio').find(jQuery(this)).length) {
                            jQuery(this).closest('.wpb_row').addClass('hook_active_fl');
                        }
                        else {
                            jQuery(this).addClass('hook_active_fl');
                        }
                        loading_page=true;
                        ran_preloader=false;
                        setTimeout(function() {
                            ran_preloader=true;
                        },fadeout_timing);
                        jQuery('#hook_main_wrapper').addClass('prk_loading_page');
                        jQuery('#hook_main_wrapper').addClass('prk_wait');
                        jQuery('#prk_main_loader').removeClass('prk_hidden_loader');
                        //PAUSE VIDEO
                        if (jQuery('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg').length) {
                            jQuery('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg').get(0).pause();
                        }
                        setTimeout(function() {
                            load_ajax_link(next_page,false);
                        },350);
                        setTimeout(function() {
                            jQuery('#hook_overlayer').addClass('show');
                        },fadeout_timing);
                    }
                    else {
                        //REGULAR LINKS - INSIDE OVERLAYER ALREADY
                        loading_page=true;
                        ran_preloader=false;
                        jQuery('#hook_main_wrapper').addClass('prk_loading_page');
                        jQuery('#hook_main_wrapper').addClass('prk_wait');
                        jQuery('#prk_main_loader').removeClass('prk_hidden_loader');
                        setTimeout(function() {
                            load_ajax_link(next_page,false);
                        },300);
                    }

                }
            });
        });
        jQuery('.hook_next_arrow').each(function() {
            if (jQuery(this).hasClass('hook_sp_arrow')) {
                jQuery(this).parent().attr('href','#'+jQuery('#s_sec_inner>.hook_row').attr('id'));
                if (jQuery(this).parent().attr('data-color')!=="default") {
                    jQuery(this).parent().css({'color':jQuery(this).parent().attr('data-color')});
                }
            }
            else if (!jQuery(this).hasClass('hook_at_slider')) {
                if (jQuery(this).parent().attr('href')==="") {
                    jQuery(this).parent().attr('href','#'+jQuery(this).parent().parent().next().next().attr('id'));
                }
                jQuery(this).parent().css({'color':jQuery(this).parent().parent().css('color')});
            }
        });
        jQuery(".member_colored_block.hook_linked").each(function() {
            jQuery(this).on('click',function(e) {
                var next_page=jQuery(this).attr('data-link');
                if(hasParentClass(e.target,'member_colored_block_in') || hasParentClass(e.target,'sh_member_trg') ) {
                    if (ajax_calls) {
                        loading_page=true;
                        ran_preloader=false;
                        setTimeout(function() {
                            ran_preloader=true;
                        },fadeout_timing);
                        jQuery('#hook_main_wrapper').addClass('prk_loading_page');
                        jQuery('#hook_main_wrapper').addClass('prk_wait');
                        jQuery('#prk_main_loader').removeClass('prk_hidden_loader');
                        setTimeout(function() {
                            load_ajax_page(next_page,true);
                        },350);
                    }
                    else {
                        window.location=next_page;
                    }
                }
            });
        });
        jQuery(".pf_load_more a.per_init").each(function() {
            jQuery(this).removeClass('per_init');
            jQuery(this).on('click',function(e) {
                e.preventDefault();
                if (!jQuery(this).hasClass('loading_posts')) {
                    jQuery(this).parent().removeClass('hover_trigger');
                    jQuery(this).parent().addClass('loading_posts');
                    load_more_portfolios(jQuery(this).parent().parent().parent(),'false');
                }
            });
        });
        jQuery('.blog_load_more a').on('click',function(e) {
            e.preventDefault();
            if (!jQuery(this).parent().hasClass('loading_posts')) {
                jQuery(this).parent().addClass('loading_posts');
                jQuery('#ajax_spinner.spinner-icon').addClass('prk_first_anim');
                load_more_posts(jQuery('.blog_load_more').parent().parent());
            }
        });
        jQuery(".hook_read a").on('click', function(event) {
            event.preventDefault();
            var offsetter="";
            var fragment=jQuery(this).attr('href').split('#');
            if ((jQuery(this).attr('href')==="#" || fragment[1]==="") && fragment[0]===current_URL)  {
                offsetter=0;
            }
            else {
                var target=this.hash;
                var $target=jQuery(target);
                //IS IT AN ANCHOR LINK
                if (target!=="") {
                    //IS IT AN EXISITNG ID
                    if ($target.offset()!==undefined) {
                        offsetter=$target.offset().top;
                    }
                }
            }
            if (offsetter!=="") {
                jQuery('html,body').stop().animate({
                        'scrollTop': offsetter-admin_bar_height-mn_collapsed
                    },
                    1200,
                    'easeInOutExpo');
            }
        });
    }
    //END - THUMBS AND BUTTON FUNTIONS
    var prk_page_content;
    function ended_loading() {
        console.log("ENDED LOADING");
        prk_page_content=jQuery("#hook_ajax_container");
        smooth_scroll_now=false;
        //BLOG PAGES WITH BACKGROUND COLOR
        var custom_color=jQuery('#hook_ajax_inner.hook_colored').attr('data-color');
        if (custom_color!==undefined && custom_color!=='default') {
            jQuery('#hook_ajax_inner').css({'background-color':custom_color});
        }
        //SINGLE POSTS WITH FEATURED COLOR
        var custom_color=jQuery('#hook_ajax_inner.featured_color').attr('data-color');
        if (custom_color!==undefined && custom_color!=='default') {
            jQuery('#hook_to_top').css({'background-color':custom_color});
        }
        else {
            jQuery('#hook_to_top').css({'background-color':''});
        }
        jQuery('html,body').animate({scrollTop:0},0);
        var rows=jQuery('#owl-row,#s_sec_inner>.hook_row,#portfolio_single_page');
        var rows_array=[];
        rows.each( function(i,e) {
            rows_array.push(jQuery(e).attr('id'));
        });
        //console.log(rows_array);
        var menu_anchors=jQuery('#hook_main_menu .hook-mn li');
        if (rows.length) {
            deactivate_menu_links();
            //CHECK IF WE NEED TO "TRIGGER" THE WAYPOINT MANUALLY - NO ROW AT THE TOP
            if (jQuery('#hook_ajax_inner').hasClass('hook_forced_menu')) {
                var found_url=false;
                jQuery('#hook_main_menu .hook-mn>li>a').each(function() {
                    if (found_url===false) {
                        if(jQuery(this).attr('href')===window.location.href || (jQuery(this).attr('href').indexOf('#')!==-1 && jQuery(this).attr('href').split('#')[0]===window.location.href)) {
                            jQuery(this).parent().addClass('active');
                            found_url=true;
                        }
                    }
                });
            }
        }

        rows.waypoint({
            handler: function(direction) {
                if (!jQuery('html').hasClass('menu_at_top')) {

                    var pos=jQuery.inArray(this.element.id,rows_array);
                    var visible_row=rows.eq(direction==="up" ? pos-1 : pos);
                    if (pos<0) {
                        pos=0;
                    }
                    if (visible_row.attr("id")!==undefined && jQuery('#hook_main_menu .hook-mn>li').length) {
                        var high_link="";
                        if (pos===0 && direction==="up") {
                            var stringah=jQuery('#hook_main_menu .hook-mn>li:first-child>a').attr('href');
                            if (stringah.indexOf('#')!==-1) {
                                high_link=jQuery('#hook_main_menu .hook-mn>li:first-child>a[href$="#"]');
                            }
                        }
                        else {
                            var high_link=jQuery('#hook_main_menu .hook-mn a[href$="#'+visible_row.attr("id")+'"]');
                        }
                        //CHECK IF A MENU BUTTON HAS THIS LINK
                        if (high_link.length) {
                            deactivate_menu_links();
                            high_link.parent().addClass('active');
                        }
                        if (jQuery('#hook_main_menu ul li.active').length && ((visible_row.attr("id").substring(0,6)==="hook-" && pos===0) || visible_row.attr("id")==="owl-row" || visible_row.hasClass('hook_first_row'))) {
                            deactivate_menu_links();
                        }
                        //BUG FIX WHEN NOTHING IS HIGHLIGHTED
                        if (!jQuery('#hook_main_menu ul li.active').length) {
                            var founded=false;
                            jQuery('#hook_main_menu .hook-mn>li>a').each(function() {
                                if(window.location.href===jQuery(this).attr('href')) {
                                    high_link=jQuery(this);
                                    founded=true;
                                }
                            });
                            if (founded===false && (pos===0 || visible_row.attr("id")==="owl-row" || visible_row.hasClass('hook_first_row'))) {
                                var stringah=jQuery('#hook_main_menu .hook-mn>li:first-child>a').attr('href');
                                if (stringah.indexOf('#')!==-1) {
                                    high_link=jQuery('#hook_main_menu .hook-mn>li:first-child>a[href$="#"]');
                                }
                            }
                            if (high_link!="") {
                                high_link.parent().addClass('active');
                            }
                        }
                    }
                }
            },
            offset: rows_offset+'px'
        });

        if (jQuery('#hook_ajax_container #hook_ajax_inner.hook_forced_menu').length) {
            jQuery('#hook_main_wrapper').addClass('hook_forced_menu');
        }
        if (jQuery('#s_sec_inner>div:first-child').attr('data-top-bottom')!==undefined && !jQuery('#s_sec_inner>div:first-child').hasClass('hook_attached')) {
            jQuery('#s_sec_inner>div:first-child').attr('data-0-top-top','background-position: 50% 0px');
            jQuery('#s_sec_inner>div:first-child').attr('data-top-bottom','background-position: 50% 150px');
            jQuery('#s_sec_inner>div:first-child').removeAttr('data-bottom-top');
        }
        if(!jQuery('#owl-row').length) {
            jQuery('#s_sec_inner>div:first-child').addClass('hook_first_row')
        }
        if (jQuery('#prk_custom_folio>div:first-child').attr('data-top-bottom')!==undefined && !jQuery('#prk_custom_folio>div:first-child').hasClass('hook_attached')) {
            jQuery('#prk_custom_folio>div:first-child').attr('data-0-top-top','background-position: 50% 0px');
            jQuery('#prk_custom_folio>div:first-child').attr('data-top-bottom','background-position: 50% 150px');
            jQuery('#prk_custom_folio>div:first-child').removeAttr('data-bottom-top');
        }
        if (!hook_on_mobile && theme_options.show_sooner!=="yes") {
            var img_load=imagesLoaded('.hook_preloaded');
            img_load.on('always', function() {
                jQuery('.hook_preloaded').parent().addClass('hook_ready');
                jQuery('#hook_main_wrapper').addClass('prk_fading_block');
                jQuery('#hook_main_wrapper').removeClass('prk_loading_page');
                jQuery('#hook_main_wrapper').removeClass('prk_wait');
                setTimeout(function(){
                    jQuery(window).trigger("debouncedresize");
                    jQuery("#hook_ajax_container,#prk_footer_outer").addClass('prk_first_anim');
                    jQuery('#prk_main_loader').addClass('prk_tweaked');
                    jQuery('html').addClass('hook_ready');
                },75);
                setTimeout(function(){
                    jQuery('#prk_main_loader').addClass('prk_hidden_loader');
                },255);
                setTimeout(function() {
                    if (theme_options.active_visual_composer==="1") {
                        vc_waypoints();
                    }
                    Waypoint.refreshAll();
                },350);
                setTimeout(function(){
                    jQuery('#hook_main_wrapper').removeClass('prk_fading_block');
                    jQuery('#hook_main_wrapper').addClass(jQuery('#hook_main_wrapper').attr('data-trans'));
                    if (jQuery('#hook_main_wrapper').hasClass('hk_trans_hzsl')) {
                        fadeout_timing=925;
                    }
                    if (jQuery('#hook_main_wrapper').hasClass('hk_trans_vtsl')) {
                        fadeout_timing=725;
                    }
                },fadeout_timing);
                setTimeout(function() {
                    smooth_scroll_now=true;
                },1000);
                //ENSURE THAT EVERYTHING IS PERFECTLY RENDERED
                setTimeout(function() {
                    Waypoint.refreshAll();
                },2500);
                //LOAD LAZY IMAGES
                jQuery('.lazy_hook').each(function() {
                    jQuery(this).attr('src',jQuery(this).attr('data-src'));
                });
            });
        }
        else {
            jQuery('.hook_preloaded').parent().addClass('hook_ready');
            jQuery('#hook_main_wrapper').addClass('prk_fading_block');
            jQuery('#hook_main_wrapper').removeClass('prk_loading_page');
            jQuery('#hook_main_wrapper').removeClass('prk_wait');
            setTimeout(function(){
                jQuery(window).trigger("debouncedresize");
                jQuery("#hook_ajax_container,#prk_footer_outer").addClass('prk_first_anim');
                jQuery('#prk_main_loader').addClass('prk_tweaked');
                jQuery('html').addClass('hook_ready');
            },75);
            setTimeout(function(){
                jQuery('#prk_main_loader').addClass('prk_hidden_loader');
            },255);
            setTimeout(function() {
                if (theme_options.active_visual_composer==="1") {
                    vc_waypoints();
                }
                Waypoint.refreshAll();
            },350);
            setTimeout(function(){
                jQuery('#hook_main_wrapper').removeClass('prk_fading_block');
                jQuery('#hook_main_wrapper').addClass(jQuery('#hook_main_wrapper').attr('data-trans'));
                if (jQuery('#hook_main_wrapper').hasClass('hk_trans_hzsl')) {
                    fadeout_timing=925;
                }
                if (jQuery('#hook_main_wrapper').hasClass('hk_trans_vtsl')) {
                    fadeout_timing=725;
                }
            },fadeout_timing);
            setTimeout(function() {
                smooth_scroll_now=true;
            },1000);
            //ENSURE THAT EVERYTHING IS PERFECTLY RENDERED
            setTimeout(function() {
                Waypoint.refreshAll();
            },2500);
        }
        //OWL SLIDERS
        if (jQuery('#dotted_navigation').length) {
            jQuery('body').addClass('hook_dotted_nav');
            jQuery('#dotted_navigation a').each(function() {
                jQuery(this).addClass('hook_anchor');
            });
            mn_collapsed=0;
        }
        var img_load=imagesLoaded('#not_slider');
        img_load.on('always', function() {
            jQuery('#not_slider').addClass('hook_active_slider');
        });
        jQuery('.hook_shortcode_slider.super_height.per_init').each(function() {
            var $this_id=jQuery(this).attr('id');
            var $this_slider=jQuery(this);
            if ($this_slider.find('.item').length===0) {
                $this_slider.removeClass('per_init');
                $this_slider.parent().addClass('hook_active_slider');
            }
            else {
                $this_slider.removeClass('per_init');
                $this_slider.addClass('just_init');
                jQuery(window).on("debouncedresize", function(event) {
                    setTimeout(function() {
                        $this_slider.find('.owl-wrapper-outer,.owl-item').css({'height':height_fix-hook_header_height});
                        var min_width=jQuery(window).width();
                        var min_height=height_fix-jQuery('#hook_header_area').height();
                        $this_slider.find('.owl-item img.hook_vsbl').each(function() {
                            var $this_image=jQuery(this);
                            var or_width=parseInt($this_image.attr('data-or_w'),10);
                            var or_height=parseInt($this_image.attr('data-or_h'),10);
                            var ratio=min_height / or_height;
                            //FILL HEIGHT
                            $this_image.css("height", min_height);
                            $this_image.css("width", or_width * ratio);
                            //UPDATE VARS
                            or_width=$this_image.width();
                            or_height=$this_image.height();
                            //FILL WIDTH IF NEEDED
                            if(or_width<min_width) {
                                ratio=min_width/or_width;
                                $this_image.css("width", min_width);
                                $this_image.css("height", or_height * ratio);
                            }
                            //ADJUST MARGINS
                            $this_image.css({"margin-left":-($this_image.width()-min_width)/2});
                            if (jQuery(window).width()<780) {
                                $this_image.css("margin-top",0);
                            }
                            else {
                                $this_image.css("margin-top",-($this_image.height()-$this_slider.find('.owl-wrapper-outer').height())/2);
                            }
                        });
                        $this_slider.find('.sld_v_center').each(function() {
                            jQuery(this).css({'margin-top':-parseInt(jQuery(this).height()/2,10)});
                        });
                    },50);
                });
                if ($this_slider.find('.item').length>1 && $this_slider.attr('data-autoplay')==="true") {
                    var autoplayer=$this_slider.attr('data-delay')
                }
                else {
                    var autoplayer=false;
                }
                $this_slider.fitVids().owlCarousel({
                    autoPlay:autoplayer,
                    navigation : $this_slider.attr('data-navigation')==="true" ? true : false,
                    navigationText: ['<i class="mdi-chevron-left site_background_colored"></i><div class="hook_naver site_background_colored prk_65_em"></div>','<i class="mdi-chevron-right site_background_colored"></i><div class="hook_naver site_background_colored prk_65_em"></div>'],
                    pagination:$this_slider.attr('data-pagination')==="true" ? true : false,
                    paginationNumbers:true,
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    lazyLoad : true,
                    items : 1,
                    itemsDesktop : false,
                    itemsDesktopSmall : false,
                    itemsTablet: false,
                    itemsMobile : false,
                    itemsScaleUp:true,
                    transitionStyle : is_mobile()===true ? "fade" : $this_slider.attr('data-anim'),
                    touchDrag:false,
                    addClassActive:true,
                    afterInit: function(){
                        var img_load=imagesLoaded($this_slider.find('#hook_slide_0'));
                        img_load.on('always', function() {
                            $this_slider.parent().addClass('hook_active_slider');
                            jQuery(window).trigger("debouncedresize");
                            setTimeout(function() {
                                singleLetters($this_slider.find('.cd-headline.letters').find('b'));
                                animateHeadline($this_slider.find('.cd-headline'));
                                setTimeout(function() {
                                    $this_slider.find('.sld_v_center').each(function() {
                                        jQuery(this).css({'margin-top':-parseInt(jQuery(this).height()/2,10)});
                                    });
                                },10);
                                //LOAD ALL OTHER IMAGES NOW
                                $this_slider.find('.lazy_hook').each(function() {
                                    jQuery(this).attr('src',jQuery(this).attr('data-src'));
                                    jQuery(this).css({'display':'block'});
                                });
                            },750);
                        });
                        $this_slider.find('.owl-pagination').css({'margin-top':-$this_slider.find('.owl-pagination').height()/2});
                        jQuery(window).trigger("debouncedresize");
                        var izer=0;
                        $this_slider.find('.owl-pagination').find('.owl-numbers').each(function() {
                            var slide_id='#hook_slide_'+izer;
                            jQuery(this).html($this_slider.find(slide_id).find('.headings_top>div').html());
                            izer++;
                        });
                    },
                    afterAction : function() {
                        $this_slider.find('.headings_top,.headings_body,.slider_action_button,.hook_at_slider').removeClass('hook_animate_slide');
                        $this_slider.find('.wpb_animate_when_almost_visible').removeClass('wpb_start_animation');
                        $this_slider.find('.wpb_animate_when_almost_visible').addClass('hook_manual_anim');
                        var slide_id='#hook_slide_'+this.owl.currentItem;
                        if ($this_slider.hasClass('just_init')) {
                            var in_count=800;
                            $this_slider.removeClass('just_init');
                        }
                        else {
                            var in_count=500;
                        }
                        $this_slider.find('.hook_naver').html(parseInt(this.owl.currentItem+1,10)+' / '+this.owl.owlItems.length);
                        setTimeout(function() {
                            if ($this_slider.find(slide_id).find('.slider_action_button a').attr('data-color')!=="default") {
                                $this_slider.find(slide_id).find('.slider_action_button a').css({'border-color':$this_slider.find(slide_id).find('.slider_action_button a').attr('data-color'),'color':$this_slider.find(slide_id).find('.slider_action_button a').attr('data-color')});
                            }
                            if ($this_slider.find(slide_id).find('.slider_scroll_button a').attr('data-color')!=="default") {
                                $this_slider.find(slide_id).find('.slider_scroll_button a').css({'border-color':$this_slider.find(slide_id).find('.slider_scroll_button a').attr('data-color'),'color':$this_slider.find(slide_id).find('.slider_scroll_button a').attr('data-color')});
                            }
                            $this_slider.find(slide_id).find('.headings_top').addClass('hook_animate_slide');
                            $this_slider.find(slide_id).find('.headings_body').addClass('hook_animate_slide');
                            $this_slider.find(slide_id).find('.slider_action_button').addClass('hook_animate_slide');
                            $this_slider.find(slide_id).find('.hook_at_slider').addClass('hook_animate_slide');
                            $this_slider.find(slide_id).find('.wpb_animate_when_almost_visible').each(function() {
                                var $this_el=jQuery(this);
                                if (!$this_el.is('[class*="delay-"]')) {
                                    $this_el.addClass('wpb_start_animation');
                                }
                                else {
                                    var classes=$this_el.attr("class").split(" ");
                                    var delayer=0;
                                    for (var i=0; i < classes.length; i++) {
                                        if ( classes[i].substr(0,6)==="delay-" ) {
                                            delayer=classes[i].substr(6,classes[i].length);
                                            break;
                                        }
                                    }
                                    setTimeout(function() {
                                        $this_el.addClass('wpb_start_animation');
                                    },parseInt(delayer,10)+100);
                                }
                            });
                        },in_count);
                    },
                });
            }
        });
        jQuery('.hook_shortcode_slider.per_init').not(jQuery('.hook_shortcode_slider.super_height')).each(function() {
            var $this_slider=jQuery(this);
            if ($this_slider.find('.item').length===0) {
                $this_slider.removeClass('per_init');
                $this_slider.parent().addClass('hook_active_slider');
            }
            else {
                if ($this_slider.find('.item').length>1 && $this_slider.attr('data-autoplay')==="true") {
                    var autoplayer=$this_slider.attr('data-delay')
                }
                else {
                    var autoplayer=false;
                }
                //REMOVE FITVIDS IF NEEDED
                //GET TRANSITION STYLE - LEGACY KEEP
                var hook_trans='fade';
                if ($this_slider.attr('data-anim')!==undefined && !is_mobile()) {
                    hook_trans=$this_slider.attr('data-anim');
                }
                $this_slider.fitVids().owlCarousel({
                    autoPlay:autoplayer,
                    navigation : $this_slider.attr('data-navigation')==="true" ? true : false,
                    navigationText: ['<i class="mdi-chevron-left site_background_colored"></i><div class="hook_naver site_background_colored prk_65_em"></div>','<i class="mdi-chevron-right site_background_colored"></i><div class="hook_naver site_background_colored prk_65_em"></div>'],
                    pagination:$this_slider.attr('data-pagination')==="true" ? true : false,
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    lazyLoad : true,
                    items : 1,
                    itemsDesktop : false,
                    itemsDesktopSmall : false,
                    itemsTablet: false,
                    itemsMobile : false,
                    itemsScaleUp:true,
                    transitionStyle : hook_trans,
                    autoHeight : true,
                    touchDrag:false,
                    addClassActive:true,
                    afterInit: function() {
                        var img_load=imagesLoaded($this_slider.find('#hook_slide_0'));
                        img_load.on('always', function() {
                            $this_slider.parent().addClass('hook_active_slider');
                            jQuery(window).trigger("debouncedresize");
                        });
                        $this_slider.removeClass('per_init');
                        $this_slider.addClass('just_init');
                        setTimeout(function() {
                            singleLetters($this_slider.find('.cd-headline.letters').find('b'));
                            animateHeadline($this_slider.find('.cd-headline'));
                            setTimeout(function() {
                                $this_slider.find('.sld_v_center').each(function() {
                                    jQuery(this).css({'margin-top':-parseInt(jQuery(this).height()/2,10)});
                                });
                            },10);
                            //LOAD ALL OTHER IMAGES NOW
                            $this_slider.find('.lazy_hook').each(function() {
                                jQuery(this).attr('src',jQuery(this).attr('data-src'));
                                jQuery(this).css({'display':'block'});
                            });
                        },750);
                        if($this_slider.hasClass('hook_thumbs')) {
                            var i=0;
                            $this_slider.find('.owl-pagination').find('.owl-page').each(function() {
                                i++;
                                if ($this_slider.find('.owl-item:nth-child('+parseInt(i,10)+') img').attr('data-thumb')!==undefined) {
                                    jQuery(this).find('span').css({'background':'url('+$this_slider.find('.owl-item:nth-child('+parseInt(i,10)+') img').attr('data-thumb')+')'});
                                }
                                else {
                                    jQuery(this).find('span').addClass('hook_vd_thumb mdi-play prk_bordered');
                                }
                            });
                        }
                        else {
                            $this_slider.find('.owl-pagination').css({'margin-top':-$this_slider.find('.owl-pagination').height()/2});
                        }
                        if ($this_slider.attr('data-color')!=undefined && $this_slider.attr('data-color')!="") {
                            $this_slider.find('.owl-next,.owl-prev').attr('data-color',$this_slider.attr('data-color'));
                        }
                        setTimeout(function() {
                            $this_slider.parent().removeClass('prk_first_anim');
                            jQuery(window).trigger("smartresize");
                        },1000);
                        jQuery(window).trigger("debouncedresize");
                    },
                    afterAction : function() {
                        $this_slider.find('.headings_top,.headings_body,.slider_action_button,.hook_at_slider').removeClass('hook_animate_slide');
                        var slide_id='#hook_slide_'+this.owl.currentItem;
                        if ($this_slider.hasClass('just_init')) {
                            var in_count=750;
                            $this_slider.removeClass('just_init');
                        }
                        else {
                            var in_count=0;
                        }
                        if($this_slider.hasClass('hook_thumbs')) {
                            var i=0;
                            $this_slider.find('.owl-pagination').find('.owl-page').each(function() {
                                i++;
                                if ($this_slider.find('.owl-item:nth-child('+parseInt(i,10)+') img').attr('data-thumb')!==undefined) {
                                    jQuery(this).find('span').css({'background':'url('+$this_slider.find('.owl-item:nth-child('+parseInt(i,10)+') img').attr('data-thumb')+')'});
                                }
                                else {
                                    jQuery(this).find('span').addClass('hook_vd_thumb mdi-play prk_bordered');
                                }
                            });
                        }
                        setTimeout(function() {
                            $this_slider.find(slide_id).find('.headings_top').addClass('hook_animate_slide');
                            $this_slider.find(slide_id).find('.headings_body').addClass('hook_animate_slide');
                            $this_slider.find(slide_id).find('.slider_action_button').addClass('hook_animate_slide');
                            $this_slider.find(slide_id).find('.hook_at_slider').addClass('hook_animate_slide');
                        },in_count);
                        $this_slider.find('.hook_naver').html(parseInt(this.owl.currentItem+1,10)+' / '+this.owl.owlItems.length);
                    }
                });
            }
        });
        jQuery('.pnz-1 .folio_iframe').each(function() {
            var $par_video=jQuery(this).find('iframe');
            jQuery(window).on("debouncedresize", function(event) {
                $par_video.css({'width':'','height':''});
                var cin_ratio=$par_video.attr('width')/$par_video.attr('height');
                $par_video.css({'width':jQuery(this).width()});
                $par_video.css({'height':parseInt(jQuery(this).width()/cin_ratio,10)});
                if (parseInt(jQuery(this).width()/cin_ratio,10)<jQuery(this).height()) {
                    $par_video.css({'height':jQuery(this).height()});
                    $par_video.css({'width':jQuery(this).height()*cin_ratio});
                }
            });
        });
        jQuery('.portfolio_entry_li .folio_iframe').not('.pnz-1 .portfolio_entry_li .folio_iframe').each(function() {
            var $par_video=jQuery(this).find('iframe');
            var $par_video_wrapper=jQuery(this).closest('.portfolio_entry_li');
            jQuery(window).on("debouncedresize", function(event) {
                setTimeout(function() {
                    $par_video.css({'width':'','height':''});
                    var cin_ratio=$par_video.attr('width')/$par_video.attr('height');
                    $par_video.css({'width':$par_video_wrapper.width()});
                    $par_video.css({'height':parseInt($par_video_wrapper.width()/cin_ratio,10)});
                    if (parseInt($par_video_wrapper.width()/cin_ratio,10)<$par_video_wrapper.height()) {
                        $par_video.css({'height':$par_video_wrapper.height()});
                        $par_video.css({'width':$par_video_wrapper.height()*cin_ratio});
                    }
                },150);
            });
        });
        jQuery('.folio_panels.per_init').each(function() {
            var $this_id=jQuery(this).attr('id');
            var $this_slider=jQuery(this);
            var $this_slider_wrapper=$this_slider.closest('.recentfolio_ul_wp');
            $this_slider.removeClass('per_init');
            $this_slider.addClass('just_init');
            jQuery('#portfolio_single_page').addClass('prk_paneled');
            jQuery(window).on("debouncedresize", function(event) {
                setTimeout(function() {
                    $this_slider.find('.owl-wrapper-outer,.owl-item').css({'height':height_fix-hook_header_height});
                    var min_width=jQuery(window).width();
                    var min_height=height_fix-hook_header_height;
                    $this_slider.find('.owl-item img.hook_vsbl').each(function() {
                        var $this_image=jQuery(this);
                        var or_width=parseInt($this_image.attr('data-or_w'),10);
                        var or_height=parseInt($this_image.attr('data-or_h'),10);
                        var ratio=min_height / or_height;
                        //FILL HEIGHT
                        $this_image.css("height", min_height);
                        $this_image.css("width", or_width * ratio);
                        //UPDATE VARS
                        or_width=$this_image.width();
                        or_height=$this_image.height();
                        //FILL WIDTH IF NEEDED
                        if(or_width<min_width) {
                            ratio=min_width/or_width;
                            $this_image.css("width", min_width);
                            $this_image.css("height", or_height * ratio);
                        }
                        //ADJUST MARGINS
                        $this_image.css({"margin-left":-($this_image.width()-min_width)/2});
                        if (jQuery(window).width()<780) {
                            $this_image.css("margin-top",0);
                        }
                        else {
                            $this_image.css("margin-top",-($this_image.height()-$this_slider.find('.owl-wrapper-outer').height())/2);
                        }
                    });
                    $this_slider.find('.sld_v_center').each(function() {
                        jQuery(this).css({'margin-top':-parseInt(jQuery(this).height()/2,10)});
                    });
                },50);
            });
            if ($this_slider.find('.item').length>1 && $this_slider.attr('data-autoplay')==="true") {
                var autoplayer=$this_slider.attr('data-delay');
            }
            else {
                if($this_slider.hasClass('layout-featured') && $this_slider.find('.portfolio_entry_li').length>1 && $this_slider.attr('data-autoplay')==="1") {
                    var autoplayer=$this_slider.attr('data-delay');
                }
                else {
                    var autoplayer=false;
                }
            }
            var hook_items=$this_slider.attr('data-columns') !== undefined ? $this_slider.attr('data-columns') : "4";
            if (hook_items==="1") {
                var hook_per_page=false;
            }
            else {
                var hook_per_page=true;
            }
            $this_slider.fitVids().owlCarousel({
                autoPlay:autoplayer,
                navigation : true,
                navigationText: ['<i class="mdi-chevron-left site_background_colored"></i><div class="hook_naver site_background_colored prk_65_em"></div>','<i class="mdi-chevron-right site_background_colored"></i><div class="hook_naver site_background_colored prk_65_em"></div>'],
                pagination: true,
                paginationNumbers:true,
                slideSpeed : 300,
                paginationSpeed : 400,
                lazyLoad : true,
                itemsCustom : [
                    [0, 1],
                    [860, parseInt(hook_items,10)],
                ],
                itemsScaleUp: true,
                scrollPerPage: hook_per_page,
                transitionStyle : "fade",
                touchDrag:false,
                addClassActive:true,
                afterInit: function() {
                    var img_load=imagesLoaded($this_slider.find('#hook_slide_0'));
                    img_load.on('always', function() {
                        $this_slider.parent().addClass('hook_active_slider');
                        jQuery(window).trigger("debouncedresize");
                        setTimeout(function() {
                            singleLetters($this_slider.find('.cd-headline.letters').find('b'));
                            animateHeadline($this_slider.find('.cd-headline'));
                            setTimeout(function() {
                                $this_slider.find('.sld_v_center').each(function() {
                                    jQuery(this).css({'margin-top':-parseInt(jQuery(this).height()/2,10)});
                                });
                            },10);
                            //LOAD ALL OTHER IMAGES NOW
                            $this_slider.find('.lazy_hook').each(function() {
                                jQuery(this).attr('src',jQuery(this).attr('data-src'));
                                jQuery(this).css({'display':'block'});
                            });
                        },750);
                        //FIRST PANEL HAS VIDEO?
                        if ($this_slider_wrapper.find('.hook_panels_bk.hook_autoplay .hook_panel_bk.hook_active').find('.hook_video-bg').length) {
                            jQuery(window).trigger("debouncedresize");
                            var $par_video=$this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg');
                            var $new_pos=1;
                            var playPromise = $par_video.get(0).play();
                            if (playPromise !== undefined) {
                                playPromise.then(function() {
                                    $par_video.get(0).play();
                                }).catch(function(error) {
                                    //Show a UI element to let the user manually start playback.
                                    //console.log("NOT OK");
                                    $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').prepend('<div class="prk_play_promise"><svg class="video-overlay-play-button" viewBox="0 0 200 200" alt="Play video"><circle cx="100" cy="100" r="90" fill="none" stroke-width="15" stroke="#fff"/><polygon points="70, 55 70, 145 145, 100" fill="#fff"/></svg></div>');
                                    $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').addClass('forced_promise');
                                    $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+')').find('.prk_play_promise').on('click', function(event) {
                                        $par_video.get(0).play();
                                        $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').removeClass('forced_promise');
                                        $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').find('.prk_play_promise').addClass('prk_play_hide');
                                    });
                                });
                            }
                        }
                        //FORCE VIDEO RESIZE IF AUTOPLAY IS OFF
                        if (!$this_slider_wrapper.find('.forced_promise').length) {
                            $this_slider_wrapper.find('.hook_panels_bk').find('.hook_video-bg').each(function() {
                                var $par_video=jQuery(this);
                                $par_video.on("play", function () {
                                    $par_video.parent().addClass('hook_ready_vd');
                                    $par_video.css({'width':''});
                                    $par_video.css({'height':''});
                                    $par_video.css({'width':$par_video.parent().parent().width()});
                                    if ($par_video.height()<$par_video.parent().parent().outerHeight()) {
                                        $par_video.css({'width':''});
                                        $par_video.css({'height':$par_video.parent().parent().outerHeight()});
                                    }
                                });
                            });
                        }
                    });
                    $this_slider.find('.owl-pagination').css({'margin-top':-$this_slider.find('.owl-pagination').height()/2});
                    jQuery(window).trigger("debouncedresize");
                    var izer=0;
                    $this_slider.find('.owl-pagination').find('.owl-numbers').each(function() {
                        var slide_id='#hook_slide_'+izer;
                        jQuery(this).html($this_slider.find(slide_id).find('.headings_top>div').html());
                        izer++;
                    });
                    if ($this_slider.attr('data-panels')=="hook_def_panel") {
                        var $feates=0;
                        $this_slider.find('.grid_image_wrapper').each(function() {
                            var $this_panel=jQuery(this).find('.hook_image_parent').html();
                            if (jQuery(this).find('.hook_video-wp').length) {
                                $this_slider_wrapper.find('.hook_panels_bk').append('<div class="hook_panel_bk hook_panel_vd">'+$this_panel+jQuery(this).find('.hook_video-wp').html()+'</div>');
                            }
                            else {
                                $this_slider_wrapper.find('.hook_panels_bk').append('<div class="hook_panel_bk">'+$this_panel+'</div>');
                            }
                            if ($feates<9) {
                                if ($this_slider_wrapper.hasClass('special_numbers') && jQuery(this).find('.hook_thumb_tag').html()!==undefined) {
                                    $this_slider_wrapper.find('#hook_featured_nav').append('<div id="hfl-' + $feates + '" class="hook_featured_line" data-pos="' + $feates + '"><div class="prk_9_em prk_heavier_600">' + jQuery(this).find('.hook_thumb_tag').html() + '</div><div class="hk_inline"></div></div>');
                                }
                                else {
                                    $this_slider_wrapper.find('#hook_featured_nav').append('<div id="hfl-' + $feates + '" class="hook_featured_line" data-pos="' + $feates + '"><div class="prk_9_em prk_heavier_600">0' + parseInt($feates + 1, 10) + '</div><div class="hk_inline"></div></div>');
                                }
                            }
                            else {
                                $this_slider_wrapper.find('#hook_featured_nav').append('<div id="hfl-'+$feates+'" class="hook_featured_line" data-pos="'+$feates+'"><div class="prk_9_em prk_heavier_600">'+parseInt($feates+1,10)+'</div><div class="hk_inline"></div></div>');
                            }
                            jQuery(this).find('.hook_video-wp').remove();
                            $feates++;
                        });
                        jQuery('#hfl-0').addClass('active');
                        if(jQuery('.folio_panels.layout-featured.hook_colored').length) {
                            if (jQuery('.owl-item.active .portfolio_entry_li.featured_color').length) {
                                var faster_color=jQuery('.owl-item.active .portfolio_entry_li.featured_color').attr('data-color');
                                $this_slider_wrapper.find('#hook_featured_nav .hook_featured_line').css({'color':faster_color});
                                jQuery('.folio_panels.layout-featured.hook_colored').closest('.plus_arrow').find('.hook_next_arrow').css({'color':faster_color});
                                $this_slider_wrapper.find('#hook_featured_nav .hk_inline').css({'background-color':faster_color});
                            }
                            else {
                                $this_slider_wrapper.find('#hook_featured_nav .hook_featured_line').css({'color':''});
                                jQuery('.folio_panels.layout-featured.hook_colored').closest('.plus_arrow').find('.hook_next_arrow').css({'color':''});
                                $this_slider_wrapper.find('#hook_featured_nav .hk_inline').css({'background-color':''});
                            }
                        }
                        $this_slider_wrapper.find('#hook_featured_nav .hook_featured_line').on({
                            click:function() {
                                jQuery('.hook_featured_line').removeClass('active');
                                jQuery(this).addClass('active');
                                $this_slider.trigger('owl.goTo',parseInt(jQuery(this).attr('data-pos'),10));
                            },
                        });
                        $this_slider.parent().find('.hook_panels_bk .hook_panel_bk:nth-child(1)').addClass('hook_active');
                        if (parseInt(hook_items,10)>1) {
                            $this_slider.find('.portfolio_entry_li').on({
                                mouseenter:function() {
                                    var $new_pos=parseInt(jQuery(this).attr("data-pos"),10)+1;
                                    if($this_slider.parent().find('.hook_panels_bk .hook_panel_bk:nth-child('+parseInt($new_pos,10)+')').hasClass('hook_active')===false) {
                                        if ($this_slider_wrapper.find('.hook_panels_bk.hook_autoplay .hook_panel_bk.hook_active').find('.hook_video-bg').length) {
                                            $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg').get(0).pause();
                                        }
                                        $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk').removeClass('hook_active');
                                        $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk:nth-child('+parseInt($new_pos,10)+')').addClass('hook_active');
                                        jQuery(window).trigger("debouncedresize");
                                        if ($this_slider_wrapper.find('.hook_panels_bk.hook_autoplay .hook_panel_bk.hook_active').find('.hook_video-bg').length) {
                                            if (!$this_slider_wrapper.find('.hook_panels_bk').hasClass('hook_resume')) {
                                                $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg').get(0).currentTime=0;
                                            }
                                            var $par_video=$this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg');
                                            var playPromise = $par_video.get(0).play();
                                            if (playPromise !== undefined) {
                                                playPromise.then(function() {
                                                    $par_video.get(0).play();
                                                }).catch(function(error) {
                                                    //Show a UI element to let the user manually start playback.
                                                    //console.log("NOT OK");
                                                    if (!$this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li .prk_play_promise').length) {
                                                        $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').prepend('<div class="prk_play_promise"><svg class="video-overlay-play-button" viewBox="0 0 200 200" alt="Play video"><circle cx="100" cy="100" r="90" fill="none" stroke-width="15" stroke="#fff"/><polygon points="70, 55 70, 145 145, 100" fill="#fff"/></svg></div>');
                                                        $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+')').find('.prk_play_promise').on('click', function(event) {
                                                            $par_video.get(0).play();
                                                            $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').removeClass('forced_promise');
                                                            $this_slider_wrapper.find('.owl-wrapper .owl-item:nth-child('+parseInt($new_pos,10)+') .portfolio_entry_li').find('.prk_play_promise').addClass('prk_play_hide');
                                                        });
                                                    }
                                                });
                                            }
                                        }
                                    }
                                },
                                mouseleave:function() {

                                }
                            });
                        }
                    }
                    else {
                        //MULTI IMAGES LAYOUT
                        $this_slider.find('.grid_image_wrapper').each(function() {
                            var $this_panel=jQuery(this).find('.hook_image_parent img').attr('src');
                            jQuery(this).closest('.portfolio_entry_li').css({'background-image':'url('+$this_panel+')'});
                            if ($this_slider_wrapper.hasClass('hook_autoplay')) {
                                if (jQuery(this).closest('.portfolio_entry_li').find('.hook_video-bg').length) {
                                    var $par_video=jQuery(this).closest('.portfolio_entry_li').find('.hook_video-bg');
                                    $par_video.get(0).play();
                                    setTimeout(function() {
                                        $par_video.get(0).pause();
                                    },30);
                                    //VIDEO ON CACHE BUG FIX
                                    if ($par_video.get(0).readyState) {
                                        $par_video.get(0).volume=0;
                                        $par_video.get(0).play();
                                        setTimeout(function() {
                                            $par_video.get(0).pause();
                                            $par_video.get(0).volume=1;
                                        },30);
                                    }
                                }
                            }
                            else {
                                if (jQuery(this).closest('.portfolio_entry_li').find('.hook_video-bg').length) {
                                    jQuery(this).closest('.portfolio_entry_li').find('.hook_video-bg').get(0).play();
                                }
                            }
                        });
                    }
                    if (hook_on_mobile && false) {//DEPRECATED
                        $this_slider_wrapper.find('.hook_panels_bk').find('.hook_video-bg').remove();
                    }
                    else {
                        //MUTE BUTTON
                        var $volume_btn=$this_slider_wrapper.find('#hook_panels_vol');
                        $volume_btn.on('click', function(event) {
                            $volume_btn.toggleClass('hook_muted');
                            if ($volume_btn.hasClass('hook_muted')) {
                                $this_slider_wrapper.find('.hook_panels_bk .hook_video-bg').each(function() {
                                    var $par_video=jQuery(this);
                                    $par_video.get(0).volume=0;
                                });
                            }
                            else {
                                $this_slider_wrapper.find('.hook_panels_bk .hook_video-bg').each(function() {
                                    var $par_video=jQuery(this);
                                    $par_video.get(0).volume=1;
                                });
                            }
                        });
                        if($volume_btn.attr('data-default')==='sound_off') {
                            $volume_btn.trigger('click')
                        }
                    }
                },
                afterAction : function() {
                    if ($this_slider_wrapper.find('.hook_panels_bk.hook_autoplay .hook_panel_bk.hook_active').find('.hook_video-bg').length) {
                        $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg').get(0).pause();
                    }
                    $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk').removeClass('hook_active');
                    this.$owlItems.removeClass('hook_noborder');
                    var $new_pos=parseInt(this.owl.currentItem,10)+1;
                    $this_slider_wrapper.find('#hook_featured_nav .hook_featured_line').removeClass('active');
                    $this_slider_wrapper.find('#hook_featured_nav>div:nth-child('+parseInt($new_pos,10)+')').addClass('active');
                    $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk:nth-child('+parseInt($new_pos,10)+')').addClass('hook_active');
                    this.$owlItems.eq(parseInt(this.owl.currentItem,10)+parseInt(hook_items,10)-1).addClass('hook_noborder');
                    if ($this_slider.hasClass('just_init')) {
                        var in_count=800;
                        $this_slider.removeClass('just_init');
                    }
                    else {
                        var in_count=500;
                    }
                    $this_slider.find('.hook_naver').html(jQuery('.owl-page.active .owl-numbers').html()+' / '+$this_slider.find('.owl-pagination .owl-page').length);
                    if (parseInt(hook_items,10)===1) {
                        if ($this_slider_wrapper.find('.hook_panels_bk.hook_autoplay .hook_panel_bk.hook_active').find('.hook_video-bg').length) {
                            if (!$this_slider_wrapper.find('.hook_panels_bk').hasClass('hook_resume')) {
                                $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg').get(0).currentTime=0;
                            }
                            $this_slider_wrapper.find('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg').get(0).play();
                        }
                    }
                    if($this_slider_wrapper.find('.folio_panels.layout-featured.hook_colored').length) {
                        if ($this_slider_wrapper.find('.owl-item.active .portfolio_entry_li.featured_color').length) {
                            var faster_color=$this_slider_wrapper.find('.owl-item.active .portfolio_entry_li.featured_color').attr('data-color');
                            $this_slider_wrapper.find('#hook_featured_nav .hook_featured_line').css({'color':faster_color});
                            $this_slider_wrapper.find('#hook_featured_nav .hk_inline').css({'background-color':faster_color});
                            $this_slider_wrapper.closest('.plus_arrow').find('.hook_next_arrow').css({'color':faster_color});
                        }
                        else {
                            $this_slider_wrapper.find('#hook_featured_nav .hook_featured_line').css({'color':''});
                            $this_slider_wrapper.closest('.plus_arrow').find('.hook_next_arrow').css({'color':''});
                            $this_slider_wrapper.find('#hook_featured_nav .hk_inline').css({'background-color':''});
                        }
                    }
                },
            });
        });
        jQuery('.testimonials_slider.per_init,.comments_slider.per_init,.featured_posts_ul_slider.per_init,.hook_insta_slider .hook_instagram').each(function() {
            var $this_slider=jQuery(this);
            $this_slider.removeClass('per_init');
            if ($this_slider.find('.item').length>1 && $this_slider.attr('data-autoplay')==="true") {
                var autoplayer=$this_slider.attr('data-delay');
            }
            else {
                var autoplayer=false;
            }
//TODO WHEN AUTOHEIGHT OPTION IS AVAILABLE
            var automatic_height=false;
            if ($this_slider.attr('data-height')==="variable") {
                automatic_height=true;
            }
            var img_load=imagesLoaded($this_slider);
            img_load.on('always', function() {
                setTimeout(function() {
                    $this_slider.owlCarousel({
                        autoPlay:autoplayer,
                        navigation:$this_slider.attr('data-navigation')==="true" ? true : false,
                        navigationText: ['<i class="mdi-chevron-left"></i>','<i class="mdi-chevron-right"></i>'],
                        pagination:$this_slider.attr('data-pagination')==="true" ? true : false,
                        slideSpeed : 300,
                        paginationSpeed : 400,
                        items : 1,
                        itemsDesktop : false,
                        itemsDesktopSmall : false,
                        itemsTablet: false,
                        itemsMobile : false,
                        itemsScaleUp:true,
                        transitionStyle : is_mobile()===true ? "fade" : $this_slider.attr('data-anim'),
                        autoHeight : automatic_height,
                        touchDrag:false,
                        addClassActive:true,
                        afterInit: function() {
                            setTimeout(function() {
                                $this_slider.parent().removeClass('prk_first_anim');
                            },1000);
                            create_thumbs($this_slider);
                        },
                        afterUpdate: function() {
                            create_thumbs($this_slider);
                        }
                    });
                },25);
            });
        });
        jQuery('.recentposts_ul_slider.per_init,.member_ul_slider.per_init').each(function() {
            var $this_slider=jQuery(this);
            $this_slider.removeClass('per_init');
            $this_slider.owlCarousel({
                navigation : $this_slider.attr('data-navigation')==="true" ? true : false,
                navigationText: ['<i class="mdi-chevron-left"></i>','<i class="mdi-chevron-right"></i>'],
                pagination:false,
                touchDrag:false,
                itemsCustom : [
                    [0, 1],
                    [450, 2],
                    [920, 3],
                    [1080, 4],
                    [1460, 5],
                ],
            });
        });
        jQuery('.hook_carousel.per_init').each(function() {
            var $this_slider=jQuery(this);
            $this_slider.removeClass('per_init');
            $this_slider.owlCarousel({
                navigation : $this_slider.attr('data-navigation')==="true" ? true : false,
                navigationText: ['<i class="mdi-chevron-left"></i>','<i class="mdi-chevron-right"></i>'],
                pagination:false,
                touchDrag:false,
                autoPlay:'2800',
                itemsScaleUp:true,
                stopOnHover:true,
                itemsCustom : [
                    [0, 2],
                    [450, 3],
                    [920, 4],
                    [1080, 5],
                    [1460, 6],
                ],
            });
        });
        jQuery('.twitter_slider.per_init').each(function() {
            var $this_slider=jQuery(this);
            $this_slider.removeClass('per_init');
            $this_slider.owlCarousel({
                autoPlay:6000,
                navigation : true,
                navigationText: ['<i class="mdi-chevron-left"></i>','<i class="mdi-chevron-right"></i>'],
                pagination: false,
                slideSpeed : 300,
                paginationSpeed : 400,
                items : 1,
                itemsDesktop : false,
                itemsDesktopSmall : false,
                itemsTablet: false,
                itemsMobile : false,
                itemsScaleUp:true,
                transitionStyle : 'fade',
                autoHeight : false,
                touchDrag:false,
                addClassActive:true,
                afterInit: function() {
                },
            });
        });
        jQuery('.products_ul_slider').each(function() {
            var $this_slider=jQuery(this);
            $this_slider.removeClass('per_init');
            $this_slider.owlCarousel({
                navigation : $this_slider.attr('data-navigation')==="true" ? true : false,
                navigationText: ['<i class="mdi-chevron-left"></i>','<i class="mdi-chevron-right"></i>'],
                pagination:false,
                touchDrag:$this_slider.attr('data-touch')==="true" ? true : false,
                itemsCustom : [
                    [0, 1],
                    [400, 2],
                    [660, 3],
                    [920, 4],
                ],
            });
        });
        //OWL SLIDERS - END

        //COMING SOON PAGE
        jQuery('.hook_countdown.per_init').each(function() {
            var $countas=jQuery(this);
            $countas.removeClass('per_init');
            var custom_date = new Date();
            custom_date = new Date($countas.attr('data-year'), parseInt($countas.attr('data-month'),10)-1, $countas.attr('data-day'));
            $countas.countdown({
                /*labels: ['AnnÃ©es','Mois','Semaines','Jours','Heures','Minutes','Secondes'],
        labels1: ['AnnÃ©e','Mois','Semaine','Jour','Heure','Minute','Seconde'],
        compactLabels: ['a','m','s','j'],
        whichLabels: function(amount) {
                return (amount > 1 ? 0 : 1);
            },
        digits: ['0','1','2','3','4','5','6','7','8','9'],
        timeSeparator: ':',
        isRTL: false,*/
                until: custom_date
            });
        });

        //MAILCHIMP, CONTACT FORM 7 && PROTECTED PAGES
        jQuery('#prk_protected input,.mc_input,.wpcf7-form select,.wpcf7-form input[type="date"],.wpcf7-form input[type="password"],.wpcf7-form input[type="tel"],.wpcf7-form input[type="email"],.wpcf7-form input[type="text"],.wpcf7-form textarea').not('.wpcf7-submit').addClass('pirenko_highlighted');
        jQuery('.wpcf7-form select,.wpcf7-form input[type="date"],.wpcf7-form input[type="password"]').not('.wpcf7-submit').addClass('hook_plain');
        jQuery ('.wpcf7-form select').parent().append('<i class="hook_select_arrow hook_fa-angle-double-down"></i>');
        jQuery('.wpcf7-submit').parent().addClass('theme_button');

        //POPUPS
        jQuery('.recentfolio_ul_wp>.lightboxed,.hook_widget_gallery,.hook_mag_img,.hook_vertical_folio.lightboxed').not('.recentfolio_ul_wp.multipled>.lightboxed,.hook_vertical_folio.multipled.lightboxed').magnificPopup({
            delegate: '.portfolio_entry_li:not(.hook_inactive) a.magnificent',
            src:'data-src',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            fixedContentPos: false,
            fixedBgPos: true,
            closeOnContentClick: true,
            closeBtnInside: false,
            mainClass: 'mfp-no-margins my-mfp-zoom-in header_font',
            removalDelay: 300,
            closeMarkup:'<button title="%title%" class="mfp-close"><div class="mfp-close_inner"></div></button><div id="mfp-hook-nav" class="header_font"></div><div id="mfp-hook-title" class="header_font"></div>',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% mdi-chevron-%dir%"></button>',
                preload: [0,1],
                tCounter: '%curr% '+theme_options.lightbox_text+' %total%',
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title');
                }
            },
            iframe: {
                markup:
                    '<div class="mfp-iframe-scaler">'+
                    '<div class="mfp-close"></div>'+
                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                    '<figcaption><div class="mfp-bottom-bar"><div class="mfp-title">Text</div><div class="mfp-counter">Number</div></div></figcaption>'+
                    '</div>'
            },
            callbacks: {
                open: function() {
                    jQuery('html').css({'overflow':'hidden','height':'100%'});
                    if (!jQuery('html').hasClass('hook_safari')) {
                        jQuery('body').css({'overflow': 'hidden'});
                    }
                    jQuery.magnificPopup.instance.next=function() {
                        var self=this;
                        self.wrap.addClass('mfp-hook-transition');
                        setTimeout(function() { jQuery.magnificPopup.proto.next.call(self); }, 200);
                    }
                    jQuery.magnificPopup.instance.prev=function() {
                        var self=this;
                        self.wrap.addClass('mfp-hook-transition');
                        setTimeout(function() { jQuery.magnificPopup.proto.prev.call(self); }, 200);
                    }
                },
                close: function() {
                    jQuery('html').css({'overflow-y':'visible','height':''});
                    jQuery('body').css('overflow', '');
                },
                markupParse: function(template, values, item) {
                    values.title=item.el.attr('data-title');
                    setTimeout(function() {
                        jQuery('.mfp-wrap').removeClass('mfp-hook-transition');
                        jQuery('#mfp-hook-nav').html(jQuery('.mfp-counter').html());
                        if (jQuery('.recentfolio_ul_wp').hasClass('out_thumbs') && item.el.attr('data-ext')=="true") {
                            if (jQuery('.recentfolio_ul_wp').hasClass('in_english')) {
                                jQuery('#mfp-hook-title').html(jQuery('.mfp-title').html()+' - <a href="'+item.el.attr('href')+'" class="body_colored" target="_blank">Open Website &rarr;</a>');
                            }
                            else {
                                jQuery('#mfp-hook-title').html(jQuery('.mfp-title').html()+' - <a href="'+item.el.attr('href')+'" class="body_colored" target="_blank">'+theme_options.launch_text+'</a>');
                            }
                        }
                        else {
                            jQuery('#mfp-hook-title').html(jQuery('.mfp-title').html());
                        }
                    },15);
                }
            }
        });
        jQuery('.recentfolio_ul_wp.multipled>.lightboxed .portfolio_entry_li,.hook_vertical_folio.multipled.lightboxed .wpb_row').each(function() {
            jQuery(this).magnificPopup({
                delegate: '.magnificent',
                src:'data-src',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                fixedContentPos: false,
                fixedBgPos: true,
                closeOnContentClick: true,
                closeBtnInside: false,
                mainClass: 'mfp-no-margins my-mfp-zoom-in header_font',
                removalDelay: 300,
                closeMarkup:'<button title="%title%" class="mfp-close"><div class="mfp-close_inner"></div></button><div id="mfp-hook-nav" class="header_font"></div><div id="mfp-hook-title" class="header_font"></div>',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% mdi-chevron-%dir%"></button>',
                    preload: [0,1],
                    tCounter: '%curr% '+theme_options.lightbox_text+' %total%',
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title');
                    }
                },
                iframe: {
                    markup:
                        '<div class="mfp-iframe-scaler">'+
                        '<div class="mfp-close"></div>'+
                        '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                        '<figcaption><div class="mfp-bottom-bar"><div class="mfp-title">Text</div><div class="mfp-counter">Number</div></div></figcaption>'+
                        '</div>'
                },
                callbacks: {
                    open: function() {
                        jQuery('html').css({'overflow':'hidden','height':'100%'});
                        if (!jQuery('html').hasClass('hook_safari')) {
                            jQuery('body').css({'overflow': 'hidden'});
                        }
                        jQuery.magnificPopup.instance.next=function() {
                            var self=this;
                            self.wrap.addClass('mfp-hook-transition');
                            setTimeout(function() { jQuery.magnificPopup.proto.next.call(self); }, 200);
                        }
                        jQuery.magnificPopup.instance.prev=function() {
                            var self=this;
                            self.wrap.addClass('mfp-hook-transition');
                            setTimeout(function() { jQuery.magnificPopup.proto.prev.call(self); }, 200);
                        }
                    },
                    close: function() {
                        jQuery('html').css({'overflow-y':'visible','height':''});
                    },
                    markupParse: function(template, values, item) {
                        values.title=item.el.attr('data-title');
                        setTimeout(function() {
                            jQuery('.mfp-wrap').removeClass('mfp-hook-transition');
                            jQuery('#mfp-hook-nav').html(jQuery('.mfp-counter').html());
                            jQuery('#mfp-hook-title').html(jQuery('.mfp-title').html());
                        },15);
                    }
                }
            });
        });

        jQuery('.hook_gallery').each(function(){
            if (!jQuery(this).hasClass('hook_gallery_nothing')) {
                jQuery(this).magnificPopup({
                    delegate: 'div.portfolio_entry_li.lighted',
                    src: 'data-src',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    fixedContentPos: false,
                    fixedBgPos: true,
                    closeOnContentClick: true,
                    closeBtnInside: false,
                    mainClass: 'mfp-no-margins my-mfp-zoom-in header_font',
                    removalDelay: 300,
                    closeMarkup: '<button title="%title%" class="mfp-close"><div class="mfp-close_inner"></div></button><div id="mfp-hook-nav" class="header_font"></div><div id="mfp-hook-title" class="header_font"></div>',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% mdi-chevron-%dir%"></button>',
                        preload: [0, 1],
                        tCounter: '%curr% ' + theme_options.lightbox_text + ' %total%',
                    },
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                        titleSrc: function (item) {
                            return item.el.attr('title');
                        }
                    },
                    iframe: {
                        markup: '<div class="mfp-iframe-scaler">' +
                            '<div class="mfp-close"></div>' +
                            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                            '<div class="mfp-title">Some caption</div>' +
                            '</div>'
                    },
                    callbacks: {
                        open: function () {
                            jQuery('html').css({'overflow': 'hidden', 'height': '100%'});
                            if (!jQuery('html').hasClass('hook_safari')) {
                                jQuery('body').css({'overflow': 'hidden'});
                            }
                            jQuery.magnificPopup.instance.next = function () {
                                var self = this;
                                self.wrap.addClass('mfp-hook-transition');
                                setTimeout(function () {
                                    jQuery.magnificPopup.proto.next.call(self);
                                }, 200);
                            }
                            jQuery.magnificPopup.instance.prev = function () {
                                var self = this;
                                self.wrap.addClass('mfp-hook-transition');
                                setTimeout(function () {
                                    jQuery.magnificPopup.proto.prev.call(self);
                                }, 200);
                            }
                        },
                        close: function () {
                            jQuery('html').css({'overflow-y': 'visible', 'height': ''});
                        },
                        markupParse: function (template, values, item) {
                            values.title = item.el.attr('data-title');
                            setTimeout(function () {
                                jQuery('.mfp-wrap').removeClass('mfp-hook-transition');
                                jQuery('#mfp-hook-nav').html(jQuery('.mfp-counter').html());
                                jQuery('#mfp-hook-title').html(jQuery('.mfp-title').html());
                            }, 15);
                        }
                    }
                });
            }
        });

        //CONVERT TO SVG PATHS ON SERVICES
        jQuery('.hook_svg img').each(function(){
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');

                // Replace image with new SVG
                $img.parent().append($svg);

            }, 'xml');

        });

        //BACKGROUND VIDEOS ADJUSTMENTS
        jQuery('.hook_with_video').each(function() {
            if (hook_on_mobile && false) {//Deprecated
                var $vid_remover=jQuery(this);
                $vid_remover.css("background-image", "url("+$vid_remover.children('.hook_video-bg').attr('poster')+")");
                $vid_remover.children('.hook_video-bg').remove();
            }
            else {
                if (jQuery(this).hasClass('forced_row')) {
                    var $video_holder=jQuery(this).find('.hook_video-bg');
                    jQuery(this).find('video').on("play", function () { });
                }
            }
        });

        //FITVIDS
        jQuery('.hook_fitter').fitVids();

        //VIDEO THUMBS REMOVE ON MOBILE
        if (hook_on_mobile && false) {//Deprecated
            jQuery('.portfolio_entry_li .hook_video-bg').remove();
        }
        else {
            jQuery('.portfolio_entry_li .hook_video-bg').each(function() {
                jQuery(this).closest('.portfolio_entry_li').addClass('folio_with_video');
            });
        }

        //WOOCOMMERCE STUFF
        jQuery('.woocommerce .woocommerce-ordering .orderby,.woocommerce #calc_shipping_country,.hook_custom_select,.summary .variations select').selectOrDie({
            onChange: function(){

            }
        });
        jQuery('.hook_single_woo .images').magnificPopup({
            delegate: 'a',
            src:'data-src',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            fixedContentPos: false,
            fixedBgPos: true,
            closeOnContentClick: true,
            closeBtnInside: false,
            mainClass: 'mfp-no-margins my-mfp-zoom-in header_font',
            removalDelay: 300,
            closeMarkup:'<button title="%title%" class="mfp-close"><div class="mfp-close_inner"></div></button><div id="mfp-hook-nav" class="header_font"></div><div id="mfp-hook-title" class="header_font"></div>',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% mdi-chevron-%dir%"></button>',
                preload: [0,1],
                tCounter: '%curr% '+theme_options.lightbox_text+' %total%',
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title');
                }
            },
            callbacks: {
                open: function() {
                    jQuery('html').css({'overflow':'hidden','height':'100%'});
                    if (!jQuery('html').hasClass('hook_safari')) {
                        jQuery('body').css({'overflow': 'hidden'});
                    }
                    jQuery.magnificPopup.instance.next=function() {
                        var self=this;
                        self.wrap.addClass('mfp-hook-transition');
                        setTimeout(function() { jQuery.magnificPopup.proto.next.call(self); }, 200);
                    }
                    jQuery.magnificPopup.instance.prev=function() {
                        var self=this;
                        self.wrap.addClass('mfp-hook-transition');
                        setTimeout(function() { jQuery.magnificPopup.proto.prev.call(self); }, 200);
                    }
                },
                close: function() {
                    jQuery('html').css({'overflow-y':'visible','height':''});
                },
                markupParse: function(template, values, item) {
                    values.title=item.el.attr('data-title');
                    setTimeout(function() {
                        jQuery('.mfp-wrap').removeClass('mfp-hook-transition');
                        jQuery('#mfp-hook-nav').html(jQuery('.mfp-counter').html());
                        jQuery('#mfp-hook-title').html(item.el.attr('title'));
                    },15);
                }
            }
        });

        //SIDEBAR STUFF
        jQuery('#prk_footer_inner a,#hook_sidebar a').not('a.button,.pirenko_social a,#prk_footer_inner .pirenko_recent_posts a,#hook_sidebar .pirenko_recent_posts a,.product_list_widget a').not('.prk_twt_ul a').addClass('body_colored');
        jQuery('#prk_footer_inner .pirenko_recent_posts a,#hook_sidebar .pirenko_recent_posts a,.prk_twt_ul a').addClass('zero_color');

        //GOOGLE MAPS
        if (jQuery('.google_maps').length) {
            if (loaded_google_maps===false) {
                loaded_google_maps=true;
                var script=document.createElement('script');
                script.type='text/javascript';
                if(theme_options.google_maps_key!==undefined && theme_options.google_maps_key!=="") {
                    script.src='https://maps.googleapis.com/maps/api/js?v=3.exp&callback=init_map&key='+theme_options.google_maps_key;
                }
                else {
                    script.src='https://maps.googleapis.com/maps/api/js?v=3.exp&callback=init_map';
                }
                document.body.appendChild(script);
            }
            else {
                init_map();
            }
        }

        //TEXTFIELDS MANAGEMENT
        jQuery('.pirenko_highlighted').not('.hook_swrapper .pirenko_highlighted').on({
            blur:function() {
                jQuery(this).parent().removeClass('high_search');
                if (jQuery(this).attr('data-bk')!==undefined) {
                    jQuery(this).css({'border':'','outline':'none','color':''});
                    jQuery(this).css({'background-color':jQuery(this).attr('data-bk')});
                }
                else {
                    jQuery(this).css({'border':'','outline':'none','color':'','background-color':''});
                }
            },
        });
        jQuery('.pirenko_highlighted').not('#footer_in .pirenko_highlighted,.hook_swrapper .pirenko_highlighted').on({
            focus:function() {
                if (jQuery(this).attr('data-color')!=undefined && jQuery(this).attr('data-color')!="") {
                    jQuery(this).css({'border':'1px solid '+hex2rgb(jQuery(this).attr('data-color'),0.65)+'','color':jQuery(this).attr('data-color'),'background-color':hex2rgb(jQuery(this).attr('data-color'),0.05)});
                }
                if (jQuery(this).attr('data-bk')!==undefined) {
                    jQuery(this).css({'background-color':''});
                }
            },
        });
        jQuery('.hook_swrapper .pirenko_highlighted').on({
            focus:function() {
                jQuery(this).css({'border':'1px solid '+hex2rgb(theme_options.bd_headings_color,0.65)+'','color':theme_options.bd_headings_color});
                jQuery(this).parent().addClass('high_search');
                jQuery(this).parent().find('.hook_lback i').css({'color':theme_options.bd_headings_color});
            },
            blur:function() {
                jQuery(this).parent().removeClass('high_search');
                jQuery(this).parent().find('.hook_lback i').css({'color':''});
                jQuery(this).css({'border':'','outline':'none','color':''});
            },
        });
        //COMMENTS SEND FEATURE
        jQuery('#submit_comment_div a').click(function(e) {
            e.preventDefault();
            var already_submitted_comment=false;
            var wordpress_directory=jQuery('#submit_comment_div').attr('data-wordpress_directory');
            var empty_text_error=jQuery('#submit_comment_div').attr('data-empty_text_error');
            var invalid_email_error=jQuery('#submit_comment_div').attr('data-invalid_email_error');
            var comment_ok_message=jQuery('#submit_comment_div').attr('data-comment_ok_message');
            //REMOVE PREVIOUS ERROR MESSAGES IF THEY EXIST
            jQuery("#respond_wrapper .contact_error").remove();
            var error=false;
            var emailReg=/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if (already_submitted_comment===false) {
                //DATA VALIDATION
                jQuery('#commentform textarea, #author, #email').each(function() {
                    var value=jQuery(this).val();
                    var theID=jQuery(this).attr('id');
                    if(value == '' || value===jQuery(this).attr('data-original')) {
                        jQuery(this).after('<p class="contact_error hook_italic prk_heavier_600 header_font">'+empty_text_error+'</p>');
                        error=true;
                    }
                    if(theID === 'email' && value !=='' && value!==jQuery(this).attr('data-original') && !emailReg.test(value)) {
                        jQuery(this).after('<p class="contact_error hook_italic prk_heavier_600 header_font">'+invalid_email_error+'</p>');
                        error=true;
                    }
                    jQuery('.contact_error').addClass('hook_animated shake');
                });
                //SEND COMMENT IF THERE ARE NO ERRORS
                if(error === false) {
                    jQuery("#submit_comment_div").addClass("hook_animated bounceOut");
                    setTimeout(function() {
                        jQuery('#contact_ok').addClass('hook_animated flash');
                        //POST COMMENT
                        jQuery.ajax({
                            type: "POST",
                            url: wordpress_directory+"/wp-comments-post.php",
                            data: jQuery("#commentform").serialize(),
                            success: function(resp) {
                                jQuery('#contact_ok').html('');
                                jQuery('#contact_ok').append(comment_ok_message);
                                jQuery("#contact_ok").css({'display':'inline-block'});
                                already_submitted_comment=true;
                            },
                            error: function(e) {
                                jQuery('#contact_ok').html('');
                                jQuery('#contact_ok').append('<p class="comment_error">Comment error. Please try again!</p>');
                                jQuery("#contact_ok").css({'display':'inline-block'});
                            }
                        });
                    },1200);
                }
            }
        });

        //EMAIL SEND FEATURE
        jQuery('#submit_message_div a').on('click',function(e) {
            e.preventDefault();
            var $curr_form=jQuery(this).closest('.prk_theme_form');
            //REMOVE PREVIOUS ERRORS IF THEY EXIST
            $curr_form.find(".contact_error").remove();

            //ADD THE TEMPLATE NAME TO THE SUBJECT
            $curr_form.find('#full_subject').attr('value',$curr_form.attr('data-name'));
            var empty_text_error=$curr_form.attr('data-empty');
            var invalid_email_error=$curr_form.attr('data-invalid');
            var value, theID, error, emailReg;
            error=false;
            emailReg=/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            //DATA VALIDATION
            $curr_form.find('#c_name, #c_email, #c_message').each(function() {
                value=jQuery(this).val();
                theID=jQuery(this).attr('id');
                if(value==='' || value=== jQuery(this).attr('data-original')) {
                    if (theID==='c_message') {
                        jQuery(this).after('<p class="contact_error hook_italic prk_heavier_600 header_font at_messa">'+empty_text_error+'</p>');
                    }
                    else {
                        jQuery(this).after('<p class="contact_error hook_italic prk_heavier_600 header_font">'+empty_text_error+'</p>');
                    }
                    error=true;
                }
                if(theID==='c_email' && value !== '' && !emailReg.test(value)) {
                    jQuery(this).after('<p class="contact_error hook_italic prk_heavier_600 header_font">'+invalid_email_error+'</p>');
                    error=true;
                }
                jQuery('.contact_error').addClass('hook_animated shake');
            });

            //SEND EMAIL IF THERE ARE NO ERRORS
            if(error===false) {
                $curr_form.find("#submit_message_div").addClass("hook_animated bounceOut");
                setTimeout(function() {
                    $curr_form.find('#contact_ok').addClass('hook_animated flash');
                    $curr_form.addClass('hook_sending_email');
                    email_ajax_submit();
                },1200);
            }
        });

        //VARIOUS THEME FUNCTIONS
        initHeadline();
        init_member();
        init_blog();
        init_portfolio();
        thumbs_update();
        prk_init_sharrre();

        //Fire custom event. Useful to initialize plugins
        jQuery.event.trigger('hook_init_plugins');
        //Here's how you can bind this event - replace plugin_function() with whatever is needed
        /*jQuery(document).on("hook_init_plugins", function(event, data) {
            plugin_function();
        });*/

        //ADD ARROWS
        jQuery('.sitemap_block li a,.widget_rss ul li a, .widget_meta a,.widget_recent_entries a,.widget_categories a,.widget_archive a,.widget_pages a,.widget_links a,.widget_nav_menu a').each(function() {
            jQuery(this).prepend('<div class="prk_theme_arrows"><div class="tr_wrapper"><div class="hook_fa-angle-double-right"></div></div></div>');
        });

        //VC STUFF
        if (jQuery.isFunction(window.vc_twitterBehaviour) && theme_options.active_visual_composer==="1") {
            vc_tabsBehaviour();
            vc_twitterBehaviour();
            vc_toggleBehaviour();
            vc_accordionBehaviour();
            vc_teaserGrid();
            vc_carouselBehaviour();
            vc_slidersBehaviour();
            vc_googleplus();
            vc_pinterest();
            vc_progress_bar();
            vc_plugin_flexslider();
            vc_google_fonts();
            jQuery('.vc_tta-panel-heading').each(function() {
                if (jQuery(this).find('i.fa').length) {
                    jQuery(this).addClass('hookonized');
                }
            });
        }
        else {
            jQuery('.wpb_animate_when_almost_visible').removeClass('wpb_animate_when_almost_visible');
        }
        //RETINA IMAGES SIZE CHANGE
        jQuery('img.hook_retina,.hook_retina img').each(function() {
            var $hook_imager=jQuery(this);
            $hook_imager.parent().imagesLoaded(function() {
                $hook_imager.addClass('prk_first_anim');
                $hook_imager.width($hook_imager.attr('width')/2);
            });
        });
        var img_load=imagesLoaded("#hook_ajax_container");
        img_load.on('always', function() {
            setTimeout(function() {
                jQuery('#prk_hidden_menu,.forced_row>div,.forced_row>.row,.vertical_forced_row>div').not('.hook_read,#single_post_teaser').each(function() {
                    jQuery(this).css({'height':''});
                    var compensation=0;
                    if (jQuery(this).attr('data-adjust')!==undefined) {
                        compensation=jQuery(this).attr('data-adjust');
                    }
                    jQuery(this).css({'height':jQuery(window).height()-admin_bar_height-compensation-hook_header_height});
                });
            },15);
        });
        first_load=false;
    }
    //END - ended_loading

    //SKROLLR INIT
    if (!hook_on_mobile) {
        var hook_skrollr=skrollr.init({
            forceHeight:true,
            smoothScrolling:false
        });
        jQuery(window).trigger("debouncedresize");
    }
    //SCROLLING FUNCTIONS
    jQuery(window).scroll(function() {
        if (hide_onscroll) {
            ns_pos=jQuery(this).scrollTop();
            if (!jQuery('html').hasClass('menu_at_top') && jQuery(window).scrollTop()>=theme_options.menu_hide_pixels && ns_pos > ls_pos){
                jQuery('#hook_main_wrapper').addClass('hook_hide_nav');
            } else {
                jQuery('#hook_main_wrapper').removeClass('hook_hide_nav');
            }
            ls_pos=ns_pos;
        }
        //BACK TO TOP BUTTON
        if(jQuery(window).scrollTop() >= 240) {
            jQuery('#hook_to_top').addClass('hook_top_shown');
        }
        else {
            jQuery('#hook_to_top').removeClass('hook_top_shown');
        }
        //STICKY MENU
        if(jQuery(window).scrollTop() >= sticky_scroll) {
            jQuery('body').addClass('sticky_hook');
        }
        else {
            jQuery('body').removeClass('sticky_hook');
        }
        check_top_menu(false);
    });
    //CALL A SCROLL EVENT TO INITIALIZE CONTENT
    jQuery(window).scroll();
    //BACK TO TOP BUTTON
    jQuery('#hook_to_top').on('click',function(e) {
        e.preventDefault();
        jQuery('html,body').stop().animate({
                'scrollTop': 0
            }, 1200, 'easeInOutExpo'
        );
    });
    //CLOSE AJAX PORTFOLIO BUTTON
    jQuery('#hook_close_portfolio').on('click',function(e) {
        jQuery('#hook_main_wrapper').addClass('hook_closing_ajax');
        jQuery('#hook_main_wrapper').removeClass('hook_showing_ajax');
        setTimeout(function() {
            jQuery('#hook_main_wrapper').removeClass('hook_closing_ajax');
            jQuery(window).trigger("debouncedresize");
            jQuery(window).trigger("smartresize");
            jQuery('.folio_masonry').each(function() {
                jQuery(this).isotope('layout');
            });
            Waypoint.refreshAll();
            //GO TO HASHTAG IF POSSIBLE
            go_hash(15,true);
            jQuery('#hook_to_top').css({'background-color':''});
        },300);
        setTimeout(function() {
            //PLAY VIDEO IF AVAILABLE
            if (jQuery('.hook_panels_bk.hook_autoplay .hook_panel_bk.hook_active').find('.hook_video-bg').length) {
                jQuery('.hook_panels_bk .hook_panel_bk.hook_active').find('.hook_video-bg').get(0).play();
            }
            Waypoint.refreshAll();
            jQuery('#hook_overlayer').addClass('hook_opacer');
            if (jQuery('.google_maps').length) {
                init_map();
            }
        },450);
        setTimeout(function() {
            jQuery('#hook_overlayer').removeClass('show');
            jQuery('#hook_overlayer').removeClass('hook_opacer');
            hook_ajax_folio.html('');
        },750);
    });

    //TOP BAR SEARCH FORM
    jQuery('#prk_menu_loupe').on('click',function() {
        jQuery('body').addClass('hook_showing_search');
        jQuery('body').addClass('hook_second_menu_search_anims');
        if (!jQuery('html').hasClass('hook_ie')) {
            jQuery('#searchform_top input').focus();
        }
    });
    function hook_close_search() {
        jQuery('body').removeClass('hook_second_menu_search_anims');
        setTimeout(function() {
            jQuery('body').removeClass('hook_showing_search');
        },300);
    }
    jQuery('#top_form_close').on('click',function() {
        hook_close_search();
    });

    //FIRST LOAD
    ended_loading(false);
    loading_page=false;
    setTimeout(function(){
        jQuery(window).trigger("debouncedresize");
        jQuery('html').addClass('hook_ready');
        go_hash(1200,false);
    },300);

    //DELAYED RESIZE LISTENTERS
    jQuery.event.special.debouncedresize.threshold=100;
    jQuery(window).on("debouncedresize", function() {
        if (!hook_on_mobile) {
            jQuery('.hook_video-bg.parallax_video').each(function() {
                var $par_video=jQuery(this);
                var scrolly=$par_video.height()-$par_video.parent().outerHeight();
                $par_video.attr('data-top-bottom',"bottom: -"+scrolly+"px;");
            });
            hook_skrollr.refresh();
        }
        jQuery('.grid_image_wrapper .hook_video-bg,.hook_panels_bk .hook_video-bg').each(function() {
            var $par_video=jQuery(this);
            $par_video.css({'width':''});
            $par_video.css({'height':''});
            $par_video.css({'width':$par_video.parent().parent().width()+4});
            if ($par_video.height()<$par_video.parent().parent().outerHeight()) {
                $par_video.css({'width':''});
                $par_video.css({'height':$par_video.parent().parent().outerHeight()});
            }
        });
        jQuery('#prk_footer_mirror').css({'height':jQuery('#prk_footer').outerHeight()});
        if (!jQuery('#hook_main_wrapper').hasClass('st_without_menu') && !jQuery('#hook_ajax_container').hasClass('hook_coming') && ((jQuery(window).width())<(resp_width - scrollbar_width) || jQuery(window).width()<(768 - scrollbar_width))) {
            if (!jQuery('html').hasClass('menu_at_top')) {
                jQuery('html').addClass('menu_at_top');
                jQuery('#hook_main_menu .hook-mn').css({'display':'none'});
                hook_header_height=theme_options.collapsed_menu_vertical;
            }
        }
        else {
            if (jQuery('html').hasClass('menu_at_top')) {
                jQuery('html').removeClass('menu_at_top');
                jQuery('#hook_main_menu .hook-mn').css({'display':'block'});
                hook_header_height=0;
            }
        }
        jQuery('#prk_hidden_menu,.forced_row>div,.forced_row>.row,.vertical_forced_row>div').not('.hook_read,#single_post_teaser').each(function() {
            jQuery(this).css({'height':''});
            var compensation=0;
            if (jQuery(this).attr('data-adjust')!==undefined) {
                compensation=jQuery(this).attr('data-adjust');
            }
            jQuery(this).css({'height':jQuery(window).height()-admin_bar_height-compensation-hook_header_height});
        });
        jQuery("#prk_hidden_bar_scroller").mCustomScrollbar("update");
        jQuery("#prk_mobile_bar_scroller").mCustomScrollbar("update");
        jQuery('#hook_related_grid').find('.centerized_father').each(function() {
            jQuery(this).height(jQuery(this).closest('.portfolio_entry_li').innerHeight());
        });
        jQuery('#dotted_navigation').css({'margin-top':-jQuery('#dotted_navigation').height()/2});
        jQuery(".google_maps").height(jQuery(".google_maps").attr('data-map_height'));
        jQuery('.google_maps').css({'max-height':jQuery(window).height()-100});
        jQuery('.cd-words-wrapper').each(function() {
            jQuery(this).css({'width':''});
            jQuery(this).css({'width':jQuery(this).width()});
        });
    });
    //RESIZE LISTENER
    function pirenko_resize() {
        if (jQuery.browser.msie  && parseInt(jQuery.browser.version, 10)===8) {
            height_fix=jQuery(window).height();
        }
        else {
            height_fix=window.innerHeight ? window.innerHeight : jQuery(window).height();
        }
        if (jQuery('#wpadminbar').length) {
            height_fix=height_fix-jQuery('#wpadminbar').height();
        }
        jQuery("#prk_hidden_bar,#prk_hidden_bar_scroller,#prk_mobile_bar_scroller").outerHeight(height_fix);
        jQuery('.folio_masonry').each(function() {
            jQuery(this).width('');
        });
    }
    jQuery(window).resize(function() {
        pirenko_resize();
    });
}
//GLOBAL FUNCTIONS

( function( window ) {

    'use strict';

    function classReg( className ) {
        return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
    }

    var hasClass, addClass, removeClass;

    if ( 'classList' in document.documentElement ) {
        hasClass=function( elem, c ) {
            return elem.classList.contains( c );
        };
        addClass=function( elem, c ) {
            elem.classList.add( c );
        };
        removeClass=function( elem, c ) {
            elem.classList.remove( c );
        };
    }
    else {
        hasClass=function( elem, c ) {
            return classReg( c ).test( elem.className );
        };
        addClass=function( elem, c ) {
            if ( !hasClass( elem, c ) ) {
                elem.className=elem.className + ' ' + c;
            }
        };
        removeClass=function( elem, c ) {
            elem.className=elem.className.replace( classReg( c ), ' ' );
        };
    }

    function toggleClass( elem, c ) {
        var fn=hasClass( elem, c ) ? removeClass : addClass;
        fn( elem, c );
    }

    var classie={
        // full names
        hasClass: hasClass,
        addClass: addClass,
        removeClass: removeClass,
        toggleClass: toggleClass,
        // short names
        has: hasClass,
        add: addClass,
        remove: removeClass,
        toggle: toggleClass
    };

    if ( typeof define==='function' && define.amd ) {
        define( classie );
    } else {
        window.classie=classie;
    }

})( window );
function hasParentClass( e, classname ) {
    if(e===document){
        return false;
    }
    if( classie.has( e, classname ) ) {
        return true;
    }
    return e.parentNode && hasParentClass( e.parentNode, classname );
}
//GOOGLE MAPS FUNCTIONS
function init_map() {
    "use strict";
    jQuery('.google_maps').each(function() {
        var $this_map=jQuery(this);
        var is_draggable=jQuery(document).width() > 480 ? true : false;
        if ($this_map.attr('data-style')==='subtle_grayscale') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}],
                scrollwheel: false,
            };
        }
        else if ($this_map.attr('data-style')==='almost_gray') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{"stylers":[{"saturation":-100},{"gamma":1}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":50},{"gamma":0},{"hue":"#50a5d1"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"weight":0.5},{"color":"#333333"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"gamma":1},{"saturation":50}]}],
                scrollwheel: false,
            };
        }
        else if ($this_map.attr('data-style')==='cobalt') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{"featureType":"all","elementType":"all","stylers":[{"invert_lightness":true},{"saturation":10},{"lightness":30},{"gamma":0.5},{"hue":"#435158"}]}],
                scrollwheel: false,
            };
        }
        else if ($this_map.attr('data-style')==='midnight') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{"featureType":"water","stylers":[{"color":"#021019"}]},{"featureType":"landscape","stylers":[{"color":"#08304b"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#0c4152"},{"lightness":5}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#0b434f"},{"lightness":25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#0b3d51"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"lightness":13}]},{"featureType":"transit","stylers":[{"color":"#146474"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#144b53"},{"lightness":14},{"weight":1.4}]}],
                scrollwheel: false,
            };
        }
        else if ($this_map.attr('data-style')==='old_timey') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#ff6865"},{"visibility":"on"}]}],
                scrollwheel: false,
            };
        }
        else if ($this_map.attr('data-style')==='green') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#333739"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2ecc71"}]},{"featureType":"poi","stylers":[{"color":"#2ecc71"},{"lightness":-7}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#2ecc71"},{"lightness":-28}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#2ecc71"},{"visibility":"on"},{"lightness":-15}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#2ecc71"},{"lightness":-18}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#2ecc71"},{"lightness":-34}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#333739"},{"weight":0.8}]},{"featureType":"poi.park","stylers":[{"color":"#2ecc71"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#333739"},{"weight":0.3},{"lightness":10}]}],
                scrollwheel: false,
            };
        }
        else if ($this_map.attr('data-style')==='blue_essence') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}],
                scrollwheel: false,
            };
        }
        else if ($this_map.attr('data-style')==='theme_special_dk') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":theme_options.active_color},{"lightness":17}]}],
                scrollwheel: false,
            };
        }
        else if ($this_map.attr('data-style')==='theme_special') {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":theme_options.active_color},{"visibility":"on"}]}],
                scrollwheel: false,
            };
        }
        else {
            var mapOptions={
                draggable: is_draggable,
                zoom: parseInt($this_map.attr('data-zoom'),10),
                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                scrollwheel: false,
            };
        }

        var mapElement=document.getElementById($this_map.attr('id'));
        var map=new google.maps.Map(mapElement, mapOptions);
        google.maps.event.addListenerOnce(map, 'idle', function() {

        });
        if ($this_map.attr('data-marker_image_lat')!="" && $this_map.attr('data-marker_image_long')!=""){
            var marker=new google.maps.Marker({
                position: new google.maps.LatLng($this_map.attr('data-marker_image_lat'), $this_map.attr('data-marker_image_long')),
                map: map,
                icon: $this_map.attr('data-marker'),
                size: new google.maps.Size(40,52),
                clickable: false,
            });
        }
        else {
            var marker=new google.maps.Marker({
                position: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
                map: map,
                icon: $this_map.attr('data-marker'),
                size: new google.maps.Size(40,52),
                clickable: false,
            });
        }
    });
}

//CONTROL SCROLL ON IFRAMES/MAPS
jQuery('.wpb_raw_html iframe').css("pointer-events", "none");
jQuery('.wpb_raw_html>.wpb_wrapper').on({
    click:function() {
        jQuery(this).find('iframe').css("pointer-events", "auto");
    },
    mouseleave:function() {
        jQuery(this).find('iframe').css("pointer-events", "none");
    }
});

//FUNCTION TO DETECT IF A TOUCH DEVICE IS IN USE
function is_mobile() {
    "use strict";
    var check=false;
    (function(a){
        if((/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase())) || /(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a.toLowerCase())||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4).toLowerCase())){check=true;}})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
}
//HEXADECIMAL TO RGB:#CCCCCC=>rgb(204,204,204)
function hex2rgb(hexStr,alpha) {
    "use strict";
    var hex=parseInt(hexStr.substring(1), 16);
    var r=(hex & 0xff0000) >> 16;
    var g=(hex & 0x00ff00) >> 8;
    var b=hex & 0x0000ff;
    if (alpha>1) {
        alpha=alpha/100;
    }
    return "rgba("+[r, g, b]+","+alpha+")";
}
function is_retina_device() {
    return window.devicePixelRatio > 1;
}
if (is_retina_device() && !is_mobile()) {
    jQuery('html').addClass('hook_retina_desktop');
}
if (jQuery('.hook_single_woo').length) {
    jQuery('body').addClass('woocommerce single-product')
}

//END - GLOBAL FUNCTIONS
jQuery(document).ready(function() {
    if (theme_options.hook_active_skin!==undefined) {
        jQuery('html').addClass(theme_options.hook_active_skin);
    }
    if(theme_options.hook_responsive==="1") {
        jQuery('html').addClass('hook_responsive');
    }
    var ua = navigator.userAgent;
    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
        jQuery('html').addClass('hook_edge');
    }
    else if (jQuery.browser.chrome) {
        jQuery('html').addClass('hook_chrome');
    }
    else {
        var nua=navigator.userAgent;
        if (((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1))) {
            jQuery('html').addClass('hook_android');
        }
        else {
            var msie=nua.indexOf('MSIE ');
            var trident=nua.indexOf('Trident/');
            if (msie > 0 || trident > 0) {
                jQuery('html').addClass('hook_ie');
            }
            else if (jQuery.browser.safari) {
                jQuery('html').addClass('hook_safari');
            }
            else if (jQuery.browser.mozilla) {
                jQuery('html').addClass('hook_mozilla');
            }
        }
    }

    var found_url=false;
    if (jQuery('#hook_main_menu .hook-mn').length) {
        jQuery('#hook_main_menu .hook-mn li').each(function() {
            if (jQuery(this).hasClass('active') && jQuery(this).parent().hasClass('sub-menu')) {
                jQuery(this).parent().parent().addClass('active');
                found_url=true;
            }
        });
        if (found_url===false) {
            if (window.location.href===jQuery("#hook_main_menu .hook-mn>li:first-child>a").attr('href').split('#')[0] && jQuery("#hook_main_menu .hook-mn>li:first-child>a").attr('href').split('#')[1]==="") {
                jQuery("#hook_main_menu .hook-mn>li:first-child").addClass('active');
            }
        }
    }

    if (jQuery('#hook_ajax_inner.hook_forced_menu').length) {
        jQuery('#hook_main_wrapper').addClass('hook_forced_menu');
    }

    jQuery('#hook_logos_wrapper').css({'min-width':jQuery('#hook_logo_after>img').attr('data-width')+'px'});
    jQuery('#hook_main_wrapper').addClass('prk_loading_page');
    if (!jQuery('#hook_side_menu>div').length){
        jQuery('#hook_side_menu').css({'display':'none'});
    }

    if (jQuery('#hook_full_back').length) {
        jQuery('#hook_full_back').css({'background-image':'url('+jQuery('#hook_full_back').attr('data-image')+')'});
        jQuery('#hook_countdown_wrapper').css({'color':jQuery('#hook_countdown_wrapper').attr('data-color'),'opacity':1});
        jQuery('html').css({'min-height':'1px'});
    }

    //CALL MAIN SCRIPT
    hook_init();
});

/* jshint ignore:end */
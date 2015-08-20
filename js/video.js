// Autplay video elements that are WP shortcodes.
jQuery(window).bind("load",function(){
    jQuery(function() {
        jQuery(window).scroll(function() {
            jQuery('.wp-video-shortcode').each(function() {
                var str = jQuery(this).attr('id');
                var arr = str.split('_');
                typecheck = arr[0];
                if (jQuery(this).is(":in-viewport( 400 )") && typecheck == "mep") {
                    mejs.players[jQuery(this).attr('id')].media.play();
                } else if (typecheck == "mep") {
                    mejs.players[jQuery(this).attr('id')].media.stop();
                }
            });
        });
    });
});

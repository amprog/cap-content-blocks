<?php
/**
 * @param checks to see if the current post has a [video] shortcode.
 * @return script that will autoplay an HTML5 video player when in viewport, pauses when exits viewport.
 * @extends https://codex.wordpress.org/Video_Shortcode
 */
function ccb_video_script() {
	global $post;
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'video') ) {
		?>
        <script type="text/javascript">
		// Add :in-viewport jQuery detection
		(function($){$.belowthefold=function(element,settings){var fold=$(window).height()+$(window).scrollTop();return fold<=$(element).offset().top-settings.threshold;};$.abovethetop=function(element,settings){var top=$(window).scrollTop();return top>=$(element).offset().top+$(element).height()-settings.threshold;};$.rightofscreen=function(element,settings){var fold=$(window).width()+$(window).scrollLeft();return fold<=$(element).offset().left-settings.threshold;};$.leftofscreen=function(element,settings){var left=$(window).scrollLeft();return left>=$(element).offset().left+$(element).width()-settings.threshold;};$.inviewport=function(element,settings){return!$.rightofscreen(element,settings)&&!$.leftofscreen(element,settings)&&!$.belowthefold(element,settings)&&!$.abovethetop(element,settings);};$.extend($.expr[':'],{"below-the-fold":function(a,i,m){return $.belowthefold(a,{threshold:0});},"above-the-top":function(a,i,m){return $.abovethetop(a,{threshold:0});},"left-of-screen":function(a,i,m){return $.leftofscreen(a,{threshold:0});},"right-of-screen":function(a,i,m){return $.rightofscreen(a,{threshold:0});},"in-viewport":function(a,i,m){return $.inviewport(a,{threshold:0});}});})(jQuery);

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
                            mejs.players[jQuery(this).attr('id')].media.pause();
                        }
                    });
                });
            });
        });
        </script>
        <?php
	}
}
add_action( 'wp_footer', 'ccb_video_script');

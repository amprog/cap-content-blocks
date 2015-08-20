<?php
/**
 * @param checks to see if the current post has a [video] shortcode.
 * @return script that will autoplay an HTML5 video player when in viewport, pauses when exits viewport.
 */
function ccb_video_script() {
	global $post;
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'video') ) {
		?>
        <script type="text/javascript">
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
        </script>
        <?php
	}
}
add_action( 'wp_footer', 'ccb_video_script');

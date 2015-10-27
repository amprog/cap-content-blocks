<?php
function ccb_chapter_shortcode_register() {
    add_shortcode( 'ccb_chapter', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'title'     => '',
			'background_image' => ''
		) );

		ob_start();
        $title  = $attr['title'];
        $bg_id  = $attr['background_image'];
        $bg     = '';
        $class  = 'ccb ccb-chapter';
        if ($bg_id) {
            $bg = wp_get_attachment_image_src( $bg_id, 'large' );
            $class .= ' ccb-chapter-has-image';
        }
		?>
		<?php do_action('ccb_chapter_outside_before');?>
		<section class="<?php echo $class;?>" data-chapter-title="<?php echo esc_attr($title);?>">
			<?php do_action('ccb_chapter_inside_before');?>
            <?php if ($bg_id) {
                echo '<div class="ccb-chapter-image" style="background-image: url('.$bg[0].');"><h1 class="chapter-title">'.$title.'</h1></div>';
            } else {
                echo '<h1 class="chapter-title">'.$title.'</h1>';
            }?>
			<?php do_action('ccb_chapter_inside_after');?>
		</section>
		<?php do_action('ccb_chapter_outside_after');?>

		<?php

		return ob_get_clean();

	} );

    if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
       add_action( 'admin_notices', function(){
           if ( current_user_can( 'activate_plugins' ) ) {
               echo '<div class="error message"><p>You need Shortcake (Shortcode UI) in order to use CAP Content Blocks.</p></div>';
           }
       });
       return;
    }

    shortcode_ui_register_for_shortcode(
		'ccb_chapter',
		array(
			// Display label. String. Required.
			'label' => 'Chapter',

			// Icon/attachment for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
			'listItemImage' => 'dashicons-editor-ol',

			'post_type'     => array( 'reports' ),

			// Available shortcode attributes and default values. Required. Array.
			// Attribute model expects 'attr', 'type' and 'label'
			// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
			'attrs' => array(

				array(
					'label' => 'Title',
					'attr'  => 'title',
					'type'  => 'text',
					'meta' => array(
						'placeholder' => 'Chapter #',
						'data-test'    => 1,
					),
				),

				array(
					'label' => 'Chapter Background',
					'attr'  => 'background_image',
					'type'  => 'attachment',
					'libraryType' => array( 'image' ),
					'addButton'   => 'Select Image',
					'frameTitle'  => 'Select Image',
				),

			),

		)
	);
}
add_action('init', 'ccb_chapter_shortcode_register');

function ccb_chapter_script() {
	global $post;
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'ccb_chapter') ) {
		?>
        <script type="text/javascript">
        jQuery(document).ready(function(){

            // Wrap content between chapters
            jQuery('.ccb-chapter').each(function(index) {
                jQuery(this).attr('data-chapter', index);
                jQuery(this).nextUntil('.ccb-chapter').appendTo(this);
            });

        });
        </script>
        <?php
	}
}
add_action( 'wp_footer', 'ccb_chapter_script');

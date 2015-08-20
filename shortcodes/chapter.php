<?php
$shortcode_name = 'chapter';

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
        if ($bg_id) {
            $bg = wp_get_attachment_image_src( $bg_id, 'large' );
        }
		?>
		<?php do_action('ccb_chapter_outside_before');?>
		<section class="ccb ccb-chapter">
			<?php do_action('ccb_chapter_inside_before');?>
			<h1 class="chapter-title"><?php echo $title;?></h1>
			<?php do_action('ccb_chapter_inside_after');?>
		</section>
		<?php do_action('ccb_chapter_outside_after');?>

		<?php

		return ob_get_clean();

	} );

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
add_action('init', 'ccb_'.$shortcode_name.'_shortcode_register');

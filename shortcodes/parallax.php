<?php
$shortcode_name = 'parallax';
function ccb_parallax_shortcode_register() {

    add_shortcode( 'ccb_parallax', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'image' => '',
			'headline' => ''
		) );

		ob_start();
        $bg_id  = $attr['image'];
		$headline  = $attr['headline'];
		$inner_class = 'inner';
        $bg     = '';
        if ($bg_id) {
            $bg = wp_get_attachment_image_src( $bg_id, 'full' );
        }
		if ($headline) {
			$inner_class = 'inner gradient-cover';
		}
		?>
		<?php do_action('ccb_parallax_outside_before');?>
		<figure class="ccb ccb-parallax" style="background-image: url(<?php echo $bg[0];?>);">
			<?php do_action('ccb_parallax_inside_before');?>
			<div class="<?php echo $inner_class;?>"><h2><?php echo $headline;?></h2></div>
			<?php do_action('ccb_parallax_inside_after');?>
		</figure>
		<?php do_action('ccb_parallax_outside_after');?>

		<?php

		return ob_get_clean();

	} );

    shortcode_ui_register_for_shortcode(
		'ccb_parallax',
		array(
			// Display label. String. Required.
			'label' => 'Parallax Image',

			// Icon/attachment for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
			'listItemImage' => 'dashicons-image-flip-vertical',

			'post_type'     => array( 'reports' ),

			// Available shortcode attributes and default values. Required. Array.
			// Attribute model expects 'attr', 'type' and 'label'
			// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
			'attrs' => array(

				array(
					'label' => 'Headline',
					'attr'  => 'headline',
					'type'  => 'text',
					'meta' => array(
						'placeholder' => 'Headline',
						'data-test'    => 1,
					),
				),

				array(
					'label' => 'Parralax Image',
					'attr'  => 'image',
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

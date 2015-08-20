<?php
$shortcode_name = 'pullquote';
function ccb_pullquote_shortcode_register() {

    add_shortcode( 'ccb_pullquote', function( $attr, $content = null ) {

		$attr = wp_parse_args( $attr, array(
			'alignment'		=> 'none',
			'source'   		=> '',
		) );

		ob_start();
        $alignment  = $attr['alignment'];
		$source = $attr['source'];
		$classes = 'ccb ccb-pullquote'.' '.$alignment;
		?>
		<?php do_action('ccb_pullquote_outside_before');?>
		<aside class="<?php echo $classes;?>">
			<?php do_action('ccb_pullquote_inside_before');?>
			<p><?php echo $content;?></p>
			<span class="source"><?php echo $source;?></span>
			<?php do_action('ccb_pullquote_inside_after');?>
		</aside>
		<?php do_action('ccb_pullquote_outside_after');?>

		<?php

		return ob_get_clean();

	} );

    shortcode_ui_register_for_shortcode(
		'ccb_pullquote',
		array(
			'label' => 'Pull Quote',
			'listItemImage' => 'dashicons-editor-quote',
			'inner_content' => array(
				'label' => 'Quote',
			),
			'post_type'     => array( 'reports' ),
			'attrs' => array(

				array(
					'label' => 'Alignment',
					'attr'  => 'alignment',
					'type'  => 'select',
					'options'   => array(
						'none'	=> 'None (Default)',
						'alignleft' => 'Left'
					),
				),

				array(
					'label' => 'Cite',
					'attr'  => 'source',
					'type'  => 'text',
					'meta' => array(
						'placeholder' => 'John Doe',
						'data-test'    => 1,
					),
				)

			),

		)
	);

}
add_action('init', 'ccb_'.$shortcode_name.'_shortcode_register');

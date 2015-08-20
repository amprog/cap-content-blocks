<?php
$shortcode_name = 'content';
function ccb_content_shortcode_register() {

    add_shortcode( 'ccb_content', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'id'		=> '',
			'style'		=> 'box',
		) );

		ob_start();
        $id 	 = $attr['id'];
		$classes = 'ccb ccb-content'.' '.$attr['style'];
		$post 	 = get_post($id);
		?>
		<?php do_action('ccb_content_oustide_before');?>
		<aside class="<?php echo $classes;?>" data-original-post-id="<?php echo $id;?>">
			<?php do_action('ccb_content_inside_before');?>
			<div>
				<?php echo $post->post_content;?>
			</div>
			<?php do_action('ccb_content_inside_after');?>
		</aside>
		<?php do_action('ccb_content_oustide_after');?>

		<?php

		return ob_get_clean();

	} );

    shortcode_ui_register_for_shortcode(
		'ccb_content',
		array(
			'label' => 'Content',
			'listItemImage' => 'dashicons-media-document',
			'post_type'     => array( 'reports', 'post' ),
			'attrs' => array(

				array(
					'label'    => 'Select Post to Pull Content From',
					'attr'     => 'id',
					'type'     => 'post_select',
					'query'    => array( 'post_type' => 'post' ),
					'multiple' => false,
				),

				array(
					'label' => 'Style',
					'attr'  => 'style',
					'type'  => 'select',
					'options'   => array(
						'box'	=> 'Box (Default)',
						'none' => 'None'
					),
				),
			)
		)
	);
}
add_action('init', 'ccb_'.$shortcode_name.'_shortcode_register');

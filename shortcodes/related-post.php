<?php
$shortcode_name = 'related_post';
function ccb_related_post_shortcode_register() {

    add_shortcode( 'ccb_related_post', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'id'		=> '',
		) );

		ob_start();
        $id 	 = $attr['id'];
		$post 	 = get_post($id);
		?>
		<?php do_action('ccb_related_post_oustide_before');?>
		<aside class="ccb ccb-related-post" data-original-post-id="<?php echo $id;?>">
			<?php do_action('ccb_related_post_inside_before');?>
			<div>
                <?php echo $post->post_title;?>
				<?php echo $post->post_excerpt;?>
			</div>
			<?php do_action('ccb_related_post_inside_after');?>
		</aside>
		<?php do_action('ccb_related_post_oustide_after');?>

		<?php

		return ob_get_clean();

	} );

    if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
       return;
    }

    shortcode_ui_register_for_shortcode(
		'ccb_related_post',
		array(
			'label' => 'Related Post',
			'listItemImage' => 'dashicons-media-document',
			'post_type'     => array( 'reports', 'post' ),
			'attrs' => array(

				array(
					'label'    => 'Select Related Post',
					'attr'     => 'id',
					'type'     => 'post_select',
					'query'    => array( 'post_type' => 'post' ),
					'multiple' => false,
				),

			)
		)
	);
}
add_action('init', 'ccb_'.$shortcode_name.'_shortcode_register');

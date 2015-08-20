<?php
// TODO make a view interactive button to take them to a specific page that is only that...

if ( ! function_exists('cap_interactive_register') ) {
    // Register Interactive Post Type
    function cap_interactive_register() {
        $labels = array(
            'name'                => 'Interactives',
            'singular_name'       => 'Interactive',
            'menu_name'           => 'Interactives',
            'parent_item_colon'   => 'Interactive:',
            'all_items'           => 'All Interactives',
            'view_item'           => 'View Interactive',
            'add_new_item'        => 'Add New Interactive',
            'add_new'             => 'Add New',
            'edit_item'           => 'Edit Interactive',
            'update_item'         => 'Update Interactive',
            'search_items'        => 'Search Interactives',
            'not_found'           => 'No Interactive found',
            'not_found_in_trash'  => 'No Interactives found in Trash',
        );
        $rewrite = array(
            'slug'                => 'interactive',
            'with_front'          => true,
            'pages'               => true,
            'feeds'               => true,
        );
        $args = array(
            'label'               => 'Interactives',
            'description'         => 'Interactives',
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', ),
            'taxonomies'          => array( 'category', 'post_tag' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-chart-pie',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => 'post',
        );
        register_post_type( 'interactive', $args );
    }
    // Hook into the 'init' action
    add_action( 'init', 'cap_interactive_register', 0 );
}

function ccb_interactive_shortcode_register() {

    add_shortcode( 'ccb_interactive', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'id'		=> '',
			'alignment'	=> 'full-bleed'
		) );

		ob_start();
        $id 	 = $attr['id'];
		$alignment_class  = $attr['alignment'];
		$post 	 = get_post($id);
		?>
		<?php do_action('ccb_interactive_outside_before');?>
		<figure class="ccb ccb-interactive <?php echo $alignment_class;?>" data-original-post-id="<?php echo $id;?>">
			<?php do_action('ccb_interactive_inside_before');?>
			<?php echo $post->post_content;?>
			<?php do_action('ccb_interactive_inside_after');?>
		</figure>
		<?php do_action('ccb_interactive_outside_after');?>

		<?php

		return ob_get_clean();

	} );

    if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
       return;
    }

	shortcode_ui_register_for_shortcode(
		'ccb_interactive',
		array(
			'label' => 'Interactive',
			'listItemImage' => 'dashicons-chart-pie',
			'post_type'     => array( 'reports', 'post' ),
			'attrs' => array(

				array(
					'label'    => 'Select Interactive to Include',
					'attr'     => 'id',
					'type'     => 'post_select',
					'query'    => array( 'post_type' => 'interactive' ),
					'multiple' => false,
				),

				array(
					'label' => 'Alignment',
					'attr'  => 'alignment',
					'type'  => 'select',
					'options'   => array(
						'full-bleed'	=> 'Full Bleed (Default)',
						'in-content' => 'In Content Well'
					),
				),
			)
		)
	);
}
add_action('init', 'ccb_interactive_shortcode_register');

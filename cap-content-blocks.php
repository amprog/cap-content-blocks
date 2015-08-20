<?php
/*
Plugin Name: CAP Content Blocks (Shortcodes)
Plugin URI: http://americanprogress.org
Description: CAP specific shortcodes for use in long form content.
Version: 0.1
Author: Seth Rubenstein for Center for American Progress
Author URI: http://sethrubenstein.info
*/
$plugin_dir = plugin_dir_path( __FILE__ );

function ccb_styles_scripts() {
    wp_register_style( 'cap-content-blocks',  plugin_dir_url( __FILE__ ) . 'css/ccb.css' );

    // Check to see if the current theme has support for cap-content-blocks
    // This can be delcared on a theme by declaring add_theme_support('cap-content-blocks'); in functions.php
    if (current_theme_supports('cap-content-blocks')) {

    } else {

    }

    // check for material design icons and then include
}
add_action( 'wp_enqueue_scripts', 'ccb_styles_scripts' );

function ccb_editor_style() {
    add_editor_style( plugin_dir_url( __FILE__ ) . 'css/ccb-editor-style.css' );
    // check for material design icons and then include
}
add_action( 'admin_init', 'ccb_editor_style' );

// Check for individual shortcodes in content.


add_action( 'init', function() {

	/**
	 * Register your shortcode as you would normally.
	 * This is a simple example for a pullquote with a citation.
	 */
	add_shortcode( 'chapter', function( $attr ) {

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
		<?php do_action('cap_report_chapter_shortcode_outside_before');?>
		<section class="chapter">
			<?php do_action('cap_report_chapter_shortcode_inside_before');?>
			<h1 class="chapter-title"><?php echo $title;?></h1>
			<?php do_action('cap_report_chapter_shortcode_inside_end');?>
		</section>
		<?php do_action('cap_report_chapter_shortcode_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	add_shortcode( 'pull_quote', function( $attr, $content = null ) {

		$attr = wp_parse_args( $attr, array(
			'alignment'		=> 'none',
			'source'   		=> '',
		) );

		ob_start();
        $alignment  = $attr['alignment'];
		$source = $attr['source'];
		$classes = 'pullquote'.' '.$alignment;
		?>
		<?php do_action('cap_report_pullquote_shortcode_outside_before');?>
		<aside class="<?php echo $classes;?>">
			<?php do_action('cap_report_pullquote_shortcode_inside_before');?>
			<p><?php echo $content;?></p>
			<span class="source"><?php echo $source;?></span>
			<?php do_action('cap_report_pullquote_shortcode_inside_end');?>
		</aside>
		<?php do_action('cap_report_pullquote_shortcode_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	add_shortcode( 'content', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'id'		=> '',
			'style'		=> 'box',
		) );

		ob_start();
        $id 	 = $attr['id'];
		$classes = 'contentbox'.' '.$attr['style'];
		$post 	 = get_post($id);
		?>
		<?php do_action('cap_report_content_shortcode_outside_before');?>
		<aside id="content-from-<?php echo $id;?>" class="<?php echo $classes;?>">
			<?php do_action('cap_report_content_shortcode_inside_before');?>
			<div class="inner-content">
				<?php echo $post->post_content;?>
			</div>
			<?php do_action('cap_report_content_shortcode_inside_end');?>
		</aside>
		<?php do_action('cap_report_content_shortcode_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	add_shortcode( 'interactive', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'id'		=> '',
			'alignment'	=> 'full-bleed'
		) );

		ob_start();
        $id 	 = $attr['id'];
		$alignment_class  = $attr['alignment'];
		$post 	 = get_post($id);
		?>
		<?php do_action('cap_report_interactive_shortcode_outside_before');?>
		<figure id="interactive-<?php echo $id;?>" class="interactive <?php echo $alignment_class;?>">
			<?php do_action('cap_report_interactive_shortcode_inside_before');?>
			<?php echo $post->post_content;?>
			<?php do_action('cap_report_interactive_shortcode_inside_end');?>
		</figure>
		<?php do_action('cap_report_interactive_shortcode_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	add_shortcode( 'download', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'file_id'		=> ''
		) );

		ob_start();
        $id 	 = $attr['file_id'];
		$file 	 = get_post($id);
		?>
		<?php do_action('cap_report_download_shortcode_outside_before');?>
		<a href="<?php echo wp_get_attachment_url( $id );?>" id="file-download-<?php echo $id;?>" class="download-shortcode" data-file-type="<?php echo esc_attr($file->post_mime_type);?>" download>
			<?php do_action('cap_report_download_shortcode_inside_before');?>
			<div>
				<?php
				if ( $file->post_mime_type === 'application/pdf' ) {
					echo '<i class="mdi mdi-file-pdf"></i>';
				} elseif ( $file->post_mime_type === 'application/vnd.ms-excel' || $file->post_mime_type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
					echo '<i class="mdi mdi-file-excel"></i>';
				} elseif ( $file->post_mime_type === 'application/msword' || $file->post_mime_type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
					echo '<i class="mdi mdi-file-word"></i>';
				} elseif ( $file->post_mime_type === 'image/svg+xml' ) {
					echo '<i class="mdi mdi-file-image"></i>';
				} else {
					echo '<i class="mdi mdi-file"></i>';
				}
				?>
			</div>
			<div>
				<small>Download File</small><br>
				<h4><?php echo $file->post_title;?></h4>
				<span class="description"><?php echo $file->post_content;?></span>
			</div>
			<?php do_action('cap_report_download_shortcode_inside_end');?>
		</a>
		<?php do_action('cap_report_download_shortcode_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	add_shortcode( 'parallax', function( $attr ) {

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
		<?php do_action('cap_report_parallax_shortcode_outside_before');?>
		<figure class="parallax" style="background-image: url(<?php echo $bg[0];?>);">
			<?php do_action('cap_report_parallax_shortcode_inside_before');?>
			<div class="<?php echo $inner_class;?>"><h2><?php echo $headline;?></h2></div>
			<?php do_action('cap_report_parallax_shortcode_inside_end');?>
		</figure>
		<?php do_action('cap_report_parallax_shortcode_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	/////////////////////////////////////////////////////////////////
	/// Throw warning if Shortcake not available.
    if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
		add_action( 'admin_notices', function(){
			if ( current_user_can( 'activate_plugins' ) ) {
				echo '<div class="error message"><p>Shortcode UI plugin must be active for shortcodes to function properly.</p></div>';
			}
		});
		return;
	}
	/////////////////////////////////////////////////////////////////

	/**
	 * Register a UI for the Shortcode.
	 * Pass the shortcode tag (string)
	 * and an array or args.
	 */
	shortcode_ui_register_for_shortcode(
		'chapter',
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

	shortcode_ui_register_for_shortcode(
		'pull_quote',
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

	shortcode_ui_register_for_shortcode(
		'content',
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

	shortcode_ui_register_for_shortcode(
		'interactive',
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

	shortcode_ui_register_for_shortcode(
		'download',
		array(
			'label' => 'File Download',
			'listItemImage' => 'dashicons-download',
			'post_type'     => array( 'reports', 'post' ),
			'attrs' => array(
				array(
					'label' => 'File',
					'attr'  => 'file_id',
					'type'  => 'attachment',
					'libraryType' => array( 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'image/svg+xml' ),
					'addButton'   => 'Select File',
					'frameTitle'  => 'Select File (doc, xls, pdf, svg)',
				),
			)
		)
	);

	shortcode_ui_register_for_shortcode(
		'parallax',
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

	///////////////////////// END
} );

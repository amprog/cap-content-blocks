<?php
$shortcode_name = 'download';
function ccb_download_shortcode_register() {

    add_shortcode( 'ccb_download', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'file_id'		=> ''
		) );

		ob_start();
        $id 	 = $attr['file_id'];
		$file 	 = get_post($id);
		?>
		<?php do_action('ccb_download_outside_before');?>
		<a href="<?php echo wp_get_attachment_url( $id );?>" class="ccb ccb-download" data-file-type="<?php echo esc_attr($file->post_mime_type);?>" download>
			<?php do_action('ccb_download_inside_before');?>
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
			<?php do_action('ccb_download_inside_after');?>
		</a>
		<?php do_action('ccb_download_outside_after');?>

		<?php

		return ob_get_clean();

	} );

    shortcode_ui_register_for_shortcode(
		'ccb_download',
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

}
add_action('init', 'ccb_'.$shortcode_name.'_shortcode_register');

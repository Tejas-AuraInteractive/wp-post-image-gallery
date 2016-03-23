<?php

/*
 * Aura Post Gallery
 *
 * @package   Aura_Post_Gallery
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Aura Post Gallery
 * Plugin URI:  
 * Description: Enables custom fields.
 * Version:     0.1.0
 * Author:      Tejas Mishra
 * Author URI:  
 * Text Domain: wpaura
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: 
 *
 */


/**
 * function to return a custom field value.
 */
function wpaura_get_gallery_images( $value ) {
	global $post;

    $gallery_images = get_post_meta( $post->ID, $value, true );
    if ( !empty( $gallery_images ) )
	    return is_array( $gallery_images ) ? stripslashes_deep( $gallery_images ) : stripslashes( wp_kses_decode_entities( $gallery_images ) );

    return false;
}


/**
 * Register the Meta box
 */
function wpaura_add_custom_meta_box() {
	// add_meta_box( 'wpaura-meta-box', __( 'Metabox Example', 'wpaura' ), 'wpaura_meta_box_output', 'post', 'normal', 'high' );
	// add_meta_box( 'wpaura-meta-box', __( 'Metabox Example', 'wpaura' ), 'wpaura_meta_box_output', 'page', 'normal', 'high' );
	add_meta_box( 'wpaura-meta-box', __( 'Post Gallery', 'wpaura' ), 'wpaura_meta_box_output', 'apps', 'normal', 'high' );

	
}
add_action( 'add_meta_boxes', 'wpaura_add_custom_meta_box' );




/**
 * Output the Meta box
 */
function wpaura_meta_box_output( $post ) {
	// create a nonce field
	wp_nonce_field( 'my_wpaura_meta_box_nonce', 'wpaura_meta_box_nonce' ); ?>
    <p>
    	<style>#wpaura_sortable li { display: inline-block; }</style>
    	<textarea name="wpaura_sortable_textarea" id="wpaura_sortable_textarea"  hidden ><?php echo wpaura_get_gallery_images( 'wpaura_sortable_textarea' ); ?></textarea>
		<input type="text" id="listofimages" name="listofimages" hidden value="">
    	<div id="sortable-ul">
    		<ul id="wpaura_sortable" name="wpaura_sortable">
		  		
			</ul>

    	</div>
    	
    	<input type="button" name="upload_btn" class="upload_btn button" value="Upload Image">
    	<input type="button" name="save" class="save button" value="Save Order">

    </p>
    
	<?php
}



/**
 * Save the Meta box values
 */
function wpaura_meta_box_save( $post_id ) {
	// Stop the script when doing autosave
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// Verify the nonce. If insn't there, stop the script
	if( !isset( $_POST['wpaura_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpaura_meta_box_nonce'], 'my_wpaura_meta_box_nonce' ) ) return;

	// Stop the script if the user does not have edit permissions
	if( !current_user_can( 'edit_post', get_the_id() ) ) return;

    // Save the textfield
	if( isset( $_POST['wpaura_textfield'] ) )
		update_post_meta( $post_id, 'wpaura_textfield', esc_attr( $_POST['wpaura_textfield'] ) );

    // Save the textarea
	if( isset( $_POST['wpaura_textarea'] ) )
		update_post_meta( $post_id, 'wpaura_textarea', esc_attr( $_POST['wpaura_textarea'] ) );

    // Save the textarea
	if( isset( $_POST['wpaura_sortable_textarea'] ) )
		update_post_meta( $post_id, 'wpaura_sortable_textarea', esc_attr( $_POST['wpaura_sortable_textarea'] ) );

	// Save the textarea
	if( isset( $_POST['listofimages'] ) )
		update_post_meta( $post_id, 'listofimages', esc_attr( $_POST['listofimages'] ) );
}
add_action( 'save_post', 'wpaura_meta_box_save' );


function wpaura_post_gallery_admin_scripts() {
	wp_enqueue_media();
	wp_register_script('wpaura-post-gallery', plugin_dir_url( __FILE__ ) . 'upload-script.js', array('jquery'));
	wp_enqueue_script('wpaura-post-gallery');
}

add_action( 'admin_enqueue_scripts', 'wpaura_post_gallery_admin_scripts' );



?>
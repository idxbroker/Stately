<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category Stately
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_action( 'cmb2_init', 'equity_child_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function equity_child_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_equity_';

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'equity_child_metabox',
		'title'         => __( 'Single Post Options', 'stately' ),
		'object_types'  => array( 'page', 'post', 'listing', 'idx-wrapper', 'community' ), // Post type
		'context'       => 'side',
		'priority'      => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	// Select field to upload custom background image
	$cmb->add_field( array(
		'name' => __( 'Custom Background Image', 'stately' ),
		'desc' => __( 'Upload an image to use as the background for this post.', 'stately' ),
		'id'   => $prefix . 'single_post_background',
		'type' => 'file',
	) );

	// Checkbox field to disable background image
	$cmb->add_field( array(
		'name' => __( 'Disable Background', 'stately' ),
		'desc' => __( 'Check to disable the background image on this post.', 'stately' ),
		'id'   => $prefix . 'disable_single_post_background',
		'type' => 'checkbox',
	) );
}

add_action( 'init', 'equity_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function equity_initialize_cmb_meta_boxes() {

	// Include CMB2 for our metabox
	if ( ! class_exists( 'CMB2' ) ) {
		require_once EQUITY_CLASSES_DIR . '/cmb2/init.php';
	}
}

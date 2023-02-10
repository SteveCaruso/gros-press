<?php
/**
* Plugin Name: GROSS Press
* Plugin URI: https://www.graverobbersgame.com
* Description: The card database system for Grave Robbers From Outer Space.
* Version: 0.1
* Author: Steve Caruso
* Author URI: https://steve.rogueleaf.com
**/


//Custom post type add
function gros_custom_post_type() {
	register_post_type('gros_card',
		array(
			'labels'      => array(
				'name'          		=> __( 'Cards', 'textdomain' ),
				'singular_name' 		=> __( 'Card', 'textdomain' ),
				'add_new'            	=> _x( 'Add New', 'book' ),
				'add_new_item'       	=> __( 'Add New Card' ),
				'edit_item'          	=> __( 'Edit Card' ),
				'new_item'           	=> __( 'New Card' ),
				'all_items'          	=> __( 'All Cards' ),
				'view_item'          	=> __( 'View Card' ),
				'search_items'       	=> __( 'Search Cards' ),
				'not_found'          	=> __( 'No cards found' ),
				'not_found_in_trash' 	=> __( 'No cards found in the Trash' ), 
				'menu_name'			 	=> __( 'Cards' )
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'card' ), // my custom slug
			'supports' => array( 
				'title', 
				'editor', 
				'excerpt', 
				'thumbnail', 
				'custom-fields', 
				'revisions' 
			),
			'description'   			=> 'All cards in the database',
			'register_meta_box_cb' 		=> 'gros_card_meta_box',
		)
	);
}
add_action('init', 'gros_custom_post_type');

//Messages
function gros_card_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['gros_card'] = array(
		0 => ’, 
		1 => sprintf( __('Card updated. <a href="%s">View card</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Field updated.'),
		3 => __('Field deleted.'),
		4 => __('Card updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Card restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Card published. <a href="%s">View card</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Card saved.'),
		8 => sprintf( __('Card submitted. <a target="_blank" href="%s">Preview card</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Card scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview card</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Card draft updated. <a target="_blank" href="%s">Preview card</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'gros_card_updated_messages' );


//The Card metabox
function gros_card_meta_box(WP_Post $post) {
    add_meta_box('gros_card', 'Card Details', function() {
        echo 'Working';
    });
}

?>
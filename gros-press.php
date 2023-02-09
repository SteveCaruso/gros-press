<?php
/**
* Plugin Name: GROSS Press
* Plugin URI: https://www.graverobbersgame.com
* Description: The card database system for Grave Robbers From Outer Space.
* Version: 0.1
* Author: Steve Caruso
* Author URI: https://steve.rogueleaf.com
**/

function gros_custom_post_type() {
	register_post_type('gros_card',
		array(
			'labels'      => array(
				'name'          => __( 'Cards', 'textdomain' ),
				'singular_name' => __( 'Card', 'textdomain' ),
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'card' ), // my custom slug
		)
	);
}
add_action('init', 'gros_custom_post_type');


?>
<?php
/**
* Plugin Name: GROSS Press
* Plugin URI: https://www.graverobbersgame.com
* Description: The card database system for Grave Robbers From Outer Space.
* Version: 0.1
* Author: Steve Caruso
* Author URI: https://steve.rogueleaf.com
**/


/*
	Add Custom Post Type

	This is the backbone of the system. All cards are represented by custom post types in the Wordpress database.

	We still need import and export functions.

*/
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
				'revisions' 
			),
			'description'   			=> 'All cards in the database',
			'register_meta_box_cb' 		=> 'gros_card_meta_box',
			'menu_icon' 				=> 'dashicons-tablet', 
		)
	);
    add_action('save_post', 'gros_card_update');
}
add_action('init', 'gros_custom_post_type');

/*
	Custom Messages

	Messages for various actions.
*/
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


/*
	The Card Metabox

	This is where all of the card details can be edited.
*/

function gros_card_meta_box(WP_Post $post) {
    add_meta_box('gros_card', 'Card Details', function() {
        
		
		//$field_name = 'your_field';
        //$field_value = get_post_meta($post->ID, $field_name, true);

		$gros_name = get_post_meta($post->ID, 'gros_name', true);
		$gros_type = get_post_meta($post->ID, 'gros_type', true);
		$gros_art = get_post_meta($post->ID, 'gros_art', true);
		$gros_artist = get_post_meta($post->ID, 'gros_artist', true);
		$gros_stat = get_post_meta($post->ID, 'gros_stat', true);
		$gros_popcorn = get_post_meta($post->ID, 'gros_popcorn', true);
		$gros_bucket = get_post_meta($post->ID, 'gros_bucket', true);
		$gros_quote = get_post_meta($post->ID, 'gros_quote', true);
		$gros_abilities = get_post_meta($post->ID, 'gros_abilities', true);
		$gros_title = get_post_meta($post->ID, 'gros_title', true);
		$gros_series = get_post_meta($post->ID, 'gros_series', true);
		$gros_number = get_post_meta($post->ID, 'gros_number', true);
		$gros_mechanic = get_post_meta($post->ID, 'gros_mechanic', true);


		/*
			Fields needed:
				Name (title of post)
				Type gros_type
				Artwork
					gros_art
					gros_artist
				Traits gros_traits
				Stat gros_stat
				Popcorn gros_popcorn
				Bucket gros_bucket
				Quote gros_quote
				Abilities gros_abilities
				Title Word gros_title
				Series gros_series
				Number gros_number
				Mechanic gros_mechanic

			The actual body of the post will be for notes and rulings.

		*/
		
        //wp_nonce_field('gros_card_nonce', 'gros_card_nonce');

		?>
		
		<table class="form-table">
			
			<tr>
                <th><label for="gros_name">Card Name:</label></th>
                <td>
                    <input id="gros_name"
                           name="gros_name"
                           type="text"
                           value="<?php echo esc_attr($gros_name); ?>"
                    />
                </td>
            </tr>
		
			<tr>
                <th><label for="gros_type">Card Type</label></th>
                <td>
                    <select id="gros_type"
                           name="gros_type"
                           type="text">
						<option value="">--CHOOSE:--</option>
						<option <?php if ($gros_type == "character") echo 'selected="true"'; ?> value="character">Character</option>
						<option <?php if ($gros_type == "creature") echo 'selected="true"'; ?> value="creature">Creature</option>
						<option <?php if ($gros_type == "roll-the-credits") echo 'selected="true"'; ?> value="roll-the-credits">Roll the Credits</option>
						<option <?php if ($gros_type == "location") echo 'selected="true"'; ?> value="location">Location</option>
						<option <?php if ($gros_type == "prop") echo 'selected="true"'; ?> value="prop">Prop</option>
						<option <?php if ($gros_type == "special-effect") echo 'selected="true"'; ?> value="special-effect">Special Effect</option>
					</select>
                </td>
            </tr>

			<tr>
                <th><label for="gros_art">Art Image:</label></th>
                <td>
                    <input id="gros_art"
                           name="gros_art"
                           type="text"
                           value="<?php echo esc_attr($gros_art); ?>"
						   size="16"
                    />
                </td>
            </tr>

			<tr>
                <th><label for="gros_artist">Artist:</label></th>
                <td>
                    <input id="gros_artist"
                           name="gros_artist"
                           type="text"
                           value="<?php echo esc_attr($gros_artist); ?>"
                    />
                </td>
            </tr>
			
			<tr>
                <th><label for="gros_stat">Attack/Defense:</label></th>
                <td>
                    <input id="gros_stat"
                           name="gros_stat"
                           type="text"
                           value="<?php echo esc_attr($gros_stat); ?>"
						   size="3"
                    />
                </td>
            </tr>

			<tr>
                <th><label for="gros_popcorn">Popcorn:</label></th>
                <td>
                    <input id="gros_popcorn"
                           name="gros_popcorn"
                           type="text"
                           value="<?php echo esc_attr($gros_popcorn); ?>"
						   size="3"
                    />
                </td>
            </tr>

			<tr>
                <th><label for="gros_bucket">Popcorn Bucket?</label></th>
                <td>
                    <input id="gros_bucket"
                           name="gros_bucket"
                           type="checkbox"
                           value="true"
						   <?php echo ($gros_bucket == "true") ? 'checked="true"' : '' ?>
                    />
                </td>
            </tr>

			<tr>
                <th><label for="gros_quote">Quote:</label></th>
                <td>
					<textarea id="gros_quote" name="gros_quote" cols="50" rows="3"><?php echo esc_attr($gros_quote); ?></textarea>
                </td>
            </tr>

			<tr>
                <th><label for="gros_abilities">Ability Text:</label></th>
                <td>
					<textarea id="gros_abilities" name="gros_abilities" cols="50" rows="3"><?php echo esc_attr($gros_abilities); ?></textarea>
                </td>
            </tr>

			<tr>
                <th><label for="gros_title">Title Word:</label></th>
                <td>
                    <input id="gros_title"
                           name="gros_title"
                           type="text"
                           value="<?php echo esc_attr($gros_title); ?>"
                    />
                </td>
            </tr>

			<tr>
                <th><label for="gros_series">Series:</label></th>
                <td>
                    <input id="gros_series"
                           name="gros_series"
                           type="text"
                           value="<?php echo esc_attr($gros_series); ?>"
						   size="10"
                    />
                </td>
            </tr>

			<tr>
                <th><label for="gros_number">Number in Series:</label></th>
                <td>
                    <input id="gros_number"
                           name="gros_number"
                           type="text"
                           value="<?php echo esc_attr($gros_number); ?>"
						   size="3"
                    />
                </td>
            </tr>

			<tr>
                <th><label for="gros_mechanic">Mechanic:</label></th>
                <td>
                    <input id="gros_mechanic"
                           name="gros_mechanic"
                           type="text"
                           value="<?php echo esc_attr($gros_mechanic); ?>"
                    />
                </td>
            </tr>

        </table>

        <?php


    });
}

/*
	Save Metabox data
*/

// Check for empty string allowing for a value of `0`
function empty_str( $str ) {
    return ! isset( $str ) || $str === "";
}

// Save and delete data
function gros_card_update($post_id){

    $post = get_post($post_id);
    $is_revision = wp_is_post_revision($post_id);

    // Do not save meta for a revision or on autosave
    if ( $post->post_type != 'gros_card' || $is_revision )
        return;

	// Secure with nonce field check
    //if( ! check_admin_referer('gros_nonce', 'gros_nonce') )
    //    return;

	//Update post slug based on card's unique ID
    remove_action('save_post', 'gros_card_update');
    wp_update_post( array(
        'ID' => $post_id,
        'post_name' => $gros_series.'-'.$gros_number
    ));
    add_action('save_post', 'gros_card_update');

    //Update fields
    $fields = array(
        'gros_name',
        'gros_type',
        'gros_art',
        'gros_artist',
        'gros_stat',
        'gros_popcorn',
        'gros_bucket',
        'gros_quote',
        'gros_abilities',
        'gros_title',
        'gros_series',
        'gros_number',
        'gros_mechanic'
    );

    foreach($fields as $field) {
        if( isset($_POST[$field]) ) {
            if( ! empty_str( $_POST[$field] ) ) {
                update_post_meta($post_id, $field, $_POST[$field]);
            } elseif( empty_str( $_POST[$field] ) ) {
                delete_post_meta($post_id, $field);
            }
        }
    }

}

?>
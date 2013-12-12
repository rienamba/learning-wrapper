<?php /*
Plugin Name: Learning Wrapper Plugin
Description: Adds a Custom post type "Learning Wrapper", 
Author: Rie
Version: 1.0
Author URI: http://ctlt.ubc.ca
*/
/* Creates Custom Post "Learning Wrapper*/

/*Register Custom Post Type*/
add_action( 'init', 'Learning_Wrapper_Register' );
add_filter('the_content','make_the_metabox_display');

function make_the_metabox_display($content) {
	global $post;
	echo '<pre>';
	//print_r($post);
	$post_meta = get_post_meta($post->ID);
	var_dump($post_meta);
	echo '</pre>';
	return $post_meta['_video_title'][0];
}

	function Learning_Wrapper_Register() {
	
		$labels = array(
			'name' => _x('Learning Wrapper', 'post type general name'),
			'singular_name' => _x('Learning Wrapper', 'post type singular name'),
			'add_new' => _x('Add New Learning Wrapper', 'portfolio item'),
			'add_new_item' => __('Add New Learning Wrapper'),
			'edit_item' => __('Edit Learning Wrapper'),
			'new_item' => __('New Learning Wrapper'),
			'view_item' => __('View Learning Wrapper'),
			'search_items' => __('Search Learning Wrapper'),
			'parent_item_colon' => ''
	);
 
		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','thumbnail')
	 ); 
 
register_post_type( 'Learning_Wrapper' , $args );
register_taxonomy("Category", array("Learning_Wrapper"), array("hierarchical" => true, "label" => "Category", "singular_label" => "Category", "rewrite" => true));

}


add_action("admin_init","register_wrapper_scripts");
add_action("admin_print_styles","register_wrapper_style");

add_action("admin_init", "register_metabox");
add_action('save_post', 'wrapper_prfx_meta_save', 1, 2); // save the custom fields

/*Register scripts*/
function register_wrapper_scripts(){
	wp_register_script('learning_wrapper_js_admin', plugins_url('js/learning_wrapper_admin.js', __FILE__), array('jquery'));
	wp_enqueue_script('learning_wrapper_js_admin');
}

/*enqueue Admin Custom Post Type CSS */

function register_wrapper_style(){
	wp_register_style( 'learning_wrapper_css_admin', plugins_url( '/css/learning_wrapper_admin.css', __FILE__ ));
 	wp_enqueue_style( 'learning_wrapper_css_admin' );
}


/*Adds Wrapper Metabox*/
	function register_metabox (){
 		add_meta_box(  
        "video_wrapper", // $id  
        "Add your Video Wrapper", // $title   
        "video_wrapper", // $callback  
        "Learning_Wrapper", // $page  
        "normal", // $context  
        "high"//$priority
		); 
		add_meta_box( 'repeatable-fields', 'Audio Playlist', 'repeatable_meta_box_display', 'Learning_Wrapper', 'normal', 'high');

 	
		} 

/*Video Wrapper Metabox*/
function video_wrapper() {

global $post;
 wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
        $prfx_stored_meta = get_post_meta( $post->ID );
        ?>

        <p>
                <label for="meta-text" class="prfx-row-title"><?php _e( 'Menu title', 'prfx-textdomain' )?></label>
                <input type="text" name="video-wrapper-title" id="meta-text" value="<?php if ( isset ( $prfx_stored_meta['video-wrapper-title'] ) ) echo $prfx_stored_meta['video-wrapper-title'][0]; ?>" />
</p>
  
                <label for="meta-select" class="prfx-row-title"><?php _e( 'Select icons', 'prfx-textdomain' )?></label>
                <select name="video-icon-select" id="meta-select-icon">
                        <option value="icon-play" <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-play' ); ?>>	<?php _e( 'Play Button', 'prfx-textdomain' )?></option>';
                        <option value="icon-check" <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-check' ); ?>><?php _e( 'Checkbox', 'prfx-textdomain' )?></option>';
                          <option value="icon-book" <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-book' ); ?>><?php _e( 'Book', 'prfx-textdomain' )?></option>';
                  <option value="icon-comment" <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-comment' ); ?>><?php _e( 'Comment', 'prfx-textdomain' )?></option>';          
                   <option value="icon-pencil" <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-pencil' ); ?>><?php _e( 'Pencil', 'prfx-textdomain' )?></option>';          
                    <option value="icon-mail" <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-mail' ); ?>><?php _e( 'Mail', 'prfx-textdomain' )?></option>';          
                   <option value="icon-signal" <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-signal' ); ?>><?php _e( 'Signal', 'prfx-textdomain' )?></option>';          
                    <option value="icon-other" <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-other' ); ?>><?php _e( 'Other', 'prfx-textdomain' )?></option>';          
             
                </select>
                
                
        </p>
<p><div class="icon_manual">


Add the icon manually here: <label for="meta-text" class="prfx-row-title"><?php _e( 'Menu title', 'prfx-textdomain' )?></label>
            
  <input type="text" name="video-icon-text" id="meta-text" value="<?php if ( isset ( $prfx_stored_meta['video-icon-text'] ) ) echo $prfx_stored_meta['video-icon-text'][0]; ?> " />

</div>
</p>


	 
                <?php

?>
</p>       
<?php


var_dump($prfx_stored_meta['video-wrapper-title']);

var_dump($prfx_stored_meta['video-icon-select']);
var_dump($prfx_stored_meta['video-icon-text']);

}

/**repeatable custommetabox test*/


function repeatable_meta_box_display() {
	global $post;
 
	$repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);
 
 
	wp_nonce_field( 'repeatable_meta_box_nonce', 'repeatable_meta_box_nonce' );
?>
	
 
	<div id="repeatable-fieldset-one" width="100%">
	<?php
 
	if ( $repeatable_fields ) :
 
		foreach ( $repeatable_fields as $field ) {
?>
<ul>	<div class="sort">Wrapper</a></div>

		<li> <b>Title:</b> <input type="text" class="widefat" name="wrapper-title[]" value="<?php if($field['wrapper-title'] != '') echo esc_attr( $field['wrapper-title'] ); ?>" /></li>
 
		<li><input type="text" class="widefat" name="wrapper-icon[]" value="<?php if ($field['wrapper-icon'] != '') echo esc_attr( $field['wrapper-icon'] );  ?>" /></li>
				<li><a class="button remove-row" href="#">Remove the Wrapper</a></li>

	</ul>	<?php
		}
	else :
		// show a blank one
?>
	<ul>
    <div class="sort">Wrapper</div>

		<li><input type="text" class="widefat" name="wrapper-title[]" /></li>
 
 
		<li><input type="text" class="widefat" name="wrapper-icon[]" value="http://" /></li>
				<li><a class="button remove-row" href="#">Remove</a></li>

	</ul>
	<?php endif; ?>
 
	<!-- empty hidden one for jQuery -->

	<ul class="empty-row screen-reader-text">
     <div class="sort">Wrapper</a></div>

		<li><input type="text" class="widefat" name="wrapper-title[]" /></li>
 
 
		<li><input type="text" class="widefat" name="wrapper-icon[]" value="http://" /></li>
				<li><a class="button remove-row" href="#">Remove</a></li>

	</ul>
	
 
	<p><a id="add-row" class="button" href="#">Add another Wrapper</a>
	<input type="submit" class="metabox_submit" value="Save" />
	</p>
	    </div>
        
<?php

	var_dump ($field['wrapper-title']);
	var_dump ($field['wrapper-icon']);
					  

}
 


/*Saves Wrapper Metabox*/  
	
function wrapper_prfx_meta_save( $post_id ) {
 
        // Checks save status
        $is_autosave = wp_is_post_autosave( $post_id );
        $is_revision = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
        // Exits script depending on save status
        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
                return;
        }
 
        // Checks for input and sanitizes/saves if needed
        if( isset( $_POST[ 'video-wrapper-title' ] ) ) {
                update_post_meta( $post_id, 'video-wrapper-title', sanitize_text_field( $_POST[ 'video-wrapper-title' ] ) );
        }
		if( isset( $_POST[ 'video-icon-text' ] ) )  {
                update_post_meta( $post_id, 'video-icon-text', sanitize_text_field( $_POST[ 'video-icon-text' ] ) );
        }
		
	
/*Saves dropdown menu save data */	

 // Checks for input and saves if needed
        if( isset( $_POST[ 'video-icon-select' ] ) ) {
                update_post_meta( $post_id, 'video-icon-select', $_POST[ 'video-icon-select' ] );
        }

	
	
}
add_action('save_post', 'repeatable_meta_box_save');
function repeatable_meta_box_save($post_id) {
	if ( ! isset( $_POST['repeatable_meta_box_nonce'] ) ||
		! wp_verify_nonce( $_POST['repeatable_meta_box_nonce'], 'repeatable_meta_box_nonce' ) )
		return;
 
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
 
	if (!current_user_can('edit_post', $post_id))
		return;
 
	$old = get_post_meta($post_id, 'repeatable_fields', true);
	$new = array();
 
 
	$wrappertitles = $_POST['wrapper-title'];
	$wrappericons = $_POST['wrapper-icon'];
 
	$count = count( $wrappertitles );

 
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $wrappertitles[$i] != '' ) :
			$new[$i]['wrapper-title'] = stripslashes( strip_tags( $wrappertitles[$i] ) );
 
 if ( $wrappericons[$i] == '' )
			$new[$i]['wrapper-icon'] = '';
		else
			$new[$i]['wrapper-icon'] = stripslashes( $wrappericons[$i] ); // and however you want to sanitize
		endif;
	}
 
	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'repeatable_fields', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'repeatable_fields', $old );
}



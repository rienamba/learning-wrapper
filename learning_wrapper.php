<?php 
/*
Plugin Name: Learning Wrapper Plugin
Description: Adds a Custom post type "Learning Wrapper", 
Author: Rie
Version: 1.0
Author URI: http://ctlt.ubc.ca
*/
/* Creates Custom Post "Learning Wrapper*/





/*
Register Custom Post Type
*/
add_action( 'init', 'ctlt_lwp_register_custom_post_type' );

/*
Display Metabox
*/
add_filter('the_content','ctlt_lwp_display_metabox');

/*
Register CSS and Scripts
*/
add_action("admin_init","ctlt_lwp_register_scripts");
add_action("admin_print_styles","ctlt_lwp_register_style");
/*
Register Metabox
*/
add_action("admin_init", "ctlt_lwp_register_metabox");

/*
Saves Custom field
*/
add_action('save_post', 'ctlt_lwp_save_metabox', 1, 2); 

/*
Function - Register Custom Post Type
*/


function ctlt_lwp_register_custom_post_type() {

    $labels = array(
        'name'              => 'Learning Wrapper',
        'singular_name'     => 'Learning Wrapper',
        'add_new'           => 'Add New Learning Wrapper',
        'add_new_item'      => 'Add New Learning Wrapper',
        'edit_item'         => 'Edit Learning Wrapper',
        'new_item'          => 'New Learning Wrapper',
        'view_item'         => 'View Learning Wrapper',
        'search_items'      => 'Search Learning Wrapper',
        'parent_item_colon' => ''
    );

    $args = array(
        'labels'            => $labels,
        'public'            => false,
        'publicly_queryable'=> true,
        'show_ui'           => true,
        'query_var'         => true,
        'rewrite'           => true,
        'capability_type'   => 'post',
        'hierarchical'      => false,
        'menu_position'     => null,
        'supports'          => array('title','thumbnail')
    );

    $category_args = array(
        "hierarchical"      => true,
        "label"             => "Category",
        "singular_label"    => "Category",
        "rewrite"           => true
    );

    register_post_type( 'learning-wrapper' , $args );
    # register_taxonomy( "Category" , array( "Learning_Wrapper" ), $category_args );

}

/*
Function - Display Metabox
*/

function ctlt_lwp_display_metabox($content) {
    global $post;
    echo '<pre>';
    //print_r($post);
    $post_meta = get_post_meta($post->ID);
    var_dump($post_meta);
    echo '</pre>';
    return $post_meta['_video_title'][0];
}




/*
Function - Register scripts
*/
function ctlt_lwp_register_scripts(){
    wp_register_script('learning_wrapper_js_admin', plugins_url('js/learning_wrapper_admin.js', __FILE__), array('jquery'));
    wp_register_script('quicktags_js', includes_url('js/quicktags.js', __FILE__), array('jquery'));

    wp_enqueue_script('learning_wrapper_js_admin');
	wp_enqueue_script('quicktags_js');
}

/*
Function - Enqueue Admin Custom Post Type CSS 
*/

function ctlt_lwp_register_style(){
    wp_register_style( 'learning_wrapper_css_admin', plugins_url( '/css/learning_wrapper_admin.css', __FILE__ ));
    wp_enqueue_style( 'learning_wrapper_css_admin' );
}


/*
Function - Adds Learning Wrapper Metabox 
*/
function ctlt_lwp_register_metabox(){
    
    add_meta_box(  
        "video_wrapper", // $id  
        "Add your Video Wrapper", // $title   
        "ctlt_lwp_video_wrapper", // $callback  
        "learning-wrapper", // $post_type  
        "normal", // $context  
        "high"//$priority
    ); 
    
    $post_id = ( isset( $_GET['post']) ? (int)$_GET['post'] : false );
     $learning_wappers = null;
    if( $post_id ) {
          $learning_wappers = get_post_meta( $post_id, 'learning-wrapper', true );
    }
    
    $counter = 0;
    if( is_array( $learning_wappers ) ) {
        foreach( $learning_wappers as $wapper ){

             add_meta_box(  
                "content_wrapper_".$counter, // $id  
                "Content Wrapper", // $title   
                "ctlt_lwp_content_wrapper", // $callback  
                "learning-wrapper", // $post_type  
                "normal", // $context  
                "high",//$priority
                array( 'data' => $wapper, 'id' => $counter )
            );

            $counter++;
        }
    }
   


    

    if( $post_id && get_transient(  "add-content-wrapper".$post_id ) ) {
       // echo "hey";
        add_meta_box(  
            "content_wrapper_".$counter, // $id  
            "Content Wrapper", // $title   
            "ctlt_lwp_content_wrapper", // $callback  
            "learning-wrapper", // $post_type  
            "normal", // $context  
            "high",//$priorit
            array( 'id' => $counter )
        );
    }


    add_meta_box(  
        "content_wrapper", // $id  
        "Add --- Content Wrapper", // $title   
        "ctlt_lwp_add_additional_metabox", // $callback  
        "learning-wrapper", // $post_type  
        "normal", // $context  
        "high"//$priority
    );



}

function ctlt_lwp_content_wrapper( $post, $meta_data ){
    $num = $meta_data['args']['id'];
    $data = ( isset( $meta_data['args']['data'])  ? $meta_data['args']['data'] : ''); 

    ?>
    <input value="<?php echo esc_attr(  $data ); ?>" name="learning-wrapper[<?php echo esc_attr( $num ); ?>]" type="text" /><br />
    content wapper <?php echo  $num;
    


}		
/*
Function - Adds Learning Wrapper Metabox - For Video 
*/
function ctlt_lwp_video_wrapper() {

    global $post;
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>
    hello
    <p>
    <label for="meta-text" >
    <?php _e( 'Menu title', 'prfx-textdomain' )?></label>
    <input type="text" name="video-wrapper-title" id="meta-text" 
    value="<?php if ( isset ( $prfx_stored_meta['video-wrapper-title'] ) ) 
    echo $prfx_stored_meta['video-wrapper-title'][0]; ?>" />
    </p>

    <label for="meta-select" <?php _e( 'Select icons', 'prfx-textdomain' )?></label>
    <select name="video-icon-select" id="meta-select-icon">
    <option value="icon-play" 
    <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-play' );
    ?>> 
    <?php _e( 'Play Button', 'prfx-textdomain' )?></option>';
    <option value="icon-check" 
        <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-check' ); ?>>
        <?php _e( 'Checkbox', 'prfx-textdomain' )?></option>';
    <option value="icon-book"
        <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-book' ); ?>>
        <?php _e( 'Book', 'prfx-textdomain' )?></option>';
    <option value="icon-comment" 
        <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-comment' ); ?>>
        <?php _e( 'Comment', 'prfx-textdomain' )?></option>';          
    <option value="icon-pencil"
        <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-pencil' ); ?>>
        <?php _e( 'Pencil', 'prfx-textdomain' )?></option>';          
    <option value="icon-mail" 
        <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-mail' ); ?>>
        <?php _e( 'Mail', 'prfx-textdomain' )?></option>';          
    <option value="icon-signal" 
        <?php if ( isset ( $prfx_stored_meta['video-icon-select'] ) ) selected( $prfx_stored_meta['video-icon-select'][0], 'icon-signal' ); ?>>
        <?php _e( 'Signal', 'prfx-textdomain' )?></option>';          
             
    </select>



    <?php 

}

function ctlt_lwp_add_additional_metabox($post_id, $new){
    
    ?> 
    <input type="submit" class="button" value="Add Content Wrapper" name="another_content_wrapper" />
    <?php
}

/**
 * Saves Learning Wrapper Metabox
 */  

function ctlt_lwp_save_metabox( $post_id ) {
 
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
                
    /**
     * Saves Learning Wrapper Metabox - save the dropdown menu
     */
    

    if( isset( $_POST[ 'learning-wrapper' ] ) ){
          update_post_meta( $post_id, 'learning-wrapper', $_POST[ 'learning-wrapper' ] );

    }
  

 // Checks for input and saves if needed
    if( isset( $_POST[ 'video-icon-select' ] ) ) {
    update_post_meta( $post_id, 'video-icon-select', $_POST[ 'video-icon-select' ] );
        }
    if( isset( $_POST['another_content_wrapper'] ) ){ 
        set_transient( "add-content-wrapper".$post_id, true, 5 ); // 5 minutes
    } else {
        // delete transinet 
        delete_transient( "add-content-wrapper".$post_id );
    }
}
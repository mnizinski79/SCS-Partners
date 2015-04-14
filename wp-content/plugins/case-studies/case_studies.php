<?php
   /*
   Plugin Name: Case Study Custom Post Type  
   Description: a plugin to create a custom post type called "case study"
   Version: 1.2
   Author: Amy Lashley
   Author URI: http://amylashley.net
   License: GPL2
   */

function my_custom_post_case_study() {
  $args = array();

  $labels = array(
    'name'               => _x( 'Case Studies', 'post type general name' ),
    'singular_name'      => _x( 'Case Study', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'case-study' ),
    'add_new_item'       => __( 'Add New Case Study' ),
    'edit_item'          => __( 'Edit Case Study' ),
    'new_item'           => __( 'New Case Study' ),
    'all_items'          => __( 'All Case Studies' ),
    'view_item'          => __( 'View Case Study' ),
    'search_items'       => __( 'Search Case Studies' ),
    'not_found'          => __( 'No case studies found' ),
    'not_found_in_trash' => __( 'No case studies found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Case Studies'
  );

  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our case studies and case study specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'taxonomies' => array('category', 'post_tag'),
      
  );

  register_post_type( 'case-study', $args ); 
}

add_action( 'init', 'my_custom_post_case_study' );

/*add_action( 'add_meta_boxes', 'event_date_box' );
function event_date_box() {
    add_meta_box( 
        'event_date_box',
        __( 'Event Date', 'myplugin_textdomain' ),
        'event_date_box_content',
        'event',
        'normal',
        'high'
    );
}

function event_date_box_content( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'event_date_box_content_nonce' );
  $value = get_post_meta( $post->ID, 'event_date', true );
  echo '<label for="event_date">Event Date</label>';
  echo '&nbsp;<input type="text" id="event_date" name="event_date" placeholder="Enter a Date " value="'.$value.'"/>';
}

add_action( 'save_post', 'event_date_box_save' );
add_action( 'save_post', 'event_date_box_save' );
function event_date_box_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['event_date_box_content_nonce'], plugin_basename( __FILE__ ) ) )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $event_date = $_POST['event_date'];
  update_post_meta( $post_id, 'event_date', $event_date );
}
 * 
 */
?>
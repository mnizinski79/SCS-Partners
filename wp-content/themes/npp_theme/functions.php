<?php

//include('includes/npp_meta_boxs.php');

/*************WPALCHEMY META BOXES***************************/

include_once WP_CONTENT_DIR.'/wpalchemy/MetaBox.php';   
include_once WP_CONTENT_DIR.'/wpalchemy/MediaAccess.php';


 $wpalchemy_media_access = new WPAlchemy_MediaAccess();

  $npp_content_blocks = new WPAlchemy_MetaBox(array(
    'id' => '_npp_custom_content_meta',
    'title' => 'NPP Custom Content Blocks',
    'template' => dirname ( __FILE__ ). '/metaboxes/npp-custom-content.php',
    'init_action' => 'kia_metabox_init', 
    'save_filter' => 'kia_repeating_save_filter',
    /*'view' => WPALCHEMY_VIEW_START_CLOSED,*/
  ));





/* 
 * Sanitize the input similar to post_content
 * @param array $meta - all data from metabox
 * @param int $post_id
 * @return array
 */
function kia_repeating_save_filter( $meta, $post_id ){

  if ( is_array( $meta ) && ! empty( $meta ) ){

    array_walk( $meta, function ( &$item, $key ) { 
      if( isset( $item['textarea'] ) ){
        $item['textarea'] = sanitize_post_field( 'post_content', $item['textarea'], $post_id, 'db' );
        }

    } );

  }

  return $meta;

}


// important: note the priority of 99, the js needs to be placed after tinymce loads
add_action('admin_print_footer_scripts','my_admin_print_footer_scripts',99);

/* 
 * Enqueue styles and scripts specific to metaboxs
 */
function kia_metabox_init(){
  
  // I prefer to enqueue the styles only on pages that are using the metaboxes
  wp_enqueue_style( 'wpalchemy-metabox', get_stylesheet_directory_uri() . '/metaboxes/meta.css');

  //make sure we enqueue some scripts just in case ( only needed for repeating metaboxes )
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'jquery-ui-core' );
  wp_enqueue_script( 'jquery-ui-widget' );
  wp_enqueue_script( 'jquery-ui-mouse' );
  wp_enqueue_script( 'jquery-ui-sortable' );

  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
  
  // special script for dealing with repeating textareas- needs to run AFTER all the tinyMCE init scripts, so make 'editor' a requirement
 // wp_enqueue_script( 'kia-metabox', get_stylesheet_directory_uri() . '/metaboxes/kia-metabox' . $suffix . '.js', array( 'jquery', 'word-count', 'editor', 'quicktags', 'wplink', 'wp-fullscreen', 'media-upload' ), '1.1', true );
  wp_enqueue_script( 'kia-metabox', get_stylesheet_directory_uri() . '/metaboxes/kia-metabox.js', array( 'jquery', 'word-count', 'editor', 'quicktags', 'wplink', 'wp-fullscreen', 'media-upload' ), '1.1', true );
  
}

function kia_metabox_scripts(){
  wp_print_scripts('kia-metabox');
}

/* 
 * Recreate the default filters on the_content
 * this will make it much easier to output the meta content with proper/expected formatting
*/
add_filter( 'meta_content', 'wptexturize'        );
add_filter( 'meta_content', 'convert_smilies'    );
add_filter( 'meta_content', 'convert_chars'      );
add_filter( 'meta_content', 'wpautop'            );
add_filter( 'meta_content', 'shortcode_unautop'  );
add_filter( 'meta_content', 'prepend_attachment' );
add_filter( 'meta_content', 'do_shortcode');



/*************END WPALCHEMY META BOXES***************************/




register_nav_menus(
    array(
    'primary-menu' => __( 'Primary Menu' ),
    'secondary-menu' => __( 'Secondary Menu' ),
    'ancilary-menu' => __( 'Ancilary Menu' )
    )
);


function custom_excerpt_length( $length ) {
	return 20;
}

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


add_theme_support( 'post-thumbnails' );

/*
* Switch default core markup for search form, comment form, and comments
* to output valid HTML5.
*/
add_theme_support( 'html5', array(
	'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
) );

function get_my_header() {
	if( !is_front_page() ) {
         
        global $post;
        $post_type = get_post_type($post);
        
        if ($post_type!='post'){
            get_header($post_type);
        }else {
            get_header();
        }
        
    } else {
        get_header();
    }// ends isset()
   
} // ends get_myheader function

// Let's hook in our function with the javascript files with the wp_enqueue_scripts hook 
//Making jQuery Google API
function modify_jquery() {
    if (!is_admin()) {
        // comment out the next two lines to load the local copy of jQuery
        wp_deregister_script('jquery');
        wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, '1.10.2');
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'modify_jquery');
 
add_action( 'wp_enqueue_scripts', 'npp_load_javascript_files' );
 
// Register some javascript files, because we love javascript files. Enqueue a couple as well 
 
function npp_load_javascript_files() {
   
        //<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        //<script src="js/plugins.js"></script>
 
  wp_register_script( 'npp-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'));
    
  wp_register_script( 'npp-respond', get_template_directory_uri() . '/js/respond.min.js', array('jquery'));
    
  wp_register_script( 'npp-datepicker', get_template_directory_uri() . '/js/datepicker.js', array('jquery'));
  wp_register_script( 'npp-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'));
  wp_register_script( 'npp-hammer', get_template_directory_uri() . '/js/jquery.hammer.js', array('jquery'));
  wp_register_script( 'npp-chosen', get_template_directory_uri() . '/js/chosen.jquery.js', array('jquery'));
    
  wp_register_script( 'npp-main', get_template_directory_uri() . '/js/src/main.js', array('jquery'));
    
  wp_enqueue_script('npp-plugins');
  wp_enqueue_script('npp-respond');
  wp_enqueue_script('npp-datepicker');
  wp_enqueue_script('npp-easing');
  wp_enqueue_script('npp-hammer');
  wp_enqueue_script('npp-chosen');
  wp_enqueue_script('npp-main');
 
}

//Custom Search Functionality
function search_template_chooser($template)   
{    

  global $wp_query;   
  $post_type = get_query_var('post_type');   
  if( $wp_query->is_search && $post_type == 'position' )   
  {
   
    return locate_template('search-position.php');  //  redirect to archive-search.php
  }   
  return $template;   
}
add_filter('template_include', 'search_template_chooser');  


/**
 * Register our sidebars and widgetized areas.
 *
 */
function npp_widgets_init() {

  register_sidebar( array(
    'name' => 'Default Right Sidebar',
    'id' => 'default_right_1',
    'before_widget' => '<div>',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ) );

  register_sidebar( array(
    'name' => 'Search Sidebar',
    'id' => 'search_sidebar',
    'before_widget' => '<div>',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ) );

  register_sidebar( array(
    'name' => 'Category Sidebar',
    'id' => 'category_sidebar',
    'before_widget' => '<div>',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ) );

   register_sidebar( array(
    'name' => 'Jobs Sidebar',
    'id' => 'jobs_sidebar',
    'before_widget' => '<div>',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ) );
}
add_action( 'widgets_init', 'npp_widgets_init' );


// update the '51' to the ID of your form
add_filter('gform_pre_render_1', 'populate_jobs');
function populate_jobs($form){
    
    foreach($form['fields'] as &$field){
        if($field['type'] != 'select' || strpos($field['cssClass'], 'populate-posts') === false)
            continue;

        
        // you can add additional parameters here to alter the posts that are retreieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        $posts = get_posts('numberposts=-1&post_status=publish&post_type=job_listing');
        
        // update 'Select a Post' to whatever you'd like the instructive option to be
        $choices = array(array('text' => 'Job Interested In', 'value' => ' '));
        
        foreach($posts as $post){
            $position_company = $post->_company_name;
            
            if($position_company != ""){
                $choices[] = array('text' => $post->post_title, 'value' => $post->post_title);
            }
        }
        
        $field['choices'] = $choices;
        
    }
    
    return $form;
}

function my_admin_print_footer_scripts()
{
    ?>
    <script type="text/javascript">/* <![CDATA[ */

        jQuery(function($)
        {
         
          /*some crazy js shiz because jquery wont work on our auto-created dom elements*/
         $(document).click(function(event) {
          var className = event.target.className;
          var myName = event.target.name;
          var myValue = event.target.value;
          

         if (className =='r-ex2'){
          $('[name="'+myName+'"]').closest('table').siblings('.no-cols').val(myValue);
          $('[name="'+myName+'"]').closest('table').siblings('.npp-branding-box').css('display','none');
           if (myValue<=6){ 
              $('[name="'+myName+'"]').closest('table').siblings('.npp-user-msg').css('display','none');
              if (myValue == 1){
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-0').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-1').css('display','none');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-2').css('display','none');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-3').css('display','none');
              } else if (myValue == 2 || myValue == 5 || myValue == 6){
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-0').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-1').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-2').css('display','none');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-3').css('display','none');
              }else if (myValue == 3){
                //console.log("we should be showing 3!!");
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-0').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-1').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-2').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-3').css('display','none');
              }else if (myValue ==4){
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-0').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-1').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-2').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('#customEditor-3').css('display','block');
                $('[name="'+myName+'"]').closest('table').siblings('.npp-branding-box').css('display','none');
              }
           }else{
               switch (myValue) { 
                case '7': 
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-user-msg').html("You have selected to show the 'Related Content' carousel.");
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-branding-box').css('display','none');                    
                    break;
                case '8': 
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-user-msg').html("You have selected to show the 'Child Pages' grid.");
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-branding-box').css('display','none');
                    break;
                case '9': 
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-user-msg').css('display','none');
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-branding-box').css('display','block');
                    break;      
                case '10': 
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-user-msg').html("You have selected to show the 'Find Positions' component.");
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-branding-box').css('display','none');
                    break;
                case '11': 
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-user-msg').html("You have selected to show the 'Become a Partner' component.");
                    $('[name="'+myName+'"]').closest('table').siblings('.npp-branding-box').css('display','none');
                    break;
                default:
                    //alert('Nobody Wins!');
                }
                  $('[name="'+myName+'"]').closest('table').siblings('#customEditor-0').css('display','none');
                  $('[name="'+myName+'"]').closest('table').siblings('#customEditor-1').css('display','none');
                  $('[name="'+myName+'"]').closest('table').siblings('#customEditor-2').css('display','none');
                  $('[name="'+myName+'"]').closest('table').siblings('#customEditor-3').css('display','none');
                  $('[name="'+myName+'"]').closest('table').siblings('.npp-user-msg').css('display','block');
           }
         }else {
          //console.log("something else");
         }
        
            
        });  //end event.target stuff
       

          $.each($('.no-cols'), function(index, value){        
             switch ($(this).val()) { 
            case '1':
                  $(this).siblings('#customEditor-0').css('display','block');
                  $(this).siblings('#customEditor-1').css('display','none');
                  $(this).siblings('#customEditor-2').css('display','none');
                  $(this).siblings('#customEditor-3').css('display','none');
              break;
            case '2':
            case '5':
            case '6':
                  $(this).siblings('#customEditor-0').css('display','block');
                  $(this).siblings('#customEditor-1').css('display','block');
                  $(this).siblings('#customEditor-2').css('display','none');
                  $(this).siblings('#customEditor-3').css('display','none');
              break;
            case '3':
                  $(this).siblings('#customEditor-0').css('display','block');
                  $(this).siblings('#customEditor-1').css('display','block');
                  $(this).siblings('#customEditor-2').css('display','block');
                  $(this).siblings('#customEditor-3').css('display','none');
              break;
            case '4':
                  $(this).siblings('#customEditor-0').css('display','block');
                  $(this).siblings('#customEditor-1').css('display','block');
                  $(this).siblings('#customEditor-2').css('display','block');
                  $(this).siblings('#customEditor-3').css('display','block');
               break;
            case '7': 
                  $(this).siblings('#customEditor-0').css('display','none');
                  $(this).siblings('#customEditor-1').css('display','none');
                  $(this).siblings('#customEditor-2').css('display','none');
                  $(this).siblings('#customEditor-3').css('display','none');
                  $(this).next().html("You have selected to show the 'Related Content' carousel.");
                  $(this).next().css('display','block');
                break;
            case '8': 
                  $(this).siblings('#customEditor-0').css('display','none');
                  $(this).siblings('#customEditor-1').css('display','none');
                  $(this).siblings('#customEditor-2').css('display','none');
                  $(this).siblings('#customEditor-3').css('display','none');
                  $(this).next().html("You have selected to show the 'Child Pages' grid.");
                  $(this).next().css('display','block');
                break;
            case '9':  //branding box
                  $(this).siblings('#customEditor-0').css('display','none');
                  $(this).siblings('#customEditor-1').css('display','none');
                  $(this).siblings('#customEditor-2').css('display','none');
                  $(this).siblings('#customEditor-3').css('display','none');
                  $(this).next().html("You have selected to show the 'Marketing Message' component.");
                  $(this).next().css('display','none');
                  $(this).siblings('.npp-branding-box').css('display','block');
                break;      
            case '10': 
                  $(this).siblings('#customEditor-0').css('display','none');
                  $(this).siblings('#customEditor-1').css('display','none');
                  $(this).siblings('#customEditor-2').css('display','none');
                  $(this).siblings('#customEditor-3').css('display','none');
                  $(this).next().html("You have selected to show the 'Find Positions' component.");
                  $(this).next().css('display','block');
                break;
            case '11': 
                  $(this).siblings('#customEditor-0').css('display','none');
                  $(this).siblings('#customEditor-1').css('display','none');
                  $(this).siblings('#customEditor-2').css('display','none');
                  $(this).siblings('#customEditor-3').css('display','none');
                  $(this).next().html("You have selected to show the 'Become a Partner' component.");
                  $(this).next().css('display','block');
                break;
            default:              
                $(this).siblings('#customEditor-0').css('display','block');
                 $(this).siblings('#customEditor-1').css('display','none');
                  $(this).siblings('#customEditor-2').css('display','none');
                  $(this).siblings('#customEditor-3').css('display','none');
                break;
            }
             
          });
       
           
           
        });
    /* ]]> */</script><?php
}


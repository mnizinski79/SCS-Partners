<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
function theme_enqueue_scripts() {
  wp_register_script('scsp-main', get_stylesheet_directory_uri() . '/js/scsp-main.js', array('jquery'));
  wp_enqueue_script('scsp-main'); 
}

include_once WP_CONTENT_DIR.'/wpalchemy/MetaBox.php';   
include_once WP_CONTENT_DIR.'/wpalchemy/MediaAccess.php';

 $wpalchemy_media_access = new WPAlchemy_MediaAccess();

  $npp_content_blocks = new WPAlchemy_MetaBox(array(
    'id' => '_npp_custom_content_meta',
    'title' => 'NPP Custom Content Blocks',
    'template' => dirname ( __FILE__ ). '/metaboxes/npp-custom-content.php',
    'init_action' => 'kia_metabox_init', 
    'types' => array('page','case-study'),
    'save_filter' => 'kia_repeating_save_filter',
    /*'view' => WPALCHEMY_VIEW_START_CLOSED,*/
  ));


?>
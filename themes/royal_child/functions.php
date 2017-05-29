<?php

/*
|----------------------------------------------------
|  Framework: Require once to clean up WordPress
|----------------------------------------------------
*/

require_once("cleanup.php");

/*
|----------------------------------------------------
|  Framework: Hide metaboxes
|----------------------------------------------------
*/
	
function generate_remove_metaboxes()
{
    remove_action('add_meta_boxes', 'generate_add_layout_meta_box');
    remove_action('add_meta_boxes', 'generate_add_footer_widget_meta_box');
    //remove_action('add_meta_boxes', 'generate_add_de_meta_box');
    remove_action('add_meta_boxes', 'generate_add_page_builder_meta_box');
}
add_action( 'after_setup_theme','generate_remove_metaboxes' );

/*
|----------------------------------------------------
|  WordPress: Remove and/or Rename userrole(s)
|----------------------------------------------------
*/

// Remove Role: Subscriber / Abonnee
if( get_role('subscriber') ){
      remove_role( 'subscriber' );
}

// Remove Role: Author / Auteur
if( get_role('author') ){
      remove_role( 'author' );
}

// Remove Role: Contributor / Schrijver
if( get_role('contributor') ){
      remove_role( 'contributor' );
}

// Remove Role: BackWPup-beheerder
if( get_role('backwpup_admin') ){
      remove_role( 'backwpup_admin' );
}

// Remove Role: BackWPup taken-controle
if( get_role('backwpup_check') ){
      remove_role( 'backwpup_check' );
}

// Remove Role: BackWPup takenhulp
if( get_role('backwpup_helper') ){
      remove_role( 'backwpup_helper' );
}

// Rename userrole(s)
function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can list all currently available roles like this...
    //$roles = $wp_roles->get_names();
    //echo '<pre>',print_r($roles),'</pre>';

    //Default roles are: "administrator", "editor", "author", "contributor" or "subscriber"...
    $wp_roles->roles['administrator']['name'] = 'Webmaster';
    $wp_roles->role_names['administrator'] = 'Webmaster';
    
    $wp_roles->roles['editor']['name'] = 'Beheer';
    $wp_roles->role_names['editor'] = 'Beheer';
    
}
add_action('init', 'change_role_name');

/*
|----------------------------------------------------
|  Page Builder: Disable generation of css files
|----------------------------------------------------
*/

function wbe_filter_widget_css( $css, $instance, $widget ){
}
add_filter('siteorigin_widgets_instance_css', 'wbe_filter_widget_css', 10, 3);

/*
|----------------------------------------------------
|  Page Builder: Add css to hide forbidden options
|----------------------------------------------------
*/

function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');
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

/*
|----------------------------------------------------
|  WordPress: More unique slugs for attachments
|----------------------------------------------------
*/

add_filter( 'wp_unique_post_slug', 'unique_post_slug', 10, 6 );
function unique_post_slug( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug ) {
  if ( 'attachment' == $post_type )
    $slug = $original_slug . uniqid( '-' );
  return $slug;
}

/*
|----------------------------------------------------
|  WooCommerce: Change format of category loop title
|----------------------------------------------------
*/

function woocommerce_template_loop_category_title( $category ) {
?>
	<h2 class="woocommerce-loop-category__title">
		<?php
    echo $category->name;

    if ( $category->count > 0 )
      echo apply_filters( 'woocommerce_subcategory_count_html', '', $category );
  ?>
	</h2>
	<?php
}

/*
|------------------------------------------------------
|  WordPress: Change the Login Logo
|------------------------------------------------------
*/

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(/wp-content/uploads/logo.png);
            width: 320px;
            background-size: 160px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

/*
|------------------------------------------------------
|  Register custom sidebar: WooCommerce Product Filter
|------------------------------------------------------
*/

add_action( 'widgets_init', 'royal_widgets_init' );
function royal_widgets_init() {
    register_sidebar( array(
        'name' => __( 'WooCommerce Product Filter', 'royal' ),
        'id' => 'wcpf',
        'description' => __( 'Positie boven content voor WooCommerce Product Filter', 'royal' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h3 class="widgettitle">',
	'after_title'   => '</h3>',
    ) );
}

/*
|------------------------------------------------------
|  WooCommerce:  Rename 'You may also like'
|------------------------------------------------------
*/

add_filter('gettext', 'translate_like');
add_filter('ngettext', 'translate_like');
function translate_like($translated)
{
	$translated = str_ireplace('You may also like&hellip;', 'Accessoires', $translated);
	return $translated;
}

/*
|------------------------------------------------------
|  WooCommerce: Rename 'Related Products'
|------------------------------------------------------
*/

add_filter('gettext', 'translate_related');
add_filter('ngettext', 'translate_related');
function translate_related($translated)
{
	$translated = str_ireplace('Related Products', 'Same Collection', $translated);
	return $translated;
}

/*
|------------------------------------------------------
|  GeneratePress: Show Blog Page Header on WooCommerce
|------------------------------------------------------
*/

add_filter( 'generate_get_blog_page_header','woocommerce_blog_page_header' );
function woocommerce_blog_page_header() {
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        return true;
    }

    return false;
}
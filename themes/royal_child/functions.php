<?php

add_filter( 'wp_mail_from', 'my_mail_from' );
function my_mail_from( $email ) {
    return "info@royalthings.be";
}


/*
|----------------------------------------------------
|  Framework: Require once to clean up WordPress
|----------------------------------------------------
*/

require_once("cleanup.php");

/*
|------------------------------------------------------
|  WordPress: Enqueue Custom CSS & JS
|------------------------------------------------------
*/

function add_theme_scripts() {
  $theme_version = 'v1.1';
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

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
|------------------------------------------------------
|  WordPress: Remove and/or Rename userrole(s)
|------------------------------------------------------
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

// Remove Role: Translator
if( get_role('translator') ){
      remove_role( 'translator' );
}

// Rename userrole(s)
function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can list all currently available roles with:
	/*   
    $roles = $wp_roles->get_names();
    echo '<pre>',print_r($roles),'</pre>';
	*/

    //Rename roles:
    $wp_roles->roles['administrator']['name'] = 'Webmaster';
    $wp_roles->role_names['administrator'] = 'Webmaster';
    
    $wp_roles->roles['editor']['name'] = 'Beheer';
    $wp_roles->role_names['editor'] = 'Beheer';
    
}
add_action('init', 'change_role_name');

// Give editor more privileges:

    //add caps to editor role
    $role = get_role("editor");

    //for woocommerce
    $role->add_cap("manage_woocommerce");
    $role->add_cap("view_woocommerce_reports");
    $role->add_cap("edit_product");
    $role->add_cap("read_product");
    $role->add_cap("delete_product");
    $role->add_cap("edit_products");
    $role->add_cap("edit_others_products");
    $role->add_cap("publish_products");
    $role->add_cap("read_private_products");
    $role->add_cap("delete_products");
    $role->add_cap("delete_private_products");
    $role->add_cap("delete_published_products");
    $role->add_cap("delete_others_products");
    $role->add_cap("edit_private_products");
    $role->add_cap("edit_published_products");
    $role->add_cap("manage_product_terms");
    $role->add_cap("edit_product_terms");
    $role->add_cap("delete_product_terms");
    $role->add_cap("assign_product_terms");
    $role->add_cap("edit_shop_order");
    $role->add_cap("read_shop_order");
    $role->add_cap("delete_shop_order");
    $role->add_cap("edit_shop_orders");
    $role->add_cap("edit_others_shop_orders");
    $role->add_cap("publish_shop_orders");
    $role->add_cap("read_private_shop_orders");
    $role->add_cap("delete_shop_orders");
    $role->add_cap("delete_private_shop_orders");
    $role->add_cap("delete_published_shop_orders");
    $role->add_cap("delete_others_shop_orders");
    $role->add_cap("edit_private_shop_orders");
    $role->add_cap("edit_published_shop_orders");
    $role->add_cap("manage_shop_order_terms");
    $role->add_cap("edit_shop_order_terms");
    $role->add_cap("delete_shop_order_terms");
    $role->add_cap("assign_shop_order_terms");
    $role->add_cap("edit_shop_coupon");
    $role->add_cap("read_shop_coupon");
    $role->add_cap("delete_shop_coupon");
    $role->add_cap("edit_shop_coupons");
    $role->add_cap("edit_others_shop_coupons");
    $role->add_cap("publish_shop_coupons");
    $role->add_cap("read_private_shop_coupons");
    $role->add_cap("delete_shop_coupons");
    $role->add_cap("delete_private_shop_coupons");
    $role->add_cap("delete_published_shop_coupons");
    $role->add_cap("delete_others_shop_coupons");
    $role->add_cap("edit_private_shop_coupons");
    $role->add_cap("edit_published_shop_coupons");
    $role->add_cap("manage_shop_coupon_terms");
    $role->add_cap("edit_shop_coupon_terms");
    $role->add_cap("delete_shop_coupon_terms");
    $role->add_cap("assign_shop_coupon_terms");
    $role->add_cap("edit_shop_webhook");
    $role->add_cap("read_shop_webhook");
    $role->add_cap("delete_shop_webhook");
    $role->add_cap("edit_shop_webhooks");
    $role->add_cap("edit_others_shop_webhooks");
    $role->add_cap("publish_shop_webhooks");
    $role->add_cap("read_private_shop_webhooks");
    $role->add_cap("delete_shop_webhooks");
    $role->add_cap("delete_private_shop_webhooks");
    $role->add_cap("delete_published_shop_webhooks");
    $role->add_cap("delete_others_shop_webhooks");
    $role->add_cap("edit_private_shop_webhooks");
    $role->add_cap("edit_published_shop_webhooks");
    $role->add_cap("manage_shop_webhook_terms");
    $role->add_cap("edit_shop_webhook_terms");
    $role->add_cap("delete_shop_webhook_terms");
    $role->add_cap("assign_shop_webhook_terms");
    
add_action( 'admin_menu', 'remove_menu_pages', 999);
function remove_menu_pages() {
  global $current_user;
   
  $user_roles = $current_user->roles;
  $user_role = array_shift($user_roles);
  if($user_role == "editor") {
    $remove_submenu = remove_submenu_page('woocommerce', 'wc-settings');
    $remove_submenu = remove_submenu_page('woocommerce', 'wc-addons');
  }
}

// To reset default userroles remove above code and use:
/*
if ( !function_exists( 'populate_roles' ) ) {
  require_once( ABSPATH . 'wp-admin/includes/schema.php' );
}
populate_roles();
*/

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
|  WooCommerce:  Rename 'Stock labels'
|------------------------------------------------------
*/

add_filter('woocommerce_get_availability', 'custom_get_availability');
function custom_get_availability($availability)
{
$availability['availability'] = str_ireplace('Out of stock', 'Sold Out!', $availability['availability']);
$availability['availability'] = str_ireplace('Beschikbaar via nabestelling', 'Maatwerk - Op bestelling', $availability['availability']);

return $availability;
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
	$translated = str_ireplace('You may also like&hellip;', 'Accessories', $translated);
	$translated = str_ireplace('Andere suggesties&hellip;', 'Accesoires', $translated);
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
	$translated = str_ireplace('Gerelateerde producten', 'Zelfde Collectie', $translated);
	return $translated;
}

/*
|------------------------------------------------------
|  WooCommerce:  Rename 'Add to cart'
|------------------------------------------------------
*/

add_filter('gettext', 'translate_add');
add_filter('ngettext', 'translate_add');
function translate_add($translated)
{
	$translated = str_ireplace('Add to cart', 'Order Now', $translated);
	$translated = str_ireplace('In winkelmand', 'Bestel Nu', $translated);
	return $translated;
}

add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +
 
function woo_archive_custom_cart_button_text() {
 
        return __( '+', 'woocommerce' );
 
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

/*
|------------------------------------------------------
|  WordPress: activate masonary for blog
|------------------------------------------------------
*/

add_filter('generate_blog_masonry','generate_blog_enable_blog_masonry');
function generate_blog_enable_blog_masonry()
{
    // If we're on the blog
    if ( is_home() )
            return 'true';
	
        // Otherwise, disable it
	return 'false';
}

/*
|------------------------------------------------------
|  GeneratePress: Change Mark-up of Cart in Navigation
|------------------------------------------------------
*/

function custom_wc_cart_link() {
    ob_start();
    ?>
    <a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="cart-contents" title="<?php esc_attr_e( 'View your shopping cart','generate-woocommerce' ); ?>">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i> <small><?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></small>
    </a>
    <?php
    return ob_get_clean();
}

function custom_wc_menu_cart( $nav, $args ) {
    if ( $args->theme_location == 'primary' && generatepress_wc_get_setting( 'cart_menu_item' ) ) {
        return sprintf( 
            '%1$s 
            <li class="wc-menu-item %4$s" title="%2$s">
                %3$s
            </li>',
            $nav,
            esc_attr__( 'View your shopping cart','generate-woocommerce' ),
            custom_wc_cart_link(),
            is_cart() ? 'current-menu-item' : ''
        );
    }
	
    // Our primary menu isn't set, return the regular nav
    return $nav;
}

function custom_wc_mobile_cart_link() {
	if ( function_exists( 'generatepress_wc_get_setting' ) && ! generatepress_wc_get_setting( 'cart_menu_item' ) ) {
		return;
	}
	?>
	<div class="mobile-bar-items wc-mobile-cart-items">
		<?php do_action( 'generate_mobile_cart_items' ); ?>
		<?php echo custom_wc_cart_link(); ?>
	</div><!-- .mobile-bar-items -->
	<?php

}

add_action( 'after_setup_theme','remove_wc_cart_item' );
function remove_wc_cart_item() {
    remove_filter( 'wp_nav_menu_items','generatepress_wc_menu_cart', 10, 2 );
    add_filter( 'wp_nav_menu_items','custom_wc_menu_cart', 10, 2 );

    remove_action( 'generate_inside_navigation','generatepress_wc_mobile_cart_link' );
    remove_action( 'generate_inside_mobile_header','generatepress_wc_mobile_cart_link' );

    add_action( 'generate_inside_navigation','custom_wc_mobile_cart_link' );
    add_action( 'generate_inside_mobile_header','custom_wc_mobile_cart_link' );
}

/*
|------------------------------------------------------
|  WordPress: Add searchform to secondary nav
|------------------------------------------------------
*/
	
add_filter('wp_nav_menu_items','add_search_box', 10, 2);
function add_search_box($items, $args) {
	
	if( $args->theme_location == 'secondary')  {
        ob_start();
        get_search_form();
        $searchform = ob_get_contents();
        ob_end_clean();
        
        $items .= '<li class="search-item">' . $searchform . '</li>';        
    }

    return $items;
}

/*
|------------------------------------------------------
|  GeneratePress: Disable collapse of secondary nav
|------------------------------------------------------
*/
	
add_action( 'wp_enqueue_scripts', 'generate_dequeue_secondary_nav_mobile', 999 );
function generate_dequeue_secondary_nav_mobile() {
   wp_dequeue_style( 'generate-secondary-nav-mobile' );
}

/*
|------------------------------------------------------
|  GeneratePress: add extra content to slide-out
|------------------------------------------------------
*/

add_action( 'generate_inside_slideout_navigation', 'add_search_to_mobile_slideout', 999 );
function add_search_to_mobile_slideout() {
   ?>
   <div class="mobile-search"><?php get_search_form(); ?></div><?php
   wp_nav_menu( array( 'theme_location' => 'slide-out-header-menu' ) );
}

/*
|------------------------------------------------------
|  GeneratePress: create extra menu header for slide-out
|------------------------------------------------------
*/

function register_my_menu() {
  register_nav_menu('slide-out-header-menu',__( 'slide-out Header Menu' ));
}
add_action( 'init', 'register_my_menu' );	

/*
|------------------------------------------------------
|  WooCommerce Detail: Title on top
|------------------------------------------------------
*/

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );

/*
|------------------------------------------------------
|  WooCommerce Detail: Move price to bottom
|------------------------------------------------------
*/

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );

/*
|------------------------------------------------------
|  WooCommerce Detail: Display variation's price even if min and max prices are the same
|------------------------------------------------------
*/
add_filter('woocommerce_available_variation', function ($value, $object = null, $variation = null) {
  if ($value['price_html'] == '') {
    $value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
  }
  return $value;
}, 10, 3);

/*
|------------------------------------------------------
|  WooCommerce Detail: Move sale flash to price
|------------------------------------------------------
*/

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

/*
|------------------------------------------------------
|  WooCommerce Breadcrumbs: Move sale flash to price
|------------------------------------------------------
*/

add_filter( 'woocommerce_breadcrumb_defaults', 'my_change_breadcrumb_delimiter' );
function my_change_breadcrumb_delimiter( $defaults ) {
 // Change the breadcrumb delimiter from '/' to '>'
 $defaults['delimiter'] = ' &nbsp;>&nbsp; ';
 return $defaults;
}

/*
|------------------------------------------------------
|  Woocommerce: Add VAT field
|------------------------------------------------------
*/

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields');

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     $fields['billing']['billing_vat'] = array(
    'label'     => __('VAT no', 'woocommerce'),
    'placeholder'   => _x('VAT number', 'placeholder', 'woocommerce'),
    'required'  => false,
    'class'     => array('form-row-wide'),
    'clear'     => true
     );

     return $fields;
}

add_filter( 'woocommerce_checkout_fields', 'yourplugin_move_checkout_fields' );

function yourplugin_move_checkout_fields( $fields ) {
	// Author: apppresser.com

	// Move these around as necessary. You'll see we added email first.
	$billing_order = array(
		"billing_email",
		"billing_first_name", 
		"billing_last_name", 
		"billing_company",
		"billing_vat",
		"billing_address_1", 
		"billing_address_2", 
		"billing_postcode", 
		"billing_country",
		"billing_state",
		"billing_phone"
	);

	// This sets the billing fields in the order above
	foreach($billing_order as $billing_field) {
	    $billing_fields[$billing_field] = $fields["billing"][$billing_field];
	}

	$fields["billing"] = $billing_fields;

	return $fields;
}

/* Display field value on the order edit page */
 
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('VAT no From Checkout Form').':</strong> ' . get_post_meta( $order->get_id(), '_billing_vat', true ) . '</p>';
}

/*
|------------------------------------------------------
|  Woocommerce: Change Variable price
|------------------------------------------------------
*/

add_filter( 'woocommerce_variable_price_html', 'variation_price_format', 10, 2 );
 
function variation_price_format( $price, $product ) {
 
// 1. Find the minimum regular and sale prices

#Step 1: Get product varations
$available_variations = $product->get_available_variations();
$countVar = count($available_variations);

#Step 2: Create the variable product objects and get cheapest
$variations = array();
$varId;
$lowestPrice = 0;

for ($x = 0; $x < $countVar; $x++) {
    $localVar = new WC_Product_Variation( $available_variations[$x]['variation_id'] );
    $variations[$x] = $localVar;

    $normalPrice = $localVar ->regular_price;
    if (!empty($normalPrice) and $normalPrice < $lowestPrice or $lowestPrice == 0) {
        $varId = $x;
        $lowestPrice = $localVar ->regular_price;
    }
    $salePrice = $localVar ->sale_price;
    if(!empty($salePrice) and $salePrice < $lowestPrice or $lowestPrice == 0) {
        $varId = $x;
        $lowestPrice = $localVar ->sale_price;
    }
}

$cheapestVar = $variations[$varId];

// 2. New $price
if ($cheapestVar ->sale_price != 0 and $cheapestVar ->sale_price < $cheapestVar ->regular_price) {
$price = sprintf( __( '<div class="priceSaleTitle">From</div><del>%1$s</del><ins>%2$s</ins>', 'woocommerce' ), wc_price( $cheapestVar ->regular_price ), wc_price( $cheapestVar ->sale_price ) );
} else {
$price = sprintf( __( '<div class="priceTitle">From</div> %1$s', 'woocommerce' ), wc_price( $cheapestVar ->regular_price ) );
}
 
// 3. Return edited $price
 
return $price;
}

/*
|------------------------------------------------------
|  Woocommerce: Display Sold out label
|------------------------------------------------------
*/

add_action( 'woocommerce_before_shop_loop_item_title', 'display_sold_out_loop_woocommerce' );
 
function display_sold_out_loop_woocommerce() {
    global $product;
 
    if ( !$product->is_in_stock() ) {
        echo '<span class="soldout">' . __( 'Sold Out', 'woocommerce' ) . '</span>';
    }
} 

/*
|------------------------------------------------------
|  WordPress: Add URL Slugs as Body Classes
|------------------------------------------------------
*/

	// this only applies for non-admin pages
	if ( !is_admin() && !function_exists( 'add_body_class' ) ) :


		//	Add deconstructed URI as <body> classes
		//	$classes = array of classes WP is already planning to add
		function add_body_class( $classes )  {

			// get the global post variable
			global $post;

			// make sure we're on a post page
			if ($post && $post->ID) :

				// loop through any categories
				foreach( get_the_category($post->ID) as $category ) {
					// and push the trimmed version to the $classes array
					$classes[] = trim( $category->category_nicename );
				}

				// get the current page's URI (the part _after_ your domain name)
				$uri = $_SERVER["REQUEST_URI"];
				// explode that string into an array of "pieces"
				$bodyclass = explode('/',$uri);
				// loop through those pieces and push each into the $classes array
				foreach($bodyclass as $category) {
					$classes[] = trim($category);
				}

			endif; // $post...

			// return a unique-onlye version of the array to WP
			return array_unique($classes);
		
		}

		add_filter('post_class', 'add_body_class');
		add_filter('body_class', 'add_body_class');

	endif; // !is_admin...
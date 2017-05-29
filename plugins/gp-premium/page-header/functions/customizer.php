<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'generate_page_header_blog_customizer' ) ) :
/**
 * Add our page header Customizer options
 */
add_action( 'customize_register', 'generate_page_header_blog_customizer', 99 );
function generate_page_header_blog_customizer( $wp_customize )
{
	// Get our defaults
	$defaults = generate_page_header_get_defaults();
	
	// Get our custom controls
	require_once GP_LIBRARY_DIRECTORY . 'customizer-helpers.php';
	
	// Register our custom controls
	if ( method_exists( $wp_customize,'register_control_type' ) ) {
		$wp_customize->register_control_type( 'GeneratePress_Refresh_Button_Customize_Control' );
	}
	
	// Add our Blog Page Header panel
	$wp_customize->add_panel( 'generate_blog_page_header_panel', array(
		'priority'       => 40,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Blog Page Header','page-header' ),
		'description'    => ''
	) );
	
	// If we have a blog panel, use it
	// The blog panel only exists is the Blog add-on is activated
	if ( $wp_customize->get_panel( 'generate_blog_panel' ) ) {
		$blog_panel = 'generate_blog_panel';
	} else {
		$blog_panel = 'generate_blog_page_header_panel';
	}
	
	// Page Header image section
	$wp_customize->add_section(
		'page_header_blog_image_settings',
		array(
			'title' => __( 'Page Header Image','page-header' ),
			'capability' => 'edit_theme_options',
			'panel' => $blog_panel,
			'priority' => 5
		)
	);
	
	// Image
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_image]', 
		array(
			'default' => $defaults['page_header_image'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'generate_page_header_options[page_header_image]',
			array(
				'label' => __('Image','page-header'),
				'description' => __( 'Upload an image to be used as your page header.','page-header' ),
				'section' => 'page_header_blog_image_settings',
				'settings' => 'generate_page_header_options[page_header_image]'
			)
		)
	);
	
	// Image link
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_url]', 
		array(
			'default' => $defaults['page_header_url'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'generate_page_header_options[page_header_url]',
		array(
			'label' => __('Image link','page-header'),
			'description'    => __( 'Make your page header image clickable by adding a URL. (optional)','page-header' ),
			'section' => 'page_header_blog_image_settings',
			'settings' => 'generate_page_header_options[page_header_url]',
			'type' => 'text',
			'active_callback' => 'generate_page_header_blog_image_exists'
		)
	));
	
	// Image resize
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_hard_crop]', 
		array(
			'default' => $defaults['page_header_hard_crop'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_hard_crop]',
		array(
			'type' => 'select',
			'label' => __( 'Resize image','page-header' ),
			'section' => 'page_header_blog_image_settings',
			'choices' => array(
				'enable' => __( 'Enable','page-header' ),
				'disable' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_hard_crop]',
			'active_callback' => 'generate_page_header_blog_image_exists'
		)
	);
	
	// Width
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_image_width]', 
		array(
			'default' => $defaults['page_header_image_width'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'generate_page_header_options[page_header_image_width]',
		array(
			'label' => __('Image width','page-header'),
			'description'    => __( 'Choose your image width in pixels. (integer only, default is 1200)','page-header' ),
			'section' => 'page_header_blog_image_settings',
			'settings' => 'generate_page_header_options[page_header_image_width]',
			'type' => 'number',
			'active_callback' => 'generate_page_header_blog_crop_exists'
		)
	));
	
	// Height
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_image_height]', 
		array(
			'default' => $defaults['page_header_image_height'],
			'type' => 'option',
			'sanitize_callback' => 'absint',
			'transport' => 'postMessage'
		)
	);
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'generate_page_header_options[page_header_image_height]',
		array(
			'label' => __('Image height','page-header'),
			'description'    => __( 'Choose your image height in pixels. Use "0" or leave blank for proportional resizing. (integer only, default is 0) ','page-header' ),
			'section' => 'page_header_blog_image_settings',
			'settings' => 'generate_page_header_options[page_header_image_height]',
			'type' => 'number',
			'active_callback' => 'generate_page_header_blog_crop_exists'
		)
	));
	
	$wp_customize->add_control(
		new GeneratePress_Refresh_Button_Customize_Control(
			$wp_customize,
			'blog_page_header_apply_sizes',
			array(
				'section' => 'page_header_blog_image_settings',
				'label'	=> __( 'Apply image sizes','generate-blog' ),
				'priority' => 69,
				'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
				'active_callback' => 'generate_page_header_blog_crop_exists',
			)
		)
	);
	
	// Page header video section
	$wp_customize->add_section(
		'page_header_blog_video_settings',
		array(
			'title' => __( 'Page Header Video','page-header' ),
			'capability' => 'edit_theme_options',
			'panel' => $blog_panel,
			'active_callback' => 'generate_page_header_blog_content_exists',
			'priority' => 6
		)
	);
	
	// MP4 file
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_video]', 
		array(
			'default' => $defaults['page_header_video'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'generate_page_header_options[page_header_video]',
		array(
			'label' => __('Video Background URL (MP4 only)','page-header'),
			'section' => 'page_header_blog_video_settings',
			'settings' => 'generate_page_header_options[page_header_video]',
			'type' => 'text'
		)
	));
	
	// OGV file
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_video_ogv]', 
		array(
			'default' => $defaults['page_header_video_ogv'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'generate_page_header_options[page_header_video_ogv]',
		array(
			'label' => __('Video Background URL (OGV only)','page-header'),
			'section' => 'page_header_blog_video_settings',
			'settings' => 'generate_page_header_options[page_header_video_ogv]',
			'type' => 'text'
		)
	));
	
	// WEBM file
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_video_webm]', 
		array(
			'default' => $defaults['page_header_video_webm'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'generate_page_header_options[page_header_video_webm]',
		array(
			'label' => __('Video Background URL (WEBM only)','page-header'),
			'section' => 'page_header_blog_video_settings',
			'settings' => 'generate_page_header_options[page_header_video_webm]',
			'type' => 'text'
		)
	));
	
	// Video overlay color
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_video_overlay]', array(
			'default' => $defaults['page_header_video_overlay'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_video_overlay]', 
			array(
				'label' => __( 'Overlay Color','page-header' ), 
				'section' => 'page_header_blog_video_settings',
				'settings' => 'generate_page_header_options[page_header_video_overlay]'
			)
		)
	);
	
	// Content section
	$wp_customize->add_section(
		'page_header_blog_content_settings',
		array(
			'title' => __( 'Page Header Content','page-header' ),
			'capability' => 'edit_theme_options',
			'panel' => $blog_panel,
			'priority' => 7
		)
	);
	
	// Content textarea
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_content]', 
		array(
			'default' => $defaults['page_header_content'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_html'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Control(
		$wp_customize,
		'generate_page_header_options[page_header_content]',
		array(
			'label' => __('Content','page-header'),
			'description' => __( 'Add your content to the page header. HTML and shortcodes allowed.','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'settings' => 'generate_page_header_options[page_header_content]',
			'type' => 'textarea',
		)
	));
	
	// Add paragraphs
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_add_paragraphs]', 
		array(
			'default' => $defaults['page_header_add_paragraphs'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_add_paragraphs]',
		array(
			'type' => 'select',
			'label' => __( 'Add Paragraphs','page-header' ),
			'description'    => __( 'Wrap your text in paragraph tags automatically.','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'0' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_add_paragraphs]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Add padding
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_add_padding]', 
		array(
			'default' => $defaults['page_header_add_padding'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_add_padding]',
		array(
			'type' => 'select',
			'label' => __( 'Add Padding','page-header' ),
			'description'    => __( 'Add padding around your content.','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'0' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_add_padding]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Show background
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_image_background]', 
		array(
			'default' => $defaults['page_header_image_background'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_image_background]',
		array(
			'type' => 'select',
			'label' => __( 'Image Background','page-header' ),
			'description'    => __( 'Use the image uploaded above as a background image for your content. (requires image uploaded above)','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'0' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_image_background]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Add parallax
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_add_parallax]', 
		array(
			'default' => $defaults['page_header_add_parallax'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_add_parallax]',
		array(
			'type' => 'select',
			'label' => __( 'Parallax Background','page-header' ),
			'description'    => __( 'Add a cool parallax effect to your background image. (requires the image background option to be checked)','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'0' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_add_parallax]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Show full screen
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_full_screen]', 
		array(
			'default' => $defaults['page_header_full_screen'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_full_screen]',
		array(
			'type' => 'select',
			'label' => __( 'Full Screen','page-header' ),
			'description'    => __( 'Make your page header content area full screen.','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'0' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_full_screen]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Vertical center
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_vertical_center]', 
		array(
			'default' => $defaults['page_header_vertical_center'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_vertical_center]',
		array(
			'type' => 'select',
			'label' => __( 'Vertical Center','page-header' ),
			'description'    => __( 'Center your page header content vertically.','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'0' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_vertical_center]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Container type
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_container_type]', 
		array(
			'default' => $defaults['page_header_container_type'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_container_type]',
		array(
			'type' => 'select',
			'label' => __( 'Container Type','page-header' ),
			'description'    => __( 'Choose whether the page header is contained or fluid.','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'' => __( 'Contained','page-header' ),
				'fluid' => __( 'Full width','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_container_type]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Text alignment
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_text_alignment]', 
		array(
			'default' => $defaults['page_header_text_alignment'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_text_alignment]',
		array(
			'type' => 'select',
			'label' => __( 'Text Alignment','page-header' ),
			'description'    => __( 'Choose the horizontal alignment of your content.','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'left' => __( 'Left','page-header' ),
				'center'   => __( 'Center','page-header' ),
				'right'   => __( 'Right','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_text_alignment]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Padding
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_padding]', 
		array(
			'default' => $defaults['page_header_padding'],
			'type' => 'option',
			'sanitize_callback' => 'absint'
		)
	);
	
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'generate_page_header_options[page_header_padding]',
		array(
			'label' => __('Top/Bottom Padding','page-header'),
			'description' => __( 'This will add space above and below your content. (integer only) ','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'settings' => 'generate_page_header_options[page_header_padding]',
			'type' => 'text',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	));
	
	// Padding unit
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_padding_unit]', 
		array(
			'default' => $defaults['page_header_padding_unit'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_padding_unit]',
		array(
			'type' => 'select',
			'label' => __( 'Padding Unit','page-header' ),
			'section' => 'page_header_blog_content_settings',
			'choices' => array(
				'' => 'px',
				'percent'   => '%'
			),
			'settings' => 'generate_page_header_options[page_header_padding_unit]',
			'active_callback' => 'generate_page_header_blog_content_exists'
		)
	);
	
	// Background color
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_background_color]', array(
			'default' => $defaults['page_header_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_background_color]', 
			array(
				'label' => __( 'Background Color','page-header' ), 
				'section' => 'page_header_blog_content_settings',
				'settings' => 'generate_page_header_options[page_header_background_color]',
				'active_callback' => 'generate_page_header_blog_content_exists'
			)
		)
	);
	
	// Text color
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_text_color]', array(
			'default' => $defaults['page_header_text_color'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_text_color]', 
			array(
				'label' => __( 'Text Color','page-header' ), 
				'section' => 'page_header_blog_content_settings',
				'settings' => 'generate_page_header_options[page_header_text_color]',
				'active_callback' => 'generate_page_header_blog_content_exists'
			)
		)
	);
	
	// Link color
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_link_color]', array(
			'default' => $defaults['page_header_link_color'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_link_color]', 
			array(
				'label' => __( 'Link Color','page-header' ), 
				'section' => 'page_header_blog_content_settings',
				'settings' => 'generate_page_header_options[page_header_link_color]',
				'active_callback' => 'generate_page_header_blog_content_exists'
			)
		)
	);
	
	// Link color hover
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_link_color_hover]', array(
			'default' => $defaults['page_header_link_color_hover'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_link_color_hover]', 
			array(
				'label' => __( 'Link Color Hover','page-header' ), 
				'section' => 'page_header_blog_content_settings',
				'settings' => 'generate_page_header_options[page_header_link_color_hover]',
				'active_callback' => 'generate_page_header_blog_content_exists'
			)
		)
	);
	
	// Advanced settings section
	$wp_customize->add_section(
		'page_header_blog_advanced_settings',
		array(
			'title' => __( 'Page Header Advanced','page-header' ),
			'capability' => 'edit_theme_options',
			'panel' => $blog_panel,
			'active_callback' => 'generate_page_header_blog_content_exists',
			'priority' => 8
		)
	);
	
	// Merge
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_combine]', 
		array(
			'default' => $defaults['page_header_combine'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_combine]',
		array(
			'type' => 'select',
			'label' => __( 'Merge with site header','page-header' ),
			'section' => 'page_header_blog_advanced_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_combine]'
		)
	);
	
	// Use position:absolute
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_absolute_position]', 
		array(
			'default' => $defaults['page_header_absolute_position'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_absolute_position]',
		array(
			'type' => 'select',
			'label' => __( 'Place content behind header (sliders etc..)','page-header' ),
			'section' => 'page_header_blog_advanced_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_absolute_position]',
			'active_callback' => 'generate_page_header_blog_combined'
		)
	);
	
	// Site title color
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_site_title]', array(
			'default' => $defaults['page_header_site_title'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_site_title]', 
			array(
				'label' => __( 'Site title','page-header' ), 
				'section' => 'page_header_blog_advanced_settings',
				'settings' => 'generate_page_header_options[page_header_site_title]',
				'active_callback' => 'generate_page_header_blog_combined'
			)
		)
	);
	
	// Tagline color
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_site_tagline]', array(
			'default' => $defaults['page_header_site_tagline'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_site_tagline]', 
			array(
				'label' => __( 'Site tagline','page-header' ), 
				'section' => 'page_header_blog_advanced_settings',
				'settings' => 'generate_page_header_options[page_header_site_tagline]',
				'active_callback' => 'generate_page_header_blog_combined'
			)
		)
	);
	
	// Transparent navigation
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_transparent_navigation]', 
		array(
			'default' => $defaults['page_header_transparent_navigation'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_choices'
		)
	);
	
	$wp_customize->add_control(
		'generate_page_header_options[page_header_transparent_navigation]',
		array(
			'type' => 'select',
			'label' => __( 'Transparent navigation','page-header' ),
			'section' => 'page_header_blog_advanced_settings',
			'choices' => array(
				'1' => __( 'Enable','page-header' ),
				'' => __( 'Disable','page-header' )
			),
			'settings' => 'generate_page_header_options[page_header_transparent_navigation]',
			'active_callback' => 'generate_page_header_blog_combined'
		)
	);
	
	// Navigation text color
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_navigation_text]', array(
			'default' => $defaults['page_header_navigation_text'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_navigation_text]', 
			array(
				'label' => __( 'Navigation text','page-header' ), 
				'section' => 'page_header_blog_advanced_settings',
				'settings' => 'generate_page_header_options[page_header_navigation_text]',
				'active_callback' => 'generate_page_header_blog_combined'
			)
		)
	);
	
	// Navigation background hover
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_navigation_background_hover]', array(
			'default' => $defaults['page_header_navigation_background_hover'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_navigation_background_hover]', 
			array(
				'label' => __( 'Navigation background hover','page-header' ), 
				'section' => 'page_header_blog_advanced_settings',
				'settings' => 'generate_page_header_options[page_header_navigation_background_hover]',
				'active_callback' => 'generate_page_header_blog_combined'
			)
		)
	);
	
	// Navigation text hover
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_navigation_text_hover]', array(
			'default' => $defaults['page_header_navigation_text_hover'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_navigation_text_hover]', 
			array(
				'label' => __( 'Navigation text hover','page-header' ), 
				'section' => 'page_header_blog_advanced_settings',
				'settings' => 'generate_page_header_options[page_header_navigation_text_hover]',
				'active_callback' => 'generate_page_header_blog_combined'
			)
		)
	);
	
	// Navigation current background
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_navigation_background_current]', array(
			'default' => $defaults['page_header_navigation_background_current'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_navigation_background_current]', 
			array(
				'label' => __( 'Navigation background current','page-header' ), 
				'section' => 'page_header_blog_advanced_settings',
				'settings' => 'generate_page_header_options[page_header_navigation_background_current]',
				'active_callback' => 'generate_page_header_blog_combined'
			)
		)
	);
	
	// Navigation current text
	$wp_customize->add_setting(
		'generate_page_header_options[page_header_navigation_text_current]', array(
			'default' => $defaults['page_header_navigation_text_current'],
			'type' => 'option',
			'sanitize_callback' => 'generate_premium_sanitize_hex_color'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'generate_page_header_options[page_header_navigation_text_current]', 
			array(
				'label' => __( 'Navigation text current','page-header' ), 
				'section' => 'page_header_blog_advanced_settings',
				'settings' => 'generate_page_header_options[page_header_navigation_text_current]',
				'active_callback' => 'generate_page_header_blog_combined'
			)
		)
	);
	
	// Logo section
	$wp_customize->add_section(
		'page_header_blog_logo_settings',
		array(
			'title' => __( 'Page Header Logo','page-header' ),
			'capability' => 'edit_theme_options',
			'panel' => $blog_panel,
			'priority' => 9
		)
	);
	
	// Page header logo
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_logo]', 
		array(
			'default' => $defaults['page_header_logo'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'generate_page_header_options[page_header_logo]',
			array(
				'label' => __('Logo','page-header'),
				'description' => __( 'Replace your logo on the blog.','page-header' ),
				'section' => 'page_header_blog_logo_settings',
				'settings' => 'generate_page_header_options[page_header_logo]',
				'active_callback' => 'generate_page_header_logo_exists'
			)
		)
	);
	
	// Navigation logo
	$wp_customize->add_setting( 
		'generate_page_header_options[page_header_navigation_logo]', 
		array(
			'default' => $defaults['page_header_navigation_logo'],
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'generate_page_header_options[page_header_navigation_logo]',
			array(
				'label' => __('Navigation Logo','page-header'),
				'description' => __( 'Replace your navigation logo on the blog.','page-header' ),
				'section' => 'page_header_blog_logo_settings',
				'settings' => 'generate_page_header_options[page_header_navigation_logo]',
				'active_callback' => 'generate_page_header_logo_exists'
			)
		)
	);
}
endif;

if ( ! function_exists( 'generate_page_header_blog_customize_preview_css' ) ) :
/**
 * Add CSS to the Customizer
 */
add_action('customize_controls_print_styles', 'generate_page_header_blog_customize_preview_css');
function generate_page_header_blog_customize_preview_css() {
	?>
	<style>
		#accordion-section-page_header_blog_section .customize-control,
		#accordion-section-page_header_blog_section #customize-control-generate_page_header_options-page_header_background_color.customize-control-color {
			border-top: 1px solid #ddd;
			padding-top: 15px;
			margin-top: 15px;
		}
		#accordion-section-page_header_blog_section .customize-control-color {
			border: 0;
			padding: 0;
			margin: 0;
		}
	</style>
	<?php
}
endif;
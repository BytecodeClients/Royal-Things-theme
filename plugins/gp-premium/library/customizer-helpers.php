<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Controls
 */
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-information-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-backgrounds-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-refresh-button-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-alpha-color-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-copyright-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-spacing-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-range-slider-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-title-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-typography-control.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/controls/class-deprecated.php';

/**
 * Sanitization
 */
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/sanitize.php';

/**
 * Active callbacks
 */
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/active-callbacks.php';

/**
 * Deprecated functions
 */
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customizer/deprecated.php';
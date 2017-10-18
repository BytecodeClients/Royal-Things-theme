<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @Royal Things - Designed by Diederick L.
 */
 
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); ?>


	<div id="primary" <?php generate_content_class(); ?>>
		<main id="main" <?php generate_main_class(); ?>>
			<?php do_action('generate_before_main_content'); ?>
			<div class="inside-article">
				<?php do_action( 'generate_before_content'); ?>
				<div class="notFoundContainer">
				    <div class="leftColumn">
				        <h1>404</h1>
				        <h2><?php echo apply_filters( '404_title', __( 'Uh Oh looks like something broke.', 'generatepress' ) ); ?></h2>
				        <a class="btn" href="https://www.royalthings.be"><?php echo apply_filters( '404_home', __( 'Go Home', 'generatepress' ) ); ?></a>
				    </div>
				    <div class="leftColumn">
				        <img src="https://www.royalthings.be/wp-content/uploads/broken-christmas-ball.jpg"/>
				    </div>
				</div><!-- .entry-content -->
				<?php do_action( 'generate_after_content'); ?>
			</div><!-- .inside-article -->
			<?php do_action('generate_after_main_content'); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php 
do_action('generate_sidebars');
get_footer(); 
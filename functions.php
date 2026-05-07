<?php
/**
 * Alberts theme functions.
 *
 * @package Alberts
 */

/**
 * Enqueue child theme styles.
 */
function alberts_enqueue_styles() {
	wp_enqueue_style(
		'alberts-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'alberts_enqueue_styles' );

/**
 * Enqueue child theme block stylesheets.
 */
function alberts_block_stylesheets() {
	wp_enqueue_block_style(
		'core/button',
		array(
			'handle' => 'alberts-button-style-outline',
			'src'    => get_theme_file_uri( 'assets/css/button-outline.css' ),
			'ver'    => wp_get_theme()->get( 'Version' ),
			'path'   => get_theme_file_path( 'assets/css/button-outline.css' ),
		)
	);
}
add_action( 'init', 'alberts_block_stylesheets' );

/**
 * Register Alberts block pattern categories.
 */
function alberts_pattern_categories() {
	register_block_pattern_category(
		'alberts_page',
		array(
			'label'       => _x( 'Pages', 'Block pattern category', 'alberts' ),
			'description' => __( 'A collection of full page layouts.', 'alberts' ),
		)
	);
}
add_action( 'init', 'alberts_pattern_categories' );

/**
 * Register Alberts block styles.
 */
function alberts_register_block_styles() {
	$block_styles = array(
		'core/columns'      => array(
			'columns-reverse' => __( 'Reverse', 'alberts' ),
		),
		'core/group'        => array(
			'shadow-light' => __( 'Shadow', 'alberts' ),
			'shadow-solid' => __( 'Solid', 'alberts' ),
		),
		'core/image'        => array(
			'shadow-light' => __( 'Shadow', 'alberts' ),
			'shadow-solid' => __( 'Solid', 'alberts' ),
		),
		'core/list'         => array(
			'no-disc' => __( 'No Disc', 'alberts' ),
		),
		'core/quote'        => array(
			'shadow-light' => __( 'Shadow', 'alberts' ),
			'shadow-solid' => __( 'Solid', 'alberts' ),
		),
		'core/social-links' => array(
			'outline' => __( 'Outline', 'alberts' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', 'alberts_register_block_styles' );

/**
 * Use the Alberts logo on the login screen.
 */
function alberts_login_logo() {
	$logo_path = '/assets/images/Alberts-Logo.png';

	if ( ! file_exists( get_stylesheet_directory() . $logo_path ) ) {
		return;
	}

	$logo = get_stylesheet_directory_uri() . $logo_path;
	?>
	<style type="text/css">
		.login h1 a {
			background-image: url(<?php echo esc_url( $logo ); ?>);
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center center;
			display: block;
			overflow: hidden;
			text-indent: -9999em;
			width: 100px;
			height: 100px;
		}
	</style>
	<?php
}
add_action( 'login_head', 'alberts_login_logo' );

/**
 * Link the login logo to the public site.
 *
 * @return string
 */
function alberts_login_logo_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'alberts_login_logo_url' );

/**
 * Remove selected Twenty Twenty-Four patterns from the inserter.
 */
function alberts_remove_parent_patterns() {
	$parent_patterns = array(
		'banner-hero',
		'banner-project-description',
		'cta-content-image-on-right',
		'cta-pricing',
		'cta-rsvp',
		'cta-services-image-left',
		'cta-subscribe-centered',
		'footer-centered-logo-nav',
		'footer-colophon-3-col',
		'gallery-offset-images-grid-4-col',
	);

	foreach ( $parent_patterns as $parent_pattern ) {
		unregister_block_pattern( 'twentytwentyfour/' . $parent_pattern );
	}
}
add_action( 'init', 'alberts_remove_parent_patterns', 20 );

/**
 * Add excerpt support to pages.
 */
function alberts_add_page_excerpt_support() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'alberts_add_page_excerpt_support' );

/**
 * Render the copyright shortcode.
 *
 * @return string
 */
function alberts_copyright_line() {
	return 'Copyright &copy; 2009 - ' . gmdate( 'Y' );
}

/**
 * Register theme shortcodes.
 */
function alberts_shortcodes_init() {
	add_shortcode( 'copyright', 'alberts_copyright_line' );
}
add_action( 'init', 'alberts_shortcodes_init' );

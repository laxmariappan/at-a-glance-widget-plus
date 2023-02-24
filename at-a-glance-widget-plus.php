<?php
/**
 * Plugin Name:       At A Glance Widget Plus
 * Plugin URI:        https://github.com/laxmariappan/at-a-glance-widget-plus
 * Description:       A WordPress plugin to extend the core at a glance widget.
 * Version:           0.1.0
 * Requires at least: 6.1
 * Requires PHP:      8.1
 * Author:            Lax Mariappan
 * Author URI:        https://laxmariappan.com/
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Update URI:        FALSE
 * Text Domain:       at-a-glance-widget-plus
 * Domain Path:       /languages
 *
 * @package at-a-glance-widget-plus
 */

namespace Lax\AtAGlanceWidgetPlus;

/**
 * Get the count of individual post types, excluding core ones.
 *
 * @return void
 * @since  0.1.0
 * @author Lax Mariappan <lax@webdevstudios.com>
 */
function get_custom_post_counts() {

	$args       = array(
		'public'   => true,
		'_builtin' => false,
	);
	$post_types = get_post_types( $args, 'objects' );

	foreach ( $post_types as $cpt ) {
		$num_posts = wp_count_posts( $cpt->name );
		$num       = number_format_i18n( $num_posts->publish );
		$text      = ( 1 === intval( $num_posts->publish ) ) ? $cpt->labels->singular_name : $cpt->labels->name;
		$icon      = $cpt->menu_icon ? $cpt->menu_icon : 'dashicons-admin-post';
		echo '<li class=" dashicons-before ' . esc_attr( $icon ) . ' " ><a  href="edit.php?post_type=' . esc_attr( $cpt->name ) . '">' . esc_html( $num ) . ' ' . esc_html( $text ) . '</a></li>';
	}
}

add_action( 'dashboard_glance_items', __NAMESPACE__ . '\get_custom_post_counts' );

/**
 * Adding styles.
 *
 * @return void
 * @since  0.1.0
 * @author Lax Mariappan <lax@webdevstudios.com>
 */
function admin_styles() {
	wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . '/assets/style.css', array(), '0.1.0' );
}

add_action( 'admin_print_styles', __NAMESPACE__ . '\admin_styles' );

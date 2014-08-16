<?php
/**
 * @TODO What this does.
 *
 * @package   @TODO
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Josh Pollock
 */

class hwp_bpa_admin {
	function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
	}

	function add_admin_page() {
		add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	}

	function admin_page() {
		$view = apply_filters( 'hwp_bpa_admin_page_file', trailingslashit( HWP_BPA_PATH ).'includes/views/admin-page.php' );
		if ( file_exists( $view ) ) {
			$pods = pods( 'topic' );

			return pods_view( $view, compact( array( 'pods' => $pods ) ), DAY_IN_SECONDS, 'transient', true );

		}
		else {
			return __( sprintf( 'The admin page can not be loaded as the chosen view %1s does not exist. Please check the method %1s in the class %2s or check the "hwp_bpa_admin_page_file" filter.', __METHOD__, __CLASS__ ), 'hwp_bpa' );
		}
	}
}

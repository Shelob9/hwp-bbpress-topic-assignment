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

class hwp_bpa_pods_setup {

	static $topic_pod_id_key = 'hwp_bpp_topic_pod_id';

	function __construct( ) {

		add_filter( 'hwp_bpp_topic_fields', array( $this, 'fields' ) );
		$this->setup();

	}

	/**
	 * Adds fields to the topic Pod, and if need be extends the topic CPT.
	 *
	 * @return hwp_bpp_configure_pods
	 */
	function setup() {
		$create = $meta = true;
		$api = pods_api();
		if ( $api->pod_exists( $params[ 'name'] = 'topic' ) ) {
			$create = false;
			$pod = pods_api( 'topic')->load_pod( $params[ 'name'] = 'topic' );
			if ( 'table' === pods_v( 'storage', $pod ) ) {
				$meta = false;
			}
		}

		return hwp_bbp_setup_pods( $meta, $create, true );

	}

	function fields() {

		return array(
			'assignment' => array(
				'name' => 'assignment',
				'label' => 'Assignment',
				'description' => '',
				'help' => '',
				'type' => 'pick',
				'pick_object' => 'user',
			),
			'resolved' => array(
				'name' => 'resolved',
				'label' => 'Resolved',
				'description' => '',
				'help' => '',
				'default' => NULL,
				'type' => 'boolean',
			),

		);

	}


} 

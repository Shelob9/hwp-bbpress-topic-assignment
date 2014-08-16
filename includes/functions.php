<?php

/**
 * Checks if a topic is resolved.
 *
 * @param  int    $id ID of topic to check
 * @param bool|Pods $pods Optional. Pods object to check with. Only used if storage type is not meta. Even if is, not required. Provided for efficiency.
 *
 * @return bool
 */
function hwp_bpa_is_topic_resolved( $id, $pods = false ) {
	if ( hwp_bpa_topic_storage_type() !== 'meta' ) {
		if ( function_exists( 'pods' ) && ( ! $pods || ! is_object( $pods ) || ! is_a( $pods, 'Pods' ) ) ) {
			$pods = pods( 'topic', $id );
		}

		if ( $pods->id() !== $id || $pods->id === 0 || is_null( $pods->id ) ) {
			$pods->fetch( $id );
		}

		if ( $pods->display( 'resolved' ) ) {
			return true;
		}
	}
	else {
		$meta = get_post_meta( $id, 'resolved', true );
		if ( is_array( $meta ) ) {
			$meta = $meta[0];
		}

		return $meta;

	}

}

function hwp_bpa_topic_storage_type() {
	$option = 'hwp_bpa_topic_storage_type';

	if ( false == ( $storage_type = get_option( $option, false ) ) ) {
		if ( function_exists( 'pods_api' ) ) {
			$pod = pods_api()->load_pod( $params[ 'name'] = 'topic' );
			update_option(  $option, pods_v( 'storage', $pod, false, true ) );
		}

	}

	return $option;

}

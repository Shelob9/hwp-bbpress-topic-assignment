<?php
/**
 * Front end output of this plugin
 *
 * @package   @hwp_bpp
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 Josh Pollock
 */

class hwp_bpa_front_end {

	function __construct() {
		add_filter( 'hwp_bpp_fields_to_output', array( $this, 'new_topic' ) );
		add_filter( 'hwp_bbp_show_fields_extra', array( $this, 'assign_form' ) );
		add_filter( 'pods_form_pre_field', array( $this, 'assign_role' ) );
		add_filter( 'the_title', array( $this, 'title' ), 1, 25 );
	}


	function title( $title ) {
		global $post;
		if ( ! is_admin() && is_object( $post ) && $post->post_type == 'topic' && hwp_bpa_is_topic_resolved( $post->ID ) ) {
			$title = '<span class="hwp-bpa-resolved">[Resolved]</span> '.$title;
		}

		return $title;
	}


	function new_topic( $fields ) {
		if ( ! $this->show() ) {
			foreach( $this->fields() as $field ) {
				if ( pods_v( $field, $fields  ) ) {
					unset( $fields[ $field ] );
				}

			}

		}

		return $fields;

	}

	function show() {
		if ( ! is_user_logged_in() ) {
			return false;
		}
		$user = get_current_user_id();

		$checks = array( 'administrator', 'moderate' );

		/**
		 * Set the roles and capabilities that a user must have in order to see and edit the fields for this in the front-end.
		 *
		 * NOTE: Has no effect on editing via post editor.
		 *
		 * @since 0.0.1
		 *
		 * @params array Roles and capabilities to check. If current user is assigned to one of these roles or has one of these capabilities, they will see and be able to edit these fields in the front-end.
		 *
		 * @return array The roles and capabilities.
		 */
		$checks = apply_filters( 'hwp_bpa_allowed_checks', $checks );
		foreach( $checks as $check ) {
			if ( user_can( $user, $check ) ) {
				return true;

			}

		}

	}

	function assign_form() {
		if ( $this->show() )  {
			global $post;
			if ( is_object( $post ) && isset( $post->ID )) {
				$params = array ( 'fields' => $this->fields() );
				$form = pods( 'topic', $post->ID )->form( $params );

				if ( is_string( $form ) ) {
					return '<div class="hwp-pba-assignment-form">' . $form . '</div>';

				}
			}

		}

	}

	function assign_role( $field ){
		if ( $field === 'assignment' ) {
			/**
			 * Set the user roles that cna be assigned
			 *
			 * @since 0.0.1
			 *
			 * @param array|string One role as a string or an array of roles.
			 *
			 * @return The role(s) to allow assigning to.
			 */
			$roles = apply_filters( 'hwp_bpa_assignable_roles', 'administrator' );

			$field[ 'options' ][ 'pick_user_role' ] = $roles;


			return $field;

		}

	}

	/**
	 * @TODO CUT?
	 *
	 * @return array|bool
	 */
	function assignable_users() {



		$users = false;

		$args[ 'fields' ] =  array( 'ID', 'display_name' );
		if ( ! is_array( $roles ) ) {
			$args[ 'roles' ] = $roles;
			$users = (array) get_users( $args );
		}
		else {
			foreach ( $roles as $role ) {
				$args[ 'role' ] = $role;
				$users[] = (array) get_users( $args );

			}


		}

		return $users;


	}

	function fields() {

		return array( 'assignment', 'resolved' );

	}



} 

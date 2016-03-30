<?php

class CGC_Pinit_DB {


	private $table;
	private $db_version;

	function __construct() {

		global $wpdb;

		$this->table   		= $wpdb->base_prefix . 'cgc_pin_it';
		$this->view   		= $wpdb->base_prefix . 'cgc_pin_it_count';
		$this->db_version = '1.0';

	}

	/**
	*	Add a pin
	*
	*	@since 5.0
	*/
	public function add_pin( $args = array() ) {

		global $wpdb;

		$defaults = array(
			'user_id'		=> '',
			'post_id'		=> ''
		);

		$args = wp_parse_args( $args, $defaults );

		$add = $wpdb->query(
			$wpdb->prepare(
				"INSERT INTO {$this->table} SET
					`user_id`  		= '%d',
					`post_id`  		= '%d'
				;",
				absint( $args['user_id'] ),
				absint( $args['post_id'] )
			)
		);

		do_action( 'cgc_pin_added', $args, $wpdb->insert_id );

		if ( $add )
			return $wpdb->insert_id;

		return false;
	}

	/**
	*	Remove a pin
	*
	*	@since 5.0
	*/
	public function remove_pin( $args = array() ) {

		global $wpdb;

		$defaults = array(
			'user_id'		=> '',
			'post_id'		=> ''
		);

		$args = wp_parse_args( $args, $defaults );

		$remove = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$this->table} WHERE post_id = %d AND user_id = %d;", absint( $args['post_id'] ), absint( $args['user_id'] )
		    )
		);

		do_action( 'cgc_pin_removed', $args );

		return $remove ? true : false;

	}

	/**
	*	Get the number of pins for a specific post id
	*
	*	@since 5.0
	*/
	public function get_pins( $post_id = 0 ) {

		global $wpdb;

		$result = $wpdb->get_var( $wpdb->prepare( "SELECT total_count FROM {$this->view} WHERE `post_id` = '%d'; ", absint( $post_id ) ) );

		return $result;
	}

	/**
	*	Get the number of pins for a specific user
	*
	*	@since 5.0
	*/
	public function get_user_pins( $user_id = 0 ) {

		global $wpdb;

		$result = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM {$this->table} WHERE `user_id` = '%d'; ", absint( $user_id ) ) );

		return $result;
	}

	/**
	*	Has this user pinned a specific post id
	*
	*	@param $user_id int id of the user we're checking for
	*	@param $post_id int id of the post we're cecking to see if the user pinned
	*/
	public function has_pinned( $user_id = 0, $post_id = 0 ) {

		global $wpdb;

		$result = $wpdb->get_results( $wpdb->prepare( "SELECT user_id FROM {$this->table} WHERE `post_id` = '%d' AND `user_id` = '%d'; ", absint( $post_id ), absint( $user_id ) ) );

		if ( $result )
			return $result;
		else
			return false;
	}

}
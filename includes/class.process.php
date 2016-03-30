<?php

/**
*	Class responsible for processing the ajax call to pin or unpin a post id
*	@since 5.0
*/
class cgcProcessPinning {

	public function __construct(){

		add_action('wp_ajax_process_pin',		array($this,'process'));
		add_action('wp_ajax_process_unpin',		array($this,'process'));

	}

	public function process(){

		if ( isset( $_POST['action'] ) ) {

			global $post;

	    	$user_id 	= get_current_user_id();

	    	$post_id 	= isset( $_POST['post_id'] ) ? $_POST['post_id'] : false;
	    	$author     = $post_id ? get_post( $post_id )->post_author : false;

	    	if ( empty ( $post_id ) )
	    		return;

			if ( $_POST['action'] == 'process_pin' && wp_verify_nonce( $_POST['nonce'], 'process_pin' )  ) {

				// bail out if this user has already pinned this item
				if ( cgc_has_user_pinned( $user_id, $post_id ) ) {

					wp_send_json_success( array('message' => 'already-pinned') );

				} else if ( $user_id == $author ) {

					wp_send_json_success( array('message' => 'self-pinning') );

				} else {

					cgc_pin_something( $user_id, $post_id );

					do_action('cgc_user_pinned', $user_id, $post_id );

					wp_send_json_success( array( 'message'=> 'pinned' ) );
				}

			} elseif ( $_POST['action'] == 'process_unpin' && wp_verify_nonce( $_POST['nonce'], 'process_pin' ) ) {

	    		cgc_unpin_something( $user_id, $post_id );

		       	wp_send_json_success( array( 'message'=> 'un-pinned' ) );

			} else {

				wp_send_json_error();

			}

		} else {

			wp_send_json_error();

		}

	}

}
new cgcProcessPinning;
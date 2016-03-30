<?php

/**
*	UnPin something
*
*	@param $user_id int id of the current user doing the loving
*	@param $post_id int id of the post the user is loving
*	@since 5.0
*/
function cgc_unpin_something( $user_id = 0, $post_id = 0 ) {

	// if user is empty grab the current
	if ( empty( $user_id ) )
		$user_id = get_current_user_ID();

	// if teh post id is empty grab the current
	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	// add the pin
	$db = new CGC_Pinit_DB;
	$out =  $db->remove_pin( array( 'user_id' => $user_id, 'post_id' => $post_id ) );
}

/**
*	Pin something
*
*	@param $user_id int id of the current user doing the loving
*	@param $post_id int id of the post the user is loving
*	@since 5.0
*/
function cgc_pin_something( $user_id = 0, $post_id = 0 ) {

	// if user is empty grab the current
	if ( empty( $user_id ) )
		$user_id = get_current_user_ID();

	// if teh post id is empty grab the current
	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	// bail out if this user has already pinned this item
	if ( false !== cgc_has_user_pinned( $user_id, $post_id ) )
		return;

	// add the pin
	$db = new CGC_Pinit_DB;
	$out =  $db->add_pin( array( 'user_id' => $user_id, 'post_id' => $post_id ) );
}

/**
*	Get the number of pins for a post id
*	@param $post_id int id of the post that we're getting the pins for
*	@since 5.0
*/
function cgc_get_pins( $post_id = 0 ) {

	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	$db = new CGC_Pinit_DB;
	$out = $db->get_pins( $post_id );

	return $out ? $out : 0;

}

/**
*	Get the items a specific user has pinned
*	@param $user_id int id of the user that we're getting items for
*	@since 5.0
*/
function cgc_get_users_pins( $user_id = 0, $count = false ) {

	if ( empty( $user_id ) )
		return;

	$db = new CGC_Pinit_DB;
	$out = $db->get_user_pins( $user_id );

	return true == $count ? count( $out ) : $out;

}

/**
*	Check if a user has pinned something
*	@param $user_id int id of the user that we're checking for
*	@param $post_id int id of the post that we're checking
*	@since 5.0
*/
function cgc_has_user_pinned( $user_id = 0, $post_id = 0 ) {

	// if user is empty grab the current
	if ( empty( $user_id ) )
		$user_id = get_current_user_ID();

	// if teh post id is empty grab the current
	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	// return result
	$db = new CGC_Pinit_DB;
	$out = $db->has_pinned( $user_id , $post_id );

	return $out;
}
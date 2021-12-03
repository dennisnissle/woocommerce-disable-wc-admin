<?php
defined( 'ABSPATH' ) || exit;

/**
 * WC Admin Note Data Store (Custom Tables)
 */
class DataStoreADminNoteReplacement extends \Automattic\WooCommerce\Admin\Notes\DataStore {

	public function create( &$note ) {

	}

	public function read( &$note ) {
		throw new \Exception( __( 'Invalid admin note', 'woocommerce' ) );
	}

	public function update( &$note ) {

	}

	public function delete( &$note, $args = array() ) {

	}

	/**
	 * Return an ordered list of notes.
	 *
	 * @param array $args Query arguments.
	 * @return array An array of objects containing a note id.
	 */
	public function get_notes( $args = array() ) {
		return array();
	}

	/**
	 * Return a count of notes.
	 *
	 * @param string $type Comma separated list of note types.
	 * @param string $status Comma separated list of statuses.
	 * @return array An array of objects containing a note id.
	 */
	public function get_notes_count( $type = array(), $status = array() ) {
		return array();
	}

	/**
	 * Return where clauses for getting notes by status and type. For use in both the count and listing queries.
	 *
	 *  @param array $args Array of args to pass.
	 * @return string Where clauses for the query.
	 */
	public function get_notes_where_clauses( $args = array() ) {
		return '';
	}

	/**
	 * Find all the notes with a given name.
	 *
	 * @param string $name Name to search for.
	 * @return array An array of matching note ids.
	 */
	public function get_notes_with_name( $name ) {
		return array();
	}
}

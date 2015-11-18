<?php
/**
 * Plugin Name: Revert Comment Field Position
 * Plugin URI:  http://themehybrid.com/plugins
 * Description: Reverts the "comment" field position to below the other fields in the comment form.
 * Version:     1.0.0-dev
 * Author:      Justin Tadlock
 * Author URI:  http://themehybrid.com
 * Text Domain: revert-comment-field-position
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not,
 * write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package   RevertCommentFieldPostion
 * @version   1.0.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2015, Justin Tadlock
 * @link      http://themehybrid.com/plugins/revert-comment-field-position
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for setting up the plugin.
 *
 * @since  1.0.0
 * @access public
 */
final class JT_Revert_Comment_Field_Position {

	/**
	 * Stores the comment field HTML.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $comment_field = '';

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up main plugin actions and filters.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function setup_actions() {

		// Internationalize the text strings used.
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		// Capture the comment field HTML.
		add_filter( 'comment_form_field_comment', array( $this, 'capture_comment_field' ), 999 );

		// Dirty hack to move the comment field.
		add_filter( 'comment_form_submit_field', array( $this, 'hack_in_comment_field' ), 999 );
	}

	/**
	 * Captures the comment field HTML and returns an empty string, which disables the comment 
	 * field output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $field
	 * @return string
	 */
	public function capture_comment_field( $field ) {

		$this->comment_field = $field;

		return '';
	}

	/**
	 * A quick and dirty hack to output the comment field just before the submit field.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $submit_field
	 * @return string
	 */
	public function hack_in_comment_field( $submit_field ) {

		if ( $this->comment_field )
			$submit_field = $this->comment_field . $submit_field;

		return $submit_field;
	}

	/**
	 * Loads the translation files.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function i18n() {
		load_plugin_textdomain( 'revert-comment-field-position', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ). 'languages' );
	}
}

JT_Revert_Comment_Field_Position::get_instance();

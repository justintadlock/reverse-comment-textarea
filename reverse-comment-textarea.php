<?php
/**
 * Plugin Name: Reverse Comment Textarea
 * Plugin URI:  http://themehybrid.com/plugins/reverse-comment-textarea
 * Description: Moves the textarea back to the bottom of the comment form.
 * Version:     1.0.0
 * Author:      Justin Tadlock
 * Author URI:  http://themehybrid.com
 * Text Domain: reverse-comment-textarea
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
 * @link      http://themehybrid.com/plugins/reverse-comment-textarea
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Load translation files.
add_action( 'plugins_loaded', 'jtrct_i18n' );

# Filter comment fields.
add_filter( 'comment_form_fields', 'jtrct_comment_form_fields', 99 );

/**
 * Loads translation files.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function jtrct_i18n() {

	load_plugin_textdomain( 'reverse-comment-textarea', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ). 'languages' );
}

/**
 * Pushes the "comment" field (textarea) to the end of the comment form fields.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $fields
 * @return array
 */
function jtrct_comment_form_fields( $fields ) {

	// If the comment field is set.
	if ( isset( $fields['comment'] ) ) {

		// Grab the comment field.
		$comment_field = $fields['comment'];

		// Remove the comment field from its current position.
		unset( $fields['comment'] );

		// Put the comment field at the end.
		$fields['comment'] = $comment_field;
	}

	return $fields;
}

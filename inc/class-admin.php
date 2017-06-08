<?php
/**
 * Admin class for WP Flickitize Galleries
 *
 * Prepares wp-admin to deal with Flickity galleries.
 *
 * @since 0.1
 *
 * @package WP_Flickitize_Galleries
 */

namespace WP_Flickitize_Galleries;

/**
 * Prepares wp-admin to deal with Flickity galleries.
 */
class Admin {

	/**
	 * Run on class instatiation
	 */
	function __construct() {

		add_action( 'print_media_templates', array( $this, 'add_flickity_checkbox' ) );

	}

	/**
	 * Add the Flickity checkbox to the native gallery modal
	 *
	 * Defined as a backbone template.
	 *  The "tmpl-" prefix is required, and the input field should have a
	 *  data-setting attribute matching the shortcode name.
	 */
	function add_flickity_checkbox() {

		?>
		<script type="text/html" id="tmpl-wp-flickitize-gallery-setting">
			<label class="setting">
				<span><?php esc_html_e( 'Use Flickity', 'wp-flickitize-galleries' ); ?></span>
				<input type="checkbox" name="flickitize" data-setting="flickitize">
			</label>
		</script>

		<script>

		jQuery(document).ready(function(){

			// add the shortcode attribute and its default value to the
			// gallery settings list; $.extend should work as well...
			_.extend(wp.media.gallery.defaults, {
				flickitize: 'false'
			});

			// merge default gallery settings template with yours
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
				template: function(view){
					return wp.media.template('gallery-settings')(view)
					+ wp.media.template('wp-flickitize-gallery-setting')(view);
				}
			});

		});

	</script>

	<?php

	}

}

new Admin();

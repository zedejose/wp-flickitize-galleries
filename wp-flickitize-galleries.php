<?php
/*
Plugin Name: WP Flickitize Galleries
Plugin URI:  git@github.com:zedejose/wp-flickitize-galleries.git
Description: Turn your native WordPress galleries into beautiful sliders. Powered by the <a href="https://flickity.metafizzy.co/">Flickity JS library</a>.
Version:     0.1
Author:      Ze Fontainhas
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-flickitize-galleries
Domain Path: /languages

WP Flickitize Galleries is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WP Flickitize Galleries is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WP Flickitize Galleries. If not, see <http://www.gnu.org/licenses/>.
*/


/* Exit if called directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WP_FLICKITIZE_DIR', dirname( __FILE__ ) );
define( 'WP_FLICKITIZE_FILE', __FILE__ );
define( 'WP_FLICKITIZE_BASE', plugin_basename( __FILE__ ) );
define( 'WP_FLICKITIZE_MIN_WP', 4.6 );
define( 'WP_FLICKITIZE_MIN_PHP', 5.6 );



<?php
/**
 * Front-end class for WP Flickitize Galleries
 *
 * Hijacks the 'gallery' shortcode to see if Flickity is active for this gallery.
 *
 * @since 0.1
 *
 * @package WP_Flickitize_Galleries
 */

namespace WP_Flickitize_Galleries;

/**
 * Hijacks the 'gallery' shortcode to see if Flickity is active for this gallery.
 */
class Shortcode {

	/**
	 * Suffix (.min or empty) for loading scripts
	 *
	 * @var string
	 */
	private $suffix;

	/**
	 * Run on class instatiation
	 */
	function __construct() {

		$this->suffix = $this->get_suffix();

		add_action( 'wp_enqueue_scripts', 	array( $this, 'register_flickity_assets' ) );

		add_filter( 'post_gallery', 		array( $this, 'maybe_make_flickity' ), 10, 3 );

	}

	/**
	 * Suffix (.min or empty) for loading scripts
	 *
	 * Depends on the value of SCRIPT_DEBUG in wo-config.php.
	 *
	 * @return string '.min' or empty string
	 */
	private static function get_suffix() {

		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	}

	/**
	 * Register assets (JS and CSS files).
	 */
	public static function register_flickity_assets() {

		wp_register_script(
			'flickity',
			$this->plugin_url( 'js/flickity.pkgd' . $this->suffix . '.js' ),
			array( 'jquery' ),
			false,
			true
		);

		wp_register_style(
			'flickity',
			$this->plugin_url( 'css/flickity' . $this->suffix . '.css' ),
			array(),
			false
		);
	}

	/**
	 * Parse the native shortcode attributes for Flickity. Process if present.
	 *
	 * @param  string $output   The current output - the WordPress core passes an empty string.
	 * @param  array  $atts     The attributes from the gallery shortcode.
	 * @param  int 	  $instance Unique numeric ID of this gallery shortcode instance.
	 *
	 * @return string          	Current output or Flickity code, if flag is true.
	 */
	public static function maybe_make_flickity( $output, $atts, $instance ) {

		if ( isset( $atts['flickitize'] ) && 'true' === $atts['flickitize'] ) {

			global $post;

			$atts = wp_parse_args( $atts, array(
				'order' 	=> 'ASC',
				'orderby' 	=> 'menu_order ID',
				'id' 		=> $post ? $post->ID : 0,
				'size' 		=> 'thumbnail',
				'include' 	=> '',
				'exclude' 	=> '',
				'link' 		=> '',
			) );

			$atts = apply_filters( 'shortcode_atts_gallery', $atts, [], 'gallery' );

			if ( ! empty( $atts['include'] ) ) {

				$_attachments = get_posts(
					array(
						'include' 			=> $atts['include'],
						'post_status' 		=> 'inherit',
						'post_type' 		=> 'attachment',
						'post_mime_type' 	=> 'image',
						'order' 			=> $atts['order'],
						'orderby' 			=> $atts['orderby'],
					)
				);

				$attachments = [];

				foreach ( $_attachments as $key => $val ) {
					$attachments[ $val->ID ] = $_attachments[ $key ];
				}
			} elseif ( ! empty( $atts['exclude'] ) ) {

				$attachments = get_children(
					array(
						'post_parent' 		=> $id,
						'exclude' 			=> $atts['exclude'],
						'post_status' 		=> 'inherit',
						'post_type' 		=> 'attachment',
						'post_mime_type' 	=> 'image',
						'order' 			=> $atts['order'],
						'orderby' 			=> $atts['orderby'],
					)
				);

			} else {

				$attachments = get_children(
					array(
						'post_parent' 		=> $id,
						'post_status'		=> 'inherit',
						'post_type' 		=> 'attachment',
						'post_mime_type' 	=> 'image',
						'order' 			=> $atts['order'],
						'orderby' 			=> $atts['orderby'],
					)
				);
			}
			if ( empty( $attachments ) ) {
				return '';
			}

			wp_enqueue_script( 'flickity' );
			wp_enqueue_style( 'flickity' );

			$data_flickity['imagesLoaded'] 		= true;
			$data_flickity['percentPosition'] 	= false;
			$data_flickity['cellAlign'] 		= 'left';
			$data_flickity['pageDots'] 			= false;

			$data_flickity = wp_json_encode( $data_flickity );

			$output[] = '<div class="carousel align-left" data-flickity=' . $data_flickity . '>';

			foreach ( $attachments as $id => $attachment ) {

				$image_tag 	= wp_get_attachment_image( $id, $atts['size'], false, array( 'style' => 'max-width:none;' ) );

				$output[] 	= '<div class="carousel-cell">';
				$output[] 	= $image_tag;
				$output[] 	= '</div>';

			}

			$output[] = '</div>';

			$output = implode( "\n", $output );
		}
		return $output;

	}

	/**
	 * Get URL relative to given path.
	 *
	 * @param string $path URI to asset.
	 * @return string      Full URL to asset.
	 */
	public static function plugin_url( $path ) {

		return plugins_url( $path, WP_FLICKITIZE_FILE );

	}


}

new Shortcode();

<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.sinawiwebdesign.com
 * @since      1.0.0
 *
 * @package    Fancy_Grid_Portfolio
 * @subpackage Fancy_Grid_Portfolio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fancy_Grid_Portfolio
 * @subpackage Fancy_Grid_Portfolio/public
 * @author     Laith Sinawi <info@sinawiwebdesign.com>
 */
class Fancy_Grid_Portfolio_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Holds the values to be used in the fields callbacks
	 *
	 * @since    1.0.0
	 * @access    private
	 * @var    string $options The options for this plugin
	 */
	private $options;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->options     = get_option( 'fgp_settings' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fancy_Grid_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fancy_Grid_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name . '-lightbox-css', plugin_dir_url( __DIR__ ) . 'lib/lightbox/lightbox.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-css', plugin_dir_url( __FILE__ ) . 'css/fancy-grid-portfolio-public.css', array(), $this->version, 'all' );

		// Register styles to be call dynamically
		wp_register_style( $this->plugin_name . '-2col-css', plugin_dir_url( __FILE__ ) . 'css/templates/2col.css', array(), $this->version );
		wp_register_style( $this->plugin_name . '-3col-css', plugin_dir_url( __FILE__ ) . 'css/templates/3col.css', array(), $this->version );
		wp_register_style( $this->plugin_name . '-4col-css', plugin_dir_url( __FILE__ ) . 'css/templates/4col.css', array(), $this->version );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fancy_Grid_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fancy_Grid_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name . '-lightbox-js', plugin_dir_url( __DIR__ ) . 'lib/lightbox/lightbox.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-mixitup-js', plugin_dir_url( __DIR__ ) . 'lib/mixitup/jquery.mixitup.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-js', plugin_dir_url( __FILE__ ) . 'js/fancy-grid-portfolio-public.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Register the shortcodes
	 *
	 * @since 1.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'fgp_portfolio', array( $this, 'fgp_list_portfolio_items' ) );
	}

	/**
	 * Handle the main [fgp_portfolio] shortcode
	 *
	 * @since   1.0.0
	 * @return  string  The processed shortcode in html string
	 */
	function fgp_list_portfolio_items( $atts, $content = null ) {

		global $post;

		$this->options = get_option( 'fgp_settings' );

		$hide_filters = isset( $this->options['hide_filters'] ) ? $this->options['hide_filters'] : '';
		$num_posts    = isset( $this->options['num_posts'] ) ? $this->options['num_posts'] : - 1;
		$num_columns  = isset( $this->options['num_columns'] ) ? $this->options['num_columns'] : '';

		$atts = shortcode_atts( array(
			'count'        => $num_posts,
			'pagination'   => 'off',
			'hide_filters' => $hide_filters,
			'num_columns'  => $num_columns
		), $atts );

		$pagination = $atts['pagination'] == 'on' ? false : true;

		// If shortcode attr hide_filters is set, override global setting
		$hide_filters = isset( $atts['hide_filters'] ) ? $atts['hide_filters'] : $hide_filters;
		$num_columns  = isset( $atts['num_columns'] ) ? $atts['num_columns'] : $num_columns;
		wp_enqueue_style( 'fancy-grid-portfolio-' . $num_columns . 'col-css' ); // Enqueue the appropriate grid stylesheet
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		// Query Args
		$args = array(
			'post_type'      => 'portfolio_item',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'no_found_rows'  => $pagination,
			'posts_per_page' => $atts['count'],
			'paged'          => $paged
		);

		// Get Portfolio from DB
		$portfolio = new WP_Query( $args );

		// Loop thru portfolio items and build html output
		if ( $portfolio->have_posts() ) :
			$output = '<div id="fgp-portfolio">';

			if ( ! $hide_filters ) {
				$output .= '<ul id="fgp-filters">';
				$output .= $this->fpg_get_filters( $post );
				$output .= '</ul>';
			}
			$output .= '</div><div class="clearfix"></div>';
			$output .= '<ul id="fgp-gallery">';

			while ( $portfolio->have_posts() ) {

				$portfolio->the_post();

				$terms = wp_get_post_terms( get_the_ID(), 'portfolio_categories' );

				$filter_classes = '';
				foreach ( $terms as $term ) {
					$filter_classes .= ' ' . $term->slug;
				}
				if ( has_post_thumbnail() ) {
					get_the_post_thumbnail( 'fgp_thumbnail' );
				}

				$thumb        = wp_get_attachment_image_src( get_post_thumbnail_id(), 'fgp_thumbnail' );
				$full         = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				$project_desc = get_post_meta( get_the_ID(), 'details', true );
				$output .= '<li class="mix' . $filter_classes . '">';
				$output .= '<a href="' . $full[0] . '" data-lightbox="projects" data-title="' . get_the_title() . '" data-desc="' . $project_desc . '">';
				$output .= '<img src="' . $thumb[0] . '"></a></li>';
			}

			$output .= '</div><!-- end portfolio -->';

			// Reset post data
			wp_reset_postdata();

			return $output;

		else:

			return '<p>No portfolio items</p>';

		endif;
	}

	/*
	 * Get portfolio filter categories
	 */
	public function fpg_get_filters( $post ) {

		// Get taxonomy terms
		$terms = get_terms( 'portfolio_categories', array(
			'taxonomy'   => 'portfolio_categories',
			'hide_empty' => true,
			'parent'     => 0,
		) );

//	var_dump($terms);

		// Init output
		$output = '<li><a class="fgp-filter" data-filter="all">All</a></li>';

		// Build output
		foreach ( $terms as $term ) {
			$category = str_replace( ' ', '-', $term->name );
			$category = strtolower( $category );
			$output .= '<li><a class="fgp-filter" data-filter=".' . $category . '">' . $term->name . '</a></li>';
		}

		return $output;
	}

}
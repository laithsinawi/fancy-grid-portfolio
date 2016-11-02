<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.sinawiwebdesign.com
 * @since      1.0.0
 *
 * @package    Fancy_Grid_Portfolio
 * @subpackage Fancy_Grid_Portfolio/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fancy_Grid_Portfolio
 * @subpackage Fancy_Grid_Portfolio/admin
 * @author     Laith Sinawi <info@sinawiwebdesign.com>
 */
class Fancy_Grid_Portfolio_Admin {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __DIR__ ) . 'lib/jquery-ui/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fancy-grid-portfolio-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fancy-grid-portfolio-admin.js', array(
			'jquery',
			'jquery-ui-sortable'
		), $this->version, true );

		/**
		 * TODO: enqueue ajax script
		 */
//		wp_localize_script( 'fgp-script', 'FGP_PORTFOLIO', array(
//			'token' => wp_create_nonce( 'fgp-token' )
//		) );

	}

	/**
	 * Register custom post type portfolio_item and fields
	 */
	public function cptui_register_my_cpts_portfolio_item() {
		$labels = array(
			"name"          => __( 'Portfolio Items', 'mcst' ),
			"singular_name" => __( 'Portfolio Item', 'mcst' ),
			"menu_name"     => __( 'Grid Portfolio', 'mcst' ),
		);

		$args = array(
			"label"               => __( 'Portfolio Items', 'mcst' ),
			"labels"              => $labels,
			"description"         => "Portfolio in nice grid format that is animated and filterable with beautiful hover overlay of project title and description",
			"public"              => true,
			"publicly_queryable"  => false,
			"show_ui"             => true,
			"show_in_rest"        => false,
			"rest_base"           => "",
			"has_archive"         => false,
			"show_in_menu"        => false,
			"exclude_from_search" => true,
			"capability_type"     => "post",
			"map_meta_cap"        => true,
			"hierarchical"        => false,
			"rewrite"             => array( "slug" => "portfolio", "with_front" => false ),
			"query_var"           => true,
			"menu_position"       => 5,
			"menu_icon"           => "dashicons-images-alt2",
			"supports"            => array( "title", "thumbnail" )
		);
		register_post_type( "portfolio_item", $args );

		if(function_exists("register_field_group"))
		{
			register_field_group(array (
				'id' => 'acf_portfolio-item-fields',
				'title' => 'Portfolio Item Fields',
				'fields' => array (
					array (
						'key' => 'field_58192670e2ee2',
						'label' => 'Project Details',
						'name' => 'project_details',
						'type' => 'textarea',
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'formatting' => 'br',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'portfolio_item',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'no_box',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
		}

	}

	/**
	 * Register taxonomy portfolio_category
	 */
	public function cptui_register_my_taxes_portfolio_category() {
		$labels = array(
			"name"          => __( 'Portfolio Categories', 'mcst' ),
			"singular_name" => __( 'Portfolio Category', 'mcst' ),
		);

		$args = array(
			"label"              => __( 'Portfolio Categories', 'mcst' ),
			"labels"             => $labels,
			"public"             => false,
			"hierarchical"       => false,
			"show_ui"            => true,
			"show_in_menu"       => true,
			"show_in_nav_menus"  => false,
			"query_var"          => true,
			"rewrite"            => array( 'slug' => 'portfolio_category', 'with_front' => false, ),
			"show_admin_column"  => false,
			"show_in_rest"       => false,
			"rest_base"          => "",
			"show_in_quick_edit" => false,
		);
		register_taxonomy( "portfolio_category", array( "portfolio_item" ), $args );

	}

	/**
	 * Add columns to custom post type Portfolio
	 * */
	public function fgp_columns_header( $columns ) {

		$columns = array(
			'cb'       => '<input type="checkbox" />',
			'title'    => __( 'Portfolio Item Title' ),
			'category' => __( 'Categories' ),
			'image'    => __( 'Image' )
		);

		return $columns;
	}

	/**
	 * Add data columns for custom post type Portfolio
	 */
	public function fgp_columns_content( $column_name, $post_id ) {
		// Init output
		$output = '';

		switch ( $column_name ) {
			case 'category':

				$terms = wp_get_post_terms( $post_id, 'portfolio_category' );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$output .= $term->name . ', ';
					}
					$output = substr_replace( $output, '', - 2 );
				}
				break;
			case 'image':
				$image = get_the_post_thumbnail( $post_id, 'thumbnail' );
				$output .= $image;
				break;
		}

		echo $output;
	}


	/************** OPTION PAGE RELATED METHODS *******************/

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// This page will in admin mainn menu
		add_menu_page(
			'Grid Portfolio - Dashboard',
			'Grid Portfolio',
			'manage_options',
			$this->plugin_name,
			array( $this, 'create_admin_page' ),
			'dashicons-images-alt2',
			5
		);

		add_submenu_page(
			$this->plugin_name,
			'TEST',
			__( 'Dashboard' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'create_admin_page' )
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Portfolio Items' ),
			__( 'Portfolio Items' ),
			'manage_options',
			'edit.php?post_type=portfolio_item',
			null
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Drag Drop Sort' ),
			__( 'Drag Drop Sort' ),
			'manage_options',
			'custom-order',
			array( $this, 'fgp_reorder_portfolio_callback' )
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Portfolio Categories' ),
			__( 'Portfolio Categories' ),
			'manage_options',
			'edit-tags.php?taxonomy=portfolio_category',
			null
		);

	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property
		$this->options = get_option( 'my_option_name' );
		?>
		<div class="wrap">
			<h1>My Settings</h1>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'my_option_group' );
				do_settings_sections( 'my-setting-admin' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'my_option_group', // Option group
			'my_option_name', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'My Custom Settings', // Title
			array( $this, 'print_section_info' ), // Callback
			$this->plugin_name // Page
		);

		add_settings_field(
			'id_number', // ID
			'ID Number', // Title
			array( $this, 'id_number_callback' ), // Callback
			$this->plugin_name, // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'title',
			'Title',
			array( $this, 'title_callback' ),
			$this->plugin_name,
			'setting_section_id'
		);

	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();
		if ( isset( $input['id_number'] ) ) {
			$new_input['id_number'] = absint( $input['id_number'] );
		}

		if ( isset( $input['title'] ) ) {
			$new_input['title'] = sanitize_text_field( $input['title'] );
		}

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		print 'Enter your settings below:';
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function id_number_callback() {
		printf(
			'<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
			isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number'] ) : ''
		);
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function title_callback() {
		printf(
			'<input type="text" id="title" name="my_option_name[title]" value="%s" />',
			isset( $this->options['title'] ) ? esc_attr( $this->options['title'] ) : ''
		);
	}

	/*
 * List portfolio items for drag drop reorder
 */
	function fgp_reorder_portfolio_callback() {

		include_once 'partials/fancy-grid-portfolio-reorder.php';

	}
}

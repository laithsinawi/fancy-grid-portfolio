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

		wp_enqueue_style( $this->plugin_name . '_jquery_ui', plugin_dir_url( __DIR__ ) . 'lib/jquery-ui/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '_admin_css', plugin_dir_url( __FILE__ ) . 'css/fancy-grid-portfolio-admin.css', array(), $this->version, 'all' );

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

		wp_enqueue_script( $this->plugin_name . '-admin-js',
			plugin_dir_url( __FILE__ ) . 'js/fancy-grid-portfolio-admin.js',
			array(
				'jquery',
				'jquery-ui-sortable'
			),
			$this->version,
			true
		);

		wp_localize_script( $this->plugin_name . '-admin-js',
			'FGP_PORTFOLIO',
			array(
				'token' => wp_create_nonce( 'fgp-token' )
			)
		);

	}

	/**
	 * Register custom post type portfolio_item and fields
	 */
	public function cptui_register_my_cpts_portfolio_item() {
		$labels = array(
			"name"          => __( 'Portfolio Items', 'fancy-grid-portfolio' ),
			"singular_name" => __( 'Portfolio Item', 'fancy-grid-portfolio' ),
			"menu_name"     => __( 'Grid Portfolio', 'fancy-grid-portfolio' ),
		);

		$args = array(
			"label"               => __( 'Portfolio Items', 'fancy-grid-portfolio' ),
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

		if ( function_exists( "register_field_group" ) ) {
			register_field_group( array(
				'id'         => 'acf_portfolio-item-fields',
				'title'      => 'Portfolio Item Fields',
				'fields'     => array(
					array(
						'key'           => 'field_58192670e2ee2',
						'label'         => 'Project Details',
						'name'          => 'project_details',
						'type'          => 'textarea',
						'default_value' => '',
						'placeholder'   => '',
						'maxlength'     => '',
						'rows'          => '',
						'formatting'    => 'br',
					),
				),
				'location'   => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'portfolio_item',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options'    => array(
					'position'       => 'normal',
					'layout'         => 'no_box',
					'hide_on_screen' => array(),
				),
				'menu_order' => 0,
			) );
		}

	}

	/**
	 * Register taxonomy portfolio_categories
	 */
	public function cptui_register_my_taxes_portfolio_categories() {
		$labels = array(
			"name"          => __( 'Portfolio Categories', 'fancy-grid-portfolio' ),
			"singular_name" => __( 'Portfolio Category', 'fancy-grid-portfolio' ),
		);

		$args = array(
			"label"              => __( 'Portfolio Categories', 'fancy-grid-portfolio' ),
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
		register_taxonomy( "portfolio_categories", array( "portfolio_item" ), $args );

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

				$terms = wp_get_post_terms( $post_id, 'portfolio_categories' );

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


	/************** OPTIONS PAGE RELATED METHODS *******************/

	/**
	 * Add options page
	 */
	public function fgp_add_plugin_page() {
		// This page will in admin mainn menu
		add_menu_page(
			__( 'Grid Portfolio - Dashboard', 'fancy-grid-portfolio' ),
			__( 'Grid Portfolio', 'fancy-grid-portfolio' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'fgp_create_admin_page' ),
			'dashicons-images-alt2',
			5
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Dashboard', 'fancy-grid-portfolio' ),
			__( 'Dashboard', 'fancy-grid-portfolio' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'fgp_create_admin_page' )
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Portfolio Items', 'fancy-grid-portfolio' ),
			__( 'Portfolio Items', 'fancy-grid-portfolio' ),
			'manage_options',
			'edit.php?post_type=portfolio_item',
			null
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Drag Drop Sort', 'fancy-grid-portfolio' ),
			__( 'Drag Drop Sort', 'fancy-grid-portfolio' ),
			'manage_options',
			'custom-order',
			array( $this, 'fgp_reorder_portfolio_callback' )
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Portfolio Categories', 'fancy-grid-portfolio' ),
			__( 'Portfolio Categories', 'fancy-grid-portfolio' ),
			'manage_options',
			'edit-tags.php?taxonomy=portfolio_categories',
			null
		);

	}

	/**
	 * Options page callback
	 */
	public function fgp_create_admin_page() {
		// Set class property
		$this->options = get_option( 'fgp_option_name' );
		?>
		<div class="wrap">
			<h1>Fancy Grid Portfolio</h1>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'fgp_option_group' );
				do_settings_sections( $this->plugin_name );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function fgp_register_settings() {

		register_setting(
			'fgp_option_group', // Option group
			'fgp_option_name', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			$this->plugin_name . '_fields', // ID
			'Settings', // Title
			array( $this, 'fgp_fields_callback' ), // Callback
			$this->plugin_name // Page
		);

		add_settings_section(
			$this->plugin_name . '_info', // ID
			'How to Use', // Title
			array( $this, 'print_section_info' ), // Callback
			$this->plugin_name // Page
		);

		add_settings_field(
			'fgp_thumbcrop_width',
			'Thumbnail Crop Width',
			array( $this, 'fgp_thumbcrop_width_callback' ),
			$this->plugin_name,
			$this->plugin_name . '_fields',
			array(
				'label_for' => 'fgp_thumbcrop_width',
				'desc'      => 'This is for the width that will be cropped for your thumbnail images. Default is 400px.'

			)
		);

		add_settings_field(
			'fgp_thumbcrop_height',
			'Thumbnail Crop Height',
			array( $this, 'fgp_thumbcrop_height_callback' ),
			$this->plugin_name,
			$this->plugin_name . '_fields',
			array(
				'label_for' => 'fgp_thumbcrop_height',
				'desc'      => 'This is for the height that will be cropped for your thumbnail images. Default is 300px.'
			)
		);

		add_settings_field(
			'fgp_num_cols',
			'Number of Columns',
			array( $this, 'fgp_num_cols_callback' ),
			$this->plugin_name,
			$this->plugin_name . '_fields',
			array(
				'label_for' => 'fgp_num_cols',
				'desc'      => 'Set the number of columns you want your grid to be. Default is 3 columns. If your page is 1200px wide or more, you may want 4 columns.'
			)
		);

		add_settings_field(
			'fgp_hide_filters',
			'Hide Filter Categories',
			array( $this, 'fgp_hide_filters_callback' ),
			$this->plugin_name,
			$this->plugin_name . '_fields',
			array(
				'label_for' => 'fgp_hide_filters',
				'desc'      => 'Select this option to hide category filters. You can override this in
							shortcode attributes too.'
			)
		);

	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 *
	 * @return array       Contains settings with sanitized values
	 */
	public function sanitize( $input ) {
		$new_input = array();

		if ( isset( $input['fgp_thumbcrop_width'] ) ) {
			$new_input['fgp_thumbcrop_width'] = absint( $input['fgp_thumbcrop_width'] );
		}

		if ( isset( $input['fgp_thumbcrop_height'] ) ) {
			$new_input['fgp_thumbcrop_height'] = absint( $input['fgp_thumbcrop_height'] );
		}

		if ( isset( $input['fgp_num_cols'] ) ) {
			$new_input['fgp_num_cols'] = sanitize_option( 'fgp_num_cols', $input['fgp_num_cols'] );
		}

		if ( isset( $input['fgp_hide_filters'] ) ) {
			$new_input['fgp_hide_filters'] = filter_var( $input['fgp_hide_filters'], FILTER_SANITIZE_NUMBER_INT );
		}

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		include_once 'partials/fancy-grid-portfolio-section-info.php';
	}

	/**
	 * Print the Fields section text
	 */
	public function fgp_fields_callback() {
		// Output for fields section - doing nothing!
		// Callback function required by add_settings_section()
	}

	/**
	 * Get the settings option array and print  one of its values
	 */
	public function fgp_thumbcrop_width_callback( $args ) {
		$description = $args['desc'];
		printf(
			'<input type="text" id="fgp_option_name[fgp_thumbcrop_width]" name="fgp_option_name[fgp_thumbcrop_width]" value="%s" /> px
			<p class="description">%s</p>',
			! empty( $this->options['fgp_thumbcrop_width'] ) ? esc_attr( $this->options['fgp_thumbcrop_width'] ) : 400,
			isset( $description ) ? __( $description, 'fancy-grid-portfolio' ) : ''
		);
	}

	/**
	 * Get the settings option array and print  one of its values
	 */
	public function fgp_thumbcrop_height_callback( $args ) {
		$description = $args['desc'];
		printf(
			'<input type="text" id="fgp_option_name[fgp_thumbcrop_height]" name="fgp_option_name[fgp_thumbcrop_height]" value="%s" /> px
			<p class="description">%s</p>',
			! empty( $this->options['fgp_thumbcrop_height'] ) ? esc_attr( $this->options['fgp_thumbcrop_height'] ) : 300,
			isset( $description ) ? __( $description, 'fancy-grid-portfolio' ) : ''
		);
	}

	/**
	 * Get the settings option array and print  one of its values
	 */
	public function fgp_num_cols_callback( $args ) {
		$description = isset( $args['desc'] ) ? $args['desc'] : '';
		$num_columns = isset( $this->options['fgp_num_cols'] ) ? $this->options['fgp_num_cols'] : 3;
		?>
		<select name="fgp_option_name[fgp_num_cols]" id="fgp_option_name[fgp_num_cols]">
			<option value="2" <?php if ( $num_columns == 2 ) {
				echo 'selected="selected"';
			} ?>>2 Columns
			</option>
			<option value="3" <?php if ( $num_columns == 3 ) {
				echo 'selected="selected"';
			} ?>>3 Columns
			</option>
			<option value="4" <?php if ( $num_columns == 4 ) {
				echo 'selected="selected"';
			} ?>>4 Columns
			</option>
		</select>
		<p class="description"><?php _e( $description, 'fancy-grid-portfolio' ) ?></p>
		<?php
	}

	public function fgp_hide_filters_callback( $args ) {
		$description = isset( $args['desc'] ) ? $args['desc'] : '';
		$is_checked  = isset( $this->options['fgp_hide_filters'] ) ? $this->options['fgp_hide_filters'] : 0;
		printf(
			'<input name="fgp_option_name[fgp_hide_filters]" id="fgp_option_name[fgp_hide_filters]" type="checkbox" value="1" %s> %s',
			checked( $is_checked, 1, false ), $description
		);
	}


	/**
	 * List portfolio items for drag drop reorder
	 */
	function fgp_reorder_portfolio_callback() {

		include_once 'partials/fancy-grid-portfolio-reorder.php';

	}

	/**
	 * Save Reorder
	 */
	public function fgp_save_order() {
		// Check nonce
		if ( ! check_ajax_referer( 'fgp-token', 'token' ) ) {
			return wp_send_json_error( 'Invalid Token' );
		}

		// Check user permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			return wp_send_json_error( 'Not Authorized' );
		}

		$order = $_POST['order'];

		$counter = 0;

		foreach ( $order as $item_id ) {
			$portfolio_item = array(
				'ID'         => (int) $item_id,
				'menu_order' => $counter
			);

			//wp_update_post( $portfolio_item );

			$post_id = wp_update_post( $portfolio_item, true );
			if ( is_wp_error( $post_id ) ) {
				$errors = $post_id->get_error_messages();
				foreach ( $errors as $error ) {
					echo $error;
				}
			}

			$counter ++;
		}

		wp_send_json_success( 'Portfolio Order Saved' );
	}

	/**
	 * Handle image crop for thumbnails
	 */
	public function fgp_set_thumbnail_crop_sizes() {

		$crop_width  = isset ( $this->options['fgp_thumbcrop_width'] ) ? $this->options['fgp_thumbcrop_width'] : '';
		$crop_height = isset ( $this->options['fgp_thumbcrop_height'] ) ? $this->options['fgp_thumbcrop_height'] : '';

		add_image_size( 'fgp_thumbnail', $crop_width, $crop_height, array( 'top', 'center' ) );
	}

}

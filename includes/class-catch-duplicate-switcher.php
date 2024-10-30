<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.catchplugins.com
 * @since      1.0.0
 *
 * @package    Catch_Duplicate_Switcher
 * @subpackage Catch_Duplicate_Switcher/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Catch_Duplicate_Switcher
 * @subpackage Catch_Duplicate_Switcher/includes
 * @author     Catch Plugins <www.catchplugins.com>
 */
class Catch_Duplicate_Switcher {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Catch_Duplicate_Page_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->version = CATCH_DUPLICATE_VERSION;

		$this->plugin_name = 'catch-duplicate-switcher';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Catch_Duplicate_Page_Loader. Orchestrates the hooks of the plugin.
	 * - Catch_Duplicate_Page_i18n. Defines internationalization functionality.
	 * - Catch_Duplicate_Page_Admin. Defines all hooks for the admin area.
	 * - Catch_Duplicate_Page_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-catch-duplicate-switcher-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-catch-duplicate-switcher-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-catch-duplicate-switcher-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-catch-duplicate-switcher-public.php';


		$this->loader = new Catch_Duplicate_Switcher_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Catch_Duplicate_Page_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Catch_Duplicate_Switcher_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Catch_Duplicate_Switcher_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_settings_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->add_action('admin_action_dt_duplicate_post_as_draft',$plugin_admin,'dt_duplicate_post_as_draft' );
		$this->loader->add_filter('post_row_actions',$plugin_admin,'duplicate_post_link' ,10 , 2);
		$this->loader->add_filter('page_row_actions',$plugin_admin,'duplicate_post_link' ,10, 2);
		$this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'add_plugin_meta_links', 10, 2 );
			
		

		$this->loader->add_action('post_submitbox_misc_actions',$plugin_admin,'duplicate_page_button' );
		$this->loader->add_action('wp_before_admin_bar_render',$plugin_admin,'duplicate_page_admin_bar_link' );
        // switcher section
		$this->loader->add_action( 'manage_posts_columns', $plugin_admin, 'add_column' );
		$this->loader->add_action( 'manage_pages_columns', $plugin_admin, 'add_column' );
		$this->loader->add_action( 'manage_posts_custom_columns', $plugin_admin, 'manage_column', 10, 2 );
		$this->loader->add_action( 'manage_pages_custom_columns', $plugin_admin, 'manage_column', 10, 2);

		//Add UI to "Publish" metabox
		
	    $settings = catch_duplicate_switcher_get_options();
	    if( isset( $settings['switcher_status'] ) && 1 == $settings['switcher_status'] ) {
		$this->loader->add_action( 'quick_edit_custom_box', $plugin_admin, 'quick_edit' );
		$this->loader->add_action( 'bulk_edit_custom_box', $plugin_admin, 'quick_edit_bulk' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'quick_edit_script' );

		// Overide
		$this->loader->add_filter( 'wp_insert_attachment_data', $plugin_admin, 'override_type', 10, 2 );
		$this->loader->add_action( 'wp_insert_post_data', $plugin_admin, 'override_type', 10, 2);
		}

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Catch_Duplicate_Switcher_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Catch_Duplicate_Page_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.magayo.com
 * @since      1.0.0
 *
 * @package    Magayo_Lottery_Results
 * @subpackage Magayo_Lottery_Results/includes
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
 * @package    Magayo_Lottery_Results
 * @subpackage Magayo_Lottery_Results/includes
 * @author     magayo <support@magayo.com>
 */
class Magayo_Lottery_Results {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Magayo_Lottery_Results_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->plugin_name = 'magayo-lottery-results';
		
		// *** Update version ***
		$this->version = '2.0.12';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// ******** 06/08/16 MLR ********
		$this->define_widget_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Magayo_Lottery_Results_Loader. Orchestrates the hooks of the plugin.
	 * - Magayo_Lottery_Results_i18n. Defines internationalization functionality.
	 * - Magayo_Lottery_Results_Admin. Defines all hooks for the admin area.
	 * - Magayo_Lottery_Results_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-magayo-lottery-results-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-magayo-lottery-results-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-magayo-lottery-results-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-magayo-lottery-results-public.php';
		
		// ******** 06/08/16 MLR ********
		/**
		 * The class responsible for defining all actions in the widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-magayo-lottery-results-widget.php';

		$this->loader = new Magayo_Lottery_Results_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Magayo_Lottery_Results_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Magayo_Lottery_Results_i18n();

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

		$plugin_admin = new Magayo_Lottery_Results_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// ******** 04/08/16 MLR ********
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update');
		$this->loader->add_action ('magayo_lottery_results_cron', $plugin_admin, 'get_results'); 

		// Version 2: Add jackpots
		$this->loader->add_action ('magayo_lottery_jackpots_cron', $plugin_admin, 'get_jackpots'); 
		
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );
		
		$this->loader->add_filter( 'cron_schedules',  $plugin_admin, 'cron_add_weekly' );
		$this->loader->add_filter( 'cron_schedules',  $plugin_admin, 'cron_add_every_3_days' );
		$this->loader->add_filter( 'cron_schedules',  $plugin_admin, 'cron_add_every_2_days' );
		$this->loader->add_filter( 'cron_schedules',  $plugin_admin, 'cron_add_every_6_hours' );
		$this->loader->add_filter( 'cron_schedules',  $plugin_admin, 'cron_add_every_3_hours' );
		$this->loader->add_filter( 'cron_schedules',  $plugin_admin, 'cron_add_every_2_hours' );
		$this->loader->add_filter( 'cron_schedules',  $plugin_admin, 'cron_add_every_30_minutes' );
		$this->loader->add_filter( 'cron_schedules',  $plugin_admin, 'cron_add_every_15_minutes' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Magayo_Lottery_Results_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	// ******** 06/08/16 MLR ********
	/**
	 * Register all of the hooks related to the widget functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_widget_hooks() {

		$plugin_widget = new Magayo_Lottery_Results_Widget();

//		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
//		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Hooks for widget
		$this->loader->add_action( 'widgets_init', $plugin_widget, 'register_magayo_lottery_results_widget' );

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
	 * @return    Magayo_Lottery_Results_Loader    Orchestrates the hooks of the plugin.
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

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.magayo.com
 * @since      1.0.0
 *
 * @package    Magayo_Lottery_Results
 * @subpackage Magayo_Lottery_Results/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Magayo_Lottery_Results
 * @subpackage Magayo_Lottery_Results/admin
 * @author     magayo <support@magayo.com>
 */
class Magayo_Lottery_Results_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    		The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		// ******** 04/08/16 MLR ********
        $this->magayo_lottery_results_options = get_option($this->plugin_name);

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
		 * defined in Magayo_Lottery_Results_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Magayo_Lottery_Results_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/magayo-lottery-results-admin.css', array(), $this->version, 'all' );

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
		 * defined in Magayo_Lottery_Results_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Magayo_Lottery_Results_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/magayo-lottery-results-admin.js', array( 'jquery' ), $this->version, false );

	}
	
    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         */
        $plugin_screen_hook_suffix = add_options_page( __('magayo Lottery Results', $this->plugin_name ), 'magayo Lottery Results', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page() {
		
		// ******** 05/08/16 MLR ********
		$notify_success = false;
		$notify_info = false;
		$notify_error = false;
		$notify_message = '';
		
		$options = get_option($this->plugin_name);
		$email_address = $options['email_address'];
		$api_key = $options['api_key'];
		$supported_games = $options['supported_games'];
		$selected_games = $options['selected_games'];
		$cron_frequency = $options['cron_frequency'];
		
		if ($options['show_country'] == 1)
			$show_country = true;
		else
			$show_country = false;
		
		if ($options['show_state'] == 1)
			$show_state = true;
		else
			$show_state = false;
		
		$language = $options['language'];
		$date_format = $options['date_format'];
		
		if ($options['show_weekday'] == 1)
			$show_weekday = true;
		else
			$show_weekday = false;
		
		if ($options['show_bonus_name'] == 1)
			$show_bonus_name = true;
		else
			$show_bonus_name = false;

		$main_color = $options['main_color'];
		$bonus_color = $options['bonus_color'];
		$digit_color = $options['digit_color'];
		$post_user_id = $options['post_user_id'];
		$post_category = $options['post_category'];
		
		if ($options['tag_country'] == 1)
			$tag_country = true;
		else
			$tag_country = false;
		
		if ($options['tag_state'] == 1)
			$tag_state = true;
		else
			$tag_state = false;
		
		if ($options['tag_game'] == 1)
			$tag_game = true;
		else
			$tag_game = false;
		
		// Version 2: Add jackpots
		$supported_jackpots = $options['supported_jackpots'];
		$selected_jackpots = $options['selected_jackpots'];
		
		$count_selected_games = 0;
		$form_selected_games = array();
		$form_selected_names = array();
		$form_selected_values = array();
		
		if (strlen($selected_games) > 10) {
			$form_selected_games = preg_split("/;/", $selected_games);
			
			for ($i=0; $i<count($form_selected_games); $i++) {
				$temp = $form_selected_games[$i];
				$temp_pos = strpos($temp, "=");
				$temp_name = substr($temp, 0, $temp_pos);
				$temp_value = substr($temp, ($temp_pos+1));
				array_push($form_selected_names, $temp_name);
				array_push($form_selected_values, $temp_value);
				$count_selected_games++;
			}
		}
		
		// Version 2: Add jackpots
		$count_selected_jackpots = 0;
		$form_selected_jackpots = array();
		$form_selected_jackpot_names = array();
		$form_selected_jackpot_values = array();
		
		if (strlen($selected_jackpots) > 10) {
			$form_selected_jackpots = preg_split("/;/", $selected_jackpots);
			
			for ($i=0; $i<count($form_selected_jackpots); $i++) {
				$temp = $form_selected_jackpots[$i];
				$temp_pos = strpos($temp, "=");
				$temp_name = substr($temp, 0, $temp_pos);
				$temp_value = substr($temp, ($temp_pos+1));
				array_push($form_selected_jackpot_names, $temp_name);
				array_push($form_selected_jackpot_values, $temp_value);
				$count_selected_jackpots++;
			}
		}
		
		if (isset($_POST['submit_getting_started'])) {
			if ( current_user_can( 'manage_options' ) ) {
				if (isset($_POST['email_address'])) {
					$email_address = sanitize_email($_POST['email_address']);
					
					if (strcmp($email_address, $options['email_address']) <> 0) {
						if ( $this->process_email($email_address, $notify_message) ) {
							$options['email_address'] = $email_address;
							update_option( $this->plugin_name, $options );
							
							$notify_success = true;
						} else {
							$notify_error = true;
						}
					}
					
				}
				
				if (isset($_POST['api_key'])) {
					$api_key = sanitize_text_field($_POST['api_key']);
					
					if (strcmp($api_key, $options['api_key']) <> 0) {
						if ( $this->process_api_key($api_key, $supported_games, $notify_message) ) {
							$options['api_key'] = $api_key;
							$options['supported_games'] = $supported_games;
							
							// Version 2: Get supported jackpots
							if ( $this->process_api_key_jackpots($api_key, $supported_jackpots, $notify_message) ) {
								$options['supported_jackpots'] = $supported_jackpots;
								update_option( $this->plugin_name, $options );
								
								$notify_success = true;
							} else {
								$notify_error = true;
							}
						} else {
							$notify_error = true;
						}
					}
				}
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}
			
		} elseif (isset($_POST['submit_refresh_games'])) {
			if ( current_user_can( 'manage_options' ) ) {
				if (strlen($api_key) == 18) {
					if ( $this->process_api_key($api_key, $supported_games, $notify_message) ) {
						$options['supported_games'] = $supported_games;
						update_option( $this->plugin_name, $options );
						
						$notify_success = true;
						$notify_message = 'List of supported games refreshed successfully.';
					} else {
						$notify_error = true;
					}
				}
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}
			
		} elseif (isset($_POST['submit_add_game'])) {
			if ( current_user_can( 'manage_options' ) ) {
				if (isset($_POST['supported_games'])) {
					$selected_game = sanitize_text_field($_POST['supported_games']);
					
					if (strlen($selected_game) > 10) {					
						$found = false;
						for ($i=0; $i<count($form_selected_games); $i++) {
							if (strcmp($form_selected_games[$i], $selected_game) == 0) {
								$found = true;
								break;
							}
						}
						
						if (!$found) {
							$temp_pos = strpos($selected_game, "=");
							$temp_name = substr($selected_game, 0, $temp_pos);
							$temp_value = substr($selected_game, ($temp_pos+1));
							
							array_push($form_selected_games, $selected_game);
							array_push($form_selected_names, $temp_name);
							array_push($form_selected_values, $temp_value);
							$count_selected_games++;
							
							if (strlen($selected_games) > 10)
								$selected_games = $selected_games . ";" . $selected_game;
							else
								$selected_games = $selected_game;
							
							$options['selected_games'] = $selected_games;
							update_option( $this->plugin_name, $options );
				
							if (wp_next_scheduled('magayo_lottery_results_cron')) {
								$timestamp = wp_next_scheduled('magayo_lottery_results_cron');
								wp_unschedule_event($timestamp, 'magayo_lottery_results_cron');
							}
							
							wp_schedule_event( time(), $cron_frequency, 'magayo_lottery_results_cron' );
							
							$notify_success = true;
							$notify_message = $temp_name . ' added.';
						} else {
							$temp_pos = strpos($selected_game, "=");
							$temp_name = substr($selected_game, 0, $temp_pos);
							$temp_value = substr($selected_game, ($temp_pos+1));

							$notify_info = true;
							$notify_message = 'You had already selected ' . $temp_name . '.';
						}
					}
				}
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}
			
		} elseif (isset($_POST['submit_clear_selection'])) {
			if ( current_user_can( 'manage_options' ) ) {
				if ($count_selected_games > 0) {
					$selected_games = '';
					$options['selected_games'] = $selected_games;
					update_option( $this->plugin_name, $options );
					
					unset($form_selected_games);
					unset($form_selected_names);
					unset($form_selected_values);

					$notify_success = true;
					
					if ($count_selected_games > 1)
						$notify_message = "Your selected games have been removed.";				
					else
						$notify_message = "Your selected game has been removed.";				
						
					$count_selected_games = 0;
					$form_selected_games = array();
					$form_selected_names = array();
					$form_selected_values = array();
				} else {
					$notify_info = true;
					$notify_message = "You have not selected any game.";
				}
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}

		// Version 2: Add jackpots
		} elseif (isset($_POST['submit_refresh_jackpots'])) {
			if ( current_user_can( 'manage_options' ) ) {
				if (strlen($api_key) == 18) {
					if ( $this->process_api_key_jackpots($api_key, $supported_jackpots, $notify_message) ) {
						$options['supported_jackpots'] = $supported_jackpots;
						update_option( $this->plugin_name, $options );
						
						$notify_success = true;
						$notify_message = 'List of supported jackpots refreshed successfully.';
					} else {
						$notify_error = true;
					}
				}
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}
			
		} elseif (isset($_POST['submit_add_jackpot'])) {
			if ( current_user_can( 'manage_options' ) ) {
				if (isset($_POST['supported_jackpots'])) {
					$selected_jackpot = sanitize_text_field($_POST['supported_jackpots']);
					
					if (strlen($selected_jackpot) > 10) {					
						$found = false;
						for ($i=0; $i<count($form_selected_jackpots); $i++) {
							if (strcmp($form_selected_jackpots[$i], $selected_jackpot) == 0) {
								$found = true;
								break;
							}
						}
						
						if (!$found) {
							$temp_pos = strpos($selected_jackpot, "=");
							$temp_name = substr($selected_jackpot, 0, $temp_pos);
							$temp_value = substr($selected_jackpot, ($temp_pos+1));
							
							array_push($form_selected_jackpots, $selected_jackpot);
							array_push($form_selected_jackpot_names, $temp_name);
							array_push($form_selected_jackpot_values, $temp_value);
							$count_selected_jackpots++;
							
							if (strlen($selected_jackpots) > 10)
								$selected_jackpots = $selected_jackpots . ";" . $selected_jackpot;
							else
								$selected_jackpots = $selected_jackpot;
							
							$options['selected_jackpots'] = $selected_jackpots;
							update_option( $this->plugin_name, $options );
				
							if (wp_next_scheduled('magayo_lottery_jackpots_cron')) {
								$timestamp = wp_next_scheduled('magayo_lottery_jackpots_cron');
								wp_unschedule_event($timestamp, 'magayo_lottery_jackpots_cron');
							}
							
							wp_schedule_event( time(), $cron_frequency, 'magayo_lottery_jackpots_cron' );
							
							$notify_success = true;
							$notify_message = $temp_name . ' jackpot added.';
						} else {
							$temp_pos = strpos($selected_jackpot, "=");
							$temp_name = substr($selected_jackpot, 0, $temp_pos);
							$temp_value = substr($selected_jackpot, ($temp_pos+1));

							$notify_info = true;
							$notify_message = 'You had already selected ' . $temp_name . '.';
						}
					}
				}
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}
			
		} elseif (isset($_POST['submit_clear_jackpot_selection'])) {
			if ( current_user_can( 'manage_options' ) ) {
				if ($count_selected_jackpots > 0) {
					$selected_jackpots = '';
					$options['selected_jackpots'] = $selected_jackpots;
					update_option( $this->plugin_name, $options );
					
					unset($form_selected_jackpots);
					unset($form_selected_jackpot_names);
					unset($form_selected_jackpot_values);

					$notify_success = true;
					
					if ($count_selected_jackpots > 1)
						$notify_message = "Your selected jackpots have been removed.";				
					else
						$notify_message = "Your selected jackpot has been removed.";				
						
					$count_selected_jackpots = 0;
					$form_selected_jackpots = array();
					$form_selected_names = array();
					$form_selected_values = array();
				} else {
					$notify_info = true;
					$notify_message = "You have not selected any jackpot.";
				}
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}
			
		} elseif (isset($_POST['submit_save_frequency'])) {
			if ( current_user_can( 'manage_options' ) ) {
				if (isset($_POST['cron_frequency'])) {
					$cron_frequency = sanitize_text_field($_POST['cron_frequency']);
					$options['cron_frequency'] = $cron_frequency;
					update_option( $this->plugin_name, $options );
				
					// 08/08/16 Cron automatically runs for the first time shortly after calling wp_schedule_event
//					$this->get_results();
				
					if (wp_next_scheduled('magayo_lottery_results_cron')) {
						$timestamp = wp_next_scheduled('magayo_lottery_results_cron');
						wp_unschedule_event($timestamp, 'magayo_lottery_results_cron');
					}
					
					wp_schedule_event( time(), $cron_frequency, 'magayo_lottery_results_cron' );
				
					// Version 2: Jackpot cron
					if (wp_next_scheduled('magayo_lottery_jackpots_cron')) {
						$timestamp = wp_next_scheduled('magayo_lottery_jackpots_cron');
						wp_unschedule_event($timestamp, 'magayo_lottery_jackpots_cron');
					}
					
					wp_schedule_event( time(), $cron_frequency, 'magayo_lottery_jackpots_cron' );
					
					$notify_success = true;
					$notify_message = 'Update frequency saved.';
				}
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}
			
		} elseif (isset($_POST['submit_display_settings'])) {
			if ( current_user_can( 'manage_options' ) ) {
				$update = false;
				
				if (isset($_POST['show_country']) && !empty($_POST['show_country']) ) {
					$options['show_country'] = 1;
					$show_country = true;
				} else {
					$options['show_country'] = 0;
					$show_country = false;
				}
				
				if (isset($_POST['show_state']) && !empty($_POST['show_state']) ) {
					$options['show_state'] = 1;
					$show_state = true;
				} else {
					$options['show_state'] = 0;
					$show_state = false;
				}
				
				if (isset($_POST['language'])) {
					$language = sanitize_text_field($_POST['language']);
					$options['language'] = $language;
		
					if (($language == "es") || ($language == "pt")) {
						if (($date_format == "M-d, Y") || ($date_format == "M d, Y") || ($date_format == "d-M-Y"))
							$date_format = "d M Y";
					} elseif ($language == "zh") {
						if (($date_format == "M-d, Y") || ($date_format == "M d, Y") || 
							($date_format == "d-M-Y") || ($date_format == "d M Y"))
							$date_format = "Y-m-d";
					}
					
					$options['date_format'] = $date_format;
				}
				
				if (isset($_POST['date_format'])) {
					$date_format = sanitize_text_field($_POST['date_format']);
		
					if (($language == "es") || ($language == "pt")) {
						if (($date_format == "M-d, Y") || ($date_format == "M d, Y") || ($date_format == "d-M-Y"))
							$date_format = "d M Y";
					} elseif ($language == "zh") {
						if (($date_format == "M-d, Y") || ($date_format == "M d, Y") || 
							($date_format == "d-M-Y") || ($date_format == "d M Y"))
							$date_format = "Y-m-d";
					}
					
					$options['date_format'] = $date_format;
				}
				
				if (isset($_POST['show_weekday']) && !empty($_POST['show_weekday']) ) {
					$options['show_weekday'] = 1;
					$show_weekday = true;
				} else {
					$options['show_weekday'] = 0;
					$show_weekday = false;
				}
				
				if (isset($_POST['show_bonus_name']) && !empty($_POST['show_bonus_name']) ) {
					$options['show_bonus_name'] = 1;
					$show_bonus_name = true;
				} else {
					$options['show_bonus_name'] = 0;
					$show_bonus_name = false;
				}
				
				if (isset($_POST['main_color']) && !empty($_POST['main_color']) ) {
					$main_color = sanitize_text_field($_POST['main_color']);
					$options['main_color'] = $main_color;
				}
				
				if (isset($_POST['bonus_color']) && !empty($_POST['bonus_color']) ) {
					$bonus_color = sanitize_text_field($_POST['bonus_color']);
					$options['bonus_color'] = $bonus_color;
				}
				
				if (isset($_POST['digit_color']) && !empty($_POST['digit_color']) ) {
					$digit_color = sanitize_text_field($_POST['digit_color']);
					$options['digit_color'] = $digit_color;
				}
				
				if (isset($_POST['post_user_id'])) {
					$temp_user_id = sanitize_text_field($_POST['post_user_id']);
					$post_user_id = (int)$temp_user_id;
					$options['post_user_id'] = $post_user_id;
				}
				
				if (isset($_POST['post_category'])) {
					$post_category = sanitize_text_field($_POST['post_category']);
					$options['post_category'] = $post_category;
				}
				
				if (isset($_POST['tag_country']) && !empty($_POST['tag_country']) ) {
					$options['tag_country'] = 1;
					$tag_country = true;
				} else {
					$options['tag_country'] = 0;
					$tag_country = false;
				}
				
				if (isset($_POST['tag_state']) && !empty($_POST['tag_state']) ) {
					$options['tag_state'] = 1;
					$tag_state = true;
				} else {
					$options['tag_state'] = 0;
					$tag_state = false;
				}
				
				if (isset($_POST['tag_game']) && !empty($_POST['tag_game']) ) {
					$options['tag_game'] = 1;
					$tag_game = true;
				} else {
					$options['tag_game'] = 0;
					$tag_game = false;
				}
				
				update_option( $this->plugin_name, $options );
				
				$notify_success = true;
				$notify_message = 'Display settings saved.';
				
			} else {
				$notify_error = true;
				$notify_message = "Oops, it appears that you do not have the privilege to make changes.";				
			}
			
		}
		
		$count_supported_games = 0;
		$form_supported_games = array();
		$form_supported_names = array();
		$form_supported_values = array();
		
		if (strlen($supported_games) > 10) {
			$form_supported_games = preg_split("/;/", $supported_games);
			
			for ($i=0; $i<count($form_supported_games); $i++) {
				$temp = $form_supported_games[$i];
				$temp_pos = strpos($temp, "=");
				$temp_name = substr($temp, 0, $temp_pos);
				$temp_value = substr($temp, ($temp_pos+1));
				array_push($form_supported_names, $temp_name);
				array_push($form_supported_values, $temp_value);
				$count_supported_games++;
			}
		}
		
		// Version 2: Add jackpots
		$count_supported_jackpots = 0;
		$form_supported_jackpots = array();
		$form_supported_jackpot_names = array();
		$form_supported_jackpot_values = array();
		
		if (strlen($supported_jackpots) > 10) {
			$form_supported_jackpots = preg_split("/;/", $supported_jackpots);
			
			for ($i=0; $i<count($form_supported_jackpots); $i++) {
				$temp = $form_supported_jackpots[$i];
				$temp_pos = strpos($temp, "=");
				$temp_name = substr($temp, 0, $temp_pos);
				$temp_value = substr($temp, ($temp_pos+1));
				array_push($form_supported_jackpot_names, $temp_name);
				array_push($form_supported_jackpot_values, $temp_value);
				$count_supported_jackpots++;
			}
		}
		
        include_once( 'partials/magayo-lottery-results-admin-display.php' );
		
    }
	
    /**
     * Process API key input to retrieve & refresh list of supported jackpots.
     *
     * @since    2.0.0
     */
    private function process_api_key_jackpots($input, &$games, &$message) {
		if ( strlen($input) == 18 ) {
			if ( ctype_alnum($input) ) {
				$domain = home_url();
				$domain = preg_replace('#^https?://#', '', $domain);
				$domain = preg_replace('/^www\./', '', $domain);
				
				$base_url = 'https://www.magayo.com/api/wp_jackpots.php?';
				$url = $base_url . 'api_key=' . $input;
				$url = $url . '&domain=' . $domain;
				
				$response = wp_remote_post($url);
				
				if (!is_wp_error($response)) {
					$json_data = json_decode(wp_remote_retrieve_body($response));
					
					if ($json_data->error == 0) {
						$games = $json_data->games;
						$message = "API key saved and you can proceed to configure the display settings and select your game(s).";
						return true;
					} else {
						$message = $json_data->error_message;
						return false;
					}
					
				} else {
					$http_code = wp_remote_retrieve_response_code( $response );
					$message = "Unable to connect - " . $http_code . "";
					return false;
				}
			}
		}
		
		$message = 'Please enter a valid API key.';
		return false;
    }
	
    /**
     * Process API key input to retrieve & refresh list of supported games.
     *
     * @since    1.0.0
     */
    private function process_api_key($input, &$games, &$message) {
		if ( strlen($input) == 18 ) {
			if ( ctype_alnum($input) ) {
				$domain = home_url();
				$domain = preg_replace('#^https?://#', '', $domain);
				$domain = preg_replace('/^www\./', '', $domain);
				
				$base_url = 'https://www.magayo.com/api/wp_games.php?';
				$url = $base_url . 'api_key=' . $input;
				$url = $url . '&domain=' . $domain;
				
				$response = wp_remote_post($url);
				
				if (!is_wp_error($response)) {
					$json_data = json_decode(wp_remote_retrieve_body($response));
					
					if ($json_data->error == 0) {
						$games = $json_data->games;
						$message = "API key saved and you can proceed to configure the display settings and select your game(s).";
						return true;
					} else {
						$message = $json_data->error_message;
						return false;
					}
					
				} else {
					$http_code = wp_remote_retrieve_response_code( $response );
					$message = "Unable to connect - " . $http_code . "";
					return false;
				}
			}
		}
		
		$message = 'Please enter a valid API key.';
		return false;
    }
	
    /**
     * Process form email input.
     *
     * @since    1.0.0
     */
    private function process_email($input, &$message) {
		if ( !empty($input) ) {
			if ( is_email($input) ) {
				$domain = home_url();
				$domain = preg_replace('#^https?://#', '', $domain);
				$domain = preg_replace('/^www\./', '', $domain);
				
				$base_url = 'https://www.magayo.com/api/wp_register.php?';
				$url = $base_url . 'email=' . $input;
				$url = $url . '&domain=' . $domain;
				
				$response = wp_remote_post($url);
				
				if (!is_wp_error($response)) {
					$json_data = json_decode(wp_remote_retrieve_body($response));
					
					if ($json_data->error == 0) {
						$message = "Your API account has been created. Please check your email, including your spam folder, for the API key.";
						return true;
					} elseif ($json_data->error == 400) {
						$message = "You have already registered. Please login to our <a href=\"https://www.magayo.com/api/\" target=\"_blank\">API area</a> to check your API key.";
						return true;
					} else {
						$message = $json_data->error_message;
						return false;
					}
					
				} else {
					$http_code = wp_remote_retrieve_response_code( $response );
					$message = "Unable to connect - " . $http_code . "";
					return false;
				}
			} else {
				$message = 'Please enter a valid email address.';
				return false;
			}
		}
		
		$message = 'Please enter your email address.';
		return false;
    }
	
    /**
     * Get lottery jackpots for all selected games.
     *
     * @since    2.0.0
     */
	public function get_jackpots() {
		
		$options = get_option($this->plugin_name);
		$api_key = $options['api_key'];
		$selected_jackpots = $options['selected_jackpots'];
		
		if ($options['show_country'] == 1)
			$show_country = true;
		else
			$show_country = false;
		
		if ($options['show_state'] == 1)
			$show_state = true;
		else
			$show_state = false;
		
		$language = $options['language'];
		$date_format = $options['date_format'];
		
		if ($options['show_weekday'] == 1)
			$show_weekday = true;
		else
			$show_weekday = false;
		
		if ($options['show_bonus_name'] == 1)
			$show_bonus_name = true;
		else
			$show_bonus_name = false;

		$post_user_id = $options['post_user_id'];
		$post_category = $options['post_category'];
		
		if ($options['tag_country'] == 1)
			$tag_country = true;
		else
			$tag_country = false;
		
		if ($options['tag_state'] == 1)
			$tag_state = true;
		else
			$tag_state = false;
		
		if ($options['tag_game'] == 1)
			$tag_game = true;
		else
			$tag_game = false;
		
		$count_selected_jackpots = 0;
		$form_selected_jackpots = array();
		$form_selected_jackpot_names = array();
		$form_selected_jackpot_values = array();
		
		if (strlen($selected_jackpots) > 10) {
			$domain = home_url();
			$domain = preg_replace('#^https?://#', '', $domain);
			$domain = preg_replace('/^www\./', '', $domain);
			
			// Version 2: Calls wp_results_option
			$base_url = 'https://www.magayo.com/api/wp_next_jackpot.php?';
			$url = $base_url . 'api_key=' . $api_key;
			$url = $url . '&domain=' . $domain;
			$url = $url . '&game=';

			$form_selected_jackpots = preg_split("/;/", $selected_jackpots);
			
			for ($i=0; $i<count($form_selected_jackpots); $i++) {
				$temp = $form_selected_jackpots[$i];
				$temp_pos = strpos($temp, "=");
				$temp_name = substr($temp, 0, $temp_pos);
				$temp_value = substr($temp, ($temp_pos+1));
				array_push($form_selected_jackpot_names, $temp_name);
				array_push($form_selected_jackpot_values, $temp_value);
				$count_selected_jackpots++;
				
				$temp_url = $url . $temp_value;
				$response = wp_remote_post($temp_url);
				
				if (!is_wp_error($response)) {
					$json_data = json_decode(wp_remote_retrieve_body($response));
					
					if ($json_data->error == 0) {
						$json_next_draw = $json_data->next_draw;
						$json_currency = $json_data->currency;
						$jason_jackpot = $json_data->jackpot;
						
						if ($this->post_jackpot_exists($temp_name, $show_country, $show_state, $language, $date_format, $json_next_draw)) {
							if (WP_DEBUG) {
								$log_message = $temp_value . " jackpot: " . $json_next_draw . " - Already posted.";
								error_log($log_message);
							}
						} else {						
							if (WP_DEBUG) {
								$log_message = $temp_value . "jackpot : " . $json_next_draw . " - " . $json_currency . "," . $jason_jackpot;
								error_log($log_message);
							}
							
							$this->post_lotto_jackpot($temp_name, $show_country, $show_state, $language,
														$date_format, $show_weekday, $json_next_draw, $json_currency, $jason_jackpot,
														$post_user_id, $post_category, $tag_country, $tag_state, $tag_game);
						
						}
					} else {
						if (WP_DEBUG) {
							$json_error = $json_data->error;
							$json_error_message = $json_data->error_message;
							$log_message = "Error (jackpot): " . $json_error . " - " . $json_error_message;
							error_log($log_message);
						}
					}
				} else {
					if (WP_DEBUG) {
						$http_code = wp_remote_retrieve_response_code( $response );
						$log_message = "HTTP Error (jackpot): " . $http_code;
						error_log($log_message);
					}
				}
			}
		} else {
			if (WP_DEBUG) {
				$log_message = "No jackpots selected.";
				error_log($log_message);
			}			
		}
	}
	
    /**
     * Check if jackpot exists to prevent duplicate posts.
     *
     * @since    2.0.0
     */
	private function post_jackpot_exists($game_name, $show_country, $show_state, $language, $date_format, $next_draw) {
		
		$pos1 = strpos($game_name, "/");
		$country = substr($game_name, 0, $pos1);
		
		if ($country == "USA") {
			$pos2 = strpos($game_name, "/", ($pos1+1));
			
			if ($pos2 === false) {
				$state = '';
				$game = substr($game_name, ($pos1+1));
			} else {
				$state = substr($game_name, ($pos1+1), ($pos2-($pos1+1)));
				$game = substr($game_name, ($pos2+1));
			}
		} else {
			$state = '';
			$game = substr($game_name, ($pos1+1));
		}
		
		$post_title = '';
		
		if ($show_country) {
			$post_title = $country;
		}
		
		if ($show_state) {
			if (strlen($state) > 0) {
				if (strlen($post_title) > 0) {
					$post_title = $post_title . " " . $state;
				} else {
					$post_title = $state;
				}
			}
		}
		
		if (strlen($post_title) > 0) {
			$post_title = $post_title . " " . $game . " Jackpot";
		} else {
			$post_title = $game . " Jackpot";
		}
		
		list ($year, $month, $day) = preg_split("/-/", $next_draw); 
		
		if(!checkdate($month, $day, $year)) {
			if (WP_DEBUG) {
				$log_message = $game . ": Invalid next draw - " . $next_draw;
				error_log($log_message);
			}
			
			return;
		}

		$draw_datetime = mktime(0, 0, 0, $month, $day, $year);
		$draw = date($date_format, $draw_datetime);
		
		if ($draw == false) {
			$draw = $next_draw;
			
			if (WP_DEBUG) {
				$log_message = $game . ": Error formatting next draw date - " . $next_draw;
				error_log($log_message);
			}
		}
		
		$post_title = $post_title . " - " . $draw;		
		$post_title = preg_replace('/ & /', ' ', $post_title);
		
		$page = get_page_by_title($post_title, OBJECT, 'post');

		if (isset($page) && !empty($page) )
			return true;
			
		return false;
		
	}

    /**
     * Insert post for Lotto jackpot.
     *
     * @since    2.0.0
     */
	private function post_lotto_jackpot($game_name, $show_country, $show_state, $language,
										$date_format, $show_weekday, $next_draw, $currency, $jackpot,
										$post_user_id, $post_category, $tag_country, $tag_state, $tag_game) {
		
		$pos1 = strpos($game_name, "/");
		$country = substr($game_name, 0, $pos1);
		
		if ($country == "USA") {
			$pos2 = strpos($game_name, "/", ($pos1+1));
			
			if ($pos2 === false) {
				$state = '';
				$game = substr($game_name, ($pos1+1));
			} else {
				$state = substr($game_name, ($pos1+1), ($pos2-($pos1+1)));
				$game = substr($game_name, ($pos2+1));
			}
		} else {
			$state = '';
			$game = substr($game_name, ($pos1+1));
		}
		
		$post_title = '';
		
		if ($show_country) {
			$post_title = $country;
		}
		
		if ($show_state) {
			if (strlen($state) > 0) {
				if (strlen($post_title) > 0) {
					$post_title = $post_title . " " . $state;
				} else {
					$post_title = $state;
				}
			}
		}
		
		// Version 2: Set alignment via CSS
		$post_content = '<p class="lotto-jackpot-header">';

		if (strlen($post_title) > 0)
			$post_content = $post_content . "Next " . $post_title . " " . $game . " Jackpot";
		else
			$post_content = $post_content . "Next " . $game . " Jackpot";
		
		if (strlen($post_title) > 0) {
			$post_title = $post_title . " " . $game . " Jackpot";
		} else {
			$post_title = $game . " Jackpot";
		}

		$post_content = $post_content . "</p>";

		$post_content = $post_content . '<p class="lotto-jackpot-date">';
		
		list ($year, $month, $day) = preg_split("/-/", $next_draw); 
		
		if(!checkdate($month, $day, $year)) {
			if (WP_DEBUG) {
				$log_message = $game . ": Invalid next draw - " . $next_draw;
				error_log($log_message);
			}
			
			return;
		}

		$post_date = date("Y-m-d H:i:s");

		$draw_datetime = mktime(0, 0, 0, $month, $day, $year);
		$draw = date($date_format, $draw_datetime);
		
		if ($draw == false) {
			$draw = $next_draw;
			
			if (WP_DEBUG) {
				$log_message = $game . ": Error formatting next draw date - " . $next_draw;
				error_log($log_message);
			}
		}
		
		$post_title = $post_title . " - " . $draw;
		$post_title = preg_replace('/ & /', ' ', $post_title);
		$post_content = $post_content . $draw;
		
		if ($show_weekday) {
			$draw_day = date("l", $draw_datetime);
			$post_content = $post_content . " (" . $draw_day . ")";
		}

		$post_content = $post_content . "</p>";
		$post_content = $post_content . '<p class="lotto-jackpot-amount">';
		
		$format_jackpot = number_format($jackpot);
		
		if ($currency == "EUR")
			$post_content = $post_content . "&euro;" . $format_jackpot;
		elseif ($currency == "BRL")
			$post_content = $post_content . "R$" . $format_jackpot;
		elseif ($currency == "CHF")
			$post_content = $post_content . "CHF " . $format_jackpot;
		elseif ($currency == "GBP")
			$post_content = $post_content . "&pound;" . $format_jackpot;
		elseif ($currency == "MYR")
			$post_content = $post_content . "RM " . $format_jackpot;
		elseif ($currency == "PLN")
			$post_content = $post_content . $format_jackpot . " zł";
		elseif ($currency == "SEK")
			$post_content = $post_content . $format_jackpot . " kr";
		elseif ($currency == "ZAR")
			$post_content = $post_content . "R " . $format_jackpot;
		else
			$post_content = $post_content . "$" . $format_jackpot;
		
		$post_content = $post_content . '</p>';
		
		$new_post = array(
			'post_title' => $post_title,
			'post_content' => $post_content,
			'post_status' => 'publish',
			'post_author' => $post_user_id, 
			'post_date' => $post_date,
			'post_type' => 'post',
			'post_category' => array(0)
		);
		
		$post_id = wp_insert_post($new_post);
		
		if ($post_id <= 0) {
			if (WP_DEBUG) {
				$log_message = $game . ": Error inserting jackpot - " . $next_draw. ", " . $currency . ", " . $jackpot;
				error_log($log_message);
			}
			
			return;
		}
		
		if ($post_category == "country-state") {
			if (strlen($state) > 0)
				$category = $country . " " . $state . " Lottery Jackpots";
			else
				$category = $country . " Lottery Jackpots";
		} elseif ($post_category == "country") {
			$category = $country . " Lottery Jackpots";
		} elseif ($post_category == "state") {
			if (strlen($state) > 0)
				$category = $state . " Lottery Jackpots";
			else
				$category = $country . " Lottery Jackpots";
		} else {
			$category = $game . " Jackpots";
		}
		
		$category = preg_replace('/ & /', ' ', $category);
		
		if (is_category($category)) {
			$category_id = get_cat_ID( $category );
			
			if ($category_id <= 0) {
				if (WP_DEBUG) {
					$log_message = $game . ": Error getting category ID for jackpot - " . $category;
					error_log($log_message);
				}
			} else {
				$category_ids = array($category_id);
				wp_set_post_categories( $post_id, $category_ids, false );
			}
		} else {			
			wp_insert_term( $category, 'category' );
			$category_id = get_cat_ID( $category );

			if ($category_id <= 0) {
				if (WP_DEBUG) {
					$log_message = $game . ": Error creating category for jackpot - " . $category;
					error_log($log_message);
				}
			} else {
				$category_ids = array($category_id);
				wp_set_post_categories( $post_id, $category_ids, false );
			}
		}
		
		$tags = array();
		
		if ($tag_country) {
			$country_tag = strtolower($country);
			$country_tag = $country_tag . " lottery jackpots";
			array_push($tags, $country_tag);
		}
		
		if ($tag_state) {
			if (strlen($state) > 0) {
				$state_tag = strtolower($state);
				$state_tag = $state_tag . " lottery jackpots";
				array_push($tags, $state_tag);
			}
		}
		
		if ($tag_game) {
			$game_tag = strtolower($game);
			$game_tag = $game_tag . " jackpots";
			array_push($tags, $game_tag);
		}
		
		if (count($tags) > 0) {
			wp_set_post_tags( $post_id, $tags, false );
		}
		
	}

    /**
     * Get draw results for all selected games.
     *
     * @since    1.0.0
     */
	public function get_results() {
		
		$options = get_option($this->plugin_name);
		$api_key = $options['api_key'];
		$selected_games = $options['selected_games'];
		
		if ($options['show_country'] == 1)
			$show_country = true;
		else
			$show_country = false;
		
		if ($options['show_state'] == 1)
			$show_state = true;
		else
			$show_state = false;
		
		$language = $options['language'];
		$date_format = $options['date_format'];
		
		if ($options['show_weekday'] == 1)
			$show_weekday = true;
		else
			$show_weekday = false;
		
		if ($options['show_bonus_name'] == 1)
			$show_bonus_name = true;
		else
			$show_bonus_name = false;

		$main_color = $options['main_color'];
		$bonus_color = $options['bonus_color'];
		$digit_color = $options['digit_color'];
		$post_user_id = $options['post_user_id'];
		$post_category = $options['post_category'];
		
		if ($options['tag_country'] == 1)
			$tag_country = true;
		else
			$tag_country = false;
		
		if ($options['tag_state'] == 1)
			$tag_state = true;
		else
			$tag_state = false;
		
		if ($options['tag_game'] == 1)
			$tag_game = true;
		else
			$tag_game = false;
		
		$count_selected_games = 0;
		$form_selected_games = array();
		$form_selected_names = array();
		$form_selected_values = array();
		
		if (strlen($selected_games) > 10) {
			$domain = home_url();
			$domain = preg_replace('#^https?://#', '', $domain);
			$domain = preg_replace('/^www\./', '', $domain);
			
			// Version 2: Calls wp_results_option
			$base_url = 'https://www.magayo.com/api/wp_results_option.php?';
			$url = $base_url . 'api_key=' . $api_key;
			$url = $url . '&domain=' . $domain;
			$url = $url . '&game=';

			$form_selected_games = preg_split("/;/", $selected_games);
			
			for ($i=0; $i<count($form_selected_games); $i++) {
				$temp = $form_selected_games[$i];
				$temp_pos = strpos($temp, "=");
				$temp_name = substr($temp, 0, $temp_pos);
				$temp_value = substr($temp, ($temp_pos+1));
				array_push($form_selected_names, $temp_name);
				array_push($form_selected_values, $temp_value);
				$count_selected_games++;
				
				$temp_url = $url . $temp_value;
				$response = wp_remote_post($temp_url);
				
				if (!is_wp_error($response)) {
					$json_data = json_decode(wp_remote_retrieve_body($response));
					
					if ($json_data->error == 0) {
						$json_game_type = $json_data->game_type;
						$json_main_drawn = $json_data->main_drawn;
						$jason_bonus_drawn = $json_data->bonus_drawn;
						$json_bonus_name = $json_data->bonus_name;
						$json_digits = $json_data->digits;
						$json_drawn = $json_data->drawn;
						$json_prize1 = $json_data->prize1;
						$json_prize2 = $json_data->prize2;
						$json_prize3 = $json_data->prize3;
						$json_prize4 = $json_data->prize4;
						$json_prize5 = $json_data->prize5;
						$json_draw = $json_data->draw;
						$json_results = $json_data->results;
						
						// Version 2: Add option
						$json_is_option = $json_data->is_option;
						$json_option_name = $json_data->option_name;
						
						if ($this->post_exists($temp_name, $show_country, $show_state, $language, $date_format, $json_draw)) {
							if (WP_DEBUG) {
								$log_message = $temp_value . ": " . $json_draw . " - Already posted.";
								error_log($log_message);
							}
						} else {						
							if (WP_DEBUG) {
								$log_message = $temp_value . ": " . $json_draw . " - " . $json_results;
								error_log($log_message);
							}
							
							if ($json_game_type == "lotto") {
								// Version 2: Add option
								$this->post_lotto_results_option($temp_name, $show_country, $show_state, $language,
															$date_format, $show_weekday, $json_draw,
															$main_color, $json_main_drawn, $bonus_color, $jason_bonus_drawn, 
															$show_bonus_name, $json_bonus_name, $json_is_option, $json_option_name, $json_results,
															$post_user_id, $post_category, $tag_country, $tag_state, $tag_game);
							} else {
								$this->post_pick_results($temp_name, $show_country, $show_state, $language,
															$date_format, $show_weekday, $json_draw,
															$digit_color, $json_digits, $json_drawn, $json_results,
															$json_prize1, $json_prize2, $json_prize3, $json_prize4, $json_prize5,
															$post_user_id, $post_category, $tag_country, $tag_state, $tag_game);
							}
								
						}
					} else {
						if (WP_DEBUG) {
							$json_error = $json_data->error;
							$json_error_message = $json_data->error_message;
							$log_message = "Error: " . $json_error . " - " . $json_error_message;
							error_log($log_message);
						}
					}
				} else {
					if (WP_DEBUG) {
						$http_code = wp_remote_retrieve_response_code( $response );
						$log_message = "HTTP Error: " . $http_code;
						error_log($log_message);
					}
				}
			}
		} else {
			if (WP_DEBUG) {
				$log_message = "No games selected.";
				error_log($log_message);
			}			
		}
	}
	
    /**
     * Check if post exists to prevent duplicate posts.
     *
     * @since    1.0.0
     */
	private function post_exists($game_name, $show_country, $show_state, $language, $date_format, $draw_date) {
		
		$pos1 = strpos($game_name, "/");
		$country = substr($game_name, 0, $pos1);
		
		if ($country == "USA") {
			$pos2 = strpos($game_name, "/", ($pos1+1));
			
			if ($pos2 === false) {
				$state = '';
				$game = substr($game_name, ($pos1+1));
			} else {
				$state = substr($game_name, ($pos1+1), ($pos2-($pos1+1)));
				$game = substr($game_name, ($pos2+1));
			}
		} else {
			$state = '';
			$game = substr($game_name, ($pos1+1));
		}
		
		$post_title = '';
		
		if ($show_country) {
			$post_title = $country;
		}
		
		if ($show_state) {
			if (strlen($state) > 0) {
				if (strlen($post_title) > 0) {
					$post_title = $post_title . " " . $state;
				} else {
					$post_title = $state;
				}
			}
		}
		
		if (strlen($post_title) > 0) {
			$post_title = $post_title . " " . $game;
		} else {
			$post_title = $game;
		}
		
		list ($year, $month, $day) = preg_split("/-/", $draw_date); 
		
		if(!checkdate($month, $day, $year)) {
			if (WP_DEBUG) {
				$log_message = $game . ": Invalid draw date - " . $draw_date;
				error_log($log_message);
			}
			
			return;
		}

		$draw_datetime = mktime(0, 0, 0, $month, $day, $year);
		$post_date = date("Y-m-d H:i:s", $draw_datetime);
		$draw = date($date_format, $draw_datetime);
		
		if ($draw == false) {
			$draw = $draw_date;
			
			if (WP_DEBUG) {
				$log_message = $game . ": Error formatting date - " . $draw_date;
				error_log($log_message);
			}
		}
		
		if ($language == "es") {
			if ($date_format == "d M Y")
				$draw = $this->format_es_date($draw);
		} elseif ($language == "pt") {
			if ($date_format == "d M Y")
				$draw = $this->format_pt_date($draw);
		}
		
		$post_title = $post_title . " - " . $draw;		
		$post_title = preg_replace('/ & /', ' ', $post_title);
		
		$page = get_page_by_title($post_title, OBJECT, 'post');

		if (isset($page) && !empty($page) )
			return true;
			
		return false;
		
	}
		
    /**
     * Insert post for Pick 3/Pick 4 game.
     *
     * @since    1.0.0
     */
	private function post_pick_results($game_name, $show_country, $show_state, $language,
										$date_format, $show_weekday, $draw_date,
										$digit_color, $digits, $total_drawn, $draw_results,
										$prize1, $prize2, $prize3, $prize4, $prize5,
										$post_user_id, $post_category, $tag_country, $tag_state, $tag_game) {
		
		$pos1 = strpos($game_name, "/");
		$country = substr($game_name, 0, $pos1);
		
		if ($country == "USA") {
			$pos2 = strpos($game_name, "/", ($pos1+1));
			
			if ($pos2 === false) {
				$state = '';
				$game = substr($game_name, ($pos1+1));
			} else {
				$state = substr($game_name, ($pos1+1), ($pos2-($pos1+1)));
				$game = substr($game_name, ($pos2+1));
			}
		} else {
			$state = '';
			$game = substr($game_name, ($pos1+1));
		}
		
		$post_title = '';
		
		if ($show_country) {
			$post_title = $country;
		}
		
		if ($show_state) {
			if (strlen($state) > 0) {
				if (strlen($post_title) > 0) {
					$post_title = $post_title . " " . $state;
				} else {
					$post_title = $state;
				}
			}
		}
		
		if (strlen($post_title) > 0) {
			$post_title = $post_title . " " . $game;
		} else {
			$post_title = $game;
		}
				
		// Version 2: Set alignment via CSS
		$post_content = '<p class="pick34-results-header">';

		$post_content = $post_content . "<strong>" . $post_title . "</strong></p>";
		$post_content = $post_content . '<p class="pick34-results-date">';
		
		list ($year, $month, $day) = preg_split("/-/", $draw_date); 
		
		if(!checkdate($month, $day, $year)) {
			if (WP_DEBUG) {
				$log_message = $game . ": Invalid draw date - " . $draw_date;
				error_log($log_message);
			}
			
			return;
		}

		$draw_datetime = mktime(0, 0, 0, $month, $day, $year);
		$post_date = date("Y-m-d H:i:s", $draw_datetime);
		$draw = date($date_format, $draw_datetime);
		
		if ($draw == false) {
			$draw = $draw_date;
			
			if (WP_DEBUG) {
				$log_message = $game . ": Error formatting date - " . $draw_date;
				error_log($log_message);
			}
		}
		
		if ($language == "es") {
			if ($date_format == "d M Y")
				$draw = $this->format_es_date($draw);
		} elseif ($language == "pt") {
			if ($date_format == "d M Y")
				$draw = $this->format_pt_date($draw);
		}
		
		$post_title = $post_title . " - " . $draw;
		$post_title = preg_replace('/ & /', ' ', $post_title);
		$post_content = $post_content . $draw . "<br />";
		
		if ($show_weekday) {
			$draw_day = date("l", $draw_datetime);

			if ($language == "es") {
				$draw_day = $this->format_es_day($draw_day);
			} elseif ($language == "pt") {
				$draw_day = $this->format_pt_day($draw_day);
			} elseif ($language == "zh") {
				$draw_day = $this->format_zh_day($draw_day);
			}

			$post_content = $post_content . $draw_day . "</p>";
		}
		
		$post_content = $post_content . '<p class="pick34-results-drawn">';

		$drawn = preg_split("/,/", $draw_results);
		
		if (count($drawn) < $total_drawn) {
			if (WP_DEBUG) {
				$log_message = $game . ": Error in total drawn - " . $total_drawn . ", " . $draw_results;
				error_log($log_message);
			}
			
			return;
		}
		
		$image_url_prefix = plugins_url() . '/' . $this->plugin_name . '/assets/images/' . $digit_color . '/pick_';
		$image_url_suffix = '.png';
		
		if ($total_drawn == 1) {
			for ($i=0; $i<strlen($drawn[0]); $i++) {
				$temp_digit = substr($drawn[0], $i, 1);
				$temp_url = $image_url_prefix . $digit_color . $temp_digit . $image_url_suffix;
				$temp_img = '<img src="' . $temp_url . '" width="64" height="64">';
				$post_content = $post_content . $temp_img;
			}
		} elseif ($total_drawn >= 3) {
			$post_content = $post_content . $prize1;
			for ($i=0; $i<strlen($drawn[0]); $i++) {
				$temp_digit = substr($drawn[0], $i, 1);
				$temp_url = $image_url_prefix . $digit_color . $temp_digit . $image_url_suffix;
				$temp_img = '<img src="' . $temp_url . '" width="64" height="64">';
				$post_content = $post_content . $temp_img;
			}
			$post_content = $post_content . "<br />";

			$post_content = $post_content . $prize2;
			for ($i=0; $i<strlen($drawn[1]); $i++) {
				$temp_digit = substr($drawn[1], $i, 1);
				$temp_url = $image_url_prefix . $digit_color . $temp_digit . $image_url_suffix;
				$temp_img = '<img src="' . $temp_url . '" width="64" height="64">';
				$post_content = $post_content . $temp_img;
			}
			$post_content = $post_content . "<br />";

			$post_content = $post_content . $prize3;
			for ($i=0; $i<strlen($drawn[2]); $i++) {
				$temp_digit = substr($drawn[2], $i, 1);
				$temp_url = $image_url_prefix . $digit_color . $temp_digit . $image_url_suffix;
				$temp_img = '<img src="' . $temp_url . '" width="64" height="64">';
				$post_content = $post_content . $temp_img;
			}
			$post_content = $post_content . "<br />";
			
			if ($total_drawn == 23) {
				$post_content = $post_content . $prize4 . "<br />";
				for ($i=3; $i<13; $i++) {
					$post_content = $post_content . $drawn[$i] . " ";
					
					if ($i == 7)
						$post_content = $post_content . "<br />";
				}
				
				$post_content = $post_content . "<br />";
				$post_content = $post_content . $prize5 . "<br />";
				for ($i=13; $i<23; $i++) {
					$post_content = $post_content . $drawn[$i] . " ";
					
					if ($i == 17)
						$post_content = $post_content . "<br />";
				}
				
			} elseif ($total_drawn != 3) {
				if (WP_DEBUG) {
					$log_message = $game . ": Total drawn not supported - " . $total_drawn;
					error_log($log_message);
				}
				
				return;				
			}
		} else {
			if (WP_DEBUG) {
				$log_message = $game . ": Total drawn not supported - " . $total_drawn;
				error_log($log_message);
			}
			
			return;			
		}
		
		$post_content = $post_content . '</p>';
		
		$new_post = array(
			'post_title' => $post_title,
			'post_content' => $post_content,
			'post_status' => 'publish',
			'post_author' => $post_user_id, 
			'post_date' => $post_date,
			'post_type' => 'post',
			'post_category' => array(0)
		);
		
		$post_id = wp_insert_post($new_post);
		
		if ($post_id <= 0) {
			if (WP_DEBUG) {
				$log_message = $game . ": Error inserting post - " . $draw_date . ", " . $draw_results;
				error_log($log_message);
			}
			
			return;
		}
		
		if ($post_category == "country-state") {
			if (strlen($state) > 0)
				$category = $country . " " . $state . " Lottery";
			else
				$category = $country . " Lottery";
		} elseif ($post_category == "country") {
			$category = $country . " Lottery";
		} elseif ($post_category == "state") {
			if (strlen($state) > 0)
				$category = $state . " Lottery";
			else
				$category = $country . " Lottery";
		} else {
			$category = $game;
		}
		
		$category = preg_replace('/ & /', ' ', $category);
		
		if (is_category($category)) {
			$category_id = get_cat_ID( $category );
			
			if ($category_id <= 0) {
				if (WP_DEBUG) {
					$log_message = $game . ": Error getting category ID - " . $category;
					error_log($log_message);
				}
			} else {
				$category_ids = array($category_id);
				wp_set_post_categories( $post_id, $category_ids, false );
			}
		} else {
			// 08/06/16 - PHP Error "Call to undefined function wp_create_category()" even though category is created
//			$category_id = wp_create_category( $category );
			
			wp_insert_term( $category, 'category' );
			$category_id = get_cat_ID( $category );

			if ($category_id <= 0) {
				if (WP_DEBUG) {
					$log_message = $game . ": Error creating category - " . $category;
					error_log($log_message);
				}
			} else {
				$category_ids = array($category_id);
				wp_set_post_categories( $post_id, $category_ids, false );
			}
		}
		
		$tags = array();
		
		// Version 2: Append results & winning numbers to tags
		if ($tag_country) {
			$country_tag = strtolower($country);
			$country_tag = $country_tag . " lottery results";
			array_push($tags, $country_tag);
		}
		
		if ($tag_state) {
			if (strlen($state) > 0) {
				$state_tag = strtolower($state);
				$state_tag = $state_tag . " lottery results";
				array_push($tags, $state_tag);
			}
		}
		
		if ($tag_game) {
			$game_tag = strtolower($game);
			$game_tag = $game_tag . " results";
			array_push($tags, $game_tag);

			$game_tag = strtolower($game);
			$game_tag = $game_tag . " winning numbers";
			array_push($tags, $game_tag);
		}
		
		if (count($tags) > 0) {
			wp_set_post_tags( $post_id, $tags, false );
		}
		
	}

    /**
     * Insert post for Lotto game.
     *
     * @since    1.0.0
     */
	// Version 2: Add option
	private function post_lotto_results_option($game_name, $show_country, $show_state, $language,
										$date_format, $show_weekday, $draw_date,
										$main_color, $main_drawn, $bonus_color, $bonus_drawn, 
										$show_bonus_name, $bonus_name, $is_option, $option_name, $draw_results,
										$post_user_id, $post_category, $tag_country, $tag_state, $tag_game) {
		
		$pos1 = strpos($game_name, "/");
		$country = substr($game_name, 0, $pos1);
		
		if ($country == "USA") {
			$pos2 = strpos($game_name, "/", ($pos1+1));
			
			if ($pos2 === false) {
				$state = '';
				$game = substr($game_name, ($pos1+1));
			} else {
				$state = substr($game_name, ($pos1+1), ($pos2-($pos1+1)));
				$game = substr($game_name, ($pos2+1));
			}
		} else {
			$state = '';
			$game = substr($game_name, ($pos1+1));
		}
		
		$post_title = '';
		
		if ($show_country) {
			$post_title = $country;
		}
		
		if ($show_state) {
			if (strlen($state) > 0) {
				if (strlen($post_title) > 0) {
					$post_title = $post_title . " " . $state;
				} else {
					$post_title = $state;
				}
			}
		}
		
		// Version 2: Set alignment via CSS
		$post_content = '<p class="lotto-results-header">';

		$post_content = $post_content . "<strong>" . $post_title;
		
		if ($language == "zh") {
			if (($country == "China") || ($country == "Taiwan")) {
				$game_zh = $this->format_zh_game($country, $game);
			} else {
				$game_zh = $game;
			}
			
			if (strlen($post_title) > 0)
				$post_content = $post_content . " " . $game_zh;
			else
				$post_content = $post_content . $game_zh;
		} else {
			if (strlen($post_title) > 0)
				$post_content = $post_content . " " . $game;
			else
				$post_content = $post_content . $game;
		}
		
		if (strlen($post_title) > 0) {
			$post_title = $post_title . " " . $game;
		} else {
			$post_title = $game;
		}

		$post_content = $post_content . "</strong></p>";
		
		$post_content = $post_content . '<p class="lotto-results-date">';

		list ($year, $month, $day) = preg_split("/-/", $draw_date); 
		
		if(!checkdate($month, $day, $year)) {
			if (WP_DEBUG) {
				$log_message = $game . ": Invalid draw date - " . $draw_date;
				error_log($log_message);
			}
			
			return;
		}

		$draw_datetime = mktime(0, 0, 0, $month, $day, $year);
		$post_date = date("Y-m-d H:i:s", $draw_datetime);
		$draw = date($date_format, $draw_datetime);
		
		if ($draw == false) {
			$draw = $draw_date;
			
			if (WP_DEBUG) {
				$log_message = $game . ": Error formatting date - " . $draw_date;
				error_log($log_message);
			}
		}
		
		if ($language == "es") {
			if ($date_format == "d M Y")
				$draw = $this->format_es_date($draw);
		} elseif ($language == "pt") {
			if ($date_format == "d M Y")
				$draw = $this->format_pt_date($draw);
		}
		
		$post_title = $post_title . " - " . $draw;
		$post_title = preg_replace('/ & /', ' ', $post_title);
		$post_content = $post_content . $draw . "<br />";
		
		if ($show_weekday) {
			$draw_day = date("l", $draw_datetime);

			if ($language == "es") {
				$draw_day = $this->format_es_day($draw_day);
			} elseif ($language == "pt") {
				$draw_day = $this->format_pt_day($draw_day);
			} elseif ($language == "zh") {
				$draw_day = $this->format_zh_day($draw_day);
			}

			$post_content = $post_content . $draw_day . "</p>";
		}
		
		$post_content = $post_content . '<p class="lotto-results-main">';
		
		$total_drawn = $main_drawn + $bonus_drawn;
		$drawn = preg_split("/,/", $draw_results);
		
		if (count($drawn) < $total_drawn) {
			if (WP_DEBUG) {
				$log_message = $game . ": Error in total drawn - " . $total_drawn . ", " . $draw_results;
				error_log($log_message);
			}
			
			return;
		}
		
		$image_url_prefix = plugins_url() . '/' . $this->plugin_name . '/assets/images/' . $main_color . '/ball_';
		$image_url_suffix = '.png';
		
		for ($i=0; $i<$main_drawn; $i++) {
			$temp_url = $image_url_prefix . $main_color . $drawn[$i] . $image_url_suffix;
			$temp_img = '<img src="' . $temp_url . '" width="64" height="64">';
			$post_content = $post_content . $temp_img;
		}
		
		$post_content = $post_content . '</p>';
		$post_content = $post_content . '<p class="lotto-results-bonus">';
		
		if ($show_bonus_name) {
			if (strlen($bonus_name) > 0)
				// Version 2: bonus ball in next line after bonus name
				$post_content = $post_content . $bonus_name . "<br />";				
		}
		
		$image_url_prefix = plugins_url() . '/' . $this->plugin_name . '/assets/images/' . $bonus_color . '/ball_';
		
		for ($i=$main_drawn; $i<$total_drawn; $i++) {
			$temp_url = $image_url_prefix . $bonus_color . $drawn[$i] . $image_url_suffix;
			$temp_img = '<img src="' . $temp_url . '" width="64" height="64">';
			$post_content = $post_content . $temp_img;
		}
		
		$post_content = $post_content . '</p>';
		$post_content = $post_content . '<p class="lotto-results-multiplier">';
		
		// Version 2: Add option
		if ($is_option == "Y") {
			if (count($drawn) < ($total_drawn+1)) {
				if (WP_DEBUG) {
					$log_message = $game . ": Error in total drawn with option - " . $total_drawn . ", " . $draw_results;
					error_log($log_message);
				}
				
				return;
			}
			
			$temp_option = $option_name . ": " . $drawn[$total_drawn];
			$post_content = $post_content . $temp_option;
		}
		
		$post_content = $post_content . '</p>';

		$new_post = array(
			'post_title' => $post_title,
			'post_content' => $post_content,
			'post_status' => 'publish',
			'post_author' => $post_user_id, 
			'post_date' => $post_date,
			'post_type' => 'post',
			'post_category' => array(0)
		);
		
		$post_id = wp_insert_post($new_post);
		
		if ($post_id <= 0) {
			if (WP_DEBUG) {
				$log_message = $game . ": Error inserting post - " . $draw_date . ", " . $draw_results;
				error_log($log_message);
			}
			
			return;
		}
		
		if ($post_category == "country-state") {
			if (strlen($state) > 0)
				$category = $country . " " . $state . " Lottery";
			else
				$category = $country . " Lottery";
		} elseif ($post_category == "country") {
			$category = $country . " Lottery";
		} elseif ($post_category == "state") {
			if (strlen($state) > 0)
				$category = $state . " Lottery";
			else
				$category = $country . " Lottery";
		} else {
			$category = $game;
		}
		
		$category = preg_replace('/ & /', ' ', $category);
		
		if (is_category($category)) {
			$category_id = get_cat_ID( $category );
			
			if ($category_id <= 0) {
				if (WP_DEBUG) {
					$log_message = $game . ": Error getting category ID - " . $category;
					error_log($log_message);
				}
			} else {
				$category_ids = array($category_id);
				wp_set_post_categories( $post_id, $category_ids, false );
			}
		} else {
			// 08/06/16 - PHP Error "Call to undefined function wp_create_category()" even though category is created
//			$category_id = wp_create_category( $category );
			
			wp_insert_term( $category, 'category' );
			$category_id = get_cat_ID( $category );

			if ($category_id <= 0) {
				if (WP_DEBUG) {
					$log_message = $game . ": Error creating category - " . $category;
					error_log($log_message);
				}
			} else {
				$category_ids = array($category_id);
				wp_set_post_categories( $post_id, $category_ids, false );
			}
		}
		
		$tags = array();
		
		// Version 2: Append results & winning numbers to tags
		if ($tag_country) {
			$country_tag = strtolower($country);
			$country_tag = $country_tag . " lottery results";
			array_push($tags, $country_tag);
		}
		
		if ($tag_state) {
			if (strlen($state) > 0) {
				$state_tag = strtolower($state);
				$state_tag = $state_tag . " lottery results";
				array_push($tags, $state_tag);
			}
		}
		
		if ($tag_game) {
			$game_tag = strtolower($game);
			$game_tag = $game_tag . " results";
			array_push($tags, $game_tag);

			$game_tag = strtolower($game);
			$game_tag = $game_tag . " winning numbers";
			array_push($tags, $game_tag);
		}
		
		if (count($tags) > 0) {
			wp_set_post_tags( $post_id, $tags, false );
		}
		
	}

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links( $links ) {


        return array_merge(
            array(
                'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>'
            ),
            $links
        );

    }

    /**
     *  Save the plugin options
     *
     *
     * @since    1.0.0
     */
    public function options_update() {		
        register_setting( $this->plugin_name, $this->plugin_name );
    }

    /**
     *  Custom cron frequency
     *
     *
     * @since    1.0.0
     */	
	public function cron_add_weekly($schedules) {
		$schedules['every_week'] = array(
				'interval' => 604800,	// 7 x 24 x 60 x 60 seconds
				'display'  => esc_html__( 'Every week' ),
			);

		return $schedules;
	}
	
	public function cron_add_every_3_days($schedules) {
		$schedules['every_3_days'] = array(
				'interval' => 259200,	// 3 x 24 x 60 x 60 seconds
				'display'  => esc_html__( 'Every 3 days' ),
			);

		return $schedules;
	}
	
	public function cron_add_every_2_days($schedules) {
		$schedules['every_2_days'] = array(
				'interval' => 172800,	// 2 x 24 x 60 x 60 seconds
				'display'  => esc_html__( 'Every 2 days' ),
			);

		return $schedules;
	}
	
	public function cron_add_every_6_hours($schedules) {
		$schedules['every_6_hours'] = array(
				'interval' => 21600,	// 6 x 60 x 60 seconds
				'display'  => esc_html__( 'Every 6 hours' ),
			);

		return $schedules;
	}
	
	public function cron_add_every_3_hours($schedules) {
		$schedules['every_3_hours'] = array(
				'interval' => 10800,	// 3 x 60 x 60 seconds
				'display'  => esc_html__( 'Every 3 hours' ),
			);

		return $schedules;
	}
	
	public function cron_add_every_2_hours($schedules) {
		$schedules['every_2_hours'] = array(
				'interval' => 7200,	// 2 x 60 x 60 seconds
				'display'  => esc_html__( 'Every 2 hours' ),
			);

		return $schedules;
	}
	
	public function cron_add_every_30_minutes($schedules) {
		$schedules['every_30_minutes'] = array(
				'interval' => 1800,	// 30 x 60 seconds
				'display'  => esc_html__( 'Every 30 minutes' ),
			);

		return $schedules;
	}
	
	public function cron_add_every_15_minutes($schedules) {
		$schedules['every_15_minutes'] = array(
				'interval' => 900,	// 15 x 60 seconds
				'display'  => esc_html__( 'Every 15 minutes' ),
			);

		return $schedules;
	}

    /**
     *  Format dates & days in other languages
     *
     *
     * @since    1.0.0
     */	
	private function format_es_date($draw_date) {
		if (preg_match("/Jan/", $draw_date))
			$draw_date_replaced = preg_replace("/Jan/", "de enero de", $draw_date);
		elseif (preg_match("/Feb/", $draw_date))
			$draw_date_replaced = preg_replace("/Feb/", "de febrero de", $draw_date);
		elseif (preg_match("/Mar/", $draw_date))
			$draw_date_replaced = preg_replace("/Mar/", "de marzo de", $draw_date);
		elseif (preg_match("/Apr/", $draw_date))
			$draw_date_replaced = preg_replace("/Apr/", "de abril de", $draw_date);
		elseif (preg_match("/May/", $draw_date))
			$draw_date_replaced = preg_replace("/May/", "de mayo de", $draw_date);
		elseif (preg_match("/Jun/", $draw_date))
			$draw_date_replaced = preg_replace("/Jun/", "de junio de", $draw_date);
		elseif (preg_match("/Jul/", $draw_date))
			$draw_date_replaced = preg_replace("/Jul/", "de julio de", $draw_date);
		elseif (preg_match("/Aug/", $draw_date))
			$draw_date_replaced = preg_replace("/Aug/", "de agosto de", $draw_date);
		elseif (preg_match("/Sep/", $draw_date))
			$draw_date_replaced = preg_replace("/Sep/", "de septiembre de", $draw_date);
		elseif (preg_match("/Oct/", $draw_date))
			$draw_date_replaced = preg_replace("/Oct/", "de octubre de", $draw_date);
		elseif (preg_match("/Nov/", $draw_date))
			$draw_date_replaced = preg_replace("/Nov/", "de noviembre de", $draw_date);
		elseif (preg_match("/Dec/", $draw_date))
			$draw_date_replaced = preg_replace("/Dec/", "de diciembre de", $draw_date);
		else
			$draw_date_replaced = $draw_date;
		
		return $draw_date_replaced;
	}
	
	private function format_pt_date($draw_date) {
		if (preg_match("/Jan/", $draw_date))
			$draw_date_replaced = preg_replace("/Jan/", "de janeiro de", $draw_date);
		elseif (preg_match("/Feb/", $draw_date))
			$draw_date_replaced = preg_replace("/Feb/", "de fevereiro de", $draw_date);
		elseif (preg_match("/Mar/", $draw_date))
			// 09/08/16 get_page_by_title() fails if março
//			$draw_date_replaced = preg_replace("/Mar/", "de março de", $draw_date);
			$draw_date_replaced = preg_replace("/Mar/", "de marco de", $draw_date);
		elseif (preg_match("/Apr/", $draw_date))
			$draw_date_replaced = preg_replace("/Apr/", "de abril de", $draw_date);
		elseif (preg_match("/May/", $draw_date))
			$draw_date_replaced = preg_replace("/May/", "de maio de", $draw_date);
		elseif (preg_match("/Jun/", $draw_date))
			$draw_date_replaced = preg_replace("/Jun/", "de junho de", $draw_date);
		elseif (preg_match("/Jul/", $draw_date))
			$draw_date_replaced = preg_replace("/Jul/", "de julho de", $draw_date);
		elseif (preg_match("/Aug/", $draw_date))
			$draw_date_replaced = preg_replace("/Aug/", "de agosto de", $draw_date);
		elseif (preg_match("/Sep/", $draw_date))
			$draw_date_replaced = preg_replace("/Sep/", "de setembro de", $draw_date);
		elseif (preg_match("/Oct/", $draw_date))
			$draw_date_replaced = preg_replace("/Oct/", "de outubro de", $draw_date);
		elseif (preg_match("/Nov/", $draw_date))
			$draw_date_replaced = preg_replace("/Nov/", "de novembro de", $draw_date);
		elseif (preg_match("/Dec/", $draw_date))
			$draw_date_replaced = preg_replace("/Dec/", "de dezembro de", $draw_date);
		else
			$draw_date_replaced = $draw_date;
		
		return $draw_date_replaced;
	}
	
	private function format_es_day($draw_day) {
		if (preg_match("/Monday/", $draw_day))
			$draw_day_replaced = preg_replace("/Monday/", "lunes", $draw_day);
		elseif (preg_match("/Tuesday/", $draw_day))
			$draw_day_replaced = preg_replace("/Tuesday/", "martes", $draw_day);
		elseif (preg_match("/Wednesday/", $draw_day))
			$draw_day_replaced = preg_replace("/Wednesday/", "miércoles", $draw_day);
		elseif (preg_match("/Thursday/", $draw_day))
			$draw_day_replaced = preg_replace("/Thursday/", "jueves", $draw_day);
		elseif (preg_match("/Friday/", $draw_day))
			$draw_day_replaced = preg_replace("/Friday/", "viernes", $draw_day);
		elseif (preg_match("/Saturday/", $draw_day))
			$draw_day_replaced = preg_replace("/Saturday/", "sábado", $draw_day);
		elseif (preg_match("/Sunday/", $draw_day))
			$draw_day_replaced = preg_replace("/Sunday/", "domingo", $draw_day);
		else
			$draw_day_replaced = $draw_day;
		
		return $draw_day_replaced;
	}
	
	private function format_pt_day($draw_day) {
		if (preg_match("/Monday/", $draw_day))
			$draw_day_replaced = preg_replace("/Monday/", "segunda-feira", $draw_day);
		elseif (preg_match("/Tuesday/", $draw_day))
			$draw_day_replaced = preg_replace("/Tuesday/", "terça-feira", $draw_day);
		elseif (preg_match("/Wednesday/", $draw_day))
			$draw_day_replaced = preg_replace("/Wednesday/", "quarta-feira", $draw_day);
		elseif (preg_match("/Thursday/", $draw_day))
			$draw_day_replaced = preg_replace("/Thursday/", "quinta-feira", $draw_day);
		elseif (preg_match("/Friday/", $draw_day))
			$draw_day_replaced = preg_replace("/Friday/", "sexta-feira", $draw_day);
		elseif (preg_match("/Saturday/", $draw_day))
			$draw_day_replaced = preg_replace("/Saturday/", "sábado", $draw_day);
		elseif (preg_match("/Sunday/", $draw_day))
			$draw_day_replaced = preg_replace("/Sunday/", "domingo", $draw_day);
		else
			$draw_day_replaced = $draw_day;
		
		return $draw_day_replaced;
	}
	
	private function format_zh_day($draw_day) {
		if (preg_match("/Monday/", $draw_day))
			$draw_day_replaced = preg_replace("/Monday/", "星期一", $draw_day);
		elseif (preg_match("/Tuesday/", $draw_day))
			$draw_day_replaced = preg_replace("/Tuesday/", "星期二", $draw_day);
		elseif (preg_match("/Wednesday/", $draw_day))
			$draw_day_replaced = preg_replace("/Wednesday/", "星期三", $draw_day);
		elseif (preg_match("/Thursday/", $draw_day))
			$draw_day_replaced = preg_replace("/Thursday/", "星期四", $draw_day);
		elseif (preg_match("/Friday/", $draw_day))
			$draw_day_replaced = preg_replace("/Friday/", "星期五", $draw_day);
		elseif (preg_match("/Saturday/", $draw_day))
			$draw_day_replaced = preg_replace("/Saturday/", "星期六", $draw_day);
		elseif (preg_match("/Sunday/", $draw_day))
			$draw_day_replaced = preg_replace("/Sunday/", "星期日", $draw_day);
		else
			$draw_day_replaced = $draw_day;
		
		return $draw_day_replaced;
	}
	
	private function format_zh_game($country, $game) {
		if ($game == "Union Lotto")
			$game_zh = "双色球";
		elseif ($game == "Super 7 Lottery")
			$game_zh = "七乐彩";
		elseif ($game == "Anhui 5/25")
			$game_zh = "安徽25选5";
		elseif ($game == "Fujian 5/22")
			$game_zh = "福建22选5";
		elseif ($game == "Fujian 7/31")
			$game_zh = "福建31选7";
		elseif ($game == "Fujian 7/36")
			$game_zh = "福建36选7";
		elseif ($game == "Guangdong 5/26")
			$game_zh = "南粤风采26选5";
		elseif ($game == "Guangdong 7/36")
			$game_zh = "南粤风采36选7";
		elseif ($game == "Hebei 5/20")
			$game_zh = "燕赵风采20选5";
		elseif ($game == "Heilongjiang 5/22")
			$game_zh = "黑龙江22选5";
		elseif ($game == "Heilongjiang 7/36")
			$game_zh = "黑龙江36选7";
		elseif ($game == "Henan 5/22")
			$game_zh = "中原风采22选5";
		elseif ($game == "Hong Kong Mark Six")
			$game_zh = "六合彩";
		elseif ($game == "Huadong 5/15")
			$game_zh = "华东15选5";
		elseif ($game == "Hubei 5/22")
			$game_zh = "楚天风采22选5";
		elseif ($game == "Liaoning 7/35")
			$game_zh = "风采35选7";
		elseif ($game == "Shenzhen 7/35")
			$game_zh = "深圳风采35选7";
		elseif ($game == "Xinjiang 7/18")
			$game_zh = "风采18选7";
		elseif ($game == "Xinjiang 7/25")
			$game_zh = "风采25选7";
		elseif ($game == "Xinjiang 7/35")
			$game_zh = "风采35选7";
		elseif ($game == "Zhejiang 5/20")
			$game_zh = "体彩20选5";
		elseif ($game == "Daily Cash")
			$game_zh = "今彩539";
		elseif ($game == "Lotto 6/49")
			$game_zh = "49選6大樂透";
		elseif ($game == "Super Lotto") {
			if ($country == "China")
				$game_zh = "大乐透";
			else
				$game_zh = "威力彩";
		} else
			$game_zh = $game;
		
		return $game_zh;
	}

}

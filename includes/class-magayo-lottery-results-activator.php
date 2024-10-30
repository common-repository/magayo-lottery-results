<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.magayo.com
 * @since      1.0.0
 *
 * @package    Magayo_Lottery_Results
 * @subpackage Magayo_Lottery_Results/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Magayo_Lottery_Results
 * @subpackage Magayo_Lottery_Results/includes
 * @author     magayo <support@magayo.com>
 */
class Magayo_Lottery_Results_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// ******** 05/08/16 MLR ********
		// Version 2: Append jackpots
		$options = array(
			'email_address' => '',
			'api_key' => '',
			'supported_games' => '',
			'selected_games' => '',
			'cron_frequency' => 'every_3_days',
			'show_country' => 0,
			'show_state' => 0,
			'language' => 'en',
			'date_format' => 'd M Y',
			'show_weekday' => 1,
			'show_bonus_name' => 1,
			'main_color' => 'white',
			'bonus_color' => 'red',
			'digit_color' => 'beige',
			'post_user_id' => 0,
			'post_category' => 'game',
			'tag_country' => 0,
			'tag_state' => 0,
			'tag_game' => 1,
			'supported_jackpots' => '',
			'selected_jackpots' => ''
		);

		update_option( 'magayo-lottery-results', $options );
	}

}

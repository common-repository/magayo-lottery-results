<?php

/**
 * Provide a admin area view for the plugin - Games settings tab
 *
 * @link       https://www.magayo.com
 * @since      1.0.0
 *
 * @package    Magayo_Lottery_Results
 * @subpackage Magayo_Lottery_Results/admin/partials
 */

// Version 2: Add jackpots selection
?>

<div id="games-settings" class="wrap metabox-holder columns-2 magayo-lottery-results-metaboxes hidden">

	<h2><?php _e( 'Lottery Games Selection', $this->plugin_name ); ?></h2>
        <p><?php _e('Please select the lottery games to display the draw results, jackpots and configure the results update frequency.', $this->plugin_name);?></p>
		
	<table class="form-table">
		<tr>
			<td>
				<label for="supported_games">
				<?php 
					_e('Supported games', $this->plugin_name);
					echo ' (';
					echo $count_supported_games; 
					_e(' games', $this->plugin_name);
					echo ')';
				?>
				</label>
			</td>
			<td>
				<select id="supported_games" name="supported_games" <?php if ($count_supported_games <= 0) echo 'disabled'; ?> >
				<?php
					if ($count_supported_games > 0) {
						for ($i=0; $i<count($form_supported_games); $i++) {
							$temp_game = $form_supported_games[$i];
							$temp_name = $form_supported_names[$i];
							
							echo '<option value="';
							echo $temp_game;
							echo '">';
							echo $temp_name;
							echo '</option>';
						}
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" class="button-primary" id="submit_refresh_games" name="submit_refresh_games" value="<?php _e('Refresh supported games') ?>" <?php if ($count_supported_games <= 0) echo 'disabled'; ?> />
			</td>
			<td>
				<input type="submit" class="button-primary" id="submit_add_game" name="submit_add_game" value="<?php _e('Add game') ?>" <?php if ($count_supported_games <= 0) echo 'disabled'; ?> />
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<textarea rows="10" cols="38" id="selected_games" name="selected_games" disabled>
				<?php
					echo '&#13;&#10;';
					
					if ($count_selected_games > 0) {
						for ($i=0; $i<count($form_selected_games); $i++) {
							$temp_game = $form_selected_games[$i];
							$temp_name = $form_selected_names[$i];
							
							echo $temp_name;
							echo '&#13;&#10;';
						}
					}
				?>
				</textarea>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<input type="submit" class="button-primary" id="submit_clear_selection" name="submit_clear_selection" value="<?php _e('Clear game selection') ?>" <?php if ($count_supported_games <= 0) echo 'disabled'; ?> />
			</td>
		</tr>
		<tr>
			<td>
				<label for="supported_jackpots">
				<?php 
					_e('Supported jackpots', $this->plugin_name);
					echo ' (';
					echo $count_supported_jackpots; 
					_e(' games', $this->plugin_name);
					echo ')';
				?>
				</label>
			</td>
			<td>
				<select id="supported_jackpots" name="supported_jackpots" <?php if ($count_supported_jackpots <= 0) echo 'disabled'; ?> >
				<?php
					if ($count_supported_jackpots > 0) {
						for ($i=0; $i<count($form_supported_jackpots); $i++) {
							$temp_game = $form_supported_jackpots[$i];
							$temp_name = $form_supported_jackpot_names[$i];
							
							echo '<option value="';
							echo $temp_game;
							echo '">';
							echo $temp_name;
							echo '</option>';
						}
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" class="button-primary" id="submit_refresh_jackpots" name="submit_refresh_jackpots" value="<?php _e('Refresh supported jackpots') ?>" <?php if ($count_supported_games <= 0) echo 'disabled'; ?> />
			</td>
			<td>
				<input type="submit" class="button-primary" id="submit_add_jackpot" name="submit_add_jackpot" value="<?php _e('Add jackpot') ?>" <?php if ($count_supported_jackpots <= 0) echo 'disabled'; ?> />
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<textarea rows="10" cols="38" id="selected_jackpots" name="selected_jackpots" disabled>
				<?php
					echo '&#13;&#10;';
					
					if ($count_selected_jackpots > 0) {
						for ($i=0; $i<count($form_selected_jackpots); $i++) {
							$temp_jackpot = $form_selected_jackpots[$i];
							$temp_name = $form_selected_jackpot_names[$i];
							
							echo $temp_name;
							echo '&#13;&#10;';
						}
					}
				?>
				</textarea>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<input type="submit" class="button-primary" id="submit_clear_jackpot_selection" name="submit_clear_jackpot_selection" value="<?php _e('Clear jackpot selection') ?>" <?php if ($count_supported_jackpots <= 0) echo 'disabled'; ?> />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php _e('Please select how often you would like to retrieve the draw results and lottery jackpots for your selected games.', $this->plugin_name); ?><br />
				<?php _e('For example, if you have selected a game that is played twice a week, you should select the update frequency to be at least once every 3 days and you will be making approximately 10 API calls per month.', $this->plugin_name); ?><br />
				<?php _e('A shorter update frequency implies that your site will be updated faster with the lottery results or jackpot after each draw and this requires more API calls per month.', $this->plugin_name); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php _e('If you are using our Free Plan, you have 10 API calls per month. You can <a href="https://www.magayo.com/lottery-feeds/wordpress-lottery-plugin/" target="_blank">easily upgrade to increase the number of API calls</a>.', $this->plugin_name); ?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<label for="cron_frequency"><?php _e('Update frequency', $this->plugin_name);?></label>
			</td>
			<td>
				<select id="cron_frequency" name="cron_frequency" <?php if ($count_selected_games <= 0) echo 'disabled'; ?> /> >
					<option value="every_week" <?php if ($cron_frequency == "every_week" ) echo 'selected'; ?> >Once every week</option>
					<option value="every_3_days" <?php if ($cron_frequency == "every_3_days" ) echo 'selected'; ?> >Once every 3 days</option>
					<option value="every_2_days" <?php if ($cron_frequency == "every_2_days" ) echo 'selected'; ?> >Once every 2 days</option>
					<option value="daily" <?php if ($cron_frequency == "daily" ) echo 'selected'; ?> >Once every day</option>
					<option value="twicedaily" <?php if ($cron_frequency == "twicedaily" ) echo 'selected'; ?> >Twice every day</option>
					<option value="every_6_hours" <?php if ($cron_frequency == "every_6_hours" ) echo 'selected'; ?> >Once every 6 hours</option>
					<option value="every_3_hours" <?php if ($cron_frequency == "every_3_hours" ) echo 'selected'; ?> >Once every 3 hours</option>
					<option value="every_2_hours" <?php if ($cron_frequency == "every_2_hours" ) echo 'selected'; ?> >Once every 2 hours</option>
					<option value="hourly" <?php if ($cron_frequency == "hourly" ) echo 'selected'; ?> >Once every hour</option>
					<option value="every_30_minutes" <?php if ($cron_frequency == "every_30_minutes" ) echo 'selected'; ?> >Once every 30 minutes</option>
					<option value="every_15_minutes" <?php if ($cron_frequency == "every_15_minutes" ) echo 'selected'; ?> >Once every 15 minutes</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<input type="submit" class="button-primary" id="submit_save_frequency" name="submit_save_frequency" value="<?php _e('Save frequency') ?>" <?php if ($count_selected_games <= 0) echo 'disabled'; ?> />
			</td>
		</tr>
	</table>

</div>

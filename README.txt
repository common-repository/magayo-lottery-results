=== Plugin Name ===
Contributors: magayo
Tags: lottery, lotto, lottery results, lotto results, lottery jackpots, powerball, mega millions, euromillions, eurojackpot
Requires at least: 3.5.1
Tested up to: 6.6.2
Stable tag: 2.0.12
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display lottery results and lottery jackpots for lottery games across the world.

== Description ==

magayo Lottery Results plugin allows you to easily display lottery results and lottery jackpots in your WordPress blog. You can select and display the draw results and next jackpot amounts for multiple lottery games. Over 600 lottery games around the world are supported.

The supported games include games in Anguilla, Antigua & Barbuda, Argentina, Aruba, Australia, Austria, Azerbaijan, Barbados, Belgium, Belarus, Belize, Benin, Bermuda, Bosnia and Herzegovina, Brazil, Bulgaria, Cameroon, Canada, China, Chile, Colombia, Costa Rica, Côte d'Ivoire, Croatia, Curaçao, Cyprus, Czech Republic, Denmark, Dominica, Dominican Republic, Estonia, Finland, France, Germany, Ghana, Greece, Grenada, Guyana, Honduras, Hong Kong, Hungary, Iceland, Ireland, Israel, Italy, Jamaica, Japan, Kenya, Latvia, Lebanon, Lithuania, Luxembourg, Macedonia, Malaysia, Malta, Mauritius, Mexico, Mongolia, Morocco, Netherlands, New Zealand, Nicaragua, Nigeria, Norway, Panama, Peru, Philippines, Poland, Portugal, Puerto Rico, Romania, Russia, Saint Kitts and Nevis, Saint Lucia, Saint Vincent and the Grenadines, Serbia, Singapore, Sint Maarten, Slovakia, Slovenia, South Africa, South Korea, Spain, Sri Lanka, Sweden, Switzerland, Taiwan, Trinidad and Tobago, Turkey, Uganda, Ukraine, United Kingdom, United States, Uruguay, US Virgin Islands, Vietnam, Zambia & Zimbabwe.

You have the flexibility to customize how the draw results and lottery jackpots will be displayed such as the date format as well as the colors of the balls and digits. You can also choose to display the lottery results in English, Spanish (Español), Portuguese (Portugués) or Simplified Chinese (简体中文). Many other configurable options are also available and you can further customize the look and feel by adding specific CSS class attributes into the Additional CSS of your WordPress theme.

The lottery results and lottery jackpots are saved as posts in the specified categories of your WordPress blog. You can further add multiple lottery results and lottery jackpot widgets to display the most recent draw results and the next jackpots.

== Installation ==

1. Upload the 'magayo-lottery-results' directory to your '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress Admin
3. Register for an API account and customize the settings through the 'Settings' menu
4. Customize the additional CSS in your theme
5. Drag & drop the 'magayo-lottery-results' widget under the 'Appearance - Widgets' menu

= CSS Class Attributes =

* .pick34-results-header: Name of Pick 3/Pick 4 game
* .pick34-results-date: Draw date of Pick 3/Pick 4 game
* .pick34-results-drawn: Drawn digits in Pick 3/Pick 4 game
* .lotto-results-header: Name of Lotto game
* .lotto-results-date: Draw date of Lotto game
* .lotto-results-main: Main balls drawn in Lotto game
* .lotto-results-bonus: Bonus ball(s) drawn in Lotto game
* .lotto-results-multiplier: Multiplier in Lotto game
* .lotto-jackpot-header: Name of Lotto game
* .lotto-jackpot-date: Next draw date of Lotto game
* .lotto-jackpot-amount: Next jackpot amount of Lotto game

Following is the sample CSS which you can edit and include in the additional CSS of your theme:

`
.pick34-results-header { text-align: center; font-size: 150%; color: blue; }
.pick34-results-date { text-align: center; font-weight: bold; }
.pick34-results-drawn { text-align: center; }

.lotto-results-header { text-align: center; font-size: 150%; color: blue; }
.lotto-results-date { text-align: center; font-weight: bold; }
.lotto-results-main { text-align: center; }
.lotto-results-bonus { text-align: center; }
.lotto-results-multiplier { text-align: center; font-weight: bold; }

.lotto-jackpot-header { text-align: center; font-size: 150%; color: blue; }
.lotto-jackpot-date { text-align: center; font-weight: bold; }
.lotto-jackpot-amount { text-align: center; font-weight: bold; font-size: 200%; color: red; }
`

== Frequently Asked Questions ==

= Which WordPress user is used to post the lottery results and jackpots? =

You can select the user to use for posting the lottery results when you configure the plugin under the Settings menu. However, the user can only have the Author role. If you do not have any user with the Author role only, please create a new user first before configuring our plugin.

= How many API calls do I need? =

For a weekly lottery game, you will require at least 4 API calls per month to retrieve and display the lottery results. If you lik to further display the lottery jackpot, you will need at least 8 API calls per month.

For a daily game, at least 30 API calls will be needed to show the draw results. To further show the next jackpot, at least 60 API calls will be needed.

= How do I set the number of API calls? =

You do not need to set the number of API calls. You only need to indicate the update frequency under the Settings menu. For example, if you choose to update once every week, our plugin will make 4-5 API calls per month to show the draw results for each selected game.

= How many lottery games can I choose to display the lottery results? =

You can choose as many games as you like. However, a single API call can only retrieve the latest draw results for a single game.

= How many lottery games can I choose to display the lottery jackpot? =

You can choose as many games as you like. However, a single API call can only retrieve the next jackpot for a single game.

= How many lottery results widgets can I add to my blog? =

You can add as many lottery results widgets as you like. Each lottery results widget will only display the most recent draw results in the specified category.

= How many lottery jackpot widgets can I add to my blog? =

You can add as many lottery jackpot widgets as you like.

= How do I know how many API calls are made by the plugin? =

You can login to our [API Area](https://www.magayo.com/api/) to view your monthly API usage.

= Why are the lottery results or jackpots not updated? =

The most likely reason is that you have exceeded your API limit. You can check your API usage in our [API Area](https://www.magayo.com/api/) and you may like to consider [upgrading your API plan](https://www.magayo.com/lottery-feeds/wordpress-lottery-plugin/).

If you are sure that you have not exceeded your API limit, you may like to turn on your WordPress debug mode to see if you can identify and resolve the problem. Our WordPress cron job for updating the lottery results will log messages when WordPress is in debug mode.

To turn on the debug mode, you can add the following lines into your wp-config.php file:
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

When in debug mode, you can check the file /wp-content/debug.log for any errors or messages from our cron job.

Please note that it is not recommended to run WordPress in debug mode for live sites.

Alternatively, you can deactivate and re-activate the plugin.

== Screenshots ==

1. Our lottery results widgets in English and Spanish where you can easily customize the colors of the balls.
2. Our lottery results widgets in Portuguese and Simplified Chinese where you can easily customize the colors of the balls.
3. Our lottery results posts for USA lottery games based on the Twenty Sixteen theme.
4. Our lottery results posts for UK lottery games based on the Twenty Sixteen theme.
5. The Display Settings in the Settings menu where you can easily customize how the lottery results will be displayed.
6. The Games Settings for you to select your lottery games to show the lottery results.

== Changelog ==

= 2.0.2 =
* Tested compatibility with WordPress Version 5.6.

= 2.0.1 =
* Tested compatibility with WordPress Version 5.4.2.

= 2.0.0 =
* Added the multiplier in the draw results for games such as Powerball and Mega Millions.
* Added lottery jackpots.
* Added the support for the use of additional CSS.
* Tested compatibility with WordPress Version 5.0.3.

= 1.0.2 =
* Tested compatibility with WordPress Version 4.9.

= 1.0.1 =
* Updated all links to HTTPS.
* Tested compatibility with WordPress Version 4.6.

= 1.0.0 =
* First release.

<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://weatherapi
 * @since      1.0.0
 *
 * @package    Weatherapi
 * @subpackage Weatherapi/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Weatherapi
 * @subpackage Weatherapi/includes
 * @author     Bilal Naveed <bilalnaveed7861@gmail.com>
 */
class Weatherapi_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Droping Table
		global $wpdb;
		$table_name = $wpdb->prefix . "weather_Status"; 	
		$sql = "DROP TABLE IF EXISTS $table_name";
    	$wpdb->query($sql);

	}

}

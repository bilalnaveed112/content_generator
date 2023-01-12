<?php

/**
 * Fired during plugin activation
 *
 * @link       https://weatherapi
 * @since      1.0.0
 *
 * @package    Weatherapi
 * @subpackage Weatherapi/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Weatherapi
 * @subpackage Weatherapi/includes
 * @author     Bilal Naveed <bilalnaveed7861@gmail.com>
 */
class Weatherapi_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	global $wpdb;
	$table_name = $wpdb->prefix . "weather_Status"; 	
	$charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  city_day varchar(50) NOT NULL,
	  city_date varchar(50) NOT NULL,
	  city_name varchar(50) NOT NULL,
	  city_description varchar(50) NOT NULL,
	  temp_max varchar(2) NOT NULL,
	  temp_min varchar(2) NOT NULL,
	  humidity varchar(50) NOT NULL,
	  wind varchar(50) NOT NULL,
	  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY  (id)
	) $charset_collate;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	}

}

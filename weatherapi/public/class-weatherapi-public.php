<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://weatherapi
 * @since      1.0.0
 *
 * @package    Weatherapi
 * @subpackage Weatherapi/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Weatherapi
 * @subpackage Weatherapi/public
 * @author     Bilal Naveed <bilalnaveed7861@gmail.com>
 */
class Weatherapi_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Weatherapi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Weatherapi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/weatherapi-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Weatherapi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Weatherapi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/weatherapi-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
		 * This hook responsile for enqueue js file and creating ajax url + creating nonce.
	*/

	public function enque_weather_js_files() {

		wp_register_script('weather_javascript_ajax_file', plugin_dir_url(__FILE__).'js/weatherapi_ajax_public.js', array('jquery'),'1.1', false);
		wp_enqueue_script('weather_javascript_ajax_file');
	
		$localize = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'security' => wp_create_nonce('lahore_weather')
		);
		wp_localize_script( 'weather_javascript_ajax_file', 'weather_ajax_params', $localize);
	}


	/**
	 * This function responsile for handling ajax request and sending response of
	 * Lahore weather status.
	*/	

	public function load_weather_status_with_ajax(){

		$nonce = $_POST['security'];

		if ( ! wp_verify_nonce( $nonce, 'lahore_weather' ) ) {
			die ();
		}

		$today_date = date("jS F, Y");		
		global $wpdb;
		$table_name = $wpdb->prefix . "weather_Status";
		$result = $wpdb->get_results( "SELECT * FROM $table_name WHERE city_date='".$today_date."'");

		
		if( !empty( $result ) ){

			// display data if availale
			$this->display_today_weather_status($result);

		} else {

			$apiKey = "57586f374e6a927afd361bcee6c65ec8";
			$cityId = "Lahore";
			$googleApiUrl = "https://api.openweathermap.org/data/2.5/forecast?q=". $cityId."&lat=44.34&lon=10.99&APPID=" . $apiKey;

			$response = wp_remote_get($googleApiUrl, array('timeout'=> 10));

			if( is_wp_error( $response ) ) {
				return false;
			} else {
				$responsed_data = json_decode( wp_remote_retrieve_body( $response ));
			}

			// // Curl
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
			// curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
			// $response = curl_exec($ch);
			// curl_close($ch);
			// $responsed_data = json_decode( $response );
			
			// Update data into Database Tables
			$this->update_database_tables( $responsed_data );	
			
			// display data after availability
			$result_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE city_date='".$today_date."'");
			$this->display_today_weather_status( $result_data );
			
		}
		die();
	}

	/**
	 * This function responsile for getting data from database and sending data
	 * as a response.
	*/

	public function display_today_weather_status( $res ) {

		?>
		<div class="weather_status_data">
		<?php

		foreach ( $res as $post )
		{
			// Displaying Data
			?>
			<div>	
			<p>Day: <?php echo $post->city_day; ?></p>
			<p>Date:  <?php echo $post->city_date; ?></p>
			<p>Humidity: <?php echo $post->humidity; ?>%</p>
			<p>Desc: <?php echo $post->city_description;?></p>
			<p>Max Temp: <?php echo $post->temp_max;?>°C</p>
			</div>
			<?php
		}
		?>
		</div>
		<?php
	}


	/**
	 * This function responsile for getting data from API and updating data
	 * into database.
	*/

	public function update_database_tables( $data )
	{

		$today_date = date("jS F, Y");   // Current Date
		global $wpdb;
		$table_name = $wpdb->prefix . "weather_Status";

		$total_lists = count( $data->list );  
		$city_name =$data->city->name; 
		
		for( $i=0;$i<$total_lists;$i++ )
		{
			$date = date("jS F, Y", $data->list[$i]->dt); 

			if( $date == $today_date )   // Getting current date from api dates
			{
				$day = date("l",$data->list[$i]->dt ); 
				$desc = ucwords($data->list[$i]->weather[0]->description); 
				$temp_max = $data->list[$i]->main->temp_max; 
				$temp_min = $data->list[$i]->main->temp_min; 
				$humid = $data->list[$i]->main->humidity;  
				$wind = $data->list[$i]->wind->speed; 

				
				$datum = $wpdb->get_results("SELECT * FROM $table_name WHERE city_date= '".$date."'" );
				if($wpdb->num_rows > 0)  // Checking if Already Exists
					{
						//Upadte Data
						$wpdb->update( 
								$table_name, 
								array( 
									'city_day' => $day, 
									'city_date' => $date,
									'city_name' => $city_name, 
									'city_description' => $desc, 
									'temp_max' => $temp_max,
									'temp_min' => $temp_min,
									'humidity' => $humid,
									'wind' => $wind
								), 
								array(
									'city_date' => $date
								)
							); 
				} else {

						// Insert Data
						$wpdb->insert( 
							$table_name, 
							array( 
							'city_day' => $day, 
							'city_date' => $date,
							'city_name' => $city_name, 
							'city_description' => $desc, 
							'temp_max' => $temp_max,
							'temp_min' => $temp_min,
							'humidity' => $humid,
							'wind' => $wind
							) 
						);

				}
				break;
			} 
			//response is in arrays of every 3 hours.I have changed value of i that is skipping 
			// 3 Values. So we can get value on time.
			$i = $i + 3;

		}

	}


}

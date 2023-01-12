<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://autcontentcreator
 * @since      1.0.0
 *
 * @package    Autcontentcreator
 * @subpackage Autcontentcreator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Autcontentcreator
 * @subpackage Autcontentcreator/public
 * @author     Sigma Square <info@sigmasquare.com>
 */
class Autcontentcreator_Public {

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
		 * defined in Autcontentcreator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Autcontentcreator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/autcontentcreator-public.css', array(), $this->version, 'all' );

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
		 * defined in Autcontentcreator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Autcontentcreator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/autcontentcreator-public.js', array( 'jquery' ), $this->version, false );

	}

	public function register_custom_endpoint() {


		/**
		 * This function will register path and a call back function 
		 * for communicating with other hosts.
		 * 
		 * This API will recieve two parameters from requests and
		 * send response after communicating with it.
		 * 
		 */

		register_rest_route( 'auto-content-generator/v1', '/send-inputs', array(
			'methods'  => 'POST',
			'callback' => array($this,'receive_values_from_api'),
		) );

	}

	public function receive_values_from_api( $data ){

		// Getting Values from request
		$subject_value = $data->get_param( 'subject' );
		$keyword_value = $data->get_param( 'keyword' );

		// // AI API CAll to generate Content
		// $url = "https://api.writesonic.com/v2/business/content/paragraph-writer?num_copies=5";
	
		// $response = wp_remote_POST($url, array(
		// 	'timeout'=> 100,
		// 	'body' => '{"tone_of_voice":"Professional",
		// 				"paragraph_title":"'.$subject_value.'",
		// 				"keywords":"'.$keyword_value.'"}',
		// 	'headers' => [
		// 		// 'X-API-KEY' => '8228616e-e18d-4c3a-9634-e9c8eda8446f',
		// 		'X-API-KEY' => '2076276c-1332-4417-b5bc-6571c8faaddf',
		// 		'accept' => 'application/json',
		// 		'content-type' => 'application/json',
		// 	],
		// ));

		// //return Response back to the Request
		// return $responsed_data = json_decode( wp_remote_retrieve_body( $response ));

		$response = "Hi Dear, You Enter Subject ".$subject_value.". And Keyword Value is ".$keyword_value.". In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. "; 
		return $response; 

	}

}

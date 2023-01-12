<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://lastthreeposts
 * @since      1.0.0
 *
 * @package    Lastthreeposts
 * @subpackage Lastthreeposts/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Lastthreeposts
 * @subpackage Lastthreeposts/public
 * @author     Bilal Naveed <bilalnaveed7861@gmail.com>
 */
class Lastthreeposts_Public {

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
		 * defined in Lastthreeposts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lastthreeposts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lastthreeposts-public.css', array(), $this->version, 'all' );

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
		 * defined in Lastthreeposts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lastthreeposts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lastthreeposts-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
		* This function responsile for enqueue js file and creating ajax url + creating nonce.
	*/

	public function enque_post_js_files() {

		wp_register_script('javascript_ajax_file', plugin_dir_url(__FILE__).'js/lastthreeposts-public.js', array('jquery'),'1.1', false);
		wp_enqueue_script('javascript_ajax_file');
	
		$localize = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'security' => wp_create_nonce('posts_nonce')
		);
		wp_localize_script( 'javascript_ajax_file', 'ajax_params', $localize);
	}


	/**
	 * This function responsile for handling ajax request and sending response of
	 * last three published posts.
	*/

	public function load_posts_with_ajax(){

		$nonce = $_POST['security'];

		if ( ! wp_verify_nonce( $nonce, 'posts_nonce' ) ) {
			die ();
		}

		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => '3',
		);
		$all_posts = new WP_Query( $args );

		if ( $all_posts->have_posts()){
			while ( $all_posts->have_posts() ){
				$all_posts->the_post();
				?>
				<h5><?php the_title(); ?></h5>
				<?php the_excerpt(); ?>
				<?php
			}
		}
		wp_reset_postdata();
		die();

	}




}

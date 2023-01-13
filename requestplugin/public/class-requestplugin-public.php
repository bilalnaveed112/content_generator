
<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://requestplugin
 * @since      1.0.0
 *
 * @package    Requestplugin
 * @subpackage Requestplugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Requestplugin
 * @subpackage Requestplugin/public
 * @author     Sigma Square <info@sigmasquare.com>
 */
class Requestplugin_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the ID of this plugin
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the current version of this plugin
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param string $plugin_name the name of the plugin
     * @param string $version     the version of this plugin
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_shortcode('api_request_get_content', ['Requestplugin_Public', 'api_request_get_content_generated']);
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Requestplugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Requestplugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/requestplugin-public.css', [], $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Requestplugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Requestplugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/requestplugin-public.js', ['jquery'], $this->version, false);
    }

    public static function api_request_get_content_generated()
    {
        /*
         * This shortcode function will provide two inputs. One for subject and
         * the other one is for keywords.
         *
         * You can enter subject and keywords here and get auto generated
         * content.
		 * Try and Enjoy!
		 */

		?>
		<div id="content_body">
		<h5><?php esc_html_e('Welcome to Auto Content Generator'); ?></h5>

		<form id="content_generation_form" action="" method="post">

			<div class="subject_input">
				<label for="">Enter Your Subject Here	</label>
				<input name="subject" type="text">
			</div>

			<div class="keyword_input">
				<label for="">Enter Your Keywords Here</label>
			<input name="keyword" type="text">
			</div>
		
			<input name="submit" type="submit" value="Generate Content">
			
		</form>

		<?php

        if (isset($_POST['subject']) && isset($_POST['keyword'])) {
            // Make the API request
            $subject = sanitize_text_field($_POST['subject']);
            $keyword = sanitize_text_field($_POST['keyword']);

            $response = wp_remote_post('http://localhost/custom_admin_pages/wp-json/auto-content-generator/v1/send-inputs', [
                'body' => [
                    'subject' => $subject,
                    'keyword' => $keyword,
                ],
            ]);

            if (is_wp_error($response)) {
                // Handle the error
                return false;
            } else {
                // Handle the success
                $responsed_data = json_decode(wp_remote_retrieve_body($response));
            }

            // Display Response?>
			<textarea id="responsed_data" rows="5">
			<?php $get_responsed_data = trim($responsed_data);
            echo $get_responsed_data; ?>
			</textarea>
			<?php
        } ?>
		</div>
		<?php
    }
}

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @see       https://autcontentcreator
 * @since      1.0.0
 *
 * @package    Autcontentcreator
 * @subpackage Autcontentcreator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author     Sigma Square <info@sigmasquare.com>
 */
class Autcontentcreator_Admin
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
     * @param string $plugin_name the name of this plugin
     * @param string $version     the version of this plugin
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /*
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/autcontentcreator-admin.css', [], $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /*
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/autcontentcreator-admin.js', ['jquery'], $this->version, false);
    }

    public function admin_content_creator_page()
    {
        add_menu_page('Content Creator', 'Auto Content Generator' ,'manage_options','content-creator',
        [$this, 'auto_content_creation'], 'dashicons-welcome-write-blog', 3);
    }

    public function auto_content_creation()
    {
        /*
         * This function will provide two inputs. One for subject and
         * the other one is for keywords.
         *
         * You can enter subject and keywords here and get auto generated
         * content.
         *
         * Try and Enjoy!
         */ ?>
		<div id="content_body">
		<h1><?php esc_html_e('Welcome to Auto Content Generator'); ?></h1>

		<form id="content_generation_form" action="" method="post">

			<div class="subject_input">
				<label for="">Enter Your Subject Here	</label>
				<input name="subject" type="text">
			</div>

			<div class="keyword_input">
				<label for="">Enter Your Keywords Here</label>
			<input name="keyword" type="text">
			</div>

			<?php submit_button('Generate Content'); ?>
		</form>

		<?php

        if (isset($_POST['subject']) && isset($_POST['keyword'])) {
            $subject_value = $_POST['subject'];
            $keyword_value = $_POST['keyword'];

            $url = 'https://api.writesonic.com/v2/business/content/paragraph-writer?num_copies=5';

            $response = wp_remote_POST($url, [
                'timeout' => 100,
                'body' => '{"tone_of_voice":"Professional",
							"paragraph_title":"'.$subject_value.'",
							"keywords":"'.$keyword_value.'"}',
                'headers' => [
                    // 'X-API-KEY' => '8228616e-e18d-4c3a-9634-e9c8eda8446f',
                    'X-API-KEY' => '2076276c-1332-4417-b5bc-6571c8faaddf',
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            if (is_wp_error($response)) {
                // Handle Error
                return false;
            } else {
                // Handle Response
                $responsed_data = json_decode(wp_remote_retrieve_body($response));
            } ?>
			<textarea id="responsed_data" rows="5">
			<?php print_r($responsed_data->detail); ?>
			</textarea>
			</div>
			<?php
        }
    }
}
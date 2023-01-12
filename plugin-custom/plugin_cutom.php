<?php
/*
Plugin Name: Custom Admin Pages
Plugin URI: https://example.com/plugins/the-basics/
Description: Custom Admin PAges
Version: 1.0
Author: Bilal
Author URI: https://author.example.com/
*/

add_action('wp_enqueue_scripts', 'custom_enqueue_scripts' );
function custom_enqueue_scripts(){
    wp_enqueue_style('style_css', plugin_dir_url(__FILE__)."assets/css/style.css");
    wp_enqueue_script('custom_script', plugin_dir_url(__FILE__)."assets/js/custom.js", array(), '1.0.0', true);
}

function my_admin_menu() {

    add_menu_page(  'Sample page', 'Sample menu' ,'manage_options','sample-page',
    'my_admin_page_contents','dashicons-schedule',3 );
    add_submenu_page( 'sample-page', 'Sample page', 'Barchart Submenu' ,3 ,'submenu_page',
    'my_admin_barsubmenu_page_contents' );
    add_submenu_page( 'sample-page', 'Sample page', 'Linechart Submenu' ,3 ,'line_submenu_page',
    'my_admin_linesubmenu_page_contents' );
    
}
    
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_page_contents() {
    ?>
    <h1> <?php esc_html_e( 'Welcome to my Custom Admin Page.', 'my-plugin-textdomain' ); ?></h1>
    <form method="POST" action="">
    <?php
    settings_fields( 'sample-page' );
    do_settings_sections( 'sample-page' );
    submit_button();
    ?>
    </form>
    <?php
}
function my_admin_barsubmenu_page_contents(){
    ?>
    <h1> <?php echo "Hi"; ?></h1>
    <?php
    include 'admin/barchart.php';
}

function my_admin_linesubmenu_page_contents(){
    ?>
    <h1> <?php echo "Hi Line Chart"; ?></h1>
    <?php
    include 'admin/linechart.php';
}

add_action( 'admin_init', 'my_settings_init' );

function my_settings_init() {

    add_settings_section(
        'sample_page_setting_section',__( 'Custom settings', 'my-textdomain' ),
        'my_setting_section_callback_function','sample-page'
    );

		add_settings_field(
		   'my_setting_field',__( 'My custom setting field', 'my-textdomain' ),
		   'my_setting_markup','sample-page','sample_page_setting_section'
		);

		register_setting( 'sample-page', 'my_setting_field' );
}


function my_setting_section_callback_function() {
    echo '<p>Intro text for our settings section</p>';
}


function my_setting_markup() {
    ?>
    <label for="my_setting_field"><?php _e( 'My Input', 'my-textdomain' ); ?></label>
    <input type="text" id="my_setting_field" name="my_setting_field" value="<?php echo get_option( 'my_setting_field' ); ?>">
    <?php
    if(isset($_POST['my_setting_field'])){
        $input = $_POST['my_setting_field'];
        echo "<br>Input Value is: <strong>". $input . "</strong>";
    }
}


register_activation_hook(__FILE__, function(){});
register_deactivation_hook(__FILE__, function(){});


?>
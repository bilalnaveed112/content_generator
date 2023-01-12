
<?php

add_shortcode('lahore_weather', 'display_lahore_weather');

function display_lahore_weather(){

    ob_start();
    ?> 
     <!-- Dashoard -->
    <h4> See Lahore Weather</h4>

    <div class="weather_status"></div>
    <div class="weather_status_loading_text">Status is loadin please wait for 2 minutes</div>

    <?php
    $output = ob_get_clean();
    return $output;
}
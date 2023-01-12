<?php

add_shortcode('lastthreeposts', 'display_last_three_posts');

function display_last_three_posts(){

    ob_start();
    ?> 
     <!-- Dashoard -->
    <h4> See Latest Posts </h4>

    <div class="all_posts"></div>
    <div class="post_loading_text">Loading Posts . . . Please Wait for 2 minutes Only</div>
    <?php

    $output = ob_get_clean();
    return $output;

}
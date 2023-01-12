<?php
// add_action( 'rest_api_init', 'register_custom_endpoint' );

// function register_custom_endpoint() {
//     register_rest_route( 'custom-endpoint/v1', '/receive-values', array(
//         'methods'  => 'POST',
//         'callback' => 'receive_values',
//     ) );
// }
// function receive_values( $data ) {
//     $subject_value = $data->get_param( 'value1' );
//     $$keyword_value = $data->get_param( 'value2' );
//     $url = "https://api.writesonic.com/v2/business/content/paragraph-writer?num_copies=5";

// 			$response = wp_remote_POST($url, array(
// 				'timeout'=> 100,
// 				'body' => '{"tone_of_voice":"Professional",
// 							"paragraph_title":"'.$subject_value.'",
// 							"keywords":"'.$keyword_value.'"}',
// 				'headers' => [
// 					// 'X-API-KEY' => '8228616e-e18d-4c3a-9634-e9c8eda8446f',
// 					'X-API-KEY' => '2076276c-1332-4417-b5bc-6571c8faaddf',
// 					'accept' => 'application/json',
// 					'content-type' => 'application/json',
// 				],
// 			));
//             return $responsed_data = json_decode( wp_remote_retrieve_body( $response ));
//     // return array( 'message' => 'Values received successfully: ' . $value1 . ' ' . $value2 );
// }


// {

// 	$allposts = '';
    
//     // // Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
//      $response = wp_remote_get( 'http://localhost/ccf_test/wp-json/wp/v2/posts', array(
// 			'timeout'=> 1000,
// 			'headers' => [
// 				'accept' => 'application/json',
// 				'content-type' => 'application/json',
// 			],
// 			'sslverify' => FALSE,
// 	 	));

//     // Exit if error.
//     if ( is_wp_error( $response ) ) {
// 		echo "Got Error!";
// 		echo "<pre>";
// 		print_r($response);		
// 		echo "</pre>";
// 		exit;
//         return;
//     }



//     // Get the body.
//     $posts = json_decode( wp_remote_retrieve_body( $response ) );

//     // Exit if nothing is returned.
//     if ( empty( $posts ) ) {
//         return;
//     }

//     // If there are posts.
//     if ( ! empty( $posts ) ) {

//         // For each post.
//         foreach ( $posts as $post ) {

//             // Use print_r($post); to get the details of the post and all available fields
//             // Format the date.
//             $fordate = date( 'n/j/Y', strtotime( $post->modified ) );

//             // Show a linked title and post date.
//             $allposts .= '<a href="' . esc_url( $post->link ) . '" target=\"_blank\">' . esc_html( $post->title->rendered ) . '</a> <br />';
//         }
        
//         // return $allposts;
//     }

// 	echo "<pre>";
// 	print_r($allposts);		
// 	echo "</pre>";
// 	// exit;

// }
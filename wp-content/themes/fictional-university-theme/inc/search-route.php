<?php

function university_search_results(){
  return 'Congratulations, you created a route';
}

function university_register_search(){
  // Primer aurgumento: name space que queremos usar. Segundo: nombre de la ruta a la que vamos a acceder. Tercero: .
  register_rest_route('university/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE,  // ---> equivalente a 'GET'
    'callback' => 'university_search_results'
  ));
}

add_action('rest_api_init', 'university_register_search');
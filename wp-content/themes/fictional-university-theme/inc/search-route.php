<?php

add_action('rest_api_init', 'university_register_search');

function university_register_search(){
  // Primer aurgumento: name space que queremos usar. Segundo: nombre de la ruta a la que vamos a acceder. Tercero: .
  register_rest_route('university/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE,  // ---> equivalente a 'GET'
    'callback' => 'university_search_results'
  ));
}

function university_search_results( $data ){

  $professors = new WP_Query(array(
    'post_type' => 'professor',
    's' => sanitize_text_field($data['term'])
  ));

  $professor_resuts = array();
  
  while( $professors->have_posts() ){
    
    $professors->the_post();

    array_push($professor_resuts, array(
      'title' => get_the_title(),
      'permalink' => get_the_permalink(),
    ));

  }

  //return $professors->posts;  ---> funciona, pero queremos una respuesta personalizada...
  return $professor_resuts;

}
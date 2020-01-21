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

  $mainQuery = new WP_Query(array(
    'post_type' => array('post', 'page', 'professor', 'program', 'event', 'campus'),
    's' => sanitize_text_field($data['term'])
  ));

  $resuts = array(
    'general_info' => array(),
    'professors' => array(),
    'programs' => array(),
    'events' => array(),
    'campuses' => array()
  );
  
  while( $mainQuery->have_posts() ){
    
    $mainQuery->the_post();

    switch( get_post_type() ){
      case 'post':  //---> este código equivale un un post_type de tipo 'post' OR 'page' 
      case 'page': 
        array_push($resuts['general_info'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'post_type' => get_post_type(),
          'author_name' => get_the_author()
        ));
        break;
      case 'professor': 
        array_push($resuts['professors'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
        ));
        break;
      case 'program': 
        array_push($resuts['programs'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
        ));
        break;
      case 'event': 
        array_push($resuts['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
        ));
        break;
      case 'campus': 
        array_push($resuts['campuses'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
        ));
        //break;
      default:
        //break;

    }
/*
    if( get_post_type() == 'post' || get_post_type() == 'page' ){
      array_push($resuts['general_info'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
      ));
    }
*/


  }

  //return $professors->posts;  ---> funciona, pero queremos una respuesta personalizada...
  return $resuts;

}
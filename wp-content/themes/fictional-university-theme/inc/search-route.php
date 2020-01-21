<?php

add_action('rest_api_init', 'university_register_search');

function university_register_search(){
  // Primer aurgumento: name space que queremos usar. Segundo: nombre de la ruta a la que vamos a acceder. Tercero: .
  // http://localhost:3000/amazing-college/app/wp-json/university/v1/search?term=biology
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
          'url_image' => get_the_post_thumbnail_url(0, 'professorLandscape')
        ));
        break;
      case 'program': 
        array_push($resuts['programs'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
        ));
        break;
      case 'event':

        $description = null;
        $description = ( has_excerpt() ) ? get_the_excerpt() : ( wp_trim_words( get_the_content(), 18 ) );

        $eventDate = new DateTime(get_field('event_date'));
        $monthEvent = $eventDate->format('M');
        $dayEvent = $eventDate->format('d');

        array_push($resuts['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'month_event' => $monthEvent,
          'day_event' => $dayEvent,
          'description' => $description 
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

  }

  $programRelationshipQuery = new WP_Query(array(
    'post_type' => 'professor',
    'meta_query' => array(
      array(
        'key' => 'related_programs',
        'compare' => 'LIKE',
        'value' => '56'
      )
    )
  ));

  while( $programRelationshipQuery->have_posts() ){
    $programRelationshipQuery->the_post();

    if( get_post_type() == 'professor' ){
      array_push($resuts['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'url_image' => get_the_post_thumbnail_url(0, 'professorLandscape'))
      );
    }

  }

  // Eliminamos duplicados cuando la busqueda muestra resultados tanto para la consulta principal como para la consulta relacional
  $resuts['professors'] = array_values(array_unique( $resuts['professors'], SORT_REGULAR ));

  //return $professors->posts;  ---> funciona, pero queremos una respuesta personalizada...
  return $resuts;

}
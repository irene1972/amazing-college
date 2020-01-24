<?php

add_action('rest_api_init', 'university_like_routes');

function university_like_routes(){
  // http://localhost:3000/amazing-college/app/wp-json/university/v1/manageLike (POST!! o DELETE!!)
  
  register_rest_route('university/v1', 'manageLike', array(
    'methods' => 'POST',
    'callback' => 'createLike'
  ));

  register_rest_route('university/v1', 'manageLike', array(
    'methods' => 'DELETE',
    'callback' => 'deleteLike'
  ));

}

function createLike( $data ){

  // También podríamos usar una verificación de permisos como: current_user_can('publish_note') 
  if( is_user_logged_in() ){

    $professor_id = sanitize_text_field($data['professorId']);

    $existQuery = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => 'like',
      'meta_query' => array(
        array(
          'key' => 'liked_professor_id',
          'compare' => '=',
          'value' => $professor_id
        )
      )
    ));

    if( $existQuery->found_posts == 0 && get_post_type($professor_id) == 'professor' ){

      // Este insert si va bien devuelve el número de la publicación que acaba de crear
      return wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => '4nd Programatic Like post test',
        'meta_input' => array(
          'liked_professor_id' => $professor_id
        )
      ));

    }else{
      die("Invalid professor id");
    }

  }else{

    die("Only logged in users can create a Like");

  }

}

function deleteLike(){

  return 'Thanks for trying to delete a like.';
}
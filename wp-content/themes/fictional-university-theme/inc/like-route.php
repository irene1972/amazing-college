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

  $professor_id = sanitize_text_field($data['professorId']);

  wp_insert_post(array(
    'post_type' => 'like',
    'post_status' => 'publish',
    'post_title' => '4nd Programatic Like post test',
    'meta_input' => array(
      'liked_professor_id' => $professor_id
    )
  ));
}

function deleteLike(){

  return 'Thanks for trying to delete a like.';
}
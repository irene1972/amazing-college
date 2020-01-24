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

function createLike(){

  return 'Thanks for trying to create a like.';
}

function deleteLike(){

  return 'Thanks for trying to delete a like.';
}
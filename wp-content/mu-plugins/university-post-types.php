<?php

function university_post_types(){
  // Event post type
  register_post_type('event', array(
    'capability_type' => 'event',   // RELACIONADO CON LOS ROLES. Si no indicamos nada sobre capability_type, por defecto tiene el tipo 'post'. Event es el nick que le ponemos a la capability
    'map_meta_cap' => true,   // RELACIONADO CON LOS ROLES. 
    'supports' => array( 'title', 'editor', 'excerpt'), // Si usamos el plugin ACF no necesitamos añadir en esta línea 'custom-fields'
    'rewrite' => array( 'slug' => 'events' ),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event'
    ),
    'menu_icon' => 'dashicons-calendar'
  ));

  // Program post type
  register_post_type('program', array(
    'supports' => array( 'title'),
    'rewrite' => array( 'slug' => 'programs' ),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program'
    ),
    'menu_icon' => 'dashicons-awards'
  ));

    // Professors post type
    register_post_type('professor', array(
      'show_in_rest' => true,
      'supports' => array( 'title', 'editor', 'thumbnail'),
      //'rewrite' => array( 'slug' => 'professors' ), ---> porque no hay archivo.php asociado
      //'has_archive' => true,                        ---> porque no hay listado de Todos los Profesores como tal
      'public' => true,
      'labels' => array(
        'name' => 'Professors',
        'add_new_item' => 'Add New Professor',
        'edit_item' => 'Edit Professor',
        'all_items' => 'All Professors',
        'singular_name' => 'Professor'
      ),
      'menu_icon' => 'dashicons-welcome-learn-more'
    ));

    // Campus post type
    register_post_type('campus', array(
      'supports' => array( 'title', 'editor'),
      'rewrite' => array( 'slug' => 'campuses' ),
      'has_archive' => true,
      'public' => true,
      'labels' => array(
        'name' => 'Campuses',
        'add_new_item' => 'Add New Campus',
        'edit_item' => 'Edit Campus',
        'all_items' => 'All Campuses',
        'singular_name' => 'Campus'
      ),
      'menu_icon' => 'dashicons-location-alt'
    ));

    // Note post type
    register_post_type('note', array(
      'capability_type' => 'note',
      'map_meta_cap' => true,
      'show_in_rest' => true,
      'supports' => array( 'title', 'editor'),
      'public' => false,  // Important! in this case we want Notes not to be public
      'show_ui' => true,  // Show in the admin dashboard ui (cause the previous attribute)
      'labels' => array(
        'name' => 'Notes',
        'add_new_item' => 'Add New Note',
        'edit_item' => 'Edit Note',
        'all_items' => 'All Notes',
        'singular_name' => 'Note'
      ),
      'menu_icon' => 'dashicons-welcome-write-blog'
    ));

    // Like post type
    //'show_in_rest' => false,   ---> because this post type requires a customized logic. No usaremos los end point integrados de la rest api. Crearemos ends points propios y customizaremos el manejo de permisos
    register_post_type('like', array(
      'supports' => array( 'title'),
      'public' => false,
      'show_ui' => true,
      'labels' => array(
        'name' => 'Likes',
        'add_new_item' => 'Add New Like',
        'edit_item' => 'Edit Like',
        'all_items' => 'All Likes',
        'singular_name' => 'Like'
      ),
      'menu_icon' => 'dashicons-heart'
    ));

}

add_action( 'init', 'university_post_types' );

?>
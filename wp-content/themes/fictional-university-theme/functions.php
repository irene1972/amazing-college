<?php

function university_files(){
  /* El primer parámetro es un alias para el archivo que cargaremos después */
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());

}

add_action('wp_enqueue_scripts', 'university_files');

?>
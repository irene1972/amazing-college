<?php

function university_files(){
  /* El primer parámetro es un alias, el segundo la ruta, el tercero dice si tiene dependencias o no el script, el cuarto la versión (no importa p.e. 1.0), el quinto... */
  /* ... pregunta si queremos cargar este archivo justo antes de la etiqueta de cierre del cuerpo SÍ o NO (en nuestro caso sí que queremos) */
  wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, 1.0, true);
  /* El primer parámetro es un alias para el archivo que cargaremos después */
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());

}

add_action('wp_enqueue_scripts', 'university_files');

?>
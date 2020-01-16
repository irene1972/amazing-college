<?php

function pageBanner( $args = NULL ){
  
  $name_field_subtitle = 'page_banner_subtitle';
  $name_field_image_background = 'pageBanner';

  $title = ( $args['title'] ) ? $args['title'] : get_the_title();
  $subtitle = ( $args['subtitle'] ) ? $args['subtitle'] : get_field($name_field_subtitle);  
   
  if( $args['url_banner'] ){
    $url_banner = $args['url_banner'];
  }else{
    if( get_field('page_banner_background') ){
      $url_banner = get_field('page_banner_background')['sizes'][$name_field_image_background];
    }else{
      $url_banner = get_theme_file_uri('/images/ocean.jpg');
    }
  }


  ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $url_banner;  ?>);"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $title; ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $subtitle; ?></p>
        </div>
      </div>  
    </div>
  <?php
}

function university_files(){
  /* El primer parámetro es un alias, el segundo la ruta, el tercero dice si tiene dependencias o no el script, el cuarto... */
  /* ... la versión (no importa p.e. '1.0') o si queremos que no se cachee ponemos la función de php microtime(), el quinto pregunta si queremos cargar este archivo justo antes de la etiqueta de cierre del cuerpo SÍ o NO (en nuestro caso sí que queremos) */
  wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
  /* El primer parámetro es un alias para el archivo que cargaremos después */
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());

}

// Add scripts and css para nuestro tema
add_action('wp_enqueue_scripts', 'university_files');



function university_features(){
  //register_nav_menu('headerMenuLocation', 'Header Menu Location');
  //register_nav_menu('footerLocationOne', 'Footer Location One');
  //register_nav_menu('footerLocationTwo', 'Footer Location Two');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails'); //-> activamos las miniaturas -img- del tablero derecho en el editor de nuestro tema de wordpress
  add_image_size( 'professorLandscape', 400, 260, true ); //-> primer parámetro es: 
                                                          //    - un nickname, 
                                                          //    - anchura en px, 
                                                          //    - altura px 
                                                          //    - el último param (true) es para que recorte (crop) desde el centro (es decir recorta los bordes para que no se deforme la imagen). 
                                                          //  Nota: si queremos recortar las imágenes a demanda desde el administrador del wordpress, podemos usar un plugin como p.e. Manual Image Crop
                                                          //   El parámetro crop puede ser una array si queremos el recorte personalizado y no desde el centro.
  add_image_size( 'professorPortrait', 480, 650, true );  //->  IMPORTANTE: wp no crea retroactivamente imagenes... 
                                                          //    ...para ello necesitaríamos un plugin (p.e. Regenerate Thumbnails)
  add_image_size( 'pageBanner', 1500, 350, true );

                                                        }

// Customización de menús, customización de títulos en nuesto tema...
add_action('after_setup_theme', 'university_features');


//----------------------------------------------------------------
//Todo este código pasa a la carpeta mu-plugins
//----------------------------------------------
// function university_post_types(){
//   register_post_type('event', array(
//     'has_archive' => true,
//     'public' => true,
//     'labels' => array(
//       'name' => 'Events',
//       'add_new_item' => 'Add New Event',
//       'edit_item' => 'Edit Event',
//       'all_items' => 'All Events',
//       'singular_name' => 'Event'
//     ),
//     'menu_icon' => 'dashicons-calendar'
//   ));
// }

// Creación de un nuevo tipo de post (Eventos) customizado
//add_action( 'init', 'university_post_types' );
//----------------------------------------------------------------


function university_adjust_queries( $query ){
  //Nota: cuidado!! modificar esta query sin restricciones podría modificar todas las queries que ejecuta wordpress. Ejemplo...
  //$query->set( 'posts_per_page', 1 );

  //Por ello se incluye el siguiente if...

  if( !is_admin() && is_post_type_archive('event') && $query->is_main_query() ){

    $today = date('Ymd');

    //$query->set( 'posts_per_page', 2 );
    $query->set( 'meta_key', 'event_date' );
    $query->set( 'orderby', 'meta_value_num' );
    $query->set( 'order', 'ASC' );
    $query->set( 'meta_query', array(
      'key' => 'event_date',
      'compare' => '>=',
      'value' => $today,
      'type' => 'numeric'
    ) );

  }

  if( !is_admin() && is_post_type_archive('program') && $query->is_main_query() ){

    $query->set( 'posts_per_page', -1 );
    $query->set( 'orderby', 'title' );
    $query->set( 'order', 'ASC' );

  }

}

// Ligeras modificaciones de las queries que wordpress nos aporta de forma predeterminada (por defecto)
add_action( 'pre_get_posts', 'university_adjust_queries' );

?>
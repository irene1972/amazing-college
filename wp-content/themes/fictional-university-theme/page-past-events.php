<?php 
  
  get_header(); 

  pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.'
  ));

?>

<div class="container container--narrow page-section">
  
  <?php

    $today = date('Ymd');

    $pastEvents = new WP_Query(array(
      'paged' => get_query_var('paged', 1),  //esta función devuelve el parámetro de página que tenemos en ese momento en la url (según la página en la que nos encontremos)
      //'posts_per_page' => -1,
      'post_type' => 'event',
      'meta_key' => 'event_date',
      'orderby' => 'meta_value_num',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'event_date',
          'compare' => '<',
          'value' => $today,
          'type' => 'numeric'
        )
      ) 
    ));

    while( $pastEvents->have_posts() ){
      $pastEvents->the_post(); 

      $eventDate=new DateTime( get_field('event_date')  );
      $monthEvent = $eventDate->format('M');
      $dayEvent = $eventDate->format('d');
      
  ?>

  <div class="event-summary">
    <a class="event-summary__date t-center" href="<?= the_permalink() ?>">
      <span class="event-summary__month"><?= $monthEvent ?></span>
      <span class="event-summary__day"><?= $dayEvent ?></span>  
    </a>
    <div class="event-summary__content">
      <h5 class="event-summary__title headline headline--tiny"><a href="<?= the_permalink() ?>"><?= the_title() ?></a></h5>
      <p><?= wp_trim_words( get_the_content(), 18 ) ?><a href="<?= the_permalink() ?>" class="nu gray">Learn more</a></p>
    </div>
  </div>
  <?php
    }
    wp_reset_postdata();

    echo paginate_links(array(
      'total' => $pastEvents->max_num_pages
    ));

  ?>
</div>

<?php get_footer(); ?>
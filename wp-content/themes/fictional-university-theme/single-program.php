<?php 

get_header(); 

while( have_posts() ){

  the_post();
  
  pageBanner();
  
  ?>

  <div class="container container--narrow page-section">
    
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i>All Programs
        </a> <span class="metabox__main"><?= the_title() ?></span></p>
    </div>

    <div class="generic-content"><?php the_content(); ?></div>

    <?php 

      // Professor's relationship
      $relatedProfessors = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'professor',
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key' => 'related_programs',
            'compare' => 'LIKE',
            'value' => get_the_ID()
          )
        ) 
      ));

      if( $relatedProfessors->have_posts() ){

        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';   
        echo '<ul class="professor-cards">';  

        while( $relatedProfessors->have_posts() ){
          $relatedProfessors->the_post();
          //the_post_thumbnail( 'medium' );

          ?>
            <li class="professor-card__list-item">
              <a class="professor-card" href="<?= the_permalink() ?>">
                <img class="professor-card__image"  src="<?= the_post_thumbnail_url('professorLandscape') ?>" alt="">
                <span class="professor-card__name"><?= the_title() ?></span>
              </a>
            </li>
          <?php

        }
        echo '</ul>';  
        
  wp_reset_postdata();
      }

      // Event's relationship
      $today = date('Ymd');

      $relatedEvents = new WP_Query(array(
              'posts_per_page' => -1,
              'post_type' => 'event',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                ),
                array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' .get_the_ID() . '"'
                )
              ) 
            ));

            if( $relatedEvents->have_posts() ){

              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

              while( $relatedEvents->have_posts() ){
                
                $relatedEvents->the_post();
                
                get_template_part( 'template-parts/content-event');

              }
              
        wp_reset_postdata();
            }

      ?>

  </div>

  <?php
}

get_footer(); 

?>
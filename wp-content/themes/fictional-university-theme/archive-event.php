<?php 
  get_header(); 

  pageBanner(array(
    'title' => 'All Events',
    'subtitle' => 'See what is going on in our world.'
  ));

?>

<div class="container container--narrow page-section">
  <?php 
    while( have_posts() ){
      the_post(); 

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

    echo paginate_links();
  ?>
  <hr class="section-break">
  <p>Looking for a recap of past events? <a href="<?= site_url('/past-events')  ?>">Check out our past events archive</a></p>
</div>

<?php get_footer(); ?>
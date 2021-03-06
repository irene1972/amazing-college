<?php 
  $eventDate = new DateTime( get_field('event_date')  );
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
    <p><?= ( has_excerpt() ) ? get_the_excerpt() : ( wp_trim_words( get_the_content(), 18 ) ) ?><a href="<?= the_permalink() ?>" class="nu gray">Learn more</a></p>
  </div>
</div>
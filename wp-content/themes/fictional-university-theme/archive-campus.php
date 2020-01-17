<?php

  get_header(); 
  
  pageBanner(array(
    'title' => 'Our Campuses',
    'subtitle' => 'We have several conveniently located campuses.'
  ));

?>

<div class="container container--narrow page-section">
  <div class="acf-map">
  <!-- <ul class="link-list min-list"> -->
    <?php 

      while( have_posts() ){
        
        the_post();

        $map_location = get_field('map_location');

      // Lo hardcodeamos porque no tenemos la api-key de google
      $map_location['lat'] = '40.78214997551874';
      $map_location['lng'] = '-74.01127620000000';


    ?>
    <!-- <li><a href="< ?= the_permalink() ?>">< ?= the_title() ?></a></li> -->
    <div class="marker" data-lat="<?= $map_location['lat'] ?>" data-lng="<?= $map_location['lng'] ?>">
        <h3><a href="<?= the_permalink() ?>"><?= the_title() ?></a></h3>
        <?php echo $map_location['address'] ?>
    </div>
    <?php

      }?>
  <!-- </ul> -->
  </div>

</div>

<?php get_footer(); ?>
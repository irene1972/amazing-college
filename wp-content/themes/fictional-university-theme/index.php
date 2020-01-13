<?php get_header(); ?>
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?= get_theme_file_uri('/images/ocean.jpg')?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Wellcom to our blog!</h1>
    <div class="page-banner__intro">
      <p>Keep up with our latest news.</p>
    </div>
  </div>  
</div>

<div class="container container--narrow page-section">
  <?php 
    while( have_posts() ){
      the_post(); 
  ?>
  <div class="post-item">

    <h2><a class="headline headline--medium headline--post-title" href="<?= the_permalink() ?>"><?= the_title() ?></a></h2>
    
    <div class="metabox">
      <p>Posted by <?= the_author_posts_link() ?> on <?= the_time('n/j/Y') ?> in <?= get_the_category_list(', ') ?></p>
    </div>
    
    <div class="generic-content">
      <!-- < ?php the_content(); ?> Nota: la función the_excerpt() muetra solo un trozo del content -->
      <?= the_excerpt(); ?>
      <p><a class="btn btn--blue" href="<?= the_permalink() ?>">Continue reading &raquo;</a></p>
    </div>
  </div>
  <?php
    }
  ?>
</div>

<?php get_footer(); ?>
<?php 

get_header();

while( have_posts() ){
  the_post();
  
  pageBanner();

  ?>

  <div class="container container--narrow page-section">

    <?php 
      $theIdParent = wp_get_post_parent_id(get_the_ID());

      //estoy en una página hijo
      if( $theIdParent ): 
    ?>

    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?= get_permalink( $theIdParent )?>"><i class="fa fa-home" aria-hidden="true"></i>Back to <?= get_the_title( $theIdParent ) ?>
        </a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>

    <?php endif; ?>

    <?php
      $testArray = get_pages(array(
        'child_of' => get_the_ID()
      ));
    ?>

    <!-- Si estoy en una página hijo o estoy en una pagina padre que tiene hijos  -->
    <?php if( $theIdParent || $testArray ): ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?= get_permalink( $theIdParent ) ?>"><?= get_the_title( $theIdParent ) ?></a></h2>
      <ul class="min-list">
        <?php 

          if( $theIdParent ){
            //estoy en una página hijo
            $findChildrenOf = $theIdParent;
          }else{
            //estoy en una página padre
            $findChildrenOf = get_the_ID();
          }
          
          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order'
          )); 

        ?>
      </ul>
    </div>
    <?php endif; ?>

    <div class="generic-content">

        <?php get_search_form(); ?>
        
    </div>

  </div>
  

  <?php
}

get_footer();
 
?>
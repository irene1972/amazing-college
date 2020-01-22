<?php 

if( !is_user_logged_in() ){
  wp_redirect( esc_url(site_url('/')) );
  exit;
}

get_header();

while( have_posts() ){
  the_post();
  
  pageBanner();

  ?>

  <div class="container container--narrow page-section">

    <ul class="min-list link-list" id="my-notes">
      <?php
        
        $user_notes = new WP_Query(array(
          'posts_per_page' => -1,
          'post_type' => 'note',
          'author' => get_current_user_id()
        ));

        while( $user_notes->have_posts() ){
          
          $user_notes->the_post();

          ?>
            <li>
              <input value="<?= esc_attr(get_the_title()) ?>" class="note-title-field">
              <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
              <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
              <textarea class="note-body-field"><?= esc_attr(get_the_content()) ?></textarea>
            </li>
          <?php

        }

      ?>
    </ul>

  </div>
  

  <?php
}

get_footer();
 
?>
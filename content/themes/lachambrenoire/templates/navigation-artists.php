<?php
$count = 0;
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <?php
  /* Include the Post-Format-specific template for the content.
   * If you want to override this in a child theme, then include a file
   * called content-___.php (where ___ is the Post Format name) and that will be used instead.
   */
  $artist_date = get_post_meta( get_the_ID(), '_artists_date', true );
  if($artist_date != $current_date){
    get_template_part( 'templates/content-artists' );
  }

  ?>

<?php endwhile; ?>
<?php endif; ?>

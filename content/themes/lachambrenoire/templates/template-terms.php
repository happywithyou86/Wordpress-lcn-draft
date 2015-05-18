<?php/*
Template Name: Terms
*/
?>
<article class="terms">
  <?php while (have_posts()) : the_post(); ?>
    <h1><?php the_title();?></h1>
    <?php the_content(); ?>
  <?php endwhile; ?>

</article>

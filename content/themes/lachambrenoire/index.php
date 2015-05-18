<?php get_template_part('templates/page', 'header'); ?>

<!-- Artist page -->


<!-- Terms and conditions -->
<!-- <section class="content-page terms">
  <header>
    <div class="color-bar"></div>
    <h1>Terms & conditions</h1>
  </header>
  <div class="content">
    <p>Cupcake ipsum dolor. Sit amet tart soufflé tootsie roll. Powder croissant caramels candy canes. Muffin bonbon ice cream sweet roll jelly-o chocolate topping sweet jujubes. Dragée wafer sweet dessert cheesecake halvah biscuit pudding oat cake. Cake jelly-o tiramisu. Topping powder cotton candy toffee muffin pudding wafer. Jujubes I love I love. Chocolate candy I love toffee fruitcake. Marshmallow gummies oat cake pudding jujubes lollipop marshmallow apple pie. I love chocolate cake lollipop apple pie tootsie roll. I love gummies lollipop cheesecake chocolate cake.</p>
    <h3>Changes to the terms and conditions</h3>
    <p>CUPCAKE IPSUM dolor. Sit amet tart soufflé tootsie roll. Powder croissant caramels candy canes. Muffin bonbon ice cream sweet roll jelly-o chocolate topping sweet jujubes. Dragée wafer sweet dessert cheesecake halvah biscuit pudding oat cake. Cake jelly-o tiramisu. Topping powder cotton candy toffee muffin pudding wafer. Jujubes I love I love. Chocolate candy I love toffee fruitcake. Marshmallow gummies oat cake pudding jujubes lollipop marshmallow apple pie. I love chocolate cake lollipop apple pie tootsie roll. I love gummies lollipop cheesecake chocolate cake.</p>
  </div>
</section>
 -->


<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', get_post_format()); ?>
<?php endwhile; ?>

<!-- When all the mounth post are done -->
<?php if ($wp_query->max_num_pages > 1) : ?>
      <!-- <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></li>
      <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></li> -->
<?php endif; ?>


<!-- See all at bottom of page -->
<section class="other-mounth clear">
  <div class="back-top">
    <i class="icon up"></i>
  </div>
  <a href="#" class="see-all">See all</a>
</section>

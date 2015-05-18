<article class='artist' id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    <?php $gallery_images = get_post_meta( get_the_ID(), '_artists_gallery_images', true ); ?>
    <?php if ( ! empty( $gallery_images ) ) : ?>
      <ul>
        <?php foreach ( $gallery_images as $gallery_imageID ) : ?>
          <?php
          $category = get_the_category( $gallery_imageID );
          if(!empty($category)){
            echo $category[0]->cat_name;
          }
          ?>
          <li><?php echo wp_get_attachment_image( $gallery_imageID, 'thumbnail' ); ?></li>

        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </header><!-- .entry-header -->

  <div class="entry-content">
    <?php the_content(); ?>
    <?php
    wp_link_pages( array(
      'before' => '<div class="page-links">' . __( 'Pages:', '_s' ),
      'after'  => '</div>',
    ) );
    ?>
  </div><!-- .entry-content -->

</article><!-- #post-## -->

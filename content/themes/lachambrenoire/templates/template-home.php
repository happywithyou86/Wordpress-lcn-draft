<?php
/*
Template Name: Home
*/
?>

<div class="home-loader"></div>
<section class="article-list clear">

    <?php
    $currentMonth = date('m');
    $currentYear = date('Y');
    $args = array (
      'post_type'  => 'artists',
      'orderby' 	 => 'meta_value',
      'meta_query' => array(
        array(
          'key'       => '_artists_date',
          'value'     => $currentMonth . '/01/'. $currentYear,
        ),
      ),
    );
    // The Query
    $the_query = new WP_Query( $args );
    $image_array = array();
    ?>
    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php
      $gallery_images = get_post_meta( get_the_ID(), '_artists_gallery_images', true ); ?>
      <?php if ( ! empty( $gallery_images ) ) : ?>
        <?php foreach ( $gallery_images as $gallery_imageID ) :
          $category = get_the_category( $gallery_imageID );
          $className = 'type1';
          if(!empty($category)){
            $className = $category[0]->cat_name;
          }
          $date = get_post_meta(get_the_ID(), '_artists_date');
          $date_bis = new DateTime($date[0]);
          $month = $date_bis->format('M');
          $alt = get_post_meta($gallery_imageID, '_wp_attachment_image_alt', true);
          ?>
          <article id="<?php get_the_title($gallery_imageID); ?>" class="<?php echo $className;?>">
            <div class="date">
              <i class="icon clock"></i>
              <span class="day"><?php echo get_post_meta($gallery_imageID, 'media_date')[0];?></span>
              <span class="mounth"><?php echo mb_strtoupper($month);?></span>
            </div>
            <img src="<?php echo wp_get_attachment_image_src( $gallery_imageID, 'large' )[0];?>"
                 width="800px"
                 height="600px"
                 alt="<?php echo $alt;?>"
                 title="<?php echo wp_get_attachment($gallery_imageID)['caption'];?>">
            <?php print_social_buttons($gallery_imageID, true);
             array_push($image_array, wp_get_attachment_image_src( $gallery_imageID, 'large' )[0]);
            ?>
          </article>
        <?php endforeach; ?>
      <?php endif;
      ?>
    <?php endwhile; ?>
    <?php print_slider_container($image_array);?>

<!--      --><?php
//      $args = array (
//        'post_type'  => 'artists',
//        'orderby' 	 => 'meta_value',
//        'meta_query' => array(
//          array(
//            'key'       => '_artists_date',
//          ),
//        ),
//        'posts_per_page' => -1,
//      );
//
//      // The Query
//      $the_query = new WP_Query( $args );
//      global $wp_query;
//      $tmp_query = $wp_query;
//      // Now wipe it out completely
//      $wp_query = null;
//      // Re-populate the global with our custom query
//      $wp_query = $the_query;
//      ?>
<!--      <div class="navigation-home">-->
<!--        --><?php
//        $current_date = get_post_meta( get_the_ID(), '_artists_date', true );
//        get_template_part( 'templates/navigation-artists' );
////        include(locate_template('navigation-artists.php'));
//        wp_reset_postdata();
//        $wp_query = null;
//        $wp_query = $tmp_query;
//        ?>
<!--      </div>-->
    <?php else : ?>

      <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>

</section>


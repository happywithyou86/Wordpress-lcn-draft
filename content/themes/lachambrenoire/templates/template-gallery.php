<?php
/*
Template Name: Gallery
*/
?>

<section class="gallery">
  <div class="photo-holder">
    <div class="close"></div>
    <div class="chevron chevron-previous"></div>
    <div class="chevron chevron-next"></div>
    <div class="fade">
      <!--       <div class="photo">
        <figure>
          <img src="<?php bloginfo('template_directory');?>/assets/img/animaux/lion.jpg" alt="">
          <figcaption>
            <span class="origin">ELLE Italy</span>
            <span class="date">February, 28 2014</span>
            <span class="starring">Starring Nathalie Portman</span>
            <span class="produced">Produced by Iconoclast Image</span>
          </figcaption>
        </figure>
      </div> -->
    </div>
  </div>
  <div class="gallery-list clear">
<?php
$currentMonth = date('m');
$currentYear = date('Y');
$args = array (
  'post_type' => 'artists',
  'meta_key' => '_artists_date',
  'orderby' => 'meta_value',
  'order' => 'DESC'
);
// The Query
$the_query = new WP_Query( $args );
$firstArtist = true;
?>
<?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
  <?php
  $fname = get_post_meta( get_the_ID(), '_artists_fname', true );
  $lname = get_post_meta( get_the_ID(), '_artists_name', true );
  $description = get_post_meta( get_the_ID(), '_artists_biography', true );
  $gallery_images = get_post_meta( get_the_ID(), '_artists_gallery_images', true );
  $activated = get_post_meta(get_the_ID(), '_artists_activated', true);
  if ($activated == 'on'){
    ?>
    <div class="artist-wrapper" id="<?php echo sanitize_title(get_the_title());?>">
      <div class="artist-info">
        <div class="info-container">
          <div class="info">
            <span class="italic">by</span>
            <div class="center">
              <h1><strong><?php echo $fname; ?></strong> <?php echo $lname; ?></h1>
              <a class="legend" href="<?php echo get_the_permalink();?>"><?php echo __('More about the artist', 'roots'); ?></a>
            </div>
          </div>
        </div>
      </div>
      <?php
      if ($firstArtist){
        $firstArtist = false;
        ?>
        <button id="see-all">See All</button>

        <?php print_see_all_menu();?>
        <?php

      }
      ?>
      <?php if ( ! empty( $gallery_images ) ) : ?>
        <?php foreach ( $gallery_images as $gallery_imageID ) :
          $category = get_the_category( $gallery_imageID );
          $className = 'type1';
          if(!empty($category)){
            $className = $category[0]->cat_name;
          }
          $date = get_post_meta(get_the_ID(), '_artists_date');
          $date_bis = new DateTime($date[0]);
          $date_string = $date_bis->format('m, d Y');
          $alt = get_post_meta($gallery_imageID, '_wp_attachment_image_alt', true);
          ?>
          <div class="photo <?php echo $className;?>" id="<?php echo sanitize_title(get_post( $gallery_imageID )->post_name);?>">
            <figure>
              <img src="<?php echo wp_get_attachment_image_src( $gallery_imageID, 'large' )[0];?>"
                   alt="<?php echo $alt;?>"
                   title="<?php echo wp_get_attachment($gallery_imageID)['caption'];?>">
              <?php
              $caption_str = "";
              for ($i=1; $i<=5; $i++) {
                $line_info = get_post_meta($gallery_imageID, 'be-title-line'.$i, true);
                if($line_info)	$caption_str .= '<p class="starring">'.$line_info.'</p>';
              }
              if($caption_str) {
                echo '<figcaption><div class="cadre">';
                echo $caption_str;
                echo '</div></figcaption>';
              }
              print_social_buttons($gallery_imageID, false);
              ?>
            </figure>
          </div>
        <?php endforeach;
      endif;?>
    </div>
    <?php
  }
endwhile;
endif;?>
    <?php wp_reset_query(); ?>
  </div>
</section>
<!--  <div class="photo-holder">-->
<!--    <div class="close"></div>-->
<!--    <div class="chevron chevron-previous"></div>-->
<!--    <div class="chevron chevron-next"></div>-->
<!--    <figure class="photo">-->
<!--      <img src="--><?php //bloginfo('template_directory');?><!--/assets/img/animaux/panther.jpg" alt="">-->
<!--      <figcaption>-->
<!--        <span class="origin">ELLE Italy</span>-->
<!--        <span class="date">February, 28 2014</span>-->
<!--        <span class="starring">Starring Nathalie Portman</span>-->
<!--        <span class="produced">Produced by Iconoclast Image</span>-->
<!--      </figcaption>-->
<!--    </figure>-->
<!--  </div>-->


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <?php $currentArtist = the_post(); ?>
  <section class="artist-page clear">
    <?php
    $currentMonth = date('M');
    $currentYear = date('Y');
    $args = array (
      'post_type'  => 'artists',
      'meta_key' => '_artists_date',
      'orderby' => 'meta_value',
      'order' => 'ASC',
      'posts_per_page' => 0
    );
    // The Query
    $the_query = new WP_Query( $args );
    $other_artists = array();
    ?>
    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php
      $currentMonth = mb_strtoupper(date('F'));
      $fname = get_post_meta( get_the_ID(), '_artists_fname', true );
      $lname = get_post_meta( get_the_ID(), '_artists_name', true );
      $description = get_post_meta( get_the_ID(), '_artists_biography', true );
      $image_src =  wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));
      $artist_id = get_the_ID();
      $date = get_post_meta(get_the_ID(), '_artists_date');
      $date_bis = new DateTime($date[0]);
      $month = mb_strtoupper($date_bis->format('F'));
      if ($posts[0]->ID == get_the_ID()) {
        ?>
        <div class="text-holder">
          <div class="artist-title">
            <span class="mounth"><?php echo $month?></span>
            <span class="by">by</span>
            <h1><strong><?php echo $fname?></strong> <?php echo $lname?></h1>
          </div>
          <p><?php echo $description?></p>
        </div>
        <div class="img-holder" data-src="<?php echo $image_src; ?>" data-fname="<?= $fname; ?>" data-lname="<?= $lname ?>">
          <button id="js-artist-photo">See the artist's photo</button>
        </div>
        <?php
      }
      else{
        $artist = array(
          'fname' => $fname,
          'lname' => $lname,
          'description' => $description,
          'image_src' => $image_src,
          'month' => $month,
          'link' => get_the_permalink()
        );
        array_push($other_artists, $artist);
      }
      ?>
    <?php endwhile; ?>
    <?php endif;?>
    <?php wp_reset_query(); ?>
  </section>
  <section class="other-artist">
    <div class="artist-slider">
      <?php foreach ( $other_artists as $artist ) :
        ?>
        <div class="artist" data-link="<?php echo $artist['link']; ?>">
          <span class="mounth">guest <br> <span class="italic">of</span> <br> <?php echo $artist['month'];?></span>
          <span class="name"> <?php echo $artist['fname'];?>  <?php echo $artist['lname'];?></span>
        </div>
      <?php endforeach; ?>

    </div>
    <?php
    $num_other_artists = sizeof($other_artists);

    if ( $num_other_artists > 3 ) :
      ?>
      <div class="chevron chevron-previous"></div>
      <div class="chevron chevron-next"></div>
      <?php
    endif;
    ?>
    <ul class="pages"></ul>
  </section>





<?php endwhile; ?>
<?php endif; ?>

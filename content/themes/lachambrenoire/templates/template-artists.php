<?php
/*
Template Name: Artists
*/
?>

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
    $description = get_the_content();
    $image_src =  wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));
    $artist_id = get_the_ID();
    $date = get_post_meta(get_the_ID(), '_artists_date');
    $date_bis = new DateTime($date[0]);
    $month = mb_strtoupper($date_bis->format('F'));
    $year = $date_bis->format('Y');
    $artist = array(
      'fname' => $fname,
      'lname' => $lname,
      'description' => $description,
      'image_src' => $image_src,
      'month' => $month,
      'link' => get_the_permalink(),
      'activated' =>  get_post_meta(get_the_ID(), '_artists_activated')
    );
    if ($currentMonth == $month) {
      $artist['style'] = 'current-artist';
      ?>
      <div class="img-holder" data-src="<?php echo $image_src; ?>" data-fname="<?= $fname; ?>" data-lname="<?= $lname ?>">
        <button id="js-artist-photo">See the artist's photos</button>
      </div>
      <div class="text-holder">
        <div class="artist-title">
          <span class="mounth"><?php echo $month.'  '.$year ?></span>
          <span class="by">by</span>
          <h1><strong><span class="fname"><?php echo $fname?></span></strong> <span class="lname"><?php echo $lname?></span></h1>
        </div>
        <p class="description"><?php echo $description?></p>
      </div>
      <?php
    }
    else{
      $artist['style'] = '';
    }

      array_push($other_artists, $artist);

    ?>
  <?php endwhile; ?>
  <?php endif;?>
  <?php wp_reset_query(); ?>
</section>
<section class="other-artist">
  <div class="artist-slider">
    <?php foreach ( $other_artists as $artist ) :
      $class =  $artist['activated'][0] == 'on' ? 'activated' : '';
      ?>
      <div class="artist <?php echo $class . ' '. $artist['style'];?>"
           data-link="<?php echo $artist['link']; ?>"
           data-fname="<?php echo $artist['fname']; ?>"
           data-lname="<?php echo $artist['lname']; ?>"
           data-description="<?php echo $artist['description']; ?>"
           data-image_src="<?php echo $artist['image_src']; ?>"
           data-month="<?php echo $artist['month']; ?>"
<!--           style="--><?php //echo $artist['style']; ?><!--"-->
        >
        <span class="mounth">guest <br> <span class="italic">of</span> <br> <?php echo $artist['month'];?></span>
        <span class="name"> <?php echo $artist['fname'];?>  <?php echo $artist['lname'];?></span>
          <br>
        <?php
          if ($class == ''){
            ?>
              <span class="coming-soon"><?php echo __('Coming Soon', 'lcn');?></span>
            <?php
          }
        ?>
      </div>
    <?php
    endforeach; ?>

  </div>
  <?php
    $num_other_artists = sizeof($other_artists);

    if ( $num_other_artists - 1 > 3 ) :
  ?>
    <div class="chevron chevron-previous"></div>
    <div class="chevron chevron-next"></div>
  <?php
    endif;
  ?>
  <ul class="pages"></ul>
</section>




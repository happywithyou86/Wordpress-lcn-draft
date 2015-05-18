<?php
$args = array (
  'post_type'  => 'artists'
);
// The Query
$the_query = new WP_Query( $args );
$other_artists = array();
$all_artists = array();
$image_src = '';
if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();

  $currentMonth = mb_strtoupper(date('M'));
  $date = get_post_meta(get_the_ID(), '_artists_date');
  $date_bis = new DateTime($date[0]);
  $month = mb_strtoupper($date_bis->format('M'));
  $year = mb_strtoupper($date_bis->format('Y'));


  if ($currentMonth == $month) {
    $fname = get_post_meta( get_the_ID(), '_artists_fname', true );
    $lname = get_post_meta( get_the_ID(), '_artists_name', true );
    $description = get_post_meta( get_the_ID(), '_artists_biography', true );
    $image_src =  get_post_meta( get_the_ID(), '_artists_image', true );
  }
  if (get_post_meta( get_the_ID(), '_artists_image', true ) !==''){
    array_push($all_artists, get_the_ID());
  }
endwhile;
if (isset($pagename)){
  if ($pagename == 'about-us'){
    $image_src =  get_post_meta( $all_artists[array_rand($all_artists, 1)], '_artists_image', true );
  }
}

endif;
?>
<header class="banner navbar navbar-default navbar-static-top" role="banner" style="background-image: url(<?php echo $image_src;?>) ">
  <div class="menu-overlay"></div>
  <div class="menu-holder clear">
    <a class="logo" href="<?php echo bloginfo('url');?>"></a>
    <?php wp_nav_menu(array(
      'menu'            => 'menu',
      'menu_class'      => 'animate',
      'menu_id'         => ''
    )); ?>
  </div>
  <a class="logo single" href="<?php echo bloginfo('url');?>"></a>
  <div class="artist-holder">
    <div class="artist">
      <span class="by">by</span>
      <h2><strong><?php echo $fname?></strong> <?php echo $lname?></h2>
    </div>
  </div>


  <div class="menu" id="js-menu-open"><a ><span data-hover="<?php _e('Menu', 'roots'); ?>"><?php _e('Menu', 'roots'); ?></span></a></div>
  <div class="menu menu-close" id="js-menu-close"><a ><span data-hover="<?php _e('Close', 'roots'); ?>"><?php _e('Close', 'roots'); ?></span></a></div>
  <div id="js-artists-list-close"></div>
  <div class="socials">
    <a class="fa fa-facebook" href="https://www.facebook.com/labelchambrenoire" target="_blank"></a>
    <a class="fa fa-instagram" href="https://instagram.com/labelchambrenoire" target="_blank"></a>
  </div>
</header>
<div class="border">
  <div class="top"></div>
  <div class="right"></div>
  <div class="bottom"></div>
  <div class="left"></div>
</div>

<div class="artist-holder big" <?php if(!$fname) echo 'style="display:none;"';?>>
  <div class="artist clear">
    <div class="big-title">
      <div class="date-container">
        <span class="mounth"><?php echo $month?></span>
        <span class="year"><?php echo $year?></span>
      </div>
      <div class="separator"></div>
      <h1><strong><?php echo $fname?></strong> <?php echo $lname?></h1>
    </div>
    <p class="description"><?php echo $description?></p>
  </div>
</div>
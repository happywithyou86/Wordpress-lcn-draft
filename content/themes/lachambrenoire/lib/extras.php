<?php
/**
 * Clean up the_excerpt()
 */
function roots_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'roots') . '</a>';
}
add_filter('excerpt_more', 'roots_excerpt_more');

/**
 * Manage output of wp_title()
 */
function roots_wp_title($title) {
  if (is_feed()) {
    return $title;
  }

  $title .= get_bloginfo('name');

  return $title;
}
add_filter('wp_title', 'roots_wp_title', 10);


function insert_twitter_cards_in_head() {
  global $post;

  if ( !is_singular()) //if it is not a post or a page
    return;
  echo '<meta property="twitter:card" content="summary_large_image">';
  echo '<meta property="twitter:title" content="' . get_the_title() . '">';
  setup_postdata( $post );
  $description = get_post_meta( get_the_ID(), '_artists_biography', true );
  if ($description == ''){
    $description = get_bloginfo('description');
  }
  echo '<meta property="twitter:description" content="' . esc_attr($description) . '">';
  echo '<meta name="twitter:site" content="@lcn">';
  echo '<meta name="twitter:creator" content="@lcn">';
  echo '<meta name="twitter:domain" content="' . get_bloginfo('url') . '">';

  $image_src =  get_post_meta( get_the_ID(), '_artists_image', true );

  if (isset($_REQUEST['image']) && isset($_REQUEST['id'])){
    $image_id = $_REQUEST['id'];
    $thumbnail_src = wp_get_attachment_image_src( $image_id, 'large' )[0];
    echo '<meta property="twitter:image:src" content="' . esc_attr( $thumbnail_src ) . '"/>';
  }
  else if ($image_src != ''){
    echo '<meta property="twitter:image:src" content="' . esc_attr($image_src)  . '"/>';
  }
  else{
    $default_image=get_template_directory_uri() . '/assets/img/logo.jpg';
    echo '<meta property="twitter:image:src" content="' . $default_image . '"/>';
  }
}
add_action( 'wp_head', 'insert_twitter_cards_in_head', 5 );
//Lets add Open Graph Meta Info

function insert_fb_in_head() {
  global $post;
  if ( !is_singular()) //if it is not a post or a page
    return;

  echo '<meta property="og:type" content="article"/>';
  setup_postdata( $post );
  $description = get_post_meta( get_the_ID(), '_artists_biography', true );
  if ($description == ''){
    $description = get_bloginfo('description');
  }
  echo '<meta property="og:description" content="' . esc_attr($description) . '"/>';
  echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>';
  if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['HTTP_HOST'])){
    echo '<meta property="og:url" content="http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]  . '"/>';
  }
  else{
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
  }

  $image_src =  get_post_meta( get_the_ID(), '_artists_image', true );

  if (isset($_REQUEST['image']) && isset($_REQUEST['id'])){
    $image_id = $_REQUEST['id'];
    $thumbnail_src = wp_get_attachment_image_src( $image_id, 'large' );
    echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    echo '<meta property="og:title" content="' . get_the_title($image_id) . '"/>';
  }
  else if ($image_src != ''){
    echo '<meta property="og:image" content="' . esc_attr($image_src)  . '"/>';
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
  }
  else{
    $default_image=get_template_directory_uri() . '/assets/img/logo.jpg';
    echo '<meta property="og:image" content="' . $default_image . '"/>';
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
  }
  $width = isset($thumbnail_src)? $thumbnail_src[1]:237;
  $height = isset($thumbnail_src)? $thumbnail_src[2]:237;
  echo '<meta property="og:image:type" content="image/jpg">';
  echo '<meta property="og:image:width" content="'.$width.'">';
  echo '<meta property="og:image:height" content="'.$height.'">';
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );


function add_social_scripts() {
  ?>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '831632540243818',
        xfbml      : true,
        version    : 'v2.2'
      });
    };

    (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
  <?php
}
add_action('wp_footer', 'add_social_scripts');

function print_social_buttons($gallery_imageID, $has_text) {
  ?>
  <div class="social" >
    <?php
    if ($has_text){
      ?>
      <p><?php _e('Share this Photo:','roots'); ?></p>
      <?php
    }
    ?>
    <i class="share-btn facebook-btn" data-link="<?php echo bloginfo('url').'/gallery/?image='.sanitize_title(get_post( $gallery_imageID )->post_name).'&id='.$gallery_imageID?>" data-text="share text"></i>
    <i class="share-btn twitter-btn" data-link="<?php echo bloginfo('url').'/gallery/?image='.sanitize_title(get_post( $gallery_imageID )->post_name).'%26id='.$gallery_imageID?>" data-text="share text"></i>
  </div>
  <?php
}

function print_slider_container($image_array){
  ?>
  <div class="photo-holder">
    <?php foreach ( $image_array as $img ) :
      ?>
      <div class="slide">
        <img class="slick-slider-img" alt="Alt" src="<?php echo $img; ?>" />
      </div>
    <?php endforeach; ?>
    <div class="close"></div>
    <div class="chevron chevron-previous"></div>
    <div class="chevron chevron-next"></div>
    <div class="fade"></div>
  </div>
  <?php
}

function print_see_all_menu(){
  $args = array (
    'post_type' => 'artists',
    'meta_key' => '_artists_date',
    'orderby' => 'meta_value',
    'order' => 'ASC'
  );
// The Query
  $the_query = new WP_Query( $args );

  ?>
  <div class="artists-list-overlay"></div>
  <div class="menu-holder artists-list clear">
    <h1>Artists</h1>
    <ul class="animate">
      <?php
      if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
        $fname = get_post_meta( get_the_ID(), '_artists_fname', true );
        $lname = get_post_meta( get_the_ID(), '_artists_name', true );
        $date = get_post_meta(get_the_ID(), '_artists_date');
        $date_bis = new DateTime($date[0]);
        $month = $date_bis->format('F');
        $year = $date_bis->format('Y');
        $activated = get_post_meta(get_the_ID(), '_artists_activated', true);
        $class =  $activated == 'on' ? 'activated' : '';
        ?>
        <li class="fadeInUp <?php echo $class; ?>" data-artist="<?php echo sanitize_title(get_the_title());?>">
          <div class="img-holder" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()))?>)"></div>
          <div class="info">
            <h2><strong><?php echo $fname; ?></strong> <?php echo $lname; ?></h2>
            <p>Guest <span class="italic">of</span> <?php echo $month;?>, <?php echo $year;?></p>
          </div>
        </li>
        <?php
      endwhile;
      endif;
      ?>
    </ul>
  </div>
  <?php
}


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function theme_name_wp_title( $title, $sep ) {
  if ( is_feed() ) {
    return $title;
  }

  global $page, $paged, $post;

  // Add the blog name
  $title = get_bloginfo( 'name', 'display' );
  $title .= ' - ';
  if (is_home() || is_front_page()){
    $title .= __('Guest of the month', 'roots') . ' : ' . get_the_title(get_current_artist_id());
  }
  else{
    $title .= $post->post_title;
  }
//
//  // Add the blog description for the home/front page.
//  $site_description = get_bloginfo( 'description', 'display' );
//  if ( $site_description && ( is_home() || is_front_page() ) ) {
//    $title .= " $sep $site_description";
//  }
//
//  // Add a page number if necessary:
//  if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
//    $title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
//  }

  return $title;
}
add_filter( 'wp_title', 'theme_name_wp_title', 10, 2 );


function get_current_artist_id(){
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
  $current_artist_id = 0;
  // The Query
  $the_query = new WP_Query( $args );
 if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
          $current_artist_id = get_the_ID();
   endwhile;
   endif;
  return $current_artist_id;
}

add_action( 'wp_head', 'custom_meta' );
function custom_meta() {

}


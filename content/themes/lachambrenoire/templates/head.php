<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="description" content="<?php bloginfo('description'); ?>" />
  <meta name="author" content="La Chambre Noire" />
  <meta name="application-name" content="La Chambre Noire" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

  <?php wp_head(); ?>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
  <link rel="shortcut icon" type="image/ico" href="<?php echo get_template_directory_uri();?>/assets/img/favicon.ico"/>
</head>

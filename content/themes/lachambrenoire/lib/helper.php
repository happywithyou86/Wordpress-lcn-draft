<?php

function get_children_by_page_title($title){
  $parent =  get_page_by_title($title);
  $args = array(
      'child_of' => $parent->ID,
//      'parent' => $parent->ID,
      'hierarchical' => 0,
      'sort_column' => 'menu_order',
      'sort_order' => 'asc'
  );
  $children = get_pages( $args );
  return  $children;
}

function getTranslatedPageByTitle($title){
  $m_page = get_page_by_title($title);
  $m_page_id = $m_page->ID;

  $translated_page_id = icl_object_id($m_page_id, 'page', FALSE, ICL_LANGUAGE_CODE);
  $t_page = get_page($translated_page_id);
  return $t_page;
}

function wp_get_attachment( $attachment_id ) {

  $attachment = get_post( $attachment_id );
  return array(
      'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
      'caption' => $attachment->post_excerpt,
      'description' => $attachment->post_content,
      'href' => get_permalink( $attachment->ID ),
      'src' => $attachment->guid,
      'title' => $attachment->post_title
  );
}





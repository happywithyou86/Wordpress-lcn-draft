<?php
function wptp_add_categories_to_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'wptp_add_categories_to_attachments' );

function attachment_custom_field( $form_fields, $post ) {
  $form_fields['media-date'] = array(
    'label' => 'Jour',
    'input' => 'text',
    'value' => get_post_meta( $post->ID, 'media_date', true ),
  );

  return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'attachment_custom_field', 10, 2 );

function attachment_custom_field_save( $post, $attachment ) {
  if( isset( $attachment['media-date'] ) )
    update_post_meta( $post['ID'], 'media_date', $attachment['media-date'] );
  return $post;
}

add_filter( 'attachment_fields_to_save', 'attachment_custom_field_save', 10, 2 );

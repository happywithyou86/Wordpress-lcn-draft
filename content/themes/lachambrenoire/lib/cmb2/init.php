<?php

add_action( 'cmb2_init', 'cmb2_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function cmb2_sample_metaboxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_artists_';
    $types = array( 'artists', );

    /**
     * Initiate the metabox
     */


    $cmb = new_cmb2_box( array(
        'id'            => 'artist_metabox',
        'title'         => __( 'Artist Information and data', '_s' ),
        'object_types'  => $types,
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    $cmb->add_field( array(
      'name' => __( 'Activated', '_s' ),
      'desc' => __( 'Check this box if this is a activated artist?', '_s' ),
      'id'   => $prefix . 'activated',
      'type' => 'checkbox',
    ) );

    $cmb->add_field( array(
        'name'       => __( 'Firstname', '_s' ),
        'desc'       => __( 'The firstname of the artist', '_s' ),
        'id'         => $prefix . 'fname',
        'type'       => 'text',
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

    $cmb->add_field( array(
        'name'       => __( 'Name', '_s' ),
        'desc'       => __( 'The name of the artist', '_s' ),
        'id'         => $prefix . 'name',
        'type'       => 'text',
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

    $cmb->add_field( array(
        'name'    => 'Image of the month',
        'desc'    => 'Upload an image or enter an URL.',
        'id'      => $prefix . 'image',
        'type'    => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
        ),
    ) );

    // Regular text field
    $cmb->add_field( array(
        'name'       => __( 'Biography', '_s' ),
        'desc'       => __( 'A short bio about this artist', '_s' ),
        'id'         => $prefix . 'biography',
        'type'       => 'text',
        'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

    // URL text field
    $cmb->add_field( array(
        'name' => __( 'Artist main site', '_s' ),
        'desc' => __( 'Website of this artist', '_s' ),
        'id'   => $prefix . 'url',
        'type' => 'text_url',
        // 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
        // 'repeatable' => true,
    ) );

    // Email text field
    $cmb->add_field( array(
        'name' => __( 'Contact email', '_s' ),
        'desc' => __( 'The email wher you can contact this artist', '_s' ),
        'id'   => $prefix . 'email',
        'type' => 'text_email',
        // 'repeatable' => true,
    ) );

    $cmb->add_field( array(
        'name' => 'Gallery Images',
        'desc' => 'Upload and manage gallery images for this artist',
        'button' => 'Manage gallery', // Optionally set button label
        'id'   => $prefix . 'gallery_images',
        'type' => 'pw_gallery',
        'sanitization_cb' => 'pw_gallery_field_sanitise',
    ));

    $cmb->add_field( array(
        'name' => 'Artist for the month of',
        'desc' => 'Choose a month to display this work',
        'id' => $prefix . 'date',
        'type' => 'text_date',
        'date_format' => __( 'm/d/Y', 'cmb2' ), // use European date format
    ) );

    // Add other metaboxes as needed

}

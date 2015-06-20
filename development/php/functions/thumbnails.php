<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */

function wellcrafted_get_featured_image_src( $post_id = null ) {
    if ( ! $post_id ) {
        global $post;
        if ( $post instanceof WP_Post ) {
            $post_id = $post->ID;
        }
    }

    if ( ! $post_id ) {
        return '';
    }

    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );

    if ( $image ) {
        return $image[ 0 ];
    }

    return '';
}
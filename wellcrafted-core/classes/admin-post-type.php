<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Class for a custom post type which should not be available for
 * clients but only for admins in wp-admin area
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Wellcrafted_Admin_Post_Type extends Wellcrafted_Post_Type {
    /**
     * Controls how the type is visible to authors (show_in_nav_menus, show_ui) and readers (exclude_from_search, publicly_queryable).
     * 
     * @see https://codex.wordpress.org/Function_Reference/register_post_type
     * @var boolean
     * @since  1.0.0
     */
    protected $public = false;

    /**
     * Whether to generate a default UI for managing this post type in the admin. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_ui = true;

    /**
     * Whether to make this post type available in the WordPress admin bar. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_in_admin_bar = true;
}
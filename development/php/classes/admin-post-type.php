<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class for a custom post type which should not be available for
 * clients but only for admins in wp-admin area
 */
class Wellcrafted_Admin_Post_Type extends Wellcrafted_Post_Type {
    protected $public = false;
    protected $show_ui = true;
    protected $show_in_admin_bar = true;
}
<?php
/**
 * Plugin Name: Wellcrafted Core
 * Plugin URI: http://msherstobitow.com/plugins/wellcraftedcore
 * Description: A framework for all Wellcrafted plugins and themes.
 * Version: 1.0
 * Author: Maksim Sherstobitow
 * Author URI: http://msherstobitow.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

require 'classes/core.php';
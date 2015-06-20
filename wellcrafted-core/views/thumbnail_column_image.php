<?php 
/**
 * A markup for displaying featured image column data.
 * 
 * @package Wellcrafted\Support
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

?>

<div class="wellcrafted_column_thumbnail_wrapper" style="background-image: url(<?php echo $image ?>)"></div>
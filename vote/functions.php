<?php 
if (!function_exists('add_action'))
{
    require_once("../../../wp-config.php");
}

global $wpdb, $current_user;
define( 'TSOK_TESTIMONIAL_PATH', plugin_dir_path( __FILE__ ) );
define( 'TSOK_TESTIMONIAL_LOCATION', plugin_basename(__FILE__) );
define( 'TSOK_TESTIMONIAL_VERSION', '1.0' );
define ( 'TSOK_TESTIMONIAL_URL', plugins_url( '' ,  __FILE__ ) );
//echo TSOK_TESTIMONIAL_PATH.'<br>'.TSOK_TESTIMONIAL_LOCATION.'<br>'.TSOK_TESTIMONIAL_URL;
<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Ambition
 * @since Ambition 1.0
 */
?>
<?php
global $ambition_settings, $array_of_default_settings;
	$ambition_settings = wp_parse_args( 
    get_option( 'ambition_theme_settings', array() ), 
    ambition_get_option_defaults());
	$content_layout = $ambition_settings['content_layout'];
	if( class_exists( 'WooCommerce' ) && is_woocommerce() && $content_layout == 'right' ){
	echo '<div id="secondary">';
	// Calling the right sidebar
	if ( is_active_sidebar( 'ambition_right_sidebar' ) ) :
		dynamic_sidebar( 'ambition_right_sidebar' );
	endif;
	echo '</div>';
}elseif( class_exists( 'WooCommerce' ) && is_woocommerce() && $content_layout == 'left' ){
	echo '<div id="secondary">';
	// Calling the left sidebar
	if ( is_active_sidebar( 'ambition_left_sidebar' ) ) :
		dynamic_sidebar( 'ambition_left_sidebar' );
	endif;
	echo '</div>';
}
if( !class_exists( 'WooCommerce' )){
// Calling the right sidebar
	if ( is_active_sidebar( 'ambition_right_sidebar' ) ) :
		dynamic_sidebar( 'ambition_right_sidebar' );
	endif;
}
if( class_exists( 'WooCommerce' ) && !is_woocommerce()){
// Calling the right sidebar
	if ( is_active_sidebar( 'ambition_right_sidebar' ) ) :
		dynamic_sidebar( 'ambition_right_sidebar' );
	endif;
}

?>

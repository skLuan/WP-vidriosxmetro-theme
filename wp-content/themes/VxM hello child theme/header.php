<?php
/**
 * Header template for Hello Child theme.
 *
 * @package HelloChild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
// Hook for opening body tag.
do_action( 'elementor_hello_theme_body_open' );
?>
<div class="site" id="page">
    <?php
    /**
     * Hook: elementor_hello_theme_header.
     *
     * @hooked elementor_hello_theme_site_header - 10
     */
    do_action( 'elementor_hello_theme_header' );
    ?>

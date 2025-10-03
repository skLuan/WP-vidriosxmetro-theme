<?php
/**
 * Footer template for Hello Child theme.
 *
 * @package HelloChild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Hook for closing content area.
do_action( 'elementor_hello_theme_footer' );
?>
</div><!-- #page -->

<?php
// Hook for closing body tag.
do_action( 'elementor_hello_theme_body_close' );
wp_footer();
?>
</body>
</html>

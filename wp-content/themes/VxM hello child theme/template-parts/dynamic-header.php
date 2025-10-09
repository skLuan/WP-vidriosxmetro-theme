<?php

/**
 * The template for displaying header.
 *
 * @package HelloElementor
 */
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (! hello_get_header_display()) {
	return;
}

$is_editor = isset($_GET['elementor-preview']);
$site_name = get_bloginfo('name');
$tagline   = get_bloginfo('description', 'display');
$header_class = did_action('elementor/loaded') ? hello_get_header_layout_class() : '';
$menu_args = [
	'theme_location' => 'menu-1',
	'fallback_cb' => false,
	'container' => false,
	'echo' => false,
];
$header_nav_menu = wp_nav_menu($menu_args);
$header_mobile_nav_menu = wp_nav_menu($menu_args); // The same menu but separate call to avoid duplicate ID attributes.
?>
<header id="site-header" class="site-header dynamic-header <?php echo esc_attr($header_class); ?>">
	<div class="header-inner">
		<div class="site-branding">
			<a href="/"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/logo-header.svg" alt="logo of the company"></a>
		</div>

		<?php if ($header_nav_menu) : ?>
			<nav class="site-navigation <?php echo esc_attr(hello_show_or_hide('hello_header_menu_display')); ?>" aria-label="<?php echo esc_attr__('Main menu', 'hello-elementor'); ?>">
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $header_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
		<?php endif; ?>
		<?php if ($header_mobile_nav_menu) : ?>
			<div class="site-navigation-toggle-holder <?php echo esc_attr(hello_show_or_hide('hello_header_menu_display')); ?>">
				<button type="button" class="site-navigation-toggle" aria-label="<?php echo esc_attr('Menu', 'hello-elementor'); ?>">
					<span class="site-navigation-toggle-icon" aria-hidden="true"></span>
				</button>
			</div>
			<nav class="site-navigation-dropdown <?php echo esc_attr(hello_show_or_hide('hello_header_menu_display')); ?>" aria-label="<?php echo esc_attr__('Mobile menu', 'hello-elementor'); ?>" aria-hidden="true" inert>
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $header_mobile_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
		<?php endif; ?>
	</div>
	<div class="search-container absolute">
		<?php get_search_form(); ?>
		<a href="#">
			<iconify-icon icon="logos:whatsapp-icon" style="margin-left: 16px;" width="44" height="44"></iconify-icon>
		</a>
	</div>
</header>
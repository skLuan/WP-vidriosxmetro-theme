<?php

/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$is_editor = isset($_GET['elementor-preview']);
$site_name = get_bloginfo('name');
$tagline   = get_bloginfo('description', 'display');
$footer_class = did_action('elementor/loaded') ? hello_get_footer_layout_class() : '';
$footer_nav_menu = wp_nav_menu([
	'theme_location' => 'menu-2',
	'fallback_cb' => false,
	'container' => false,
	'echo' => false,
]);
?>
<footer id="site-footer" class="site-footer dynamic-footer <?php echo esc_attr($footer_class); ?>">
	<div class="footer-inner">
		<figure class="absolute footer-logo">
			<picture>
				<img style="height: 100%;" src="<?php echo esc_url(get_theme_file_uri('/assets/logo-white-footer.svg')); ?>" alt="">
			</picture>
		</figure>
		<div class="site-branding show-<?php echo esc_attr(hello_elementor_get_setting('hello_footer_logo_type')); ?>">
			<?php if (has_custom_logo() && ('title' !== hello_elementor_get_setting('hello_footer_logo_type') || $is_editor)) : ?>
				<div class="site-logo <?php echo esc_attr(hello_show_or_hide('hello_footer_logo_display')); ?>">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif;

			if ($site_name && ('logo' !== hello_elementor_get_setting('hello_footer_logo_type')) || $is_editor) : ?>
				<div class="site-title <?php echo esc_attr(hello_show_or_hide('hello_footer_logo_display')); ?>">
					<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr__('Home', 'hello-elementor'); ?>" rel="home">
						<?php echo esc_html($site_name); ?>
					</a>
				</div>
			<?php endif;
			?>
		</div>

		<?php if ($footer_nav_menu) : ?>
			<nav class="site-navigation <?php echo esc_attr(hello_show_or_hide('hello_footer_menu_display')); ?>" aria-label="<?php echo esc_attr__('Footer menu', 'hello-elementor'); ?>">
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $footer_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
		<?php endif; ?>

		<div class="social-links">
			<ul>
				<li><a href="http://instagram.com"><iconify-icon icon="line-md:instagram" width="24" height="24"></iconify-icon></a></li>
				<li><a href="http://facebook.com"><iconify-icon icon="line-md:facebook" width="24" height="24"></iconify-icon></a></li>
				<li><a href="http://twitter.com"><iconify-icon icon="line-md:twitter" width="24" height="24"></iconify-icon></a></li>
			</ul>
		</div>
	</div>
	<div class="footer-copyright">
		<p style="font-size: 12px; font-weight:400;">Copyright &copy; <?php echo date('Y'); ?></p>
		<p style="font-size: 12px; font-weight:400;">created by <a href="https://thelamb.studio/" target="_blank" style="font-weight: 600; text-decoration: underline; color:var(--vxm-black);">The Lamb Studio</a></p>
	</div>
</footer>
<?php

/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 * @package HelloElementor
 */
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();

$is_elementor_theme_exist = function_exists('elementor_theme_do_location');

if (is_singular()) {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('single')) {
		get_template_part('template-parts/single');
	}
} elseif (is_archive() || is_home()) {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('archive')) {
		get_template_part('template-parts/archive');
	}
} elseif (is_search()) {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('archive')) {
		get_template_part('template-parts/search');
	}
} else {
	if (! $is_elementor_theme_exist || ! elementor_theme_do_location('single')) {
		get_template_part('template-parts/404');
	}
}
?>
<?php
// Get WooCommerce product categories
$product_categories = get_terms(array(
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'number' => 9, // Limit to 9 for 3x3 grid
));

if (!empty($product_categories) && !is_wp_error($product_categories)) {
	echo '<div class="categories-grid">';
	foreach ($product_categories as $category) {
		$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
		$image_url = $thumbnail_id ? wp_get_attachment_image_src($thumbnail_id, 'medium')[0] : '';
		$alt_text = $category->name;
?>
		<div class="cat-card">
			<figure class="cat-image">
				<picture>
					<img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($alt_text); ?>">
				</picture>
			</figure>
			<div class="absolute cat-name">
				<div class="flex items-center justify-center">
					<iconify-icon icon="material-symbols-light:window-outline" width="24" height="24"></iconify-icon>
				</div>
				<span><?= esc_html($category->name); ?></span>
			</div>
		</div>
	<?php
	}
	?>
	</div>
<?php
}
get_footer();

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
?>
<section id="categorias" class="categories py-32 px-4 lg:px-11 relative overflow-hidden">
	<figure class="absolute top-4 -left-5">
		<picture><img src="<?= esc_url(get_stylesheet_directory_uri() . '/assets/vector-bg.svg'); ?>" alt=""></picture>
	</figure>
	<h2 class=" pb-10">Productos <span class="" style="color: var(--color-yellow-vxm);">x</span> Categoria</h2>
	<?php
	if (!empty($product_categories) && !is_wp_error($product_categories)) :
	?>
		<div class="categories-grid">
			<?php
			foreach ($product_categories as $category) :
				$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
				$image_url = $thumbnail_id ? wp_get_attachment_image_src($thumbnail_id, 'medium')[0] : '';
				$alt_text = $category->name;
			?>
				<div class="cat-card overflow-hidden">
					<a class="flex w-full h-full" href="<?= esc_url(get_term_link($category)); ?>">
						<figure class="cat-image">
							<picture>
								<img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($alt_text); ?>">
							</picture>
						</figure>
						<div class="absolute cat-name justify-center items-center gap-2">
							<div class="flex items-center justify-center bg-[var(--vxm-black)] rounded-full p-1">
								<iconify-icon icon="material-symbols-light:window-outline" width="24" height="24"></iconify-icon>
							</div>
							<span><?= esc_html($category->name); ?></span>
						</div>
					</a>
				</div>
			<?php
			endforeach;
			?>
		</div>
</section>
<section id="nuestraSeccion" class="">
	<!-- Slider main container -->
	<div class="swiper">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			<!-- Slides -->
			<div class="swiper-slide slide-1">
				<figure>
					<picture><img src="<?= esc_url(get_stylesheet_directory_uri() . '/assets/slides/slide1.jpg'); ?>" alt=""></picture>
				</figure>
			</div>
			<div class="swiper-slide slide-2">
				<figure>
					<picture><img src="<?= esc_url(get_stylesheet_directory_uri() . '/assets/slides/slide2.jpg'); ?>" alt=""></picture>
				</figure>
			</div>
			<div class="swiper-slide slide-3">
				<figure>
					<picture><img src="<?= esc_url(get_stylesheet_directory_uri() . '/assets/slides/slide3.jpg'); ?>" alt=""></picture>
				</figure>
			</div>
		</div>
		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>

		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>

		<!-- If we need scrollbar -->
		<div class="swiper-scrollbar"></div>
	</div>
</section>
<section id="servicios" class="">

</section>
</section>
<section id="nuestros-clientes" class="">

</section>
<?php
	endif;
	get_footer();

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
<section id="categorias" class="categories py-32 px-4 lg:px-11 relative overflow-hidden lg:max-w-10/12 mx-auto">
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
				<figure class="min-h-[55vh] bg-black-vxm md:min-h-auto">
					<picture><img width="100%" src="<?= esc_url(get_stylesheet_directory_uri() . '/assets/slides/slide1.jpg'); ?>" alt=""></picture>
				</figure>
			</div>
			<div class="swiper-slide slide-2">
				<figure class="min-h-[55vh] bg-black-vxm">
					<picture><img width="100%" src="<?= esc_url(get_stylesheet_directory_uri() . '/assets/slides/slide2.jpg'); ?>" alt=""></picture>
				</figure>
			</div>
			<div class="swiper-slide slide-3">
				<figure class="min-h-[55vh] bg-black-vxm">
					<picture><img width="100%" src="<?= esc_url(get_stylesheet_directory_uri() . '/assets/slides/slide3.jpg'); ?>" alt=""></picture>
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
<section id="servicios" class="min-h-[80dvh] flex relative">
	<div class="absolute top-0 left-0 w-full h-full flex justify-center items-center">
		<h2 class="m-auto !text-[250px] h-fit opacity-35">Servicios</h2>
	</div>
	<article class=" md:max-w-8/12 mx-auto md:w-1/2">
		<div class="p-6 services-card">
			<h4 class="text-center !font-bold">Diseño</h4>
			<p>Diseñamos soluciones en vidrio y aluminio,
				equilibrando estética y funcionalidad. Fachadas y ventanas para residencias
				y comercios.</p>
		</div>
		<div class="p-6 services-card">
			<h4 class="text-center !font-bold">Fabricación</h4>
			<p>Fabricamos vidrio templado y aluminio con precisión. Cerramientos y puertas para residencias e instituciones.</p>
		</div>
		<div class="p-6 services-card">
			<h4 class="text-center !font-bold">Instalación</h4>
			<p>Instalamos ventanas y fachadas, garantizando seguridad y cumplimiento. Resultados confiables.</p>
		</div>
	</article>
</section>
</section>
<section id="nuestros-clientes" class="">

</section>
<section id="preguntas-frecuentes" class="py-12" style="background: radial-gradient(126.84% 108.18% at 82.43% 74.87%, #2E2E2E 41.62%, #000 100%);">
	<div class="inner max-w-10/12 mx-auto px-4">
		<h2 class="!text-yellow-vxm">Preguntas frecuentes</h2>
		<form action="searchFaqs" class="max-w-3/12">
			<input type="text">
			<button>send</button>
		</form>

		<div class="grid grid-cols-2 gap-4">
			<?php
			// Get FAQ categories
			$faq_categories = get_terms(array(
				'taxonomy' => 'categorias_preguntas',
				'hide_empty' => true,
			));

			if (!empty($faq_categories) && !is_wp_error($faq_categories)) {
				foreach ($faq_categories as $category) {
					// Query posts for this category
					$faq_query = new WP_Query(array(
						'post_type' => 'preguntas_frecuentes',
						'posts_per_page' => 5,
						'orderby' => 'date',
						'order' => 'DESC',
						'tax_query' => array(
							array(
								'taxonomy' => 'categorias_preguntas',
								'field' => 'term_id',
								'terms' => $category->term_id,
							),
						),
					));

					if ($faq_query->have_posts()) {
						?>
						<div class="cat-faq-container">
							<h3 class="!text-white-vxm"><?php echo esc_html($category->name); ?></h3>
							<?php
							while ($faq_query->have_posts()) {
								$faq_query->the_post();
								?>
								<div class="faq-acordeon p-8 border border-white-vxm-5 rounded-sm bg-white-vxm-5" style="backdrop-filter: blur(2);">
									<div class="flex flex-row gap-3 border-b border-yellow-vxm-30">
										<iconify-icon class="!text-yellow-vxm" icon="iconamoon:arrow-down-2" width="24" height="24"></iconify-icon>
										<p class="text-white-vxm"><?php the_title(); ?></p>
									</div>
									<div class="text-white-vxm pt-2 text-base">
										<?php the_content(); ?>
									</div>
								</div>
								<?php
							}
							wp_reset_postdata();
							?>
						</div>
						<?php
					}
				}
			} else {
				// Fallback: Show all FAQs if no categories or categories are empty
				$faq_query = new WP_Query(array(
					'post_type' => 'preguntas_frecuentes',
					'posts_per_page' => 5,
					'orderby' => 'date',
					'order' => 'DESC',
				));

				if ($faq_query->have_posts()) {
					?>
					<div class="cat-faq-container">
						<h3 class="!text-white-vxm">Preguntas Frecuentes</h3>
						<?php
						while ($faq_query->have_posts()) {
							$faq_query->the_post();
							?>
							<div class="faq-acordeon p-8 border border-white-vxm-5 rounded-sm bg-white-vxm-5" style="backdrop-filter: blur(2);">
								<div class="flex flex-row gap-3 border-b border-yellow-vxm-30">
									<iconify-icon class="!text-yellow-vxm" icon="iconamoon:arrow-down-2" width="24" height="24"></iconify-icon>
									<p class="text-white-vxm"><?php the_title(); ?></p>
								</div>
								<div class="text-white-vxm pt-2">
									<?php the_content(); ?>
								</div>
							</div>
							<?php
						}
						wp_reset_postdata();
						?>
					</div>
					<?php
				} else {
					?>
					<div class="cat-faq-container">
						<h3 class="!text-white-vxm">Preguntas Frecuentes</h3>
						<div class="faq-acordeon p-8 border border-white-vxm-5 rounded-sm bg-white-vxm-5" style="backdrop-filter: blur(2);">
							<div class="flex flex-row gap-3 border-b border-yellow-vxm-30">
								<iconify-icon class="!text-yellow-vxm" icon="iconamoon:arrow-down-2" width="24" height="24"></iconify-icon>
								<p class="text-white-vxm">No hay preguntas frecuentes disponibles</p>
							</div>
							<p class="text-white-vxm pt-2">Pronto agregaremos preguntas frecuentes aquí.</p>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>

		<!-- <div class="text-center mt-8">
			<a href="<?php // echo esc_url(get_post_type_archive_link('preguntas_frecuentes')); ?>" class="inline-block bg-yellow-vxm text-black px-6 py-3 rounded-md hover:bg-yellow-400 transition-colors">
				Ver todas las preguntas frecuentes
			</a>
		</div> -->
	</div>
</section>
<?php
	endif;
	get_footer();

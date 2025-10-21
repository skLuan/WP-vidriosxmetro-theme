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
                            <div class="p-8 border border-white-vxm-5 rounded-sm bg-white-vxm-5" style="backdrop-filter: blur(calc(4/2));">
                                <?php
                                while ($faq_query->have_posts()) :
                                    $faq_query->the_post();
                                ?>
                                    <div class="faq-acordeon">
                                        <div class="faq-touch transition-all flex flex-row gap-3 border-b border-yellow-vxm-30">
                                            <iconify-icon class="!text-yellow-vxm" icon="iconamoon:arrow-down-2" width="24" height="24"></iconify-icon>
                                            <p class="text-white-vxm mb-2"><?php the_title(); ?></p>
                                        </div>
                                        <div class="text-white-vxm pt-2 transition-all">
                                            <?php the_content(); ?>
                                        </div>
                                    </div>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
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
                        <div class="p-8 border border-white-vxm-5 rounded-sm bg-white-vxm-5" style="backdrop-filter: blur(calc(4/2));">
                            <?php
                            while ($faq_query->have_posts()) :
                                $faq_query->the_post();
                            ?>
                                <div class="faq-acordeon">
                                    <div class="faq-touch transition-all flex flex-row gap-3 border-b border-yellow-vxm-30">
                                        <iconify-icon class="!text-yellow-vxm" icon="iconamoon:arrow-down-2" width="24" height="24"></iconify-icon>
                                        <p class="text-white-vxm !mb-1"><?php the_title(); ?></p>
                                    </div>
                                    <div class="text-white-vxm pt-2 transition-all mb-8">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
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
			<a href="<?php // echo esc_url(get_post_type_archive_link('preguntas_frecuentes')); 
                        ?>" class="inline-block bg-yellow-vxm text-black px-6 py-3 rounded-md hover:bg-yellow-400 transition-colors">
				Ver todas las preguntas frecuentes
			</a>
		</div> -->
    </div>
</section>
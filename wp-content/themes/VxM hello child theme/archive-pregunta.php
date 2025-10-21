<?php
/**
 * Template for displaying archive pages for the "preguntas_frecuentes" custom post type
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container mx-auto px-4 py-8">
        <header class="page-header mb-8">
            <h1 class="text-3xl font-bold text-gray-900"><?php post_type_archive_title(); ?></h1>
            <?php
            $description = get_the_archive_description();
            if ($description) {
                echo '<div class="archive-description mt-4 text-gray-600">' . wp_kses_post(wpautop($description)) . '</div>';
            }
            ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow'); ?>>
                        <header class="entry-header mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                        </header>

                        <div class="entry-content">
                            <?php
                            $excerpt = get_the_excerpt();
                            if ($excerpt) {
                                echo '<p class="text-gray-700 mb-4">' . wp_trim_words($excerpt, 20, '...') . '</p>';
                            }
                            ?>
                        </div>

                        <footer class="entry-footer">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php
                                // Display categories
                                $categories = get_the_terms(get_the_ID(), 'categorias_preguntas');
                                if ($categories && !is_wp_error($categories)) {
                                    foreach ($categories as $category) {
                                        echo '<span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">';
                                        echo '<a href="' . esc_url(get_term_link($category)) . '" class="hover:text-blue-900">' . esc_html($category->name) . '</a>';
                                        echo '</span>';
                                    }
                                }

                                // Display tags
                                $tags = get_the_terms(get_the_ID(), 'etiquetas_preguntas');
                                if ($tags && !is_wp_error($tags)) {
                                    foreach ($tags as $tag) {
                                        echo '<span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">';
                                        echo '<a href="' . esc_url(get_term_link($tag)) . '" class="hover:text-gray-900">' . esc_html($tag->name) . '</a>';
                                        echo '</span>';
                                    }
                                }
                                ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                Leer más
                            </a>
                        </footer>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('« Anterior', 'text-domain'),
                'next_text' => __('Siguiente »', 'text-domain'),
            ));
            ?>

        <?php else : ?>
            <div class="no-posts-found text-center py-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">No se encontraron preguntas frecuentes</h2>
                <p class="text-gray-600 mb-6">Lo sentimos, no hay preguntas frecuentes disponibles en este momento.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">
                    Volver al inicio
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
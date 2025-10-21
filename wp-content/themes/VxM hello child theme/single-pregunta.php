<?php
/**
 * Template for displaying single posts for the "preguntas_frecuentes" custom post type
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container mx-auto px-4 py-8">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md p-8 max-w-4xl mx-auto'); ?>>
                <header class="entry-header mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h1>

                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php
                        // Display categories
                        $categories = get_the_terms(get_the_ID(), 'categorias_preguntas');
                        if ($categories && !is_wp_error($categories)) {
                            foreach ($categories as $category) {
                                echo '<span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">';
                                echo '<a href="' . esc_url(get_term_link($category)) . '" class="hover:text-blue-900">' . esc_html($category->name) . '</a>';
                                echo '</span>';
                            }
                        }

                        // Display tags
                        $tags = get_the_terms(get_the_ID(), 'etiquetas_preguntas');
                        if ($tags && !is_wp_error($tags)) {
                            foreach ($tags as $tag) {
                                echo '<span class="inline-block bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full">';
                                echo '<a href="' . esc_url(get_term_link($tag)) . '" class="hover:text-gray-900">' . esc_html($tag->name) . '</a>';
                                echo '</span>';
                            }
                        }
                        ?>
                    </div>
                </header>

                <div class="entry-content prose prose-lg max-w-none">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer mt-8 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <?php
                            printf(
                                __('Publicado el %s', 'text-domain'),
                                get_the_date()
                            );
                            ?>
                        </div>

                        <div class="flex gap-4">
                            <a href="<?php echo get_post_type_archive_link('preguntas_frecuentes'); ?>" class="inline-block bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                                ← Volver a Preguntas Frecuentes
                            </a>
                        </div>
                    </div>
                </footer>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
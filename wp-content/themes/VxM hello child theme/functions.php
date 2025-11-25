<?php
include_once get_stylesheet_directory() . '/inc/cpt-and-taxonomies.php';

/**
 * Functions.php del Child Theme de Hello Elementor
 * Versión consolidada y actualizada: Incluye WooCommerce para productos y taxonomías bidireccionales.
 */
/**
 * Theme setup and configuration
 */
add_action('after_setup_theme', 'vxm_theme_setup');
function vxm_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list'));
    add_theme_support('woocommerce');
}

//------- Upload galery media from wrodpress
function proyectos_gallery_admin_assets( $hook ) {
    global $post_type;

    // Only on post edit / new screens for the proyectos CPT
    if (
        in_array( $hook, array( 'post.php', 'post-new.php' ), true )
        && 'proyectos' === $post_type
    ) {
        // WordPress media APIs
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }

        // Your custom JS (create this file in your theme)
        wp_enqueue_script(
            'proyectos-gallery-admin',
            get_stylesheet_directory_uri() . '/src/admin_proyectos_gallery.js',
            array( 'jquery' ),
            '1.0',
            true
        );
    }
}
add_action( 'admin_enqueue_scripts', 'proyectos_gallery_admin_assets' );

// 1. Encolar estilos del child theme (para que herede del padre y agregue custom)
function hello_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'hello_child_enqueue_styles');

// 1.1. Vite hot reloading for development and production build enqueue
function enqueue_vite_scripts() {
    $manifestPath = get_stylesheet_directory() . '/assets/build/.vite/manifest.json';

    // Check if the manifest file exists and is readable before using it
    if (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), true);
        
        // Check if the file is in the manifest before enqueuing
        if (isset($manifest['src/main.js'])) {
            wp_enqueue_script('vxm-script', get_stylesheet_directory_uri() . '/assets/build/' . $manifest['src/main.js']['file'], array(), null, true);
            // Enqueue the CSS files (handle multiple)
            if (isset($manifest['src/main.js']['css']) && is_array($manifest['src/main.js']['css'])) {
                foreach ($manifest['src/main.js']['css'] as $index => $css_file) {
                    wp_enqueue_style('vxm-style-' . $index, get_stylesheet_directory_uri() . '/assets/build/' . $css_file);
                }
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_vite_scripts');

// 1.5. Add CORS headers for font files
function add_cors_headers() {
    if (isset($_SERVER['REQUEST_URI']) && preg_match('/\.(woff|woff2|ttf|eot)$/', $_SERVER['REQUEST_URI'])) {
        header('Access-Control-Allow-Origin: *');
    }
}
add_action('send_headers', 'add_cors_headers');


// 4. Opcional: Desactivar carrito y checkout de WooCommerce (para modo vitrina)
function desactivar_woocommerce_vitrina() {
    add_filter('woocommerce_is_purchasable', '__return_false');
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
}
add_action('init', 'desactivar_woocommerce_vitrina');

// Hook para poblar automáticamente términos basados en productos WooCommerce ('product')
function sincronizar_productos_a_etiquetas($post_id) {
    if (get_post_type($post_id) !== 'product') { // Actualizado: Usa 'product'
        return;
    }
    $producto_titulo = get_the_title($post_id);
    $producto_slug = sanitize_title($producto_titulo);

    $term = term_exists($producto_slug, 'productos_usados');
    if (!$term) {
        wp_insert_term(
            $producto_titulo,
            'productos_usados',
            array('slug' => $producto_slug)
        );
    }
}
add_action('save_post', 'sincronizar_productos_a_etiquetas');

// Función para mostrar en frontend de proyectos (ya existente)
function mostrar_productos_usados_en_proyecto() {
    global $post;
    if (get_post_type($post) !== 'proyectos') {
        return;
    }
    $productos = get_the_terms($post->ID, 'productos_usados');
    if ($productos && !is_wp_error($productos)) {
        echo '<div class="productos-usados-proyecto"><h3>Productos usados en este proyecto:</h3><ul>';
        foreach ($productos as $producto) {
            echo '<li><a href="' . get_term_link($producto) . '">' . esc_html($producto->name) . '</a></li>';
        }
        echo '</ul></div>';
    }
}
// add_shortcode('productos_usados', 'mostrar_productos_usados_en_proyecto'); // Descomenta para shortcode

// Hook para poblar automáticamente términos basados en proyectos existentes
// (Crea un término en "proyectos_asociados" cuando se publica/edita un proyecto)
function sincronizar_proyectos_a_etiquetas($post_id) {
    if (get_post_type($post_id) !== 'proyectos') {
        return;
    }
    $proyecto_titulo = get_the_title($post_id);
    $proyecto_slug = sanitize_title($proyecto_titulo);

    // Verificar si el término ya existe
    $term = term_exists($proyecto_slug, 'proyectos_asociados');
    if (!$term) {
        wp_insert_term(
            $proyecto_titulo, // Nombre del término
            'proyectos_asociados',
            array('slug' => $proyecto_slug)
        );
    }
}
add_action('save_post', 'sincronizar_proyectos_a_etiquetas');

// Ejemplo: Función para mostrar "Proyectos asociados" en el frontend de productos (usa en single-product.php)
function mostrar_proyectos_asociados_en_producto() {
    global $post;
    if (get_post_type($post) !== 'product') {
        return;
    }
    $proyectos = get_the_terms($post->ID, 'proyectos_asociados');
    if ($proyectos && !is_wp_error($proyectos)) {
        echo '<div class="proyectos-asociados-producto"><h3>Proyectos donde se usa este producto:</h3><ul>';
        foreach ($proyectos as $proyecto) {
            echo '<li><a href="' . get_term_link($proyecto) . '">' . esc_html($proyecto->name) . '</a></li>';
        }
        echo '</ul></div>';
    }
}
// Para usarlo: add_action('woocommerce_single_product_summary', 'mostrar_proyectos_asociados_en_producto', 25); // En página de producto
// O crea un shortcode: add_shortcode('proyectos_asociados', 'mostrar_proyectos_asociados_en_producto');
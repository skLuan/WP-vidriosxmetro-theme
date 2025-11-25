<?php
include_once get_stylesheet_directory() . '/inc/cpt-proyectos.php';


//-----------------------------------
//-----------------------------------

// CPT "preguntas frecuentes" (frequently asked questions)
function registrar_cpt_preguntas_frecuentes()
{
    $labels = array(
        'name' => 'Preguntas Frecuentes',
        'singular_name' => 'Pregunta Frecuente',
        'menu_name' => 'Preguntas Frecuentes',
        'name_admin_bar' => 'Pregunta Frecuente',
        'add_new' => 'Agregar Nueva',
        'add_new_item' => 'Agregar Nueva Pregunta Frecuente',
        'new_item' => 'Nueva Pregunta Frecuente',
        'edit_item' => 'Editar Pregunta Frecuente',
        'view_item' => 'Ver Pregunta Frecuente',
        'all_items' => 'Todas las Preguntas Frecuentes',
        'search_items' => 'Buscar Preguntas Frecuentes',
        'parent_item_colon' => 'Pregunta Frecuente Padre:',
        'not_found' => 'No se encontraron preguntas frecuentes.',
        'not_found_in_trash' => 'No se encontraron preguntas frecuentes en la papelera.',
        'archives' => 'Archivo de Preguntas Frecuentes',
        'insert_into_item' => 'Insertar en pregunta frecuente',
        'uploaded_to_this_item' => 'Subido a esta pregunta frecuente',
        'filter_items_list' => 'Filtrar lista de preguntas frecuentes',
        'items_list_navigation' => 'Navegación de lista de preguntas frecuentes',
        'items_list' => 'Lista de preguntas frecuentes',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'preguntas-frecuentes'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'page-attributes'),
        'show_in_rest' => true,
    );

    register_post_type('preguntas_frecuentes', $args);
}
add_action('init', 'registrar_cpt_preguntas_frecuentes');

// 3. Registro de Taxonomías compartidas (jerárquicas, como acordamos)
// Taxonomía "sector" (ej. Residencial > Hogar, compartida con 'product' y 'proyectos')
function registrar_taxonomia_sector()
{
    $labels = array(
        'name' => 'Sectores',
        'singular_name' => 'Sector',
        'menu_name' => 'Sectores',
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'sector'),
    );
    register_taxonomy('sector', array('product', 'proyectos'), $args); // Actualizado: Incluye 'product' para WooCommerce
}
add_action('init', 'registrar_taxonomia_sector');

// 5. Taxonomía "productos_usados" para proyectos (como etiquetas, ya existente)
function registrar_taxonomia_productos_usados()
{
    $labels = array(
        'name' => 'Productos usados en el proyecto',
        'singular_name' => 'Producto usado',
        'menu_name' => 'Productos usados',
        'search_items' => 'Buscar productos usados',
        'all_items' => 'Todos los productos usados',
        'edit_item' => 'Editar producto usado',
        'update_item' => 'Actualizar producto usado',
        'add_new_item' => 'Agregar nuevo producto usado',
        'new_item_name' => 'Nombre del nuevo producto usado',
    );
    $args = array(
        'hierarchical' => false, // No jerárquica, como etiquetas
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'productos-usados'),
    );
    register_taxonomy('productos_usados', array('proyectos'), $args);
}
add_action('init', 'registrar_taxonomia_productos_usados');

// 6. NUEVA: Taxonomía "proyectos_asociados" para productos WooCommerce (simétrica, como etiquetas)
function registrar_taxonomia_proyectos_asociados()
{
    $labels = array(
        'name' => 'Proyectos donde se usa este producto',
        'singular_name' => 'Proyecto asociado',
        'menu_name' => 'Proyectos asociados',
        'search_items' => 'Buscar proyectos asociados',
        'all_items' => 'Todos los proyectos asociados',
        'edit_item' => 'Editar proyecto asociado',
        'update_item' => 'Actualizar proyecto asociado',
        'add_new_item' => 'Agregar nuevo proyecto asociado',
        'new_item_name' => 'Nombre del nuevo proyecto asociado',
    );
    $args = array(
        'hierarchical' => false, // No jerárquica, como etiquetas
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'proyectos-asociados'),
    );
    register_taxonomy('proyectos_asociados', array('product'), $args); // Asociada solo a 'product' (WooCommerce)
}
add_action('init', 'registrar_taxonomia_proyectos_asociados');

// Taxonomía "categorias_preguntas" (jerárquica, como categorías) para preguntas frecuentes
function registrar_taxonomia_categorias_preguntas()
{
    $labels = array(
        'name' => 'Categorías de Preguntas',
        'singular_name' => 'Categoría de Pregunta',
        'menu_name' => 'Categorías de Preguntas',
        'all_items' => 'Todas las Categorías',
        'edit_item' => 'Editar Categoría',
        'view_item' => 'Ver Categoría',
        'update_item' => 'Actualizar Categoría',
        'add_new_item' => 'Agregar Nueva Categoría',
        'new_item_name' => 'Nombre de Nueva Categoría',
        'parent_item' => 'Categoría Padre',
        'parent_item_colon' => 'Categoría Padre:',
        'search_items' => 'Buscar Categorías',
        'popular_items' => 'Categorías Populares',
        'separate_items_with_commas' => 'Separar categorías con comas',
        'add_or_remove_items' => 'Agregar o quitar categorías',
        'choose_from_most_used' => 'Elegir de las más usadas',
        'not_found' => 'No se encontraron categorías',
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'categorias-preguntas'),
    );

    register_taxonomy('categorias_preguntas', array('preguntas_frecuentes'), $args);
}
add_action('init', 'registrar_taxonomia_categorias_preguntas');

// Taxonomía "etiquetas_preguntas" (no jerárquica, como etiquetas) para preguntas frecuentes
function registrar_taxonomia_etiquetas_preguntas()
{
    $labels = array(
        'name' => 'Etiquetas de Preguntas',
        'singular_name' => 'Etiqueta de Pregunta',
        'menu_name' => 'Etiquetas de Preguntas',
        'all_items' => 'Todas las Etiquetas',
        'edit_item' => 'Editar Etiqueta',
        'view_item' => 'Ver Etiqueta',
        'update_item' => 'Actualizar Etiqueta',
        'add_new_item' => 'Agregar Nueva Etiqueta',
        'new_item_name' => 'Nombre de Nueva Etiqueta',
        'search_items' => 'Buscar Etiquetas',
        'popular_items' => 'Etiquetas Populares',
        'separate_items_with_commas' => 'Separar etiquetas con comas',
        'add_or_remove_items' => 'Agregar o quitar etiquetas',
        'choose_from_most_used' => 'Elegir de las más usadas',
        'not_found' => 'No se encontraron etiquetas',
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'etiquetas-preguntas'),
    );

    register_taxonomy('etiquetas_preguntas', array('preguntas_frecuentes'), $args);
}
add_action('init', 'registrar_taxonomia_etiquetas_preguntas');

// CPT "testimonies" (para testimonios de clientes)
function registrar_cpt_testimonies()
{
    $labels = array(
        'name' => 'Testimonies',
        'singular_name' => 'Testimony',
        'menu_name' => 'Testimonies',
        'name_admin_bar' => 'Testimony',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Testimony',
        'new_item' => 'New Testimony',
        'edit_item' => 'Edit Testimony',
        'view_item' => 'View Testimony',
        'all_items' => 'All Testimonies',
        'search_items' => 'Search Testimonies',
        'parent_item_colon' => 'Parent Testimony:',
        'not_found' => 'No testimonies found.',
        'not_found_in_trash' => 'No testimonies found in trash.',
        'archives' => 'Testimony Archives',
        'insert_into_item' => 'Insert into testimony',
        'uploaded_to_this_item' => 'Uploaded to this testimony',
        'filter_items_list' => 'Filter testimonies list',
        'items_list_navigation' => 'Testimonies list navigation',
        'items_list' => 'Testimonies list',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonies'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_in_rest' => true,
    );

    register_post_type('testimonies', $args);
}
add_action('init', 'registrar_cpt_testimonies');

// CPT "clients" (para clientes con logos)
function registrar_cpt_clients()
{
    $labels = array(
        'name' => 'Clients',
        'singular_name' => 'Client',
        'menu_name' => 'Clients',
        'name_admin_bar' => 'Client',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Client',
        'new_item' => 'New Client',
        'edit_item' => 'Edit Client',
        'view_item' => 'View Client',
        'all_items' => 'All Clients',
        'search_items' => 'Search Clients',
        'parent_item_colon' => 'Parent Client:',
        'not_found' => 'No clients found.',
        'not_found_in_trash' => 'No clients found in trash.',
        'archives' => 'Client Archives',
        'insert_into_item' => 'Insert into client',
        'uploaded_to_this_item' => 'Uploaded to this client',
        'filter_items_list' => 'Filter clients list',
        'items_list_navigation' => 'Clients list navigation',
        'items_list' => 'Clients list',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'clients'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
    );

    register_post_type('clients', $args);
}
add_action('init', 'registrar_cpt_clients');

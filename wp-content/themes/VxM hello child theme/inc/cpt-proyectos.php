<?php

// CPT "proyectos" (para portafolio)
function registrar_cpt_proyectos()
{
    $args = array(
        'public' => true,
        'label' => 'Proyectos',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'gallery'),
        'rewrite' => array('slug' => 'proyectos'),
        'has_archive' => true,
    );
    register_post_type('proyectos', $args);
}
add_action('init', 'registrar_cpt_proyectos');

//----- custom images for proyects

/* 1. Register the Meta Box */
function proyectos_gallery_meta_box()
{
    add_meta_box(
        'proyectos_gallery',
        'Galería del Proyecto',
        'proyectos_gallery_callback',
        'proyectos', // Ensure this matches your CPT slug exactly
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'proyectos_gallery_meta_box');

/* 2. Display the Meta Box (HTML) */
function proyectos_gallery_callback($post)
{
    wp_nonce_field('proyectos_gallery_save', 'proyectos_gallery_nonce');

    // Get the saved meta. If it's an array (new save), use it. 
    // If it's a string (legacy), explode it.
    $gallery_data = get_post_meta($post->ID, '_proyectos_gallery', true);

    $gallery_ids = [];
    if (is_array($gallery_data)) {
        $gallery_ids = $gallery_data;
    } elseif (! empty($gallery_data)) {
        $gallery_ids = explode(',', $gallery_data);
    }

?>
    <div id="proyectos_gallery_wrapper">
        <!-- Hidden input stores the IDs: "12,45,88" -->
        <input type="hidden"
            id="proyectos_gallery_input"
            name="proyectos_gallery"
            value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>" />

        <!-- Button to open media manager -->
        <p style="margin-bottom:15px;">
            <button type="button" class="button button-secondary proyectos-gallery-add">
                Manage Gallery Images
            </button>
        </p>

        <!-- Preview Container -->
        <div id="proyectos_gallery_preview" style="display:flex; flex-wrap:wrap; gap:10px;">
            <?php
            if (! empty($gallery_ids)) {
                foreach ($gallery_ids as $image_id) {
                    $img = wp_get_attachment_image_src($image_id, 'thumbnail');
                    if ($img) {
                        echo '<div class="gallery-item" style="width:80px; height:80px; background:#eee; border:1px solid #ccc;">';
                        echo '<img src="' . esc_url($img[0]) . '" style="width:100%; height:100%; object-fit:cover;" />';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
    </div>
<?php
}

/* 3. Save the Data (Crucial Step) */
function proyectos_gallery_save($post_id)
{
    // Security checks
    if (
        ! isset($_POST['proyectos_gallery_nonce']) ||
        ! wp_verify_nonce($_POST['proyectos_gallery_nonce'], 'proyectos_gallery_save')
    ) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (! current_user_can('edit_post', $post_id)) return;

    // Check if our input exists in $_POST
    if (isset($_POST['proyectos_gallery'])) {
        $raw_ids = $_POST['proyectos_gallery'];

        // Convert "12,44,12" string into an array of integers
        $ids_array = array_filter(array_map('intval', explode(',', $raw_ids)));

        // Save as an array (WordPress serializes it automatically)
        update_post_meta($post_id, '_proyectos_gallery', $ids_array);
    } else {
        // If field is missing (e.g. cleared), delete the meta
        delete_post_meta($post_id, '_proyectos_gallery');
    }
}
add_action('save_post', 'proyectos_gallery_save');

<?php
// Extract client data from args, with fallback to defaults
$logo_image_url = isset($args['logo_image_url']) ? $args['logo_image_url'] : esc_url(get_stylesheet_directory_uri() . '/assets/clientes/clientes-satisfechos.jpg');
$client_name = isset($args['client_name']) ? $args['client_name'] : 'Client Logo';
?>
<figure class="card-image bg-gray-300 p-2 min-h-24 min-w-24 w-fit">
    <picture><img src="<?php echo esc_url($logo_image_url); ?>" alt="<?php echo esc_attr($client_name); ?>"></picture>
</figure>

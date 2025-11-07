<?php
// Extract testimony data from args, with fallback to defaults
$author_name = isset($args['author_name']) ? $args['author_name'] : 'John Doe';
$author_position = isset($args['author_position']) ? $args['author_position'] : 'CEO, Company Name';
$quote_text = isset($args['quote_text']) ? $args['quote_text'] : '"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."';
?>
<div class="card-testimonio rounded-lg p-4 lg:w-10/12" style="background: linear-gradient(96deg, #FFF 27.35%, #EAEAEA 100%)">
    <div class="card-testimonio__author-info flex flex-col lg:flex-row gap-2">
        <h4 class="card-testimonio__author-name !text-yellow-vxm"><?php echo esc_html($author_name); ?></h4>
        <p class="card-testimonio__author-position !mt-auto"><?php echo esc_html($author_position); ?></p>
    </div>
    <p class="card-testimonio__text"><?php echo wp_kses_post($quote_text); ?></p>
</div>

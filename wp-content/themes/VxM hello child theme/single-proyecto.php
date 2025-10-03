<?php get_header(); ?>

<main id="main">
  <?php while ( have_posts() ) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <div class="meta">
      <span>Categoría: <?php the_terms( get_the_ID(), 'categoria_proyecto' ); ?></span>
      <span>Etiquetas: <?php the_terms( get_the_ID(), 'etiqueta_proyecto' ); ?></span>
    </div>
    <div class="content">
      <?php the_content(); ?>
    </div>
    <?php if ( function_exists('get_field') ): ?>
      <p><strong>Cliente:</strong> <?php echo esc_html( get_field('cliente') ); ?></p>
      <p><strong>Fecha de inicio:</strong> <?php echo esc_html( get_field('fecha_de_inicio') ); ?></p>
      <p><strong>Enlace:</strong> <a href="<?php echo esc_url( get_field('url_del_proyecto') ); ?>">Visitar</a></p>
    <?php endif; ?>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>

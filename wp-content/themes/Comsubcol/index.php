<?php get_header(); ?>
	<?php
	if ( is_home() ) {
		get_template_part( 'part', 'slider' );
	} else {
	?>
	<div id="page-heading" class="categorias">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1>CATEGORÍAS</h1>
					<span>CON LOS MEJORES PRECIOS</span>
				</div>
			</div>
		</div>
	</div>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php endwhile; endif; ?>
	<?php } ?>
<?php get_footer(); ?>
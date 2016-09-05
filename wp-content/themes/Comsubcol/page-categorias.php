<?php

/*

Template Name: Categorias

*/

?>
<?php get_header(); ?>
	<div id="page-heading" class="categorias">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center black">
					<h1>CATEGORÍAS</h1>
					<span>CON LOS MEJORES PRECIOS</span>
				</div>
			</div>
		</div>
	</div>
	<?php get_template_part( 'part', 'categorias-menu' ); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
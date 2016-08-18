<?php

/*

Template Name: Quienes Somos

*/

?>
<?php get_header(); ?>
	<div id="page-heading" class="quienes-somos">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1>ARTÍCULOS DE CALIDAD</h1>
					<span>CON LOS MEJORES PRECIOS</span>
				</div>
			</div>
		</div>
	</div>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<section class="meet-team">
		<div class="container">
			<?php the_content(); ?>
		</div>
	</section>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
<?php get_header(); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div id="page-heading" class="general">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center black">
					<h1 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
					<span>CON LOS MEJORES PRECIOS</span>
				</div>
			</div>
		</div>
	</div>
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
<?php get_footer(); ?>
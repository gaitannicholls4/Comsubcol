<?php get_header(); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php
	$post_id = get_the_ID();
	$post = get_post( $post_id );
	$slug = $post->post_name;
	switch ( $slug ) {
		default: $sfx = 'general'; break;
		case 'por-que-preferirnos': $sfx = 'por-que-preferirnos'; break;
		case 'servicios': $sfx = 'servicios'; break;
	}
	?>
	<div id="page-heading" class="<?php echo $sfx; ?>">
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
	<?php
	if ( $slug == 'servicios' ) {
		get_template_part( 'part', 'servicios-gallery' );
	}
	?>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
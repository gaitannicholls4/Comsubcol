<?php

/*

Template Name: Login

*/

?>
<?php get_header( 'login' ); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>
<?php get_footer( 'login' ); ?>
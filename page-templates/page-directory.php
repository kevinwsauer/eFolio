<?php
/**
 * Template Name: Page with directory
 *
 * @package eFolio
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
            <?php $home = new WP_Query('pagename=directory'); ?>
	
			<?php while ( $home->have_posts() ) : $home->the_post(); ?>
	
				<?php get_template_part( 'content', 'page-directory' ); ?>
	
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary --> 
<?php get_footer(); ?>

<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package eFolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if( is_front_page() && !is_paged()) { // Custom template for the front page ?>
        <header class="entry-header">
                <h1 class="front-page-entry-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <h1 class="front-page-entry-description"><?php bloginfo( 'description' ); ?></h1>
        </header><!-- .entry-header -->
		  
	<?php } else { ?>
		<header class="entry-header">
        	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="back">Back to Home</a>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </header><!-- .entry-header -->
	<?php } ?>
   	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'efolio' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
    <?php if( !is_front_page()) : 
		edit_post_link( __( 'Edit', 'efolio' ), '<span class="edit-link">', '</span>' ); 
	endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

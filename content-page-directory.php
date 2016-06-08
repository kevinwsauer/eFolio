<?php
/**
 * The template used for displaying directory content in page.php
 *
 * @package eFolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
            <h1 class="front-page-entry-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <h1 class="front-page-entry-description"><?php bloginfo( 'description' ); ?></h1>
    </header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
        <div id="loading">
            <h1 class="entry-title">Loading....</h1>
            <p>Please wait while the Teaching Portfolios directory is loaded.</p>
        </div>
        <div id="directory"></div>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
    
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
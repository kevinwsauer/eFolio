<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package eFolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="index-box">
        <header class="entry-header">
            <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
    
            <?php if ( 'post' == get_post_type() ) : ?>
            <div class="entry-meta">
                <?php efolio_posted_on(); ?>
            </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->
    
        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    
       <footer class="entry-footer continue-reading">
			<?php echo '<a href="' . get_permalink() . '" title="' . __('Continue Reading ', 'efolio') . get_the_title() . '" rel="bookmark">Continue Reading<i class="fa fa-arrow-circle-o-right"></i></a>'; ?>
       </footer><!-- .entry-footer -->
    </div><!-- .index-box -->
</article><!-- #post-## -->

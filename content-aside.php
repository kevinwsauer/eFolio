<?php
/**
 * @package eFolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="index-box">
		<div class="aside">
            <div class="entry-content">
                <?php the_content(); ?>
            </div><!-- .entry-content -->
            <footer class="entry-footer">
				<?php efolio_posted_on(); ?>
                <?php edit_post_link( __( ' | Edit', 'efolio' ), '<span class="edit-link">', '</span>' ); ?>
            </footer><!-- .entry-footer -->
    	</div><!-- .aside -->
	</div><!-- .index-box -->
</article><!-- #post-## -->
                

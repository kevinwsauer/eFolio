<?php
/**
 * @package eFolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="index-box">	
        <header class="entry-header">
			<?php
				// Display a thumb tack in the top right hand corner if this post is sticky
				if (is_sticky()) {
					echo '<i class="fa fa-thumb-tack sticky-post"></i>';
				}
            ?>
            <?php
				/* translators: used between list items, there is a space after the comma */
				$category_list = get_the_category_list( __( ' ', 'efolio' ) );
			
				if ( efolio_categorized_blog() ) {
					echo '<div class="category-list">' . $category_list . '</div>';
				}
        	?>
            <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
            <?php echo get_the_tag_list( '<ul><li><i class="fa fa-tag"></i>', '</li><li><i class="fa fa-tag"></i>', '</li></ul>' ); ?>
			<?php if ( 'post' == get_post_type() ) : ?>
            <div class="entry-meta">
                <?php efolio_posted_on(); ?>
                <?php 
                if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) { 
                    echo '<span class="comments-link">';
                    comments_popup_link( __( 'Leave a comment', 'efolio' ), __( '1 Comment', 'efolio' ), __( '% Comments', 'efolio' ) );
                    echo '</span>';
                }
            	?>
                <?php echo edit_post_link( __( 'Edit', 'efolio' ), '<span class="edit-link">', '</span>' ); ?>
            </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->
			<?php 
            if( $wp_query->current_post == 0 && !is_paged() && is_home() ) { 
                echo '<div class="entry-content">';
                the_content( __( '', 'efolio' ) );
                echo '</div>';
                echo '<footer class="entry-footer continue-reading">';
                echo '<a href="' . get_permalink() . '" title="' . __('Read ', 'efolio') . get_the_title() . '" rel="bookmark">Read the article<i class="fa fa-arrow-circle-o-right"></i></a>'; 
                echo '</footer><!-- .entry-footer -->';
            } else { ?>
                <div class="entry-content">
                <?php the_content(); ?>
                </div><!-- .entry-content -->
                <footer class="entry-footer continue-reading">
               
                </footer><!-- .entry-footer -->
            <?php } ?>
    </div><!-- .index-box -->
</article><!-- #post-## -->

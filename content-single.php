<?php
/**
 * @package eFolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="page-header">
    	<?php
			if (in_category('benchmark-1') ) :
				echo '<h1 class="page-title">Benchmark 1: Establishes expectations</h1>';
			endif;
			if (in_category('benchmark-2') ) :
				echo '<h1 class="page-title">Benchmark 2: Arranges space for safety and effective learning.</h1>';
			endif;
			if (in_category('benchmark-3') ) :
				echo '<h1 class="page-title">Benchmark 3: Establishes small and large group procedures, routines, and manages transitions.</h1>';
			endif;
			if (in_category('benchmark-4') ) :
				echo '<h1 class="page-title">Benchmark 4: Prepares and manages materials and technology for effective learning.</h1>';
			endif;
			if (in_category('benchmark-5') ) :
				echo '<h1 class="page-title">Benchmark 5: Keeps progress records in order to match and adapt curriculum to student.</h1>';
			endif;
			if (in_category('benchmark-6') ) :
				echo '<h1 class="page-title">Benchmark 6: Uses reinforcement and correction to increase learning and show respect.</h1>';
			endif;
			if (in_category('benchmark-7') ) :
				echo '<h1 class="page-title">Benchmark 7: Paces lessons and activities to engage students.</h1>';
			endif;
			if (in_category('benchmark-8') ) :
				echo '<h1 class="page-title">Benchmark 8: Assessment method matches knowledge (curriculum) and student characteristics.</h1>';
			endif;
			if (in_category('benchmark-9') ) :
				echo '<h1 class="page-title">Benchmark 9: Formative assessment provides information regarding student(s) achievement level.</h1>';
			endif;
			if (in_category('benchmark-10') ) :
				echo '<h1 class="page-title">Benchmark 10: Assessment information is communicated to students, parents, and other professionals.</h1>';
			endif;
			if (in_category('benchmark-11') ) :
				echo '<h1 class="page-title">Benchmark 11: Focuses students attention on the information.</h1>';
			endif;
			if (in_category('benchmark-12') ) :
				echo '<h1 class="page-title">Benchmark 12: Organizes the knowledge when planning instruction.</h1>';
			endif;
			if (in_category('benchmark-13') ) :
				echo '<h1 class="page-title">Benchmark 13: Presents information for instruction that is related to assessment.</h1>';
			endif;
			if (in_category('benchmark-14') ) :
				echo '<h1 class="page-title">Benchmark 14: Guides students application of knowledge.</h1>';
			endif;
			if (in_category('benchmark-15') ) :
				echo '<h1 class="page-title">Benchmark 15: Provides opportunities for student to use information independently.</h1>';
			endif;
			if (in_category('benchmark-16') ) :
				echo '<h1 class="page-title">Benchmark 16: Participates in professional development.</h1>';
			endif;
			if (in_category('benchmark-17') ) :
				echo '<h1 class="page-title">Benchmark 17: Is proficient in communication with students, parents, and other professionals.</h1>';
			endif;
			if (in_category('benchmark-18') ) :
				echo '<h1 class="page-title">Benchmark 18: Collaborates with parents and other caregivers.</h1>';
			endif;
		?>
    </header>
 	<header class="entry-header">
    	<?php
            /* translators: used between list items, there is a space after the comma */
            $category_list = get_the_category_list( __( ', ', 'efolio' ) );
        
            if ( efolio_categorized_blog() ) {
                echo '<div class="category-list">' . $category_list . '</div>';
            }
        ?> 
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?> 
        <?php echo get_the_tag_list( '<ul><li><i class="fa fa-tag"></i>', '</li><li><i class="fa fa-tag"></i>', '</li></ul>' ); ?>     
		<div class="entry-meta">
			<?php efolio_posted_on(); ?>
			<?php 
                if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) { 
                    echo '<span class="comments-link">';
                    comments_popup_link( __( 'Leave a comment', 'efolio' ), __( '1 Comment', 'efolio' ), __( '% Comments', 'efolio' ) );
                    echo '</span>';
                }
            ?>   
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

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
        <?php echo edit_post_link( __( 'Edit', 'efolio' ), '<span class="edit-link">', '</span>' ); ?> 
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
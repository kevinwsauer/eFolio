<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package eFolio
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">     
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'efolio' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'efolio' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'efolio' ), 'eFolio', '<a href="http://www.baylor.edu/soe/" rel="designer">Kevin Sauer, Baylor University School of Education</a>' ); ?>
            <?php 
				echo '<br />';
				echo 'Copyright &copy; <a href="http://www.baylor.edu/">Baylor&reg; University</a>. All rights reserved. <a href="http://www.baylor.edu/about/index.php?id=90104">Legal Disclosures</a>.';
				echo '<br />';
				echo 'Baylor University • Waco, Texas • 76798 • 1-800-229-5678';
			?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

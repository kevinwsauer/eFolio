<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package eFolio
 */
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php  
		// Search Widget
		the_widget( 'WP_Widget_Search');
		
		// Main Menu Widget
		 $defaults = array(
			'theme_location'  => 'main',
			'menu'            => 'Main Menu',
			'container'       => 'false',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => false,
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		);
		echo '<aside class="widget widget_nav_menu">';
		echo '<h1 class="widget-title">' . __( 'Main Menu' ) . '</h1>';
		wp_nav_menu( $defaults );
		echo '</aside>';
		
		// Benchmark Menu Widget
		 $defaults = array(
			'theme_location'  => 'benchmark',
			'menu'            => 'Benchmark Menu',
			'container'       => 'false',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => false,
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		);
		echo '<aside class="widget widget_nav_menu">';
		echo '<h1 class="widget-title">' . __( 'Benchmark Menu' ) . '</h1>';
		wp_nav_menu( $defaults );
		echo '</aside>';
		
		// Categories Widget
		$categories_instance = array(
			'title' => __( 'Categories' ),
			'count' => 1,
			'hierarchical' => 1,
			'dropdown' => 1
		);
		$categories_args = array(
			'before_widget' => '<aside class="widget widget_categories">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>'
		);
		the_widget( 'WP_Widget_Categories', $categories_instance, $categories_args );
		
		// Tag Widget
		$tag_instance = array(
			'title' => __( 'Tags' ),
			'taxonomy' => 'post_tag'
		);
		$tag_args = array(
			'before_widget' => '<aside class="widget widget_tag_cloud">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>'
		);
		the_widget( 'WP_Widget_Tag_Cloud', $tag_instance, $tag_args ); 
		
		// Archives Widget
		$archives_instance = array(
			'title' => __( 'Archives' ),
			'count' => 1,
			'dropdown' => 1
		);
		$archives_args = array(
			'before_widget' => '<aside class="widget widget_archive">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>'
		);
		the_widget( 'WP_Widget_Archives', $archives_instance, $archives_args ); 
		
		// Meta Widget
		$meta_instance = array(
			'title' => __( 'Admin' )
		);
		$meta_args = array(
			'before_widget' => '<aside class="widget widget_meta">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>'
		);
		the_widget( 'WP_Widget_Meta', $meta_instance, $meta_args );
		
	?> 
</div><!-- #secondary -->

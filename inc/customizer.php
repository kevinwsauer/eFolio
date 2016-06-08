<?php
/**
 * eFolio Theme Customizer
 *
 * @package eFolio
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function efolio_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
}
add_action( 'customize_register', 'efolio_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function efolio_customize_preview_js() {
	wp_enqueue_script( 'efolio_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'efolio_customize_preview_js' );

/**
 * Add custom heading background color and site-wide link color
 */

function efolio_register_theme_customizer( $wp_customize ) {

    $wp_customize->add_setting(
        'efolio_header_footer_color',
        array(
            'default'     => '#183800'
		)
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'efolio_header_footer_color',
            array(
                'label'      => __( 'Header/Footer Color', 'efolio' ),
                'section'    => 'colors',
                'settings'   => 'efolio_header_footer_color'
            )
        )
    );
	
	$wp_customize->add_setting(
        'efolio_header_footer_text_color',
        array(
            'default'     => '#ffffff'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'efolio_header_footer_text_color',
            array(
                'label'      => __( 'Header/Footer Text Color', 'efolio' ),
                'section'    => 'colors',
                'settings'   => 'efolio_header_footer_text_color'
            )
        )
    );
	
	$wp_customize->add_setting(
        'efolio_background_color',
        array(
            'default'     => '#313131'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'efolio_background_color',
            array(
                'label'      => __( 'Background Color', 'efolio' ),
                'section'    => 'colors',
                'settings'   => 'efolio_background_color'
            )
        )
    );

    $wp_customize->add_setting(
        'efolio_link_color',
        array(
            'default'     => '#000000'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'efolio_link_color',
            array(
                'label'      => __( 'Link Color', 'efolio' ),
                'section'    => 'colors',
                'settings'   => 'efolio_link_color'
            )
        )
    );

}
add_action( 'customize_register', 'efolio_register_theme_customizer' );

function efolio_customizer_css() {
    ?>
    <style type="text/css">
		body {
			background: <?php echo get_theme_mod( 'efolio_background_color' ); ?>;
		}
		
        .site-branding,
		.site-footer {
            background: <?php echo get_theme_mod( 'efolio_header_footer_color' ); ?>;
        }
		
		.site-title a,
		.site-description,
		.site-footer,
		.site-footer a { 
			color: <?php echo get_theme_mod( 'efolio_header_footer_text_color' ); ?>;
		}

        .category-list a:hover,
        .entry-meta a:hover,
        .tag-links a:hover,
        .widget-area a:hover,
        .nav-links a:hover,
        .comment-meta a:hover,
        .continue-reading a,
        .entry-title a:hover,
        .entry-content a,
        .comment-content a {
            color: <?php echo get_theme_mod( 'efolio_link_color' ); ?>;
        }

        .border-custom {
            border: <?php echo get_theme_mod( 'efolio_link_color' ); ?> solid 1px;
        }

    </style>
    <?php
}
add_action( 'wp_head', 'efolio_customizer_css' );

<?php
/* Adds Customizer options for Stately
 */

class STATELY_Customizer extends EQUITY_Customizer_Base {

	/**
	 * Register theme specific customization options
	 */
	public function register( $wp_customize ) {

		$this->header( $wp_customize );
		$this->colors( $wp_customize );
		$this->home( $wp_customize );
		$this->misc( $wp_customize );
	}

	private function header( $wp_customize ) {

		global $wp_version;

		//* Setting key and default value array
		$settings = array(
			'site_title_font_size'    => 2.22222222,
			'nav_menu_font_size'  => 1,
			'nav_menu_padding'    => 0,
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod',
				)
			);

		}

		//* Site Title font size
		$wp_customize->add_control(
			'site_title_font_size',
			array(
				'label'      => __( 'Site Title Font Size', 'stately' ),
				'section'    => 'title_tagline',
				'settings'   => 'site_title_font_size',
				'priority'   => 100,
				'type'       => 'range',
				'input_attrs' => array(
					'min' => 0.5,
					'max' => 2.75,
					'step' => 0.001,
				),
				'active_callback' => array( $this, 'is_site_title_text' ),
			)
		);

		//* Main Menu font size
		$wp_customize->add_control(
			'nav_menu_font_size',
			array(
				'label'      => __( 'Main Menu Font Size', 'stately' ),
				'section'    => 'title_tagline',
				'settings'   => 'nav_menu_font_size',
				'priority'   => 200,
				'type'       => 'range',
				'input_attrs' => array(
					'min' => 0.5,
					'max' => 1.5,
					'step' => 0.001,
				),
			)
		);

		//* Main Menu padding
		$wp_customize->add_control(
			'nav_menu_padding',
			array(
				'label'      => __( 'Main Menu Item Padding', 'stately' ),
				'section'    => 'title_tagline',
				'settings'   => 'nav_menu_padding',
				'priority'   => 300,
				'type'       => 'range',
				'input_attrs' => array(
					'min' => -10,
					'max' => 10,
					'step' => 1,
				),
			)
		);
	}

	//* Colors
	private function colors( $wp_customize ) {
		$wp_customize->add_section(
			'colors',
			array(
				'title'    => __( 'Custom Colors', 'stately' ),
				'priority' => 200,
			)
		);

		//* Setting key and default value array
		$settings = array(
			'primary_color'       => '#3561b6',
			'secondary_color'     => '#ced82a',
			'primary_tone'        => false,
			'content_bkg'   => true,
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod',
				)
			);
		}

		//* Primary Color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'primary_color',
				array(
					'label'       => __( 'Primary Color', 'stately' ),
					'description' => __( 'Used for links, buttons, headings.', 'stately' ),
					'section'     => 'colors',
					'settings'    => 'primary_color',
					'priority'    => 100,
				)
			)
		);

		//* Secondary Color
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'secondary_color',
				array(
					'label'       => __( 'Secondary Color', 'stately' ),
					'description' => __( 'Used for accents.', 'stately' ),
					'section'     => 'colors',
					'settings'    => 'secondary_color',
					'priority'    => 100,
				)
			)
		);

		//* Toggle light/dark tone
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'primary_tone',
				array(
					'label'       => __( 'Use a light color scheme?', 'stately' ),
					'section'     => 'colors',
					'settings'    => 'primary_tone',
					'type'        => 'checkbox',
					'priority'    => 200,
				)
			)
		);

		//* Toggle light/dark content background
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'content_bkg',
				array(
					'label'       => __( 'Use a white background on the content area?', 'stately' ),
					'section'     => 'colors',
					'settings'    => 'content_bkg',
					'type'        => 'checkbox',
					'priority'    => 300,
				)
			)
		);

	}

	//* Home Page
	private function home( $wp_customize ) {
		$wp_customize->add_section(
			'home',
			array(
				'title'    => __( 'Home Page', 'stately' ),
				'priority' => 201,
			)
		);

		//* Setting key and default value array
		$settings = array(
			'home_widget_areas'                        => 6,
			'default_background_image'                 => get_stylesheet_directory_uri() . '/images/bkg-default.jpg',
			'home_top_background_overlay'              => '#201f1f',
			'home_top_background_overlay_opacity'      => 0.01,
			'home_middle_3_background'                 => get_stylesheet_directory_uri() . '/images/home-middle-3-default.jpg',
			'home_middle_3_background_overlay'         => '#201f1f',
			'home_middle_3_background_overlay_opacity' => 0.8,
			'home_middle_6_background'                 => get_stylesheet_directory_uri() . '/images/home-middle-6-default.jpg',
			'home_middle_6_background_overlay'         => '#201f1f',
			'home_middle_6_background_overlay_opacity' => 0.6,
			'home_fadeup_effect'                       => true,
			'home_match_height_for_carousel'           => true,
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod',
				)
			);
		}

		//* Number of home widget areas.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_widget_areas',
				array(
					'label'       => __( 'Number of home page widget areas.', 'stately' ),
					'description' => __( 'Enter the number of widget areas for the home page middle.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_widget_areas',
					'type'        => 'number',
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 12,
						'step' => 1,
					),
					'priority'    => 100,
				)
			)
		);

		//* Home Top image (and default background)
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'default_background_image',
				array(
					'label'       => __( 'Top Background Image', 'stately' ),
					'description' => __( 'Upload an image to use for the "Home Top" widget area background. This image will also be used as the default background on interior pages.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'default_background_image',
					'extensions'  => array( 'jpg' ),
					'priority'    => 200,
				)
			)
		);

		//* Home Top background overlay
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'home_top_background_overlay',
				array(
					'label'       => __( 'Top background overlay color', 'stately' ),
					'description' => __( 'Adjust the color overlay on home top widget area.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_top_background_overlay',
					'priority'    => 201,
				)
			)
		);

		//* Home Top background opacity
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_top_background_overlay_opacity',
				array(
					'label'       => __( 'Top background overlay color opacity.', 'stately' ),
					'description' => __( 'Adjust the overlay opacity of the home top widget area background.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_top_background_overlay_opacity',
					'type'        => 'range',
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 1,
						'step'  => 0.01,
					),
					'priority'    => 202,
				)
			)
		);

		//* Home Middle 3 background
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'home_middle_3_background',
				array(
					'label'       => __( 'Middle 3 Background Image', 'stately' ),
					'description' => __( 'Upload an image to use for the "Home Middle 3" widget area background.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_middle_3_background',
					'extensions'  => array( 'jpg' ),
					'priority'    => 300,
					'active_callback' => array( $this, 'is_home_middle_3_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 3 background overlay
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'home_middle_3_background_overlay',
				array(
					'label'       => __( 'Middle 3 background overlay color', 'stately' ),
					'description' => __( 'Adjust the color overlay on home middle 3 widget area.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_middle_3_background_overlay',
					'priority'    => 301,
					'active_callback' => array( $this, 'is_home_middle_3_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 3 background opacity
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_middle_3_background_overlay_opacity',
				array(
					'label'       => __( 'Middle 3 background overlay color opacity.', 'stately' ),
					'description' => __( 'Adjust the overlay opacity of the home middle 3 widget area backgrounds.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_middle_3_background_overlay_opacity',
					'type'        => 'range',
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 1,
						'step'  => 0.01,
					),
					'priority'    => 302,
					'active_callback' => array( $this, 'is_home_middle_3_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 6 background
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'home_middle_6_background',
				array(
					'label'       => __( 'Middle 6 Background Image', 'stately' ),
					'description' => __( 'Upload an image to use for the "Home Middle 6" widget area background.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_middle_6_background',
					'extensions'  => array( 'jpg' ),
					'priority'    => 400,
					'active_callback' => array( $this, 'is_home_middle_6_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 6 background overlay
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'home_middle_6_background_overlay',
				array(
					'label'       => __( 'Middle 6 background overlay color', 'stately' ),
					'description' => __( 'Adjust the color overlay on home middle 6 widget area.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_middle_6_background_overlay',
					'priority'    => 401,
					'active_callback' => array( $this, 'is_home_middle_6_widget_area_enabled' ),
				)
			)
		);

		//* Home Middle 6 background opacity
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_middle_6_background_overlay_opacity',
				array(
					'label'       => __( 'Middle 6 background overlay color opacity.', 'stately' ),
					'description' => __( 'Adjust the overlay opacity of the home middle 6 widget area backgrounds.', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_middle_6_background_overlay_opacity',
					'type'        => 'range',
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 1,
						'step'  => 0.01,
					),
					'priority'    => 402,
					'active_callback' => array( $this, 'is_home_middle_6_widget_area_enabled' ),
				)
			)
		);

		//* Toggle homepage fadeup effect
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_fadeup_effect',
				array(
					'label'       => __( 'Use fadeup effect on homepage?', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_fadeup_effect',
					'type'        => 'checkbox',
					'priority'    => 500,
				)
			)
		);

		//* Toggle match height on home page carousel
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'home_match_height_for_carousel',
				array(
					'label'       => __( 'Use match height on homepage carousel?', 'stately' ),
					'section'     => 'home',
					'settings'    => 'home_match_height_for_carousel',
					'type'        => 'checkbox',
					'priority'    => 600,
				)
			)
		);
	}

	//* Misc
	private function misc( $wp_customize ) {

		//* Setting key and default value array
		$settings = array(
			'enable_sticky_header'   => true,
			'show_site_description'  => false,
		);

		foreach ( $settings as $setting => $default ) {

			$wp_customize->add_setting(
				$setting,
				array(
					'default' => $default,
					'type'    => 'theme_mod',
				)
			);
		}

		//* Enable header description
		$wp_customize->add_control(
			'disable_site_description',
			array(
				'label'    => __( 'Show Site Description?', 'stately' ),
				'section'  => 'title_tagline',
				'type'     => 'checkbox',
				'settings' => 'show_site_description',
				'priority' => 300,
			)
		);

		//* Enable sticky header checkbox
		$wp_customize->add_control(
			'enable_sticky_header',
			array(
				'label'    => __( 'Enable Sticky Header?', 'stately' ),
				'section'  => 'title_tagline',
				'type'     => 'checkbox',
				'settings' => 'enable_sticky_header',
				'priority' => 300,
			)
		);
	}

	//* Render CSS
	public function render() {
		?>
		<!-- begin Child Customizer CSS -->
		<style type="text/css">
			<?php

			if ( get_theme_mod( 'primary_tone' ) ) {
				$light = true;
			}

			//* Site description
			if ( get_theme_mod( 'show_site_description' ) ) {
				echo 'header.site-header .site-description {display: block;}';
			}

			//* Background images
			echo '.home-top {background-image: url(\'' . get_theme_mod( 'default_background_image', get_stylesheet_directory_uri() . '/images/bkg-default.jpg' ) . '\');}';
			//* Background overlay
			if ( isset( $light ) ) {
				echo 'body.stately-light';
			}

			echo '.home .content-sidebar-wrap.row .home-top > .overlay {background-color: ' . self::hex2rgba( get_theme_mod( 'home_top_background_overlay', '201f1f' ), get_theme_mod( 'home_top_background_overlay_opacity', 0.1 ) ) . '}';

			if ( get_theme_mod( 'home_widget_areas', 6 ) > 2 ) {
				echo '.home-middle-3 {background-image: url(\'' . get_theme_mod( 'home_middle_3_background', get_stylesheet_directory_uri() . '/images/home-middle-3-default.jpg' ) . '\');}';
				//* Background overlay
				if ( isset( $light ) ) {
					echo 'body.stately-light';
				}
				echo '.home .content-sidebar-wrap.row div.home-middle-3.bg-image > .overlay {background-color: ' . self::hex2rgba( get_theme_mod( 'home_middle_3_background_overlay', '201f1f' ), get_theme_mod( 'home_middle_3_background_overlay_opacity', 0.8 ) ) . '}';
			}
			if ( get_theme_mod( 'home_widget_areas', 6 ) > 5 ) {
				echo '.home-middle-6 {background-image: url(\'' . get_theme_mod( 'home_middle_6_background', get_stylesheet_directory_uri() . '/images/home-middle-6-default.jpg' ) . '\');}';
				//* Background overlay
				if ( isset( $light ) ) {
					echo 'body.stately-light';
				}
				echo '.home .content-sidebar-wrap.row div.home-middle-6.bg-image > .overlay {background-color: ' . self::hex2rgba( get_theme_mod( 'home_middle_6_background_overlay', '201f1f' ), get_theme_mod( 'home_middle_6_background_overlay_opacity', 0.6 ) ) . '}';
			}

			if ( get_theme_mod( 'primary_tone' ) ) {
				//* Primary color - link color
				self::generate_css( '
					body.stately-light a,
					body.stately-light #IDX-main.IDX-wrapper-standard a,
					body.stately-light header .site-title a:focus,
					body.stately-light .ae-iconbox i[class*="fa-"],
					body.stately-light .ae-iconbox a i[class*="fa-"],
					body.stately-light .ae-iconbox.type-3:hover i[class*="fa-"],
					body.stately-light .ae-iconbox.type-3:hover a i[class*="fa-"],
					body.stately-light .ae-iconbox.type-2:hover i[class*="fa-"],
					body.stately-light .ae-iconbox.type-2:hover a i[class*="fa-"]
					', 'color', 'primary_color'
				);
			} else {
				//* Primary color - link color
				self::generate_css( '
					a,
					#IDX-main.IDX-wrapper-standard a,
					header .site-title a:focus,
					.ae-iconbox i[class*="fa-"],
					.ae-iconbox a i[class*="fa-"],
					.ae-iconbox.type-3:hover i[class*="fa-"],
					.ae-iconbox.type-3:hover a i[class*="fa-"],
					.ae-iconbox.type-2:hover i[class*="fa-"],
					.ae-iconbox.type-2:hover a i[class*="fa-"]
					', 'color', 'primary_color'
				);
			}

			//* Primary color - backgrounds
			if ( get_theme_mod( 'primary_tone' ) ) {
				self::generate_css('
					body.stately-light .bg-primary,
					body.stately-light .button,
					body.stately-light button,
					body.stately-light input[type="button"],
					body.stately-light input[type="submit"],
					body.stately-light .widget .idx-omnibar-form button,
					body.stately-light a.off-canvas-toggle,
					body.stately-light .after-entry-widget-area,
					body.stately-light.home .content-sidebar-wrap.row div[class*=\'home-middle-\'].bg-primary,
					body.stately-light .widget .owl-carousel .owl-nav.owl-controls button.owl-prev,
					body.stately-light .widget .owl-carousel .owl-nav.owl-controls button.owl-next,
					body.stately-light .ae-iconbox.type-2 i,
					body.stately-light .ae-iconbox.type-3 i,
					body.stately-light ul.pagination li.current a,
					body.stately-light ul.pagination li.current button,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn:link,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn-default,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-navbar-default
					',
					'background-color', 'primary_color'
				);
			} else {
				self::generate_css('
					.bg-primary,
					.button,
					button,
					input[type="button"],
					input[type="submit"],
					.widget .idx-omnibar-form button,
					a.off-canvas-toggle,
					.after-entry-widget-area,
					.home .content-sidebar-wrap.row div[class*=\'home-middle-\'].bg-primary,
					.widget .owl-carousel .owl-nav.owl-controls button.owl-prev,
					.widget .owl-carousel .owl-nav.owl-controls button.owl-next,
					.ae-iconbox.type-2 i,
					.ae-iconbox.type-3 i,
					ul.pagination li.current a,
					ul.pagination li.current button,
					#IDX-main.IDX-wrapper-standard .IDX-btn,
					#IDX-main.IDX-wrapper-standard .IDX-btn:link,
					#IDX-main.IDX-wrapper-standard .IDX-btn-default,
					#IDX-main.IDX-wrapper-standard .IDX-navbar-default
					',
					'background-color', 'primary_color'
				);
			}

			//* Primary color - borders
			self::generate_css('
				.IDX-wrapper-standard .IDX-navbar-default,
				.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-collapse,
				.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-form,
				.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default,
				.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-collapse,
				.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-form
				',
				'border-color', 'primary_color'
			);

			//* Primary color hover
			$primary_hover = equity_color_brightness( get_theme_mod( 'primary_color', '#3561b6' ), '-', 14 );
			if ( get_theme_mod( 'primary_tone' ) ) {
				echo '
					body.stately-light a:hover,
					body.stately-light a:focus,
					body.stately-light #IDX-main.IDX-wrapper-standard a:hover,
					body.stately-light #IDX-main.IDX-wrapper-standard a:focus {
						color: ' . $primary_hover . ';
					}';

				//* Primary color hover - backgrounds
				echo '
					body.stately-light .button:hover,
					body.stately-light .button:focus,
					body.stately-light button:hover,
					body.stately-light button:focus,
					body.stately-light input[type="button"]:hover,
					body.stately-light input[type="button"]:focus,
					body.stately-light input[type="submit"]:hover,
					body.stately-light input[type="submit"]:focus,
					body.stately-light .widget .idx-omnibar-form button:hover,
					body.stately-light .widget .idx-omnibar-form button:focus,
					body.stately-light .bg-primary .button:hover,
					body.stately-light .bg-primary input[type="button"]:hover,
					body.stately-light .bg-primary input[type="submit"]:hover,
					body.stately-light .widget .owl-carousel .owl-nav.owl-controls .owl-prev:hover,
					body.stately-light .widget .owl-carousel .owl-nav.owl-controls .owl-next:hover,
					body.stately-light ul.pagination li.current a:hover,
					body.stately-light ul.pagination li.current a:focus,
					body.stately-light ul.pagination li.current button:hover,
					body.stately-light ul.pagination li.current button:focus,
					body.stately-light.home div[class*=\'home-middle-\'] .ae-iconbox.type-3:hover > .icon > i,
					body.stately-light.home div[class*=\'home-middle-\'] .ae-iconbox.type-3 a:active i,
					body.stately-light.home div[class*=\'home-middle-\'] .ae-iconbox.type-3 a:focus i,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn:hover,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn:link:hover,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn-default:hover,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn:focus,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn:link:focus,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-btn-default:focus,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>li>a:focus,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>li>a:hover,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a:hover,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a:focus,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a:focus,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a:focus,
					body.stately-light #IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a:hover {
						background-color: ' . $primary_hover . ';
					}';
			} else {
				echo '
					a:hover,
					a:focus,
					#IDX-main.IDX-wrapper-standard a:hover,
					#IDX-main.IDX-wrapper-standard a:focus {
						color: ' . $primary_hover . ';
					}';

				//* Primary color hover - backgrounds
				echo '
					.button:hover,
					.button:focus,
					button:hover,
					button:focus,
					input[type="button"]:hover,
					input[type="button"]:focus,
					input[type="submit"]:hover,
					input[type="submit"]:focus,
					.widget .idx-omnibar-form button:hover,
					.widget .idx-omnibar-form button:focus,
					.bg-primary .button:hover,
					.bg-primary input[type="button"]:hover,
					.bg-primary input[type="submit"]:hover,
					.widget .owl-carousel .owl-nav.owl-controls .owl-prev:hover,
					.widget .owl-carousel .owl-nav.owl-controls .owl-next:hover,
					ul.pagination li.current a:hover,
					ul.pagination li.current a:focus,
					ul.pagination li.current button:hover,
					ul.pagination li.current button:focus,
					.home div[class*=\'home-middle-\'] .ae-iconbox.type-3:hover > .icon > i,
					.home div[class*=\'home-middle-\'] .ae-iconbox.type-3 a:active i,
					.home div[class*=\'home-middle-\'] .ae-iconbox.type-3 a:focus i,
					#IDX-main.IDX-wrapper-standard .IDX-btn:hover,
					#IDX-main.IDX-wrapper-standard .IDX-btn:link:hover,
					#IDX-main.IDX-wrapper-standard .IDX-btn-default:hover,
					#IDX-main.IDX-wrapper-standard .IDX-btn:focus,
					#IDX-main.IDX-wrapper-standard .IDX-btn:link:focus,
					#IDX-main.IDX-wrapper-standard .IDX-btn-default:focus,
					#IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>li>a:focus,
					#IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>li>a:hover,
					#IDX-main.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a:hover,
					#IDX-main.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li > a:focus,
					#IDX-main.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a,
					#IDX-main.IDX-wrapper-standard .IDX-mobileFirst--neutral .IDX-navbar-default .IDX-navbar-nav > li.IDX-active > a:focus,
					#IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a,
					#IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a:focus,
					#IDX-main.IDX-wrapper-standard .IDX-navbar-default .IDX-navbar-nav>.IDX-active>a:hover {
						background-color: ' . $primary_hover . ';
					}';
			}

			//* Secondary color
			if ( get_theme_mod( 'primary_tone' ) ) {
				self::generate_css('
					body.stately-light footer.site-footer a,
					body.stately-light .bg-alt a,
					body.stately-light .widget article h2.entry-title a,
					body.stately-light.home .bg-alt a,
					body.stately-light.home .bg-primary a,
					body.stately-light.home .widget article h2.entry-title a,
					body.stately-light footer.site-footer .footer-widgets .widget a,
					body.stately-light .off-canvas .widget a,
					body.stately-light .owl-carousel .property-details span.price,
					body.stately-light .button.secondary,
					body.stately-light button.secondary,
					body.stately-light .bg-primary a,
					body.stately-light.home div[class*=\'home-middle-\'] .easy-t-cycle-controls span.cycle-pager-active
					',
					'color', 'secondary_color'
				);
			} else {
				self::generate_css('
					footer.site-footer a,
					.bg-alt a,
					.widget article h2.entry-title a,
					.home .bg-alt a,
					.home .bg-primary a,
					.home .widget article h2.entry-title a,
					footer.site-footer .footer-widgets .widget a,
					.off-canvas .widget a,
					.owl-carousel .property-details span.price,
					.button.secondary,
					button.secondary,
					.bg-primary a,
					.home div[class*=\'home-middle-\'] .easy-t-cycle-controls span.cycle-pager-active
					',
					'color', 'secondary_color'
				);
			}

			//* Secondary color - backgrounds
			self::generate_css('
				.home div[class*=\'home-middle-\'] .impress-city-links li .count,
				#IDX-main #IDX-leadToolsBar
				',
				'background-color', 'secondary_color'
			);

			//* Secondary color - hover
			$secondary_hover = equity_color_brightness( get_theme_mod( 'secondary_color', '#ced82a' ), '-', 14 );
			if ( get_theme_mod( 'primary_tone' ) ) {
				echo '
				body.stately-light footer a:hover,
				body.stately-light footer a:focus,
				body.stately-light .bg-alt a:hover,
				body.stately-light .bg-alt a:focus,
				body.stately-light.home .bg-alt a:hover,
				body.stately-light.home .bg-alt a:focus,
				body.stately-light.home .widget article h2.entry-title a:hover,
				body.stately-light.home .widget article h2.entry-title a:focus,
				body.stately-light footer.site-footer .footer-widgets .widget a:hover,
				body.stately-light footer.site-footer .footer-widgets .widget a:focus,
				body.stately-light .off-canvas .widget a:hover,
				body.stately-light .off-canvas .widget a:focus {
					color: ' . $secondary_hover . ';
				}';
			} else {
				echo '
					footer a:hover,
					footer a:focus,
					.bg-alt a:hover,
					.bg-alt a:focus,
					.home .bg-alt a:hover,
					.home .bg-alt a:focus,
					.home .widget article h2.entry-title a:hover,
					.home .widget article h2.entry-title a:focus,
					footer.site-footer .footer-widgets .widget a:hover,
					footer.site-footer .footer-widgets .widget a:focus,
					.off-canvas .widget a:hover,
					.off-canvas .widget a:focus {
						color: ' . $secondary_hover . ';
					}';
			}

			// Site title font size
			self::generate_css( 'header.site-header .site-title', 'font-size', 'site_title_font_size', '', 'rem' );
			echo 'body.sticky .sticky-header header.site-header .site-title { font-size: ' . get_theme_mod( 'site_title_font_size', 2.2222222 ) * 0.8 . 'rem; }';

			// Nav menu font size
			self::generate_css( '.nav-header-right a', 'font-size', 'nav_menu_font_size', '', 'rem' );

			// Nav menu padding
			$nav_padding = 20 + get_theme_mod( 'nav_menu_padding', 0 );
			echo '.nav-header-right a {
				padding-left: ' . $nav_padding . 'px;
				padding-right: ' . $nav_padding . 'px;
			}';
			$nav_arrow = 8 + ( get_theme_mod( 'nav_menu_padding', 0 ) / 2 );
			echo '.nav-header-right ul>li.menu-item-has-children>a:after {right: ' . $nav_arrow . 'px}';

			?>
		</style>
		<!-- end Child Customizer CSS -->
		<?php
	}

	public function is_site_title_text() {
		$setting = get_theme_mod( 'logo_display_type' );
		if ( 'text' === $setting ) {
			return true;
		}
		return false;
	}

	public function is_home_middle_3_widget_area_enabled() {
		$setting = get_theme_mod( 'home_widget_areas' );
		if ( $setting > 2 ) {
			return true;
		}
		return false;
	}

	public function is_home_middle_6_widget_area_enabled() {
		$setting = get_theme_mod( 'home_widget_areas' );
		if ( $setting > 5 ) {
			return true;
		}
		return false;
	}
}

add_action( 'init', 'stately_customizer_init' );
/**
 * Instantiate STATELY_Customizer
 *
 * @since 1.0
 */
function stately_customizer_init() {
	new STATELY_Customizer;
}

/**
 * Generate a lighter or darker color from a starting color.
 * Used to generate complementary hover tints from user-chosen colors.
 *
 * @param string $color A color in hex format.
 * @param string $op The operation to apply: '+' for lighter, '-' for darker.
 * @param int    $change The amount to reduce or increase brightness by.
 * @return string Hex code for the adjusted color brightness.
 */
if ( ! function_exists( 'equity_color_brightness' ) ) {
	function equity_color_brightness( $color, $op, $change ) {

		$hexcolor = str_replace( '#', '', $color );
		$red      = hexdec( substr( $hexcolor, 0, 2 ) );
		$green    = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue     = hexdec( substr( $hexcolor, 4, 2 ) );

		if ( '+' !== $op && isset( $op ) ) {
			$red   = max( 0, min( 255, $red - $change ) );
			$green = max( 0, min( 255, $green - $change ) );
			$blue  = max( 0, min( 255, $blue - $change ) );
		} else {
			$red   = max( 0, min( 255, $red + $change ) );
			$green = max( 0, min( 255, $green + $change ) );
			$blue  = max( 0, min( 255, $blue + $change ) );
		}

		$newhex = '#';
		$newhex .= strlen( dechex( $red ) ) === 1 ? '0' . dechex( $red ) : dechex( $red );
		$newhex .= strlen( dechex( $green ) ) === 1 ? '0' . dechex( $green ) : dechex( $green );
		$newhex .= strlen( dechex( $blue ) ) === 1 ? '0' . dechex( $blue ) : dechex( $blue );

		// Forces darken if brighten color is the same as color inputted.
		if ( $newhex === $hexcolor && '+' === $op ) {
			$newhex = '#111111';
		}

		return $newhex;

	}
}

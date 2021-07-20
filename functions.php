<?php
// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Stately', 'stately' ) );
define( 'CHILD_THEME_URL', 'https://learn.agentevolution.com/kb/stately/' );
define( 'CHILD_THEME_VERSION', '1.0.10' );

// Set Localization (do not remove).
load_child_theme_textdomain( 'stately', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'stately' ) );

// Remove foundation stylesheet - components loaded in child css.
add_action( 'wp_enqueue_scripts', 'child_dequeue_foundation_stylesheet' );
function child_dequeue_foundation_stylesheet() {
	wp_dequeue_style( 'equity-foundation' );
	// Get rid of this from easy testimonials because it has overreaching styles. We'll add our own if we need to.
	wp_dequeue_style( 'easy_testimonials_pro_style_new_responsive' );
}

// Add Theme Support.
add_theme_support( 'equity-after-entry-widget-area' );
add_theme_support( 'equity-menus', array(
	'header-right' => __( 'Header Right', 'stately' ),
) );
add_theme_support( 'equity-structural-wraps', array() );

// Add Accessibility support.
add_theme_support( 'equity-accessibility', array( 'skip-links' ) );

// Set default footer widgets
if ( ! get_theme_mod( 'footer_widgets' ) ) {
	set_theme_mod( 'footer_widgets', 2 );
}

// Add class to body for easy theme identification.
add_filter( 'body_class', 'add_theme_body_class' );
function add_theme_body_class( $classes ) {
	$classes[] = 'home-theme--stately';
	return $classes;
}

/**
 * Filter header right menu args to limit depth and add custom walker.
 * @param array $args arguments for building the nav menu.
 */
add_filter( 'wp_nav_menu_args', 'equity_child_header_menu_args', 10, 1 );
function equity_child_header_menu_args( $args ) {

	if ( 'header-right' === $args['theme_location'] ) {
		$args['depth'] = 4;
	}

	return $args;
}

// Remove header right widget area.
remove_action( 'after_setup_theme', 'equity_register_header_right_widget_area' );

// Add rectangular size image for featured posts/pages.
add_image_size( 'featured-post', '700', '370', true );

// Add body classes for customizer color options.
add_filter( 'body_class', 'stately_body_class' );
function stately_body_class( $classes ) {
	// Light/dark primary scheme
	if ( get_theme_mod( 'primary_tone', false ) ) {
		$classes[] = 'stately-light';
	}
	// White content background
	if ( get_theme_mod( 'content_bkg', true ) ) {
		$classes[] = 'stately-white-bkg';
	}

	return $classes;
}

// Load fonts.
add_filter( 'equity_google_fonts', 'stately_fonts' );
function stately_fonts( $equity_google_fonts ) {
	$equity_google_fonts = 'Catamaran:400,700|Work+Sans:800';
	return $equity_google_fonts;
}

// Load scripts.
add_action( 'wp_enqueue_scripts', 'stately_register_scripts' );
function stately_register_scripts() {
	// Use jQuery matchHeight for carousel images and header height.
	wp_enqueue_script( 'jquery-matchheight', get_stylesheet_directory_uri() . '/lib/js/jquery.matchHeight-min.js', array( 'jquery', 'equity-theme-js' ), null, true );

	if ( true === get_theme_mod( 'home_match_height_for_carousel', true ) ) {
		$match_height_script = '
		jQuery(function( $ ){
			$(document).ready(function() {
				// Use matchHeight for property carousel images.
				$(".home .carousel-property img").matchHeight({
					byRow: true,
					property: "height",
					target: null,
					remove: false
				});
			});
		});';
		wp_add_inline_script( 'jquery-matchheight', $match_height_script, 'after' );
	}

	// Enable sticky header if checked in customizer and not on mobile.
	if ( true === get_theme_mod( 'enable_sticky_header', true ) && ! wp_is_mobile() ) {
		wp_enqueue_script( 'sticky-header', get_stylesheet_directory_uri() . '/lib/js/sticky-header.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'fixed-footer', get_stylesheet_directory_uri() . '/lib/js/fixed-footer.js', array( 'jquery' ), null, true );
	}

	// Enable fadeup script if enabled.
	if ( get_theme_mod( 'home_fadeup_effect', true ) ) {
		wp_enqueue_script( 'fadeup', get_stylesheet_directory_uri() . '/lib/js/fadeup.js', array( 'jquery' ), null, true );
	}

	// Andoid nav menu fix to mirror iOS behavior
	wp_enqueue_script('android-nav-menu-fix', get_stylesheet_directory_uri() . '/lib/js/android-nav-menu-fix.js', null, true );

	// Return early if home page.
	if ( is_home() ) {
		return;
	}

	$background_url = equity_get_custom_field( '_equity_single_post_background' );

	if ( ! $background_url ) {
		$background_url = get_theme_mod( 'default_background_image', get_stylesheet_directory_uri() . '/images/bkg-default.jpg' );
	}

	// Only add background image if single post option is not disabled.
	if ( 'on' !== equity_get_custom_field( '_equity_disable_single_post_background' ) ) {
		$css = 'body:not(.home) .site-inner { background-image: url(\'' . $background_url . '\'); }';
		wp_add_inline_style( 'stately', $css );
	}
}
// Dequeue the IDX widgets stylesheet.
remove_action( 'wp_enqueue_scripts', 'equity_enqueue_idx_stylesheet', 10 );

// Add sticky header wrap markup.
add_action( 'equity_before_header', 'stately_sticky_header_open', 20 );
add_action( 'equity_after_header', 'stately_sticky_header_close', 10 );
function stately_sticky_header_open() {
	if ( true === get_theme_mod( 'enable_sticky_header', true ) ) {
		echo '<div class="sticky-header">';
	}
}
function stately_sticky_header_close() {
	if ( true === get_theme_mod( 'enable_sticky_header', true ) ) {
		echo '</div><!-- end .sticky-header -->';
	}
}

// Resize title area and header menu widths
add_filter( 'equity_attr_title-area', 'stately_attributes_title_area' );
function stately_attributes_title_area( $attributes ) {
	$attributes['class'] = str_replace( 'large-5', 'large-3', $attributes['class'] );
	return $attributes;
}
add_filter( 'equity_attr_nav-header-right', 'stately_attributes_header_nav' );
function stately_attributes_header_nav( $attributes ) {
	$attributes['class'] = str_replace( 'large-7', 'large-9', $attributes['class'] );
	return $attributes;
}

// Filter nav markup to add toggle icon.
add_filter( 'equity_nav_markup_open', 'stately_nav_markup_open' );
function stately_nav_markup_open() {
	return '<a href="#" class="menu-toggle"><span class="screen-reader-text">Menu</span><i class="fas fa-bars"></i></a>';
}

// Filter listing scroller widget prev/next links.
add_filter( 'listing_scroller_prev_link', 'child_listing_scroller_prev_link' );
add_filter( 'idx_listing_carousel_prev_link', 'child_listing_scroller_prev_link' );
add_filter( 'equity_page_carousel_prev_link', 'child_listing_scroller_prev_link' );
function child_listing_scroller_prev_link( $listing_scroller_prev_link_text ) {
	$listing_scroller_prev_link_text = __( '<i class=\"fas fa-caret-left\"></i><span>Prev</span>', 'stately' );
	return $listing_scroller_prev_link_text;
}
add_filter( 'listing_scroller_next_link', 'child_listing_scroller_next_link' );
add_filter( 'idx_listing_carousel_next_link', 'child_listing_scroller_next_link' );
add_filter( 'equity_page_carousel_next_link', 'child_listing_scroller_next_link' );
function child_listing_scroller_next_link( $listing_scroller_next_link_text ) {
	$listing_scroller_next_link_text = __( '<i class=\"fas fa-caret-right\"></i><span>Next</span>', 'stately' );
	return $listing_scroller_next_link_text;
}

// Reposition footer widgets inside footer element.
remove_action( 'equity_before_footer', 'equity_footer_widget_areas' );
add_action( 'equity_footer', 'equity_footer_widget_areas', 6 );

// Filter footer widget class for 8/4 column layout with 2 widgets. Other widget configs use equal widths (default).
add_filter( 'equity_footer_widgets_class', 'stately_footer_widgets_class', 10, 3 );
function stately_footer_widgets_class( $span_class, $counter, $footer_widgets ) {

	if ( 2 === (int) $footer_widgets ) {
		if ( 1 === $counter ) {
			$span_class = 'columns small-12 medium-6 large-8';
		} else {
			$span_class = 'columns small-12 medium-6 large-4';
		}
	}

	return $span_class;
}

// Filter footer widget and footer container markup.
add_filter( 'equity_footer_output', 'stately_footer_output', 10, 4 );
function stately_footer_output( $output, $footer_left, $footer_right, $footer_disclaimer ) {
	$output = '
		<div class="columns small-12 medium-6 large-8 footer-left">' . $footer_left . '<p class="footer-disclaimer">' . $footer_disclaimer . '</p></div>
		<div class="columns small-12 medium-6 large-4 footer-right">' . $footer_right . '</div>
	';

	return $output;
}

// Register home-top widget area.
equity_register_widget_area(
	array(
		'id'           => 'home-top',
		'name'         => __( 'Home Top', 'stately' ),
		'description'  => __( 'This is the top section of the Home page. Not all widgets are designed to work here. Recommended to use IMPress Omnibar Search widget.' , 'stately' ),
	)
);
// Get number of home widget areas from Customizer. Loop through them and register each.
$home_widget_areas = get_theme_mod( 'home_widget_areas', 6 );
$widget_area_count = 1;
while ( $widget_area_count <= $home_widget_areas ) {
	equity_register_widget_area(
		array(
			'id'          => sprintf( 'home-middle-%d', $widget_area_count ),
			'name'        => sprintf( __( 'Home Middle %d', 'stately' ), $widget_area_count ),
			'description' => sprintf( __( 'This is the Home Middle %d widget area.', 'stately' ), $widget_area_count ),
		)
	);
	$widget_area_count++;
}
// Register off-canvas widget area.
equity_register_widget_area(
	array(
		'id'          => 'off-canvas-widget',
		'name'        => __( 'Off Canvas Search', 'stately' ),
		'description' => __( 'This is the Off Canvas widget area.', 'stately' ),
	)
);

// Home page - return false to not display welcome screen.
add_filter( 'equity_display_welcome_screen', '__return_false' );

// Home page - markup and default widgets.
function equity_child_home() {
	?>

	<div class="home-top">
		<div class="overlay">
			<div class="row">
				<div class="columns small-12 medium-10 large-8 small-centered">
				<?php equity_widget_area( 'home-top' ); ?>
				</div><!-- end .columns .small-12 -->
			</div><!-- .end .row -->
		</div><!-- end .overlay -->
	</div><!-- end .home-top -->

	<?php
	// Loop through registered widget areas and output markup.
	$home_widget_areas = get_theme_mod( 'home_widget_areas', 6 );
	$widget_area_count = 1;
	while ( $widget_area_count <= $home_widget_areas ) {
		?>
		<div class="<?php echo esc_attr( stately_home_middle_widget_class( $widget_area_count, $home_widget_areas ) ); ?>">
			<div class="overlay">
				<div class="row">
					<?php
					$classes = equity_widget_area_class( sprintf( 'home-middle-%d', $widget_area_count ) );
					if ( 1 !== $widget_area_count ) {
						$classes .= ' fadeup-effect';
					}
					equity_widget_area( sprintf( 'home-middle-%d', $widget_area_count ),
						array(
							'before' => '<div class="flexible-widgets columns small-12 widget-area ' . $classes . '">',
							'after'  => '</div>',
						)
					);
					?>
				</div><!-- end .row -->
			</div><!-- end .overlay -->
		</div><!-- end <?php echo sprintf( 'home-middle-%d', (int) $widget_area_count ); ?> -->
		<?php
		$widget_area_count++;
	}
}

/**
 * Set the widget class for home middle widgets.
 *
 * @param string $widget_area_count The current widget count in the loop.
 * @param string $home_widget_areas Number of total widget areas set in Customizer.
 * @return Name of column class.
 */
function stately_home_middle_widget_class( $widget_area_count, $home_widget_areas ) {

	$class = ( $widget_area_count > 6 && $widget_area_count % 2 ) ? sprintf( 'home-middle-%d bg-alt bg-primary', $widget_area_count ) : sprintf( 'home-middle-%d bg-alt', $widget_area_count );

	switch ( $widget_area_count ) {
		case 1:
			$class .= ' weighted-first bg-primary';
			break;
		case 2:
			$class .= ' full';
			break;
		case 3:
			$class .= ' offset-last bg-image';
			break;
		case 4:
			$class .= ' full';
			break;
		case 5:
			$class .= ' bg-primary';
			break;
		case 6:
			$class .= ' weighted-first bg-image';
			break;
		default:
			$class .= '';
			break;
	}
	$class = apply_filters( 'stately_home_middle_widget_class', $class, $widget_area_count, $home_widget_areas );

	return $class;
}

// Add off canvas toggle before header markup close.
add_action( 'equity_header', 'stately_off_canvas_toggle', 11 );
function stately_off_canvas_toggle() {
	$toggle = '<a class="right-off-canvas-toggle off-canvas-toggle" href="#" ><span class="screen-reader-text">Search</span><span class="hide"><span class="screen-reader-text">Close</span></span></a>';
	echo $toggle;
}

add_action( 'equity_before_header', 'stately_open_off_canvas', 10 );
/**
 * Echo the Off Canvas open markup and widget area.
 *
 * Applies 'equity_off_canvas_toggle_text' filters
 */
function stately_open_off_canvas() {
	echo '<div class="off-canvas-wrap" data-offcanvas>
			<div class="inner-wrap">
				<aside class="right-off-canvas-menu off-canvas-menu-wrap">';

	equity_widget_area( 'off-canvas-widget',
		array(
			'before' => '<div class="off-canvas off-canvas-menu widget-area columns small-12">',
			'after'  => '</div>',
		)
	);

	echo '</aside>';

}

add_action( 'equity_after_footer', 'stately_close_off_canvas' );
/**
 * Echo the Off Canvas menu closing markup
 */
function stately_close_off_canvas() {
	echo apply_filters( 'equity_off_canvas_close_markup', '<!-- close the off-canvas menu --><a class="exit-off-canvas"></a>
		</div><!-- end .inner-wrap -->
	</div><!-- end .off-canvas-wrap -->' );
}

/**
 * Filter the Equity IDX and IMPress Carousel widget markup.
 */
add_filter( 'equity_idx_carousel_property_html', 'stately_equity_idx_carousel_property_html', 10, 5 );
add_filter( 'impress_carousel_property_html', 'stately_equity_idx_carousel_property_html', 10, 5 );
/**
 * Filters the default markup of IMPress and Equity Carousel widgets.
 *
 * @param  string $output     The default HTML output.
 * @param  array  $prop       The current property array in the loop.
 * @param  array  $instance   The instance options.
 * @param  string $url        The details URL.
 * @param  string $disclaimer The HTML wrapped disclaimer.
 * @return [type]             The modified HTML to output.
 */
function stately_equity_idx_carousel_property_html( $output, $prop, $instance, $url, $disclaimer ) {

	if ( isset( $instance['target'] ) && ! empty( $instance['target'] ) ) {
		$target = '_blank';
	} else {
		$target = '_self';
	}

	$prop_image_url = ( isset( $prop['image']['0']['url'] ) ) ? $prop['image']['0']['url'] : 'https://s3.amazonaws.com/mlsphotos.idxbroker.com/defaultNoPhoto/noPhotoFull.png';

	$output = sprintf(
		'<div class="carousel-property">
			<a href="%2$s" class="carousel-photo" target="%12$s">
				<img class="owl-lazy lazyOwl" data-src="%3$s" alt="%4$s" />
				
				<div class="property-details">
					<span class="price">%1$s</span>
					<ul class="beds-baths-sqft">
						%7$s
						%8$s
						%9$s
						%10$s
					</ul>
					<p class="address">
						<span class="street">%4$s</span>
						<span class="cityname">%5$s</span>,
						<span class="state"> %6$s</span>
					</p>
				</div>
				<div class="hover-cover"><p><i class="fas fa-eye"></i>View Property</p></div>
			</a>
			%11$s
		</div>',
		$prop['listingPrice'],
		$url,
		$prop_image_url,
		(isset($prop['address']) && $prop['address'] != null) ? $prop['address'] : '',
		$prop['cityName'],
		$prop['state'],
		(isset($prop['bedrooms']) && '0' !== $prop['bedrooms']) ? '<li class="beds" title="Bedrooms">' . $prop['bedrooms'] .' <span class="label">Bedrooms</span></li>' : '',
		(isset($prop['totalBaths']) && 0 !== $prop['totalBaths']) ? '<li class="baths" title="Bathrooms">' . $prop['totalBaths'] .' <span class="label">Bathrooms</span></li>' : '',
		(isset($prop['sqFt']) && '0' !== $prop['sqFt']) ? '<li class="sqft" title="Sq Ft">' . $prop['sqFt'] .' <span class="label">Sq Ft</span></li>' : '',
		(isset($prop['acres']) && '0' !== $prop['acres'] ) ? '<li class="acres" title="Acres">' . $prop['acres'] . ' <span class="label">Acres</span></li>' : '',
		$disclaimer,
		$target
	);

	return $output;
}


// Includes

# Theme Customizatons
require_once get_stylesheet_directory() . '/lib/class-stately-customizer.php';

# Recommended Plugins
require_once get_stylesheet_directory() . '/lib/plugins.php';

# Custom metaboxes
require_once get_stylesheet_directory() . '/lib/metaboxes.php';

# TODO - Merlin theme setup
// require_once EQUITY_CLASSES_DIR . '/merlin/merlin.php';
// require_once get_stylesheet_directory() . '/lib/merlin-config.php';

<?php
/**
 * Merlin WP configuration file.
 *
 * @package Stately\Plugins
 * @author  Agent Evolution
 * @license GPL-2.0+
 * @link    
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and other settings for Merlin WP.
 */
$wizard = new Merlin(
	// Configure Merlin with custom settings.
	$config = array(
		'directory'                => 'lib/classes/', // Location where the 'merlin' directory is placed.
		'demo_directory'           => 'demo/', // Location where the theme demo files exist.
		'merlin_url'               => 'merlin', // Customize the page URL where Merlin WP loads.
		'child_action_btn_url'     => '#',  // The URL for the 'child-action-link'.
		'help_mode'                => true, // Set to true to turn on the little wizard helper.
		'dev_mode'                 => true, // Set to true if you're testing or developing.
		'branding'                 => false, // Set to false to remove Merlin WP's branding.
	),
	// Text strings.
	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup' , 'stately' ),
		'title%s%s%s%s' 		   => esc_html__( '%s%s Themes &lsaquo; Theme Setup: %s%s' , 'stately' ),

		'return-to-dashboard'      => esc_html__( 'Return to the dashboard' , 'stately' ),

		'btn-skip'                 => esc_html__( 'Skip' , 'stately' ),
		'btn-next'                 => esc_html__( 'Next' , 'stately' ),
		'btn-start'                => esc_html__( 'Start' , 'stately' ),
		'btn-no'                   => esc_html__( 'Cancel' , 'stately' ),
		'btn-plugins-install'      => esc_html__( 'Install' , 'stately' ),
		'btn-child-install'        => esc_html__( 'Install' , 'stately' ),
		'btn-content-install'      => esc_html__( 'Install' , 'stately' ),
		'btn-import'               => esc_html__( 'Import' , 'stately' ),

		'welcome-header%s'         => esc_html__( 'Welcome to %s' , 'stately' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back' , 'stately' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.' , 'stately' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.' , 'stately' ),

		'child-header'             => esc_html__( 'Install Child Theme' , 'stately' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!' , 'stately' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.' , 'stately' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.' , 'stately' ),
		'child-action-link'        => esc_html__( 'Learn about child themes' , 'stately' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.' , 'stately' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.' , 'stately' ),

		'plugins-header'           => esc_html__( 'Install Plugins' , 'stately' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!' , 'stately' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.' , 'stately' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.' , 'stately' ),
		'plugins-action-link'      => esc_html__( 'Advanced' , 'stately' ),

		'import-header'            => esc_html__( 'Import Content' , 'stately' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.' , 'stately' ),
		'import-action-link'       => esc_html__( 'Advanced' , 'stately' ),

		'ready-header'             => esc_html__( 'All done. Have fun!' , 'stately' ),
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.' , 'stately' ),
		'ready-action-link'        => esc_html__( 'Extras' , 'stately' ),
		'ready-big-button'         => esc_html__( 'View your website' , 'stately' ),

		'ready-link-1'             => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', admin_url(), esc_html__( 'Dashboard', 'stately' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
		'ready-link-2'             => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://agentevolution.com/contact/', esc_html__( 'Get Theme Support', 'stately' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
		'ready-link-3'             => wp_kses( sprintf( '<a href="'.admin_url( 'customize.php' ).'" target="_blank">%s</a>', esc_html__( 'Start Customizing', 'stately' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
	)
);

add_filter( 'equity_merlin_steps', 'stately_merlin_steps', 10, 1 );
function stately_merlin_steps( $steps ) {
	unset( $steps['child'] );

	return $steps;
}

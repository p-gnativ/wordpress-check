<?php
// add admin logo
/*
	$logo_path = get_template_directory_uri() . '/images/logo.png';
	echo get_theme_mod(sanitize_title(wp_get_theme()) . '-logo', $logo_path);
*/
function as_logo_customize($wp_customize){
	// change title
	$wp_customize->get_section('title_tagline')->title = $wp_customize->get_section('title_tagline')->title . ' ' . __('&amp; Logo');

	// name option
	$settings = sanitize_title(wp_get_theme());
	// add setting
	$wp_customize->add_setting(
		$settings.'-logo',
		array(
			'default' => get_template_directory_uri() . '/images/logo.png',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		)
	);
	// add control
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			$settings.'-logo',
			array(
				'label' => __('Logo', 'soa'),
				'section' => 'title_tagline'
			)
		)
	);
}
add_action('customize_register', 'as_logo_customize', 11);

?>
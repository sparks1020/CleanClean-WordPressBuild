<?php 
/**
 * Ambition Theme Customizer support
 *
 * @package Theme Horse
 * @subpackage Ambition
 * @since Ambition 1.0
 */
?>
<?php
if ( ! class_exists( 'WP_Customize_Section' ) ) {
	return null;
}
/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since Ambition 1.0
 *
 */
function ambition_textarea_register($wp_customize){
	class Ambition_Customize_Ambition_upgrade extends WP_Customize_Control {
		public function render_content() { ?>
		<div class="theme-info"> 
			<a title="<?php esc_attr_e( 'Review Ambition', 'ambition' ); ?>" href="<?php echo esc_url( 'http://wordpress.org/support/view/theme-reviews/ambition' ); ?>" target="_blank">
			<?php _e( 'Rate Ambition', 'ambition' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/theme-instruction/ambition/' ); ?>" title="<?php esc_attr_e( 'Ambition Theme Instructions', 'ambition' ); ?>" target="_blank">
			<?php _e( 'Theme Instructions', 'ambition' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/support-forum/' ); ?>" title="<?php esc_attr_e( 'Support Forum', 'ambition' ); ?>" target="_blank">
			<?php _e( 'Support Forum', 'ambition' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/preview/ambition/' ); ?>" title="<?php esc_attr_e( 'Ambition Demo', 'ambition' ); ?>" target="_blank">
			<?php _e( 'View Demo', 'ambition' ); ?>
			</a>
		</div>
		<?php
		}
	}
	class Ambition_Customize_Category_Control extends WP_Customize_Control {
		/**
		* The type of customize control being rendered.
		*/
		public $type = 'multiple-select';
		/**
		* Displays the multiple select on the customize screen.
		*/
		public function render_content() {
		global $ambition_settings,$array_of_default_settings;
		$ambition_settings = wp_parse_args(  get_option( 'ambition_theme_settings', array() ),  ambition_get_option_defaults() );
		$categories = get_categories(); ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
				<?php
					foreach ( $categories as $category) :?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $ambition_settings['ambition_categories']) ) { echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		<?php 
		}
	}
}
/**
 * Upsell customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class Ambition_Customize_Section_Upsell extends WP_Customize_Section {

	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'upsell';

	/**
	 * Custom button text to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $pro_text = '';

	/**
	 * Custom pro button URL.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $pro_url = '';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function json() {
		$json = parent::json();

		$json['pro_text'] = $this->pro_text;
		$json['pro_url']  = esc_url( $this->pro_url );

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template() { ?>

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">
				{{ data.title }}

				<# if ( data.pro_text && data.pro_url ) { #>
					<a href="{{ data.pro_url }}" class="upgrade-to-pro" target="_blank">{{ data.pro_text }}</a>
				<# } #>
			</h3>
		</li>
	<?php }
}
function ambition_customize_register($wp_customize){
	$wp_customize->add_panel( 'ambition_theme_options', array(
	'priority'       => 10,
	'capability'     => 'edit_theme_options',
	'title'          => __('Ambition Theme Options', 'ambition')
	));
/********************Ambition Upgrade ******************************************/
	$wp_customize->add_section('ambition_upgrade', array(
		'title'					=> __('Ambition Support', 'ambition'),
		'priority'				=> 1,
	));
	$wp_customize->add_setting( 'ambition_theme_settings[ambition_upgrade]', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new Ambition_Customize_Ambition_upgrade(
		$wp_customize,
		'ambition_upgrade',
			array(
				'label'					=> __('Ambition Upgrade','ambition'),
				'section'				=> 'ambition_upgrade',
				'settings'				=> 'ambition_theme_settings[ambition_upgrade]',
			)
		)
	);

/********************Site Layout ******************************************/
	$wp_customize->add_section('ambition_design_layout', array(
		'title'					=> __('Site Layout', 'ambition'),
		'priority'				=> 101,
		'panel'					=>'ambition_theme_options'
	));
	$wp_customize->add_setting('ambition_theme_settings[design_layout]', array(
		'default'				=> 'on',
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('ambition_design_layout', array(
		'section'				=> 'ambition_design_layout',
		'settings'				=> 'ambition_theme_settings[design_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'on'					=> __('Wide Layout','ambition'),
			'off'					=> __('Narrow Layout','ambition'),
		),
	));
/********************Content Layout ******************************************/
	$wp_customize->add_section('ambition_content_layout', array(
		'title'					=> __('Content Layout', 'ambition'),
		'description'			=> __('Make sure that you have not set the layout from specific page','ambition'),
		'priority'				=> 102,
		'panel'					=>'ambition_theme_options'
	));
	$wp_customize->add_setting('ambition_theme_settings[content_layout]', array(
		'default'				=> 'right',
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('ambition_content_layout', array(
		'section'				=> 'ambition_content_layout',
		'settings'				=> 'ambition_theme_settings[content_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'right'				=> __('Right Sidebar','ambition'),
			'left'				=> __('Left Sidebar','ambition'),
			'nosidebar'			=> __('No Sidebar','ambition'),
			'fullwidth'			=> __('No Sidebar Full Width','ambition'),
		),
	));
/********************Site Title Background Image ******************************************/
	$wp_customize->add_section( 'ambition_site_title', array(
		'title'					=> __('Page Title Background Image', 'ambition'),
		'priority'				=> 103,
		'panel'					=>'ambition_theme_options'
	));
	
	$wp_customize->add_setting( 'ambition_theme_settings[site_title_setting]', array(
		'default'				=> 0,
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control( 'site_title_setting', array(
		'label'					=> __('Check to disable', 'ambition'),
		'section'				=> 'ambition_site_title',
		'settings'				=> 'ambition_theme_settings[site_title_setting]',
		'type'					=> 'checkbox',
	));
	$wp_customize->add_setting( 'ambition_theme_settings[img-upload-site-title]',array(
		'sanitize_callback'	=> 'esc_url_raw',
		'panel'					=>'ambition_theme_options',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		$wp_customize,
			'img-upload-site-title',
			array(
			'section'			=> 'ambition_site_title',
			'settings'			=> 'ambition_theme_settings[img-upload-site-title]',
			)
		)
	);
/********************Custom Header ******************************************/
	$wp_customize->add_section('custom_header_setting', array(
		'title'					=> __('Header Options', 'ambition'),
		'priority'				=> 104,
		'panel'					=>'ambition_theme_options'
	));
	$wp_customize->add_setting( 'ambition_theme_settings[search_header_settings]', array(
		'default'				=> 0,
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control( 'custom_header_setting', array(
		'label'					=> __('Check to disable Search Form from Header', 'ambition'),
		'section'				=> 'custom_header_setting',
		'settings'				=> 'ambition_theme_settings[search_header_settings]',
		'type'					=> 'checkbox',
	));
	$wp_customize->add_setting( 'ambition_theme_settings[img-upload-header-logo]',array(
		'sanitize_callback'	=> 'esc_url_raw',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		$wp_customize,
		'img-upload-header-logo',
			array(
				'label'				=> __('Header Logo','ambition'),
				'section'			=> 'custom_header_setting',
				'settings'			=> 'ambition_theme_settings[img-upload-header-logo]'
			)
		)
	);
	$wp_customize->add_setting('ambition_theme_settings[header_settings]', array(
		'default'				=> 'header_text',
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('custom_header_display', array(
		'label'					=> __('Display', 'ambition'),
		'section'				=> 'custom_header_setting',
		'settings'				=> 'ambition_theme_settings[header_settings]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
			'choices'			=> array(
			'header_text'		=> __('Header Text Only','ambition'),
			'header_logo'		=> __('Header Logo Only','ambition'),
			'disable_both'		=> __('Disable Both','ambition'),
			),
	));
/********************Custom Css ******************************************/
	$wp_customize->add_section( 'ambition_custom_css', array(
		'title'					=> __('Custom CSS', 'ambition'),
		'description'			=> __('This CSS will overwrite the CSS of style.css file.','ambition'),
		'priority'				=> 107,
		'panel'					=>'ambition_theme_options'
	));
	$wp_customize->add_setting( 'ambition_theme_settings[css_settings]', array(
		'default'				=> '',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses'
	));
	$wp_customize->add_control( 'custom_css', array(
		'section'				=> 'ambition_custom_css',
				'settings'				=> 'ambition_theme_settings[css_settings]',
				'type'					=> 'textarea'
	));
/********************Home Page Blog Category Setting ******************************************/
	$wp_customize->add_section(
		'ambition_category_section', array(
		'title' 						=> __('Home Page Blog Category Setting','ambition'),
		'description'				=> __('Only posts that belong to the categories selected here will be displayed on the front page. ( You may select multiple categories by holding down the CTRL key. ) ','ambition'),
		'priority'					=> 109,
		'panel'					=>'ambition_theme_options'
	));
	$wp_customize->add_setting( 'ambition_theme_settings[ambition_categories]', array(
		'default'					=>array(),
		'sanitize_callback'		=> 'prefix_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control(
		new Ambition_Customize_Category_Control(
		$wp_customize,
			'ambition_categories',
			array(
			'label'					=> __('Front page posts categories','ambition'),
			'section'				=> 'ambition_category_section',
			'settings'				=> 'ambition_theme_settings[ambition_categories]',
			'type'					=> 'multiple-select',
			)
		)
	);
	$wp_customize->add_setting( 'ambition_theme_settings[disable_setting]', array(
		'default'					=> 0,
		'sanitize_callback'		=> 'prefix_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'disable_setting', array(
		'label'						=> __('Check to Default Settings ( Uncheck to show effect on front page )', 'ambition'),
		'section'					=> 'ambition_category_section',
		'settings'					=> 'ambition_theme_settings[disable_setting]',
		'type'						=> 'checkbox',
	));
/********************Featured content layout setting and control ******************************************/
	$wp_customize->add_section( 'featured_content', array(
		'title'						=> __( 'Featured Content', 'ambition' ),
		'description'				=> sprintf( __( 'Use a <a href="%1$s">tag</a> to feature your posts. If no posts match the tag, <a href="%2$s">sticky posts</a> will be displayed instead.', 'ambition' ),
	esc_url( add_query_arg( 'tag', _x( 'featured', 'featured content default tag slug', 'ambition' ), admin_url( 'edit.php' ) ) ),
	admin_url( 'edit.php?show_sticky=1' )
	),
		'priority'					=> 140,
		'active_callback'			=> 'is_front_page',
			'panel'					=>'ambition_theme_options'
	) );
	$wp_customize->add_section( 'ambition_featured_content_setting', array(
		'title'					=> __('Featured Content Setting', 'ambition'),
		'priority'				=> 141,
		'panel'					=>'ambition_theme_options'
	));
	$wp_customize->add_setting( 'ambition_theme_settings[disable_slider]', array(
		'default'					=> 0,
		'sanitize_callback'		=> 'prefix_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'ambition_disable_slider', array(
		'priority'					=>5,
		'label'						=> __('Check to disable Slider', 'ambition'),
		'section'					=> 'ambition_featured_content_setting',
		'settings'					=> 'ambition_theme_settings[disable_slider]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('ambition_theme_settings[ambition_secondary_text]', array(
		'default'					=>'',
		'sanitize_callback'		=> 'sanitize_text_field',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('ambition_secondary_text', array(
		'priority'					=>9,
		'label'						=> __('Slider Secondary Button Text', 'ambition'),
		'section'					=> 'featured_content',
		'settings'					=> 'ambition_theme_settings[ambition_secondary_text]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting('ambition_theme_settings[ambition_secondary_url]', array(
		'default'					=>'',
		'sanitize_callback'		=> 'esc_url_raw',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('ambition_secondary_url', array(
		'priority'					=>10,
		'label'						=> __('Slider Secondary Url', 'ambition'),
		'section'					=> 'featured_content',
		'settings'					=> 'ambition_theme_settings[ambition_secondary_url]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting('ambition_theme_settings[ambition_slider_content]', array(
		'default'					=> 'on',
		'sanitize_callback'		=> 'prefix_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('ambition_slider_content', array(
		'label'						=> __('Slider Content', 'ambition'),
		'section'					=> 'ambition_featured_content_setting',
		'settings'					=> 'ambition_theme_settings[ambition_slider_content]',
		'type'						=> 'radio',
		'checked'					=> 'checked',
		'choices'					=> array(
			'on'						=> __('ON','ambition'),
			'off'						=> __('OFF','ambition'),
		),
	));
	$wp_customize->add_setting('ambition_theme_settings[ambition_transition_effect]', array(
		'default'					=> 'fade',
		'sanitize_callback'		=> 'ambition_sanitize_effect',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('ambition_transition_effect', array(
		'label'						=> __('Transition Effect', 'ambition'),
		'section'					=> 'ambition_featured_content_setting',
		'settings'					=> 'ambition_theme_settings[ambition_transition_effect]',
		'type'						=> 'select',
		'choices'					=> array(
			'fade'					=> __('Fade','ambition'),
			'wipe'					=> __('Wipe','ambition'),
			'scrollUp'				=> __('Scroll Up','ambition' ),
			'scrollDown'			=> __('Scroll Down','ambition' ),
			'scrollLeft'			=> __('Scroll Left','ambition' ),
			'scrollRight'			=> __('Scroll Right','ambition' ),
			'blindX'					=> __('Blind X','ambition' ),
			'blindY'					=> __('Blind Y','ambition' ),
			'blindZ'					=> __('Blind Z','ambition' ),
			'cover'					=> __('Cover','ambition' ),
			'shuffle'				=> __('Shuffle','ambition' ),
		),
	));
	$wp_customize->add_setting('ambition_theme_settings[ambition_transition_delay]', array(
		'default'					=> '4',
		'sanitize_callback'		=> 'ambition_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('ambition_transition_delay', array(
		'label'						=> __('Transition Delay', 'ambition'),
		'section'					=> 'ambition_featured_content_setting',
		'settings'					=> 'ambition_theme_settings[ambition_transition_delay]',
		'type'						=> 'text',
	) );
	$wp_customize->add_setting('ambition_theme_settings[ambition_transition_duration]', array(
		'default'					=> '1',
		'sanitize_callback'		=> 'ambition_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('ambition_transition_duration', array(
		'label'						=> __('Transition Duration', 'ambition'),
		'section'					=> 'ambition_featured_content_setting',
		'settings'					=> 'ambition_theme_settings[ambition_transition_duration]',
		'type'						=> 'text',
	) );

}
/********************Sanitize the values ******************************************/
function prefix_sanitize_integer( $input ) {
	return $input;
}

function ambition_sanitize_effect( $input ) {
	if ( ! in_array( $input, array( 'fade', 'wipe', 'scrollUp', 'scrollDown', 'scrollLeft', 'scrollRight', 'blindX', 'blindY', 'blindZ', 'cover', 'shuffle' ) ) ) {
		$input = 'fade';
	}
	return $input;
}
function ambition_sanitize_delay_transition( $input ) {
	if(is_numeric($input)){
	return $input;
	}
}
function ambition_customizer_control_scripts() {

	wp_enqueue_script(
		'ambition-customize-controls',
		get_template_directory_uri() . '/inc/admin/js/ambition_customizer.js',
		array(), '3.0',
		true
	);

	wp_enqueue_style( 'ambition-customize-controls',
	 get_template_directory_uri() . '/inc/admin/css/customize-controls.css' );

}

add_action( 'customize_controls_enqueue_scripts', 'ambition_customizer_control_scripts', 0 );


function ambition_customize_custom_sections( $wp_customize ) {

	// Register custom section types.
	$wp_customize->register_section_type( 'Ambition_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new Ambition_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Ambition Pro', 'ambition' ),
				'pro_text' => esc_html__( 'Upgrade to Pro', 'ambition' ),
				'pro_url'  => 'http://themehorse.com/themes/ambition-pro',
				'priority' => 1,
			)
		)
	);

}

add_action( 'customize_register', 'ambition_customize_custom_sections');
add_action('customize_register', 'ambition_textarea_register');
add_action('customize_register', 'ambition_customize_register');
?>

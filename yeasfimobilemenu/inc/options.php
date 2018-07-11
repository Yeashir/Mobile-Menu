<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function ymm_optionsframework_option_name() {
	$ymm_optionsframework_settings = get_option( 'ymm_optionsframework' );
	$ymm_optionsframework_settings['id'] = 'ymmmenu_options';
	update_option( 'ymm_optionsframework', $ymm_optionsframework_settings );
}

add_action( 'ymm_optionsframework_after', 'ymm_support_link' );

function ymm_support_link() { ?>

            <?php
}

add_filter( 'ymm_optionsframework_menu', 'ymm_add_responsive_menu' );

function ymm_add_responsive_menu( $menu ) {
	$menu['page_title']  = 'YM Responsive Menu';
	$menu['menu_title']  = 'YM Menu';
	$menu['mode']		 = 'menu';
	$menu['menu_slug']   = 'ym-responsive-menu';
	$menu['position']    = '30';
	return $menu;
}

$options = get_option('ymmmenu_options');
function ymm_optionsframework_options() {

    $options = array();

    $options[] = array('name' => __('General Settings', 'ymmmenu'),
        'type' => 'heading');
		
	$options[] = array('name' => __('Enable Mobile Navigation', 'ymmmenu'),
		'desc' => __('Check if you want to activate mobile navigation.', 'ymmmenu'),
		'id' => 'enabled',
		'std' => '1',
		'type' => 'checkbox');
	$menus = get_terms('nav_menu',array('hide_empty'=>false));
	$menu = array();
	foreach( $menus as $m ) {
		$menu[$m->term_id] = $m->name;
	}
	$options[] = array('name' => __('Select Menu', 'ymmmenu'),
	'desc' => __('Select the menu you want to display for mobile devices.', 'ymmmenu'),
	'id' => 'menu',
	'std' => '',
	'class' => 'mini',
	'options' => $menu,
	'type' => 'select');
	
	$options[] = array('name' => __('Elements to hide in mobile:', 'ymmmenu'),
	'desc' => __('Enter the css class/ids for different elements you want to hide on mobile separeted by a comma(,). Example: .nav,#main-menu ', 'ymmmenu'),
	'id' => 'hide',
	'std' => '',
	'type' => 'text');
	
	$options[] = array('name' => __('Enable Swipe', 'ymmmenu'),
		'desc' => __('Enable swipe gesture to open/close menus, Only applicable for left/right menu.', 'ymmmenu'),
		'id' => 'swipe',
		'std' => 'yes',
		'options' => array('yes' => 'Yes','no' => 'No'),
		'type' => 'radio');
	
	$options[] = array('name' => __(' Search Box', 'ymmmenu'),
	'desc' => __(' Select the position of search box or simply hide the search box if you donot need it.', 'ymmmenu'),
	'id' => 'search_box',
	'std' => 'hide',
	'options' => array('above_menu' => 'Above Menu','below_menu' => 'Below Menu', 'hide'=> 'Hide search box' ),
	'type' => 'select');
		
	$options[] = array('name' => __('Allow zoom on mobile devices', 'ymmmenu'),
		'desc' => __('', 'ymmmenu'),
		'id' => 'zooming',
		'std' => 'yes',
		'options' => array('yes' => 'Yes','no' => 'No'),
		'type' => 'radio');
		
	$options[] = array('name' => __('Menu Appearance', 'ymmmenu'),
		'type' => 'heading');
	
	$options[] = array('name' => __('Menu Symbol Position', 'ymmmenu'),
	'desc' => __('Select menu icon position which will be displayed on the menu bar.', 'ymmmenu'),
	'id' => 'menu_symbol_pos',
	'std' => 'right',
	'class' => 'mini',
	'options' => array('left' => 'Left','right' => 'Right'),
	'type' => 'select');
	
	$options[] = array('name' => __('Email', 'ymmmenu'),
   'desc' => __('Entet the text you would like to display on the menu bar.', 'ymmmenu'),
   'id' => 'email',
   'std' => '',
   'class' => 'mini',
   'type' => 'text');
	
	$options[] = array('name' => __('Phone Number', 'ymmmenu'),
   'desc' => __('Entet the text you would like to display on the menu bar.', 'ymmmenu'),
   'id' => 'phone',
   'std' => '',
   'class' => 'mini',
   'type' => 'text');

//	$options[] = array('name' => __('Menu Text', 'ymmmenu'),
//	'desc' => __('Entet the text you would like to display on the menu bar.', 'ymmmenu'),
//	'id' => 'bar_title',
//	'std' => 'MENU',
//	'class' => 'mini',
//	'type' => 'text');

	$options[] = array('name' => __('Menu Logo', 'ymmmenu'),
	'desc' => __('Select menu logo.', 'ymmmenu'),
	'id' => 'bar_logo',
	'std' => '',
	'type' => 'upload');

	$options[] = array('name' => __('Menu Open Direction', 'ymmmenu'),
	'desc' => __('Select the direction from where menu will open.', 'ymmmenu'),
	'id' => 'position',
	'std' => 'left',
	'class' => 'mini',
	'options' => array('left' => 'Left','right' => 'Right', 'top' => 'Top' ),
	'type' => 'select');

	$options[] = array('name' => __('Display menu from width (in px)', 'ymmmenu'),
	'desc' => __(' Enter the width (in px) below which the responsive menu will be visible on screen', 'ymmmenu'),
	'id' => 'from_width',
	'std' => '768',
	'class' => 'mini',
	'type' => 'text');

	$options[] = array('name' => __('Menu Width', 'ymmmenu'),
	'desc' => __('Enter menu width in (%) only applicable for left and right menu.', 'ymmmenu'),
	'id' => 'how_wide',
	'std' => '80',
	'class' => 'mini',
	'type' => 'text');
	
	$options[] = array('name' => __('Top Bar BG', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'topbarbg',
	'std' => '#DB1F1F',
	'type' => 'color');
	
	$options[] = array('name' => __('Bottom bar background color', 'ymmmenu'),
   'desc' => __('', 'ymmmenu'),
   'id' => 'menu_icon_bg',
   'std' => '#000000',
   'type' => 'color');
	
	$options[] = array('name' => __('Menu bar text color', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'bar_color',
	'std' => '#F2F2F2',
	'type' => 'color');
	
	$options[] = array('name' => __('Menu background color', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'menu_bgd',
	'std' => '#2E2E2E',
	'type' => 'color');
	
	$options[] = array('name' => __('Menu text color', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'menu_color',
	'std' => '#CFCFCF',
	'type' => 'color');
	
	$options[] = array('name' => __('Menu mouse over text color', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'menu_color_hover',
	'std' => '#606060',
	'type' => 'color');
	
	$options[] = array('name' => __('Menu icon color', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'menu_icon_color',
	'std' => '#FFFFFF',
	'type' => 'color');
	
	$options[] = array('name' => __('Menu borders(top & left) color', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'menu_border_top',
	'std' => '#0D0D0D',
	'type' => 'color');
	
	$options[] = array('name' => __('Menu borders(bottom) color', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'menu_border_bottom',
	'std' => '#131212',
	'type' => 'color');
	
	$options[] = array('name' => __('Enable borders for menu items', 'ymmmenu'),
	'desc' => __('', 'ymmmenu'),
	'id' => 'menu_border_bottom_show',
	'std' => 'yes',
	'options' => array('yes' => 'Yes','no' => 'No'),
	'type' => 'radio');

    return $options;
}
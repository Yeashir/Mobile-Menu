<?php
/*
  Plugin Name: Yeasfi Mobile Menu
  Plugin URI: https://github.com/Yeashir/plugin
  Description: WP Responsive menu is a mobile menu plugin which comes with 1 click installation and has lots of admin option to customize the plugin as per your needs.
  Version: 1.0.
  Author: Nirmal Ram
  Author URI: https://www.linkedin.com/in/yeashirarafat/

 */

/**
 *
 * Enable Localization
 *
 */
load_plugin_textdomain('ymmmenu', false, basename(dirname(__FILE__)) . '/lang');

/**
 *
 * Add admin settings
 *
 */
define('ymm_OPTIONS_FRAMEWORK_DIRECTORY', plugins_url('/inc/', __FILE__));
define('ymm_OPTIONS_FRAMEWORK_PATH', dirname(__FILE__) . '/inc/');
require_once dirname(__FILE__) . '/inc/options-framework.php';

// add required js/css files
add_action('wp_enqueue_scripts', 'ymmmenu_enqueue_scripts');

function ymmmenu_enqueue_scripts() {
    $options = get_option('ymmmenu_options');
    wp_enqueue_style('ymmmenu.css', plugins_url('css/ymmmenu.css', __FILE__));
    wp_enqueue_style('ymmmenu-font', '//fonts.googleapis.com/css?family=Open+Sans:400,300,600');
    wp_enqueue_script('jquery.transit', plugins_url('/js/jquery.transit.min.js', __FILE__), array('jquery'));
    wp_enqueue_script('sidr', plugins_url('/js/jquery.sidr.js', __FILE__), array('jquery'));
    wp_enqueue_script('ymmmenu.js', plugins_url('/js/ymmmenu.js', __FILE__), array('jquery'));
    $ymm_options = array('zooming' => $options['zooming'], 'from_width' => $options['from_width'], 'swipe' => $options['swipe']);
    wp_localize_script('ymmmenu.js', 'ymmmenu', $ymm_options);
}

function ymm_search_form() {
    return '<form role="search" method="get" class="ymm-search-form" action="' . site_url() . '"><label><input type="search" class="ymm-search-field" placeholder="Search ..." value="" name="s" title="Search for:"></label></form>';
}

add_action('wp_footer', 'ymmmenu_menu', 100);

function ymmmenu_menu() {
    $options = get_option('ymmmenu_options');
    if ($options['enabled']) :
        ?>
        <div id="ymmmenu_bar" class="ymmmenu_bar">
            <div class="ymmmenu_icon" style="width:50%">
                <p class="title_menu"><?php // echo $options['title_menu']    ?></p>
                <span class="ymmmenu_ic_1"></span>
                <span class="ymmmenu_ic_2"></span>
                <span class="ymmmenu_ic_3"></span>
            </div>
            <div class="menu_logof" style="width:50%">
                <a href="<?php echo get_home_url(); ?>">
                <?php echo ' <img class="bar_logo" src="' . $options['bar_logo'] . '"/>' ?>
                </a>
            </div>
          
        </div>


        <div class="mobile-bottom d-md-block d-lg-none">
            <div class="col-xs-6 p-0" id="call"><a  class="btm-cl align-self-center"  href="tel:<?php echo $options['phone']; ?>">Call</a></div>
            <div class="col-xs-6 p-0" id="eml"> <a class="btm-eml align-self-center" href="mailto:<?php echo $options['email'] ?>"> Email </a> </div>
        </div>

        <div id="ymmmenu_menu" class="ymmmenu_levels <?php echo $options['position'] ?> ymmmenu_custom_icons">
            <?php if ($options['search_box'] == 'above_menu') { ?> 
                <div class="ymm_search">
                    <?php echo ymm_search_form(); ?>
                </div>
            <?php } ?>
            <ul id="ymmmenu_menu_ul">
                <?php
                $menus = get_terms('nav_menu', array('hide_empty' => false));
                if ($menus) : foreach ($menus as $m) :
                        if ($m->term_id == $options['menu'])
                            $menu = $m;
                    endforeach;
                endif;
                if (is_object($menu)) :
                    wp_nav_menu(array('menu' => $menu->name, 'container' => false, 'items_wrap' => '%3$s'));
                endif;
                ?>
            </ul>
                <?php if ($options['search_box'] == 'below_menu') { ?> 
                <div class="ymm_search">
                <?php echo ymm_search_form(); ?>
                </div>
        <?php } ?>
        </div>
        <?php
    endif;
}

function ymmmenu_header_styles() {
    $options = get_option('ymmmenu_options');
    if ($options['enabled']) :
        ?>
        <style id="ymmmenu_css" type="text/css" >
            /* apply appearance settings */
            #ymmmenu_bar {
                background:<?php echo $options["topbarbg"] ?>;
                /*                background-image:url(<?php echo $options['bar_logo'] ?>);*/
                background-size: 100%;
                background-repeat: no-repeat;
                background-position: center;
                height: 42px;
            }
            #ymmmenu_bar .menu_title, #ymmmenu_bar .ymmmenu_icon_menu {
                color: <?php echo $options["bar_color"] ?>;
            }
            #ymmmenu_menu {
                background: <?php echo $options["menu_bgd"] ?>!important;
            }

            .menu_title,.menu_logo {
                background: <?php echo $options["menu_title_bg"] ?>!important;
            }

            .mobile-bottom{
                background: <?php echo $options["menu_icon_bg"] ?>!important;
            }

            #ymmmenu_menu.ymmmenu_levels ul li {
                border-bottom:1px solid <?php echo $options["menu_border_bottom"] ?>;
                border-top:1px solid <?php echo $options["menu_border_top"] ?>;
            }
            #ymmmenu_menu ul li a {
                color: <?php echo $options["menu_color"] ?>;
            }
            #ymmmenu_menu ul li a:hover {
                color: <?php echo $options["menu_color_hover"] ?>;
            }
            #ymmmenu_menu.ymmmenu_levels a.ymmmenu_parent_item {
                border-left:1px solid <?php echo $options["menu_border_top"] ?>;
            }
            #ymmmenu_menu .ymmmenu_icon_par {
                color: <?php echo $options["menu_color"] ?>;
            }
            #ymmmenu_menu .ymmmenu_icon_par:hover {
                color: <?php echo $options["menu_color_hover"] ?>;
            }
            #ymmmenu_menu.ymmmenu_levels ul li ul {
                border-top:1px solid <?php echo $options["menu_border_bottom"] ?>;
            }
            #ymmmenu_bar .ymmmenu_icon span {
                background: <?php echo $options["menu_icon_color"] ?>;
            }
            <?php
            //when option "hide bottom borders is on...
            if ($options["menu_border_bottom_show"] === 'no') {
                ?>
                #ymmmenu_menu, #ymmmenu_menu ul, #ymmmenu_menu li {
                    border-bottom:none!important;
                }
                #ymmmenu_menu.ymmmenu_levels > ul {
                    border-bottom:1px solid <?php echo $options["menu_border_top"] ?>!important;
                }
                .ymmmenu_no_border_bottom {
                    border-bottom:none!important;
                }
                #ymmmenu_menu.ymmmenu_levels ul li ul {
                    border-top:none!important;
                }
        <?php } ?>

            #ymmmenu_menu.left {
                width:<?php echo $options["how_wide"] ?>%;
                left: -<?php echo $options["how_wide"] ?>%;
                right: auto;
            }
            #ymmmenu_menu.right {
                width:<?php echo $options["how_wide"] ?>%;
                right: -<?php echo $options["how_wide"] ?>%;
                left: auto;
            }


        <?php if ($options["nesting_icon"] != '') : ?>
                #ymmmenu_menu .ymmmenu_icon:before {
                    font-family: 'fontawesome'!important;
                }
            <?php endif; ?>

        <?php if ($options["menu_symbol_pos"] == 'right') : ?>
                #ymmmenu_bar .ymmmenu_icon {
                    float: <?php echo $options["menu_symbol_pos"] ?>!important;
                    margin-right:0px!important;
                }
                #ymmmenu_bar .bar_logo {
                    pading-left: 0px;
                }
        <?php endif; ?>
            /* show the bar and hide othere navigation elements */
            @media only screen and (max-width: <?php echo $options["from_width"] ?>px) {
                html { padding-top: 42px!important; }
                #ymmmenu_bar { display: block!important; }
                div#wpadminbar { position: fixed; }
                <?php
                if ($options['hide'] != '') {
                    echo $options['hide'];
                    echo ' { display:none!important; }';
                }
                ?>

            </style>
            <?php
        endif;
    }

    add_action('wp_head', 'ymmmenu_header_styles');

    
<?php
/*
Plugin Name: Shopp SEO Helper
Description: Simple plugin to modify wp_title for Shopp products and categories. Based on code by 'Stanislav' at http://forums.shopplugin.net/topic/customizing-catalog-page-titles-please-help
Author: Tyson LT
Version: 0.6
*/

/**
 * Add title hook.
 */
add_filter('wp_title', 'shopp_catalog_titles', 99, 2); 

/**
 * Change title for Shopp pages, leave for normal wordpress pages.
 */
function shopp_catalog_titles($title, $sep=' | ') {

    // Access the Shopp data structure
    global $Shopp;
    global $aioseop_options;

    // A list to keep track of our title elements
    $titles = array();

    if (shopp('catalog','is-landing')) {
	$name = 'Shop';
	if (isset($aioseop_options['aiosp_home_title'])) {
		$name = $aioseop_options['aiosp_home_title'];
	}
	$titles = array($name, '');
    } else if (shopp('catalog','is-category')) {
        if (!empty($Shopp->Category->name)) {
	    $name = $Shopp->Category->name;
            if (!empty($Shopp->Category->description)) {
		$name .= ' &mdash; '. $Shopp->Category->description;
	    }
            $titles = array($name, '');
        }
    } else if (shopp('catalog','is-product')) {
        if (!empty($Shopp->Product->name)) {
            $titles = array($Shopp->Product->name, '');
        }        
    }
    if (empty($titles)) {
        $titles = array($title);
    }

    return join($sep,$titles);
}

?>
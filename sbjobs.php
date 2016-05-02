<?php
/*
Plugin Name: StartupBrett Job Widget
Plugin URI: http://www.mucro.de/
Description: Widget zur Darstellung von StartupBrett Stellenanzeigen auf deiner Webseite/Blog. Optional mit Zusatzeinnahmen durch Affiliate-Links.
Version: 1.2
Author: mucro.de
Author URI: http://www.mucro.de/
Text Domain: sbjobs
Domain Path: /languages
*/


/*****/
/* 
[sb_jobs count="1" hide_credit="1"]

[sb_jobs order_by="rand" types="praktikum,hilfskraft"]

[sb_jobs order_by="rand" types="vollzeit" categories="development"]

[sb_jobs count="1" hide_type="1" hide_location="1"]

[sb_jobs button-color="#4CAF50" affiliate_id="3"]
*/
/*****/

include_once( ABSPATH . WPINC . '/feed.php' );
include_once( 'sbjobs_widget.php' );

/**
* sb_jobs
*/
function sbjobs_shortcode( $atts, $content = null ) {
    
    $a = shortcode_atts( array(
        'affiliate_id' => "",
        'count' => "5",
        'hide_type' => "",
        'hide_location' => "",
        'show_credit' => "",
        'hide_button' => "",
        'order_by' => "",
        'types' => "",
        'categories' => "",
        'button-color' => "#4CAF50",
    ), $atts );
      
    $ref = "";
    $type = "";
    $cat = "";
    if(strlen($a['affiliate_id'])>0)
        $ref = "?ref=" . (int)$a['affiliate_id'];
    if(strlen($a['types'])>0)
        $type = "&job_types=" . urlencode($a['types']);
    if(strlen($a['categories'])>0)
        $cat = "&job_categories=" . urlencode($a['categories']);
        
    $link = 'http://www.startupbrett.de/?feed=job_feed' . $type . $cat;
    $cache_key = md5($link);
    
    // non-persistant cache
    $rss = wp_cache_get($cache_key, 'sbjobs');
    if ( false === $rss ) {
	    $rss = fetch_feed( $link );
	    wp_cache_set($cache_key, $rss, 'sbjobs', 60*60);
    }
    
    $maxitems = 0;

    if ( ! is_wp_error( $rss ) ) : 

        if($a['order_by'] == "rand")
            $maxitems = 200;
        else
            $maxitems = $rss->get_item_quantity( (int)$a['count'] ); 
    
        $rss_items = $rss->get_items( 0, $maxitems );

    endif;

    $result = '<ul class="sb_jobs">';
    if ( $maxitems == 0 ) {
        $result .= '<li>' . _e( 'No items', 'sbjobs' ) . '</li>';
    }else {
        
        if($a['order_by'] == "rand")
            shuffle($rss_items);
        $ii = 0;
        foreach ( $rss_items as $item ) {    
            $result .= '<li class="sb_job_listing">';
            $result .= '	<a href="' . esc_url( $item->get_permalink() ) . $ref . '" target="_blank">';
            $result .= '		<div class="sb_position">';
            $result .= '			<h3>' . esc_html( $item->get_title() ) . '</h3>';
            $result .= '		</div>';
            $result .= '		<ul class="sb_meta">';
            
            $location = $item->get_item_tags('http://www.startupbrett.de', 'location')[0]['data'];
            if(strlen($location)==0)
                $location = __("Everywhere");
            if(strlen($a['hide_location']) == 0)
                $result .= '			<li class="sb_location sb_sep">' . $location . '</li>';
            if(strlen($a['hide_type']) == 0)
                $result .= '			<li class="sb_company sb_sep">';
            else
                $result .= '			<li class="sb_company">';
            $result .= $item->get_item_tags('http://www.startupbrett.de', 'company')[0]['data'] . '</li>';
            if(strlen($a['hide_type']) == 0)
                $result .= '			<li class="sb_job_type">' . $item->get_item_tags('http://www.startupbrett.de', 'job_type')[0]['data'] . '</li>';
            $result .= '		</ul>';
            $result .= '	</a>';
            $result .= '</li>';
            $ii++;
            if($a['order_by'] == "rand" && $ii == (int)$a['count'])
                break;
        }
    }
    if(strlen($a['hide_button']) == 0)
        $result .= '<a href="http://www.startupbrett.de/stellenanzeige-schalten/' . $ref . '" target="_blank"><p class="sb_button" style="background-color: ' . $a['button-color'] . '">' . __('Submit job', 'sbjobs') . '</p></a>';
    $result .= '</ul>';
    if(strlen($a['show_credit']) == 1)
        $result .= '<p class="sb_credit">' . __('Provided by', 'sbjobs') . ' <a href="http://www.startupbrett.de/' . $ref . '" target="_blank">StartupBrett.de</a></p>';
    
    return $result . $content;
}

/**
 * Register style sheet.
 */
function sbjobs_register_plugin_styles() {
	wp_register_style( 'sbjobs', plugins_url( 'sbjobs/sbjobs.css' ) );
	wp_enqueue_style( 'sbjobs' );
}

function sbjobs_load_plugin_textdomain() {
    load_plugin_textdomain( 'sbjobs', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'sbjobs_load_plugin_textdomain' );
add_action( 'wp_enqueue_scripts', 'sbjobs_register_plugin_styles' );
add_shortcode( 'sb_jobs', 'sbjobs_shortcode' );
?>

<?php

/*
Plugin Name: k3x4 Updraftplus CRON
Plugin URI: http://k3x4.tk
description: /backup/files | /backup/db
Version: 1.0
Author: k3x4
Author URI: http://k3x4.tk
License: GPL2
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! in_array( 'updraftplus/updraftplus.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

add_action('init', function(){
    add_rewrite_rule( 'backup/([^/]+)/?$', 'index.php?k3x4back=$matches[1]', 'top' );
});

add_filter('query_vars', function($vars){
    $vars[] = 'k3x4back';
    return $vars;
});

add_action('wp', function(){
    $k3x4back = get_query_var('k3x4back', false);
    if($k3x4back){
        $db = $k3x4back == 'db' ? '_database' : '';
        define('DOING_CRON', true);
        require_once('wp-load.php');
        do_action('updraft_backup' . $db);
        die();
    } 
});
<?php
/**
 * Config-file for Mute. Change settings here to affect installation.
 *
 */
 
/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly
 
 
/**
 * Define Mute paths.
 *
 */
define('MUTE_INSTALL_PATH', __DIR__ . '/..');
define('MUTE_THEME_PATH', MUTE_INSTALL_PATH . '/theme/render.php');
 
 
/**
 * Include bootstrapping functions.
 *
 */
include(MUTE_INSTALL_PATH . '/src/bootstrap.php');
 
 
/**
 * Start the session.
 *
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();
 
 
/**
 * Create the Mute variable.
 *
 */
$mute = array();
 
 
/**
 * Site wide settings.
 *
 */
$mute['lang']         = 'sv';
$mute['title_append'] = ' | Murmix&#9733;Template';

/**
 * Theme related settings.
 *
 */
$mute['stylesheets'] = array('css/style.css');
$mute['favicon']    = 'img/favicon.png';

$mute['topmenu'] = array(
      'me'  => array('text'=>'Hello',  'url'=>'hello.php'),
      'report'  => array('text'=>'Tom Sida',  'url'=>'empty.php'),
      'source' => array('text'=>'404 Felsida', 'url'=>'404.php'),
    );

/**
 * Settings for JavaScript.
 *
 */
$mute['modernizr'] = 'js/modernizr.js';
$mute['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
$mute['javascript_include'] = array('js/mute.logo-toggle.js');

/**
 * Google analytics.
 *
 */
$mute['google_analytics'] = 'UA-62015365-1'; // Set to null to disable google analytic

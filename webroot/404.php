<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
$mute['title'] = "404";
$mute['main'] = "<h1>404 - Page not found</h1><p>Mute Framework Error: 404 - Page not found</p>";
 
// Send the 404 header 
header("HTTP/1.0 404 Not Found");
 
 
// Finally, leave it all to the rendering phase of Mute.
include(MUTE_THEME_PATH);

<?php 
/**
 * This is a Mute pagecontroller.
 *
 */
// Include the essential config-file which also creates the $mute variable with its defaults.
include(__DIR__.'/config.php'); 
 
$mute['title'] = "Hello Mute";
 
$mute['main'] = <<<EOD
<h1>Välkommen till Mute</h1>
<p>Mute är en förkortning av &quot;Murmix&#9733;Template&quot;.</p>
<p>&quot;Murmix&#9733;Template&quot; är en förkortning av &quot;Murmix fantastiskt enastående och oefterhärmeliga oophp webbtemplate&quot;.</p>
EOD;
 
// Finally, leave it all to the rendering phase of Mute.
include(MUTE_THEME_PATH);

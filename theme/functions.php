<?php
/**
 * Theme related functions. 
 *
 */
 
/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @return string/null whether the favicon is defined or not.
 */
function get_title($title) {
  global $mute;
  return $title . (isset($mute['title_append']) ? $mute['title_append'] : null);
}

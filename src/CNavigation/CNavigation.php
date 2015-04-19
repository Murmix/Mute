<?php
class CNavigation {

  public static function GenerateMenu($menuContent, $cssClass) {
  
    $html = "<nav class='{$cssClass}'>\n";
    foreach($menuContent as $key => $item) {
      $selected = (basename($_SERVER['SCRIPT_FILENAME']) == $item['url']) ? 'selected' : null; 
      $html .= "<a href='{$item['url']}' class='{$selected}'>{$item['text']}</a>\n";
    }
    $html .= "</nav>\n";
    return $html;
  }
}; 
<?php
/*
 *  Config File for this Theme
 */

$template_setting =  array();
$template_setting['template_name'] = 'default';
$template_setting['template_uri'] = 'http://www.wowraidmanager.com';
$template_setting['template_description'] = 'default Template';

// template version: default is wrm version
$template_setting['template_version'] = '4.3'; 
$template_setting['template_author'] = 'WRM Developer';
$template_setting['template_author_uri'] = 'http://www.wowraidmanager.com';


// -------------------- optional: stylesheet --------------------------
/* 
 * if you want use this otion then must be insert in your stylesheet.css file
 * 
 * how it works:
 * in /style/stylesheet.css
 * body.width_normal div#container
 * {
 *   width: 1141px;
 * }
 *  or:
 *  body.width_expanded div#container
 * {
 *   width: 1400px;
 * }
*/
$template_setting['width_normal'] = $this->wrm_lang['configuration_width_normal'];
$template_setting['width_expanded'] = $this->wrm_lang['configuration_width_expanded'];

?>
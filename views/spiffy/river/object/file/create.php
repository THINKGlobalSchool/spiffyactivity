<?php
/**
 * Spiffy Activity File River Create
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

$object = $vars['item']->getObjectEntity();
$excerpt = strip_tags($object->description);
$excerpt = elgg_get_excerpt($excerpt);

$vt = elgg_get_viewtype();
elgg_set_viewtype('default');

$download_icon = "<span class='elgg-icon' style='top: 3px; background-position: 0 -234px;'></span>";

$download_link = elgg_view('output/url', array(
	'name' => 'download',
	'text' =>  $download_icon . elgg_echo('spiffyactivity:download'),
	'href' => "file/download/$object->guid",
	'class' => '',
));

$file_icon = elgg_view_entity_icon($object, 'small');

elgg_set_viewtype($vt);

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'subtitle' =>  $download_link,
	'layout' => 'horizontal',
	'attachments' => $file_icon
));
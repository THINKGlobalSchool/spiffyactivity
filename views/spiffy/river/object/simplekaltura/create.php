<?php
/**
 * Spiffy Activity Simplekaltura River Create
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

$pop_url = elgg_get_site_url() . 'ajax/view/simplekaltura/popup?entity_guid=' . $object->guid;

$attachment = elgg_view_entity_icon($object, 'large', array(
		'href' => $pop_url,
		'link_class' => 'simplekaltura-lightbox',
		'title' => 'simplekaltura_lightbox',
		'width' => elgg_get_plugin_setting('kaltura_largethumb_width', 'simplekaltura'),
		'height' => elgg_get_plugin_setting('kaltura_largethumb_height', 'simplekaltura')
));
elgg_set_viewtype($vt);

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'attachments' => $attachment
));
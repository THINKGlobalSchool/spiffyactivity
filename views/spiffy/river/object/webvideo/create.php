<?php
/**
 * Spiffy Activity Webvideo River Create
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

$object = $vars['item']->getObjectEntity();
$description = strip_tags($object->description);
$excerpt = elgg_get_excerpt($description);

$popup_url = elgg_get_site_url() . 'webvideos/popup/' . $object->guid;

$vt = elgg_get_viewtype();
elgg_set_viewtype('default');

$thumbnail_popup = elgg_view_entity_icon($object, 'large', array(
	'href' => $popup_url,
	'rel' => 'fancyvideo',
	'link_class' => 'elgg-lightbox'
));

elgg_set_viewtype($vt);

$attachments = "<div class='spiffyactivity-item-image'>$thumbnail_popup</div>";

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'attachments' => $attachments
));
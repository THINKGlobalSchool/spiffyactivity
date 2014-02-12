<?php
/**
 * Spiffy Activity Blog River Create
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

$object = $vars['item']->getObjectEntity();

$excerpt = $object->excerpt ? $object->excerpt : $object->description;
$excerpt = strip_tags($excerpt);
$excerpt = elgg_get_excerpt($excerpt);

$images = spiffyactivity_extract_images_from_entity($object);

if (count($images)) {
	$image = elgg_view('output/url', array(
		'text' => elgg_view('output/img', array(
			'src' => $images[0]
		), false, false, 'default'),
		'href' => $object->getURL()
	), false, false, 'default');

	$image = "<div class='spiffyactivity-item-image'>$image</div>";
}


echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'attachments' => $image
));
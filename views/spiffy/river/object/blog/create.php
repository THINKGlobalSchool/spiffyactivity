<?php
/**
 * Blog river view.
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
<?php
/**
 * New bookmarks river entry
 *
 * @package Bookmarks
 */

$object = $vars['item']->getObjectEntity();

if (!$object->preview_populated) {
	elgg_load_library('facebook-link-preview');

	// Get url info
	$text = $object->address;
	$imageQuantity = 1;
	$text = " " . str_replace("\n", " ", $text);
	$header = "";

	$linkPreview = new LinkPreview();
	$answer = $linkPreview->crawl($text, $imageQuantity, $header);

	$decoded_response = json_decode($answer);

	if ($decoded_response) {
		if ($decoded_response->images) {
			$object->preview_image = $decoded_response->images;
		} 

		if ($decoded_response->description) {
			$object->preview_description = $decoded_response->description;
		}
	}

	SetUp::finish();

	$object->preview_populated = true;
}

$attachments = elgg_view('output/url', 
	array(
		'href' => $object->address,
		'text' => "<span class='elgg-subtext spiffyactivity-attachment-url'>" . elgg_get_excerpt($object->address, 44) . "</span>"
	), 
	false, 
	false, 
	'default'
);

if ($object->preview_image) {
	$image = elgg_view('output/img', array('src' => $object->preview_image), false, false, 'default');
	$attachments .= "<div class='spiffyactivity-item-image'>$image</div>";
}

if (!$object->description && $object->preview_description) {
	$message = $object->preview_description;
} else {
	$message = $object->description;
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $message,
	'attachments' => $attachments,
)); 
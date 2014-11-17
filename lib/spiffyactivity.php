<?php
/**
 * Elgg Spiffy Activity - Helper Lib
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

/**
 * Generate image preview compontents from given content
 * 
 * @param  DOMDocument $document    Content to search
 * @param  int         $image_count Number of images to return (Optional, default 1)
 * @return array
 */
function spiffyactivity_extract_images_from_document($document, $image_count = 1) {
	// Get all images
	$imgs = $document->getElementsByTagname('img'); 

	$images = array();
	
	// Add all images to images array
	foreach ($imgs as $idx => $img) {
		$image = $img->getAttribute("src");

		if (strpos($image, "://") === false) {
			$image = $url . $image; 
		}

		$images[] = $image;

		if ($image_count > $idx) {
			break;
		}
	}

	return $images;
}

/**
 * Generate a DOMDocument with given content, ignoring errors
 *
 * @param  string $content
 * @return DOMDocument
 */
function spiffyactivity_create_document_from_content($content) {
	// Get current error state
	$libxml_previous_state = libxml_use_internal_errors(true);

	// Prepare the DOM document
	$dom = new DOMDocument();
	$dom->strictErrorChecking = false;
	$dom->loadHTML($content);
	$dom->preserveWhiteSpace = false; 

	// Handler and revert previous error state
	libxml_clear_errors();
	libxml_use_internal_errors($libxml_previous_state);

	return $dom;
}

/**
 * Generatle image preview components from an entity
 *
 * @param ElggEntity $entity The entity to parse
 * @param string     $field  Optional: entity field to process (default description)
 * @param int        $image_count Number of images to return (Optional, default 1)
 */
function spiffyactivity_extract_images_from_entity($entity, $field = 'description', $image_count = 1) {
	if (!elgg_instanceof($entity, 'object')) {
		return false;
	}

	$dom = spiffyactivity_create_document_from_content($entity->$field);

	$images = spiffyactivity_extract_images_from_document($dom, $image_count);

	return $images;
}

/**
 * Basic external link preview components generator
 *
 * Modified from: http://stackoverflow.com/questions/1868544/is-there-a-library-that-emulates-facebooks-link-detect
 * 
 * @param string $url          Url to generate preview components for
 * @param int    $image_count  Number of images to return (default 1)
 */
function spiffyactivity_get_external_link_preview_components($url, $image_count = 1) {
	// Get target link html
	$html = file_get_contents($url);

	$dom = spiffyactivity_create_document_from_content($html);

	// Get page title
	$titles = $dom->getElementsByTagname('title');
	foreach ($titles as $title) {
		$link_title = $title->nodeValue;
	}

	// Get META tags
	$metas = $dom->getElementsByTagname('meta'); 

	// We only need description
	foreach ($metas as $meta) {
		if ($meta->getAttribute("name") == "description") {
			$link_description = $meta->getAttribute("content");
		}
	}

	// Get images
	$images = spiffyactivity_extract_images_from_document($dom, $image_count);

	return array(
		'title' => $link_title,
		'description' => $link_description,
		'images' => $images,
		'url' => $url
	);
}

/**
 * Get access label for river item
 * 
 * @param  ElggRiverItem $item The river item
 * @return string
 */
function spiffyactivity_get_river_item_access_label($item) {
	if ($item instanceof ElggRiverItem) {
		switch ($item->access_id) {
			case -1: 
				$label = 'Default';
				break;
			case 0: 
				$label = 'Private';
				break;
			case 1: 
				$label = elgg_echo('LOGGED_IN');
				break;
			case 2:
				$label = 'Public';
				break;
			case -2 :
				$label = 'Friends Only';
				break;
			default:
				$acl = get_access_collection($item->access_id);
				$label = $acl->name;
				break;
		}
		return $label;
	} else {
		return false;
	}
}

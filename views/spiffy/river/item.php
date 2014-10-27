<?php

$item = $vars['item'];

if (!($item instanceof ElggRiverItem)) {
	// Convert object to elgg river items!
	$object = new stdClass();
	$object->id = -2;
	$object->subject_guid = $item->owner_guid;
	$object->object_guid = $item->guid;
	$object->annotation_id = 0;
	$object->access_id = $item->access_id;
	$object->posted = $item->time_created;
	$object->action_type = 'create';

	if ($item->getSubtype() == 'simplekaltura_video') {
		$object->view = "river/object/simplekaltura/create";
	} else {
		$object->view = "river/object/{$item->getSubtype()}/create";
	}

	$object->type = $item->getType();
	$object->subtype = $item->getSubtype();

	$item = new ElggRiverItem($object);
} 

// checking default viewtype since some viewtypes do not have unique views per item (rss)
$view = $item->getView();
if (!$view || !elgg_view_exists($view, 'default')) {
	return '';
}

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();
if (!$subject || !$object) {
	// subject is disabled or subject/object deleted
	return '';
}

$vars['item'] = $item;

if (elgg_view_exists($view)) {
	echo elgg_view($view, $vars);
} else {
	elgg_set_viewtype('default');
	echo elgg_view($view, $vars);
	elgg_set_viewtype('spiffy');
}
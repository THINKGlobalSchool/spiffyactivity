<?php
$object = $vars['item']->getObjectEntity();

$icon = elgg_view_entity_icon($object, 'small', array(
	'href' => $object->getURL()
	// 'rel' => 'fancyvideo',
	// 'link_class' => 'elgg-lightbox'
));

echo $icon;
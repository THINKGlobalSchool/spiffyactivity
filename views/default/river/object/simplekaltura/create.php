<?php
$object = $vars['item']->getObjectEntity();
$icon = elgg_view_entity_icon($object, 'small', array(
		'href' => $object->getURL()
		// 'link_class' => 'simplekaltura-lightbox',
		// 'title' => 'simplekaltura_lightbox',
));

echo $icon;
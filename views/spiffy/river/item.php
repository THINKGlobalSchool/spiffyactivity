<?php
$item = $vars['item'];

$view = $item->getView();

if (elgg_view_exists($view)) {
	echo elgg_view($view, $vars);
} else {
	elgg_set_viewtype('default');
	echo elgg_view($view, $vars);
	elgg_set_viewtype('spiffy');
}
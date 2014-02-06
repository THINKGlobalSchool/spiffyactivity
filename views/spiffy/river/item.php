<?php
$item = $vars['item'];
elgg_set_viewtype('default');
echo elgg_view($item->getView(), $vars);
elgg_set_viewtype('spiffy');
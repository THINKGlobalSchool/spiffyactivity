<?php
/**
 * Blog river view.
 */

$object = $vars['item']->getObjectEntity();

$icon = tagdashboards_get_blog_preview_image($object);

echo $icon;
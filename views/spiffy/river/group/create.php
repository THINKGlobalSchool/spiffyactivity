<?php
/**
 * Spiffy Activity Group River Create
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

$object = $vars['item']->getObjectEntity();
$excerpt = strip_tags($object->description);
$excerpt = elgg_get_excerpt($excerpt);

$vt = elgg_get_viewtype();
elgg_set_viewtype('default');

$group_icon = elgg_view_entity_icon($object, 'large');

$attachments = "<div class='spiffyactivity-item-image spiffyactivity-group-image'>$group_icon</div>";

elgg_set_viewtype($vt);

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'subtitle' => elgg_get_excerpt($object->description, 200),
	'layout' => 'horizontal',
	'attachments' => $attachments
));
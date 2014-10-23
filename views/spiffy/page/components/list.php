<?php
/**
 * Elgg Spiffy Activity - Items List
 * - Modified version of default view
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['items']       Array of ElggEntity or ElggAnnotation objects
 * @uses $vars['offset']      Index of the first list item in complete list
 * @uses $vars['limit']       Number of items per page. Only used as input to pagination.
 * @uses $vars['count']       Number of items in the complete list
 * @uses $vars['base_url']    Base URL of list (optional)
 */

$items = $vars['items'];

$offset = elgg_extract('offset', $vars);
$limit = elgg_extract('limit', $vars);
$count = elgg_extract('count', $vars);
$base_url = elgg_extract('base_url', $vars, '');
$offset_key = elgg_extract('offset_key', $vars, 'offset');

$html = "";
$nav = "";

if ($count) {
	elgg_set_viewtype('default');
	$nav .= elgg_view('navigation/pagination', array(
		'base_url' => $base_url,
		'offset' => $offset,
		'count' => $count,
		'limit' => $limit,
		'offset_key' => $offset_key,
	));
	elgg_set_viewtype('spiffy');
}

if (is_array($items) && count($items) > 0) {
	$html .= "<ul class=\"spiffyactivity-list\">";
	foreach ($items as $item) {
		$li = elgg_view('river/item', array('item' => $item));
		if ($li) {
			if (elgg_instanceof($item)) {
				$id = "elgg-{$item->getType()}-{$item->getGUID()}";
			} else {
				$id = "item-{$item->getType()}-{$item->id}";
			}
			$html .= "<li id=\"$id\" class=\"spiffyactivity-list-item\">$li</li>";
		}
	}
	$html .= '</ul>';
}

$html .= $nav;

echo $html;

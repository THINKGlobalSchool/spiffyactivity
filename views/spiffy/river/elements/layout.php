<?php
/**
 * SpiffyActivity - Custom Activity Layout
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['item']        ElggRiverItem
 * @uses $vars['title']       Optional title (will default to the )
 * @uses $vars['message']     Optional message (usually excerpt of text)
 * @uses $vars['attachments'] Optional attachments (displaying icons or other non-text data)
 * @uses $vars['responses']   Alternate respones (comments, replies, etc.)
 * @uses $vars['layout']      Optional layout mode (default: vertical or horizontal)
 */

$item = $vars['item'];

$layout = elgg_extract('layout', $vars, 'vertical');

$view_type = elgg_get_viewtype();

if ($view_type == 'spiffy') {
	elgg_set_viewtype('default');
}

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();
$container = $object->getContainerEntity();

$group_string = '';
if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', array(
		'href' => $container->getURL(),
		'text' => $container->name,
		'is_trusted' => true,
	));
	$group_string = ' - ' . $group_link;
}

$name = $subject->name;
$owner_link = elgg_view('output/url', array(
	'text' => $name,
	'href' => $subject->getURL(),
));
$time = elgg_view_friendly_time($item->getPostedTime());

$access = spiffyactivity_get_river_item_access_label($item);

$header_body = <<<HTML
	<span class='spiffyactivity-header-name'>$owner_link</span>
	<span class='spiffyactivity-header-posted elgg-subtext'>$time</span>
	<span class='elgg-subtext'>
		$access $group_string
	</span>
HTML;

$header = elgg_view('page/components/image_block', array(
	'image' => elgg_view_entity_icon($subject, 'medium'),
	'body' => $header_body,
	'class' => 'spiffyactivity-list-item-header',
));

$menu = elgg_view_menu('river', array(
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));


$title = elgg_extract('title', $vars, '');
if ($title == '') {
	$title = elgg_view('output/url', array(
		'text' => $object->title,
		'href' => $object->getURL()
	));
}

if ($title !== false) {
	$title = "<div class=\"spiffyactivity-item-title\">$title</div>";
}

$message = elgg_extract('message', $vars, false);
if ($message !== false) {
	$message = "<div class=\"spiffyactivity-item-message\">$message</div>";
}

$attachments = elgg_extract('attachments', $vars, false);

if ($attachments !== false) {
	$attachments = "<div class=\"spiffyactivity-item-attachments clearfix\">$attachments</div>";
}

$responses = elgg_view('river/elements/responses', $vars);
if ($responses) {
	$responses = "<div class=\"spiffyactivity-item-responses\">$responses</div>";
}

if ($layout != 'vertical') {
	$body = elgg_view('page/components/image_block', array(
		'image' => $attachments,
		'body' => $title . $message,
		'class' => 'spiffyactivity-list-item-horizontal',
	));
} else {
	$body = $title . $attachments . $message;
}

echo <<<HTML
	$header
	<div class='spiffyactivity-list-item-body'>
		$menu
		$body
		$responses
	</div>
HTML;

elgg_set_viewtype($view_type);
?>

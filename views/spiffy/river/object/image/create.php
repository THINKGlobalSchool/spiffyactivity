<?php
/**
 * Spiffy Activity Image River Create
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */
$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$object = $vars['item']->getObjectEntity();

$image = elgg_view('output/url', array(
	'text' => elgg_view('output/img', array(
		'src' => $object->getIconURL('large')
	), false, false, 'default'),
	'href' => $object->getURL()
), false, false, 'default');

$attachments = "<div class='spiffyactivity-item-image'>$image</div>";

$album_link = elgg_view('output/url', array(
	'href' => $object->getContainerEntity()->getURL(),
	'text' => $object->getContainerEntity()->getTitle(),
	'is_trusted' => true,
));

echo elgg_view('river/elements/layout', array(
	'title' => ' ',
	'item' => $vars['item'],
	'attachments' => $attachments,
	'summary' => elgg_echo('image:river:created', array($subject_link, $album_link)),
));
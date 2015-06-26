<?php
/**
 * Elgg Spiffy Activity List
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.org/
 *
 */

// Get inputs into params (for plugin hook)
$params['type'] = get_input('type');
$params['start_date'] = get_input('start_date');
$params['end_date'] = get_input('end_date');
$params['container_guid'] = get_input('container_guid');
$params['user'] = get_user_by_username(get_input('user'));
$params['tag'] = string_to_tag_array(get_input('tag'));

$dbprefix = elgg_get_config('dbprefix');

// Build type/subtype logic
if ($params['type']) {
	foreach ($params['type'] as $type) {
		switch ($type) {
			case 'user':
			case 'group':
				$options['types'][] = $type;
				break;
			default:
				// Need to hack this for tidypics..
				if ($type == 'image') {
					$type = 'tidypics_batch';
				}
				$options['subtypes'][] = $type;
				$include_object = TRUE;
				break;
		}
	}

	if ($include_object) {
		$options['types'][] = 'object';
	}
}

// Add posted lower logic
if ($params['start_date']) {
	$options['posted_time_lower'] = (int)$params['start_date'];
}

// Add posted upper logic
if ($params['end_date']) {
	$options['posted_time_upper'] = (int)$params['end_date'];
}

// Add container guid logic 
if ($params['container_guid']) {
	$guid = $params['container_guid'];
	$options['joins'] = array("JOIN {$dbprefix}entities ce ON ce.guid = rv.object_guid");
	$options['wheres'] = array("ce.container_guid = {$guid}");
}

// Check for user and add user logic
if ($params['user'] && elgg_instanceof($params['user'], 'user')) {
	$options['subject_guid'] = $params['user']->guid;
}

// Check for tag
if ($params['tag']) {
	// Set up metadata options/values
	$meta = array(
		'metadata_name_value_pairs_operator' => 'AND',
	);

	// Handle multiple tags
	foreach($params['tag'] as $tag) {
		$meta['metadata_name_value_pairs'][] = array(	
			'name' => 'tags', 
			'value' => $tag, 
			'operand' => '=',
			'case_sensitive' => FALSE
		);
	}

	// Let elgg create our metadata SQL
	$meta_options = _elgg_entities_get_metastrings_options('metadata', $meta);

	// Add each join
	foreach ($meta_options['joins'] as $join) {
		// Swap out 'e.guid' for 'rv.object_guid' and add join
		$options['joins'][] = str_replace('e.guid', 'rv.object_guid', $join);
	}

	// Add each where
	foreach ($meta_options['wheres'] as $where) {
		$options['wheres'][] = $where;
	}

	// Profit!
}

// Set list class
$options['list_class'] = 'elgg-list-river elgg-river';

// Force base URL
$options['base_url'] = current_page_url();

// See if plugins want to add their input
$options = elgg_trigger_plugin_hook('get_options', 'activity_list', $params, $options);

$activity = elgg_list_river($options);

if (!$activity) {
	$activity = "<br /><center><label>" . elgg_echo('river:none') . "</label></center>";
}

echo $activity;

<?php
/**
 * Elgg Spiffy Activity
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.org/
 *
 */

elgg_register_event_handler('init', 'system', 'spiffyactivity_init');

// Init spiffyactivity
function spiffyactivity_init() {

	// Register library
	elgg_register_library('elgg:spiffyactivity', elgg_get_plugins_path() . 'spiffyactivity/lib/spiffyactivity.php');
	elgg_load_library('elgg:spiffyactivity');

	// Extend main CSS
	elgg_extend_view('css/elgg', 'css/spiffyactivity/css');

	// Register Isotope Lib
	$js = elgg_get_simplecache_url('js', 'isotope.js');
	elgg_register_js('jquery.isotope', $js);

	// Register JS lib
	$js = elgg_get_simplecache_url('js', 'spiffyactivity/spiffyactivity.js');
	elgg_register_js('elgg.spiffyactivity', $js);

	// Register Activity Ping JS library
	$ap_js = elgg_get_simplecache_url('js', 'spiffyactivity/ping.js');
	elgg_register_js('elgg.spiffyactivity.ping', $ap_js);

	if (elgg_get_context() == 'activity') {
		elgg_load_js('elgg.spiffyactivity.ping');
	}

	elgg_load_js('jquery.isotope');

	// Register timeago lib
	$js = elgg_get_simplecache_url('js', 'timeago.js');
	elgg_register_simplecache_view('js/timeago.js');
	elgg_register_js('jquery.timeago', $js);
	elgg_load_js('jquery.timeago');	

	elgg_load_js('elgg.spiffyactivity');

	// Register labs menu item
	elgg_register_menu_item('labs', array(
		'name' => 'spiffyactivity',
		'href' => elgg_normalize_url('activity?spiffy=1'),
		'text' => elgg_echo('spiffyactivity:labstitle'),
		'desc' => elgg_echo('spiffyactivity:labsdesc'),
	));

	// Unregister activity page handler
	elgg_unregister_page_handler('activity');

	// Register new page handler for activity
	elgg_register_page_handler('activity', 'spiffyactivity_river_page_handler');

	// Set up activity menu
	elgg_register_plugin_hook_handler('register', 'menu:activity_filter', 'spiffyactivity_activity_menu_setup');

	// Modify widget menu
	elgg_register_plugin_hook_handler('register', 'menu:widget', 'spiffyactivity_widget_menu_setup', 501);

	if (get_input('page_context') == 'activity' && get_input('spiffy')) {
		elgg_set_viewtype('spiffy');

		elgg_register_plugin_hook_handler('get_options', 'activity_list', 'spiffyactivity_river_activity_list_handler');

		elgg_register_plugin_hook_handler('view', 'river/elements/layout', 'spiffyactivity_river_layout_view_handler');
	}

	// Widgets
	if (elgg_is_active_plugin('roles')) {
		elgg_register_widget_type('spiffy_activity', elgg_echo('content:latest'), elgg_echo('spiffyactivity:widget:river_desc'), array('rolewidget'));
	}

	// Whitelist ajax views
	elgg_register_ajax_view('spiffy/activity_list');
}

/**
 * Page handler for activity
 *
 * @param array $page
 * @return bool
 */
function spiffyactivity_river_page_handler($page) {
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());	

	switch ($page[0]) {
		case 'ping':
			if (elgg_is_xhr()) {
				// check for last checked time
				if (!$seconds_passed = get_input('seconds_passed', 0)) {
					echo '';
					exit;
				}

				$last_reload = time() - $seconds_passed;

				// Get current count of entries
				$current_count = elgg_get_river(array(
					'count' => TRUE,
				));

				// Get the count at the last reload
				$last_count = elgg_get_river(array(
					'count' => TRUE,
					'posted_time_upper' => $last_reload,
				));

				if ($current_count > $last_count) {
					$count = $current_count - $last_count;

					// Get the latest river items
					$latest_items = elgg_get_river(array(
						'posted_time_lower' => $last_reload,
					));

					$latest_content = '';
					foreach($latest_items as $item) {
						$latest_content .= elgg_view_river_item($item, array());
					}

					$s = ($count == 1) ? '' : 's';

					if (!get_input('classic')) {
						$spiffy = 'spiffy';
					}

					$link = "<a href='#' class='activity-update-link $spiffy'>$count update$s!</a>";
					$page_title = "[$count update$s] ";

					echo json_encode(array(
						'count' => $count,
						'link' => $link,
						'page_title' => $page_title,
						'items' => $latest_content
					));
				}
				break;
			}
			// Cascading, default needs to be next
		default:
			$options = array();

			$title = elgg_echo('river:all');
			$page_filter = 'all';

			$endpoint = elgg_get_site_url() . 'ajax/view/spiffy/activity_list';

			if (!get_input('classic')) {
				$endpoint .= '?spiffy=1';
			}

			$params = array(
				'content' =>  elgg_view('filtrate/dashboard', array(
					'menu_name' => 'activity_filter',
					'infinite_scroll' => true,
					'default_params' => array(
						'type' => 0
					),
					'list_url' => $endpoint,
					'id' => 'activity-filtrate'
				)),
				'filter' => ' ',
				'class' => '',
				'title' => elgg_echo('activity')
		 	);


			$body = elgg_view_layout('one_column', $params);

			echo elgg_view_page($title, $body);
			break;
	}

	return true;
}

/**
 * Force river layout output to spiffy viewtype
 *
 * @param string $hook
 * @param string $type
 * @param array  $value
 * @param array  $params
 * @return array
 */
function spiffyactivity_river_layout_view_handler($hook, $type, $value, $params) {
	if (!get_input('spiffy_hook')) {
		set_input('spiffy_hook', true);
		return elgg_view('river/elements/layout', $params['vars'], false, false, 'spiffy');
	} else {
		set_input('spiffy_hook', false);
		return $value;
	}
}

/**
 * Add options for activity list in spiffy context
 *
 * @param string $hook
 * @param string $type
 * @param array  $value
 * @param array  $params
 * @return array
 */
function spiffyactivity_river_activity_list_handler($hook, $type, $value, $params) {
	$value['action_type'] = 'create';
	return $value;
}

/**
 * Set up activity filter menu items
 */
function spiffyactivity_activity_menu_setup($hook, $type, $return, $params) {

	$type_picker_options = array();
	$registered_entities = elgg_get_config('registered_entities');

	// Build type picker options
	if (!empty($registered_entities)) {
		foreach ($registered_entities as $type => $subtypes) {
			switch ($type) {
				case 'user':
				case 'group':
					$label = elgg_echo("item:$type");
					$type_picker_options["$type"] = $label;
					break;
				case 'object':
				default:
					foreach($subtypes as $subtype) {
						$label = elgg_echo("item:$type:$subtype");
						$type_picker_options["$subtype"] = $label;
					}
					break;
			}
		}
	}

	asort($type_picker_options);


	// Activity type filter
	$type_input = elgg_view('input/chosen_dropdown', array(
		'id' => 'activity-type-filter',
		'options_values' => $type_picker_options,
		'value' => get_input('type'),
		'class' => 'filtrate-filter',
		'multiple' => 'MULTIPLE',
		'data-param' => 'type',
		'data-placeholder' => elgg_echo('spiffyactivity:label:selecttype'),
	));

	$options = array(
		'name' => 'activity-type-filter',
		'href' => false,
		'label' => elgg_echo('spiffyactivity:label:contentfilter'),
		'text' => $type_input,
		'encode_text' => false,
		'section' => 'main',
		'priority' => 100
	);

	$return[] = ElggMenuItem::factory($options);

	$start_date_input = elgg_view('input/date', array(
		'value' => $start_date,
		'class' => 'filtrate-filter filtrate-clearable',
		'data-param' => 'start_date',
	));

	$options = array(
		'name' => 'activity-start-filter',
		'href' => false,
		'label' => elgg_echo('spiffyactivity:label:startdate'),
		'text' => $start_date_input,
		'encode_text' => false,
		'section' => 'advanced',
		'priority' => 200
	);

	$return[] = ElggMenuItem::factory($options);	

	$end_date_input = elgg_view('input/date', array(
		'value' => $end_date,
		'class' => 'filtrate-filter filtrate-clearable',
		'data-param' => 'end_date',
	));

	$options = array(
		'name' => 'activity-end-filter',
		'href' => false,
		'label' => elgg_echo('spiffyactivity:label:enddate'),
		'text' => $end_date_input,
		'encode_text' => false,
		'section' => 'advanced',
		'priority' => 300
	);

	$return[] = ElggMenuItem::factory($options);

	// Group picker
	$group_options = array(
		'type' => 'group',
		'limit' => 0,
		'joins' => array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid"),
		'order_by' => 'ge.name ASC',
		'relationship' => 'member',
		'relationship_guid' => elgg_get_logged_in_user_entity()->guid
	);


	// Put together the group selector
	$groups = elgg_get_entities_from_relationship($group_options);

	$groups_array = array();

	if (count($groups) >= 1) {
		$groups_array[0] = '';

		foreach ($groups as $group) {
			$groups_array[$group->guid] = $group->name;
		}
	} else {
		$groups_array[''] = elgg_echo('spiffyactivity:label:nogroups');
	}

	$group_filter_input = elgg_view('input/chosen_dropdown', array(
		'id' => 'activity-group-filter',
		'options_values' => $groups_array,
		'value' => $container_guid,
		'class' => 'filtrate-filter',
		'data-param' => 'container_guid',
		'data-placeholder' => elgg_echo('spiffyactivity:label:selectagroup')
	));

	$options = array(
		'name' => 'activity-group-filter',
		'href' => false,
		'label' => elgg_echo('spiffyactivity:label:groupclass'),
		'text' => $group_filter_input,
		'encode_text' => false,
		'section' => 'advanced',
		'priority' => 400
	);

	$return[] = ElggMenuItem::factory($options);

	// User picker
	$user_input = elgg_view('input/autocomplete', array(
		'id' => 'activity-user-filter',
		'name' => 'user',
		'class' => 'filtrate-clearable filtrate-filter',
		'data-param' => 'user',
		'data-match_on' => 'users',
		'placeholder' => elgg_echo('spiffyactivity:label:typename'),
		//'data-disables' => '["#todo-context-filter", "#hidden-page-owner"]'
	));

	$options = array(
		'name' => 'user-filter',
		'label' => elgg_echo('user'),
		'text' => $user_input,
		'href' => false,
		'section' => 'advanced',
		'priority' => 500,
	);

	$return[] = ElggMenuItem::factory($options);

	$tag_input = elgg_view('input/tags', array(
		'id' => 'activity-tag-filter',
		'name' => 'activity_tag_filter',
		'class' => 'filtrate-filter',
		//'data-param' => 'tag', // Don't set data param here, need to hack it in with JS
		//'value' => get_input('tag'),
		'data-hoverHelp' => 1, // Set hoverHelp to true for floating hover box
	//	'data-match_on' => 'tags',
	));

	$options = array(
		'name' => 'tag-filter',
		'label' => elgg_echo('spiffyactivity:label:tag'),
		'text' => $tag_input,
		'href' => false,
		'section' => 'main',
		'priority' => 600,
	);

	$return[] = ElggMenuItem::factory($options);


	if (elgg_get_context() == 'activity') {
		$current_url = strtok(current_page_url(),'?');

		if (!get_input('classic')) {
			$current_url .= '?classic=1';
			$text = elgg_echo('spiffyactivity:label:classicactivity');
		} else {
			$text = elgg_echo('spiffyactivity:label:newactivity');
		}

		$options = array(
			'name' => 'switch-mode',
			'text' => elgg_view('output/url', array(
				'text' => $text,
				'href' => $current_url
			)),
			'href' => false,
			'section' => 'main',
			'priority' => 700,
		);

		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}

/**
 * Modify widget menus for widgets
 *
 * @param string $hook
 * @param string $type
 * @param array  $value
 * @param array  $params
 * @return array
 */
function spiffyactivity_widget_menu_setup($hook, $type, $return, $params) {
	if (get_input('custom_widget_controls')) {
		$widget = $params['entity'];

		if ($widget->handler == 'tgstheme_river') {
			$options = array(
				'name' => 'river_view_all',
				'text' => elgg_echo('link:view:all'),
				'title' => 'river_view_all',
				'href' => elgg_get_site_url() . 'activity',
				'class' => 'home-small'
			);

			$return[] = ElggMenuItem::factory($options);
		}
	}

	return $return;
}
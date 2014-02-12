<?php
/**
 * Elgg Spiffy Activity
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */

elgg_register_event_handler('init', 'system', 'spiffyactivity_init');

// Init wall posts
function spiffyactivity_init() {

	// Register library
	elgg_register_library('elgg:spiffyactivity', elgg_get_plugins_path() . 'spiffyactivity/lib/spiffyactivity.php');
	elgg_load_library('elgg:spiffyactivity');

	// Register fb link preview library
	elgg_register_library('facebook-link-preview', elgg_get_plugins_path() . 'spiffyactivity/vendors/fblinkpreview/php/classes/LinkPreview.php');

	// Extend main CSS
	elgg_extend_view('css/elgg', 'css/spiffyactivity/css');

	// Register Isotope Lib
	$js = elgg_get_simplecache_url('js', 'isotope.js');
	elgg_register_simplecache_view('js/isotope.js');
	elgg_register_js('jquery.isotope', $js);

	// Register timeago lib
	$js = elgg_get_simplecache_url('js', 'timeago.js');
	elgg_register_simplecache_view('js/timeago.js');
	elgg_register_js('jquery.timeago', $js);

	// Register Infinite Scroll Lib
	$js = elgg_get_simplecache_url('js', 'infinitescroll.js');
	elgg_register_simplecache_view('js/infinitescroll.js');
	elgg_register_js('jquery.infinitescroll', $js);

	// Register JS lib
	$js = elgg_get_simplecache_url('js', 'spiffyactivity/spiffyactivity.js');
	elgg_register_simplecache_view('js/spiffyactivity/spiffyactivity.js');
	elgg_register_js('elgg.spiffyactivity', $js);

	elgg_register_page_handler('spiffy', 'spiffyactivity_page_handler');

	elgg_load_js('jquery.isotope');
	elgg_load_js('jquery.infinitescroll');
	elgg_load_js('jquery.timeago');
	elgg_load_js('elgg.spiffyactivity');

	if (get_input('context') == 'activity') {
		elgg_set_viewtype('spiffy');

		elgg_register_plugin_hook_handler('get_options', 'activity_list', 'spiffyactivity_river_activity_list_handler');

		elgg_register_plugin_hook_handler('view', 'river/elements/layout', 'spiffyactivity_river_layout_view_handler');
	}
}

function spiffyactivity_page_handler($page) {
	$options = array(
		'type' => 'object',
		'subtypes' => array(
			'blog', 'simplekaltura_video', 'webvideo', 'podcast', 'bookmarks'
		),
		'action_type' => 'create',
		'base_url' => elgg_get_site_url() . 'spiffy/infinitelist'
	);

	if (elgg_is_xhr()) {
		$page_type = $page[0];

		switch ($page_type) {
			case 'infinitelist':
				$options['count'] = true;

				$item_count = elgg_get_river($options);

				$options['count'] = false;

				echo elgg_list_river($options);

				$options = array(
					'base_url' => elgg_get_site_url() . 'spiffy/infinitelist',
					'limit' => 20,
					'offset' => get_input('offset', 0),
					'count' => $item_count
				);

				echo elgg_view('navigation/pagination', $options);
				break; 
		}
	} else {
		elgg_load_js('jquery.isotope');
		elgg_load_js('jquery.infinitescroll');
		elgg_load_js('elgg.spiffyactivity');

		$params['content'] = elgg_list_river($options);

		$body = elgg_view_layout('one_column', $params);
		echo elgg_view_page($params['title'], $body);
	}
	return TRUE;
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
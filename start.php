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

	// Register Infinite Scroll Lib
	$js = elgg_get_simplecache_url('js', 'infinitescroll.js');
	elgg_register_simplecache_view('js/infinitescroll.js');
	elgg_register_js('jquery.infinitescroll', $js);

	// Register JS lib
	$js = elgg_get_simplecache_url('js', 'spiffyactivity/spiffyactivity.js');
	elgg_register_simplecache_view('js/spiffyactivity/spiffyactivity.js');
	elgg_register_js('elgg.spiffyactivity', $js);

	elgg_load_js('jquery.isotope');
	elgg_load_js('jquery.infinitescroll');

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


	if (get_input('page_context') == 'activity' && get_input('spiffy')) {
		elgg_set_viewtype('spiffy');

		elgg_register_plugin_hook_handler('get_options', 'activity_list', 'spiffyactivity_river_activity_list_handler');

		elgg_register_plugin_hook_handler('view', 'river/elements/layout', 'spiffyactivity_river_layout_view_handler');
	}
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
<?php
/**
 * Elgg Spiffy Activity Widgets
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.org/
 *
 */
elgg_load_js('elgg.spiffyactivity.ping');
echo elgg_view('filtrate/dashboard', array(
	'menu_name' => 'activity_filter',
	'infinite_scroll' => false,
	'default_params' => array(
		'type' => 0
	),
	'list_url' => elgg_get_site_url() . 'ajax/view/spiffy/activity_list',
	'disable_advanced' => true,
	'disable_history' => true,
	'id' => 'activity-filtrate'
));
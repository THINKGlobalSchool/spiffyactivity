<?php
/**
 * Elgg Spiffy Activity Infinite Scroll Simplecache View
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

$js_path = elgg_get_config('path');
$js_path = "{$js_path}mod/spiffyactivity/vendors/infinitescroll/jquery.infinitescroll.min.js";

include $js_path;
<?php
/**
 * Elgg Spiffy Activity CSS
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */
?>
.spiffyactivity-list-item {
	border: 2px solid #DDDDDD;
	max-width: 316px;
	margin-bottom: 10px;
	-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
}

.spiffyactivity-list-item .elgg-menu-river,
.spiffyactivity-list-item .river-access-display {
	display: none;
}

.spiffyactivity-list {
	margin-top: 6px;
	margin-left: 1px;
}

.spiffyactivity-list .elgg-avatar-medium > a > img {
    background-size: 50px auto !important;
    border-radius: 5px;
    height: 50px;
    width: 50px;
}

/* River tweaks */
.elgg-river-item {

}

.elgg-river-item .elgg-image {

}

.elgg-river-item .elgg-body {
	margin-right: 10px;
}

/** ISOTOPE **/

.isotope,
.isotope .isotope-item {
  /* change duration value to whatever you like */
  -webkit-transition-duration: 0.8s;
     -moz-transition-duration: 0.8s;
      -ms-transition-duration: 0.8s;
       -o-transition-duration: 0.8s;
          transition-duration: 0.8s;
}

.isotope {
  -webkit-transition-property: height, width;
     -moz-transition-property: height, width;
      -ms-transition-property: height, width;
       -o-transition-property: height, width;
          transition-property: height, width;
}

.isotope .isotope-item {
  -webkit-transition-property: -webkit-transform, opacity;
     -moz-transition-property:    -moz-transform, opacity;
      -ms-transition-property:     -ms-transform, opacity;
       -o-transition-property:      -o-transform, opacity;
          transition-property:         transform, opacity;
}

/**** disabling Isotope CSS3 transitions ****/

.isotope.no-transition,
.isotope.no-transition .isotope-item,
.isotope .isotope-item.no-transition {
  -webkit-transition-duration: 0s;
     -moz-transition-duration: 0s;
      -ms-transition-duration: 0s;
       -o-transition-duration: 0s;
          transition-duration: 0s;
}
<?php
/**
 * Elgg Spiffy Activity CSS
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 *
 */
?>
.spiffyactivity-list-item {
    border: 1px solid #EEEEEE;
    box-shadow: 0 1px 1px #999999;
    margin-bottom: 10px;
    width: 316px;
	-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
}

.spiffyactivity-list-item .elgg-menu-river,
.spiffyactivity-list-item .river-access-display {
	display: none;
}

.spiffyactivity-list-item .spiffyactivity-list-item-header {

}

.spiffyactivity-list-item .spiffyactivity-list-item-header .spiffyactivity-header-name {
	color: #444444;
	display: block;
	font-size: 1.1em;
	font-weight: bold;
}

.spiffyactivity-list-item .spiffyactivity-list-item-header .spiffyactivity-header-posted {
	display: block;
	font-style: normal;
}

.spiffyactivity-list-item .spiffyactivity-list-item-header .elgg-body {
	padding-left: 10px;
	padding-right: 5px;
}

.spiffyactivity-list-item .spiffyactivity-list-item-header.elgg-image-block {
	margin: 0;
	padding: 5px;
}

.spiffyactivity-list-item .spiffyactivity-list-item-header.elgg-image-block .elgg-image {
	margin: 0;
	padding: 0;
}

.spiffyactivity-list-item .spiffyactivity-list-item-header .elgg-image .elgg-avatar img {
	/*border-radius: 30px;*/
}

.spiffyactivity-list-item .spiffyactivity-list-item-body {
	padding: 5px;
}

.spiffyactivity-item-title {
	font-size: 1.2em;
	font-weight: bold;
	width: 100%;
	margin-bottom: 3px;
}

.spiffyactivity-item-message {
	box-shadow: 0 0 4px #DDDDDD inset;
	color: #555555;
	font-weight: bold;
	margin-top: 6px;
	padding: 6px 10px 10px;
}

.spiffyactivity-list .spiffyactivity-item-image img {
	width: 100%;
}

.spiffyactivity-group-image img {
	background-size: 100px 100px !important;
	height: 100px;
	width: 100px;
}

.spiffyactivity-attachment-url {
	font-style: normal;
	margin-bottom: 3px;
	display: block;
}

.spiffyactivity-list-item-horizontal .elgg-image,
.elgg-river-attachments > .spiffyactivity-item-image > img {
	max-width: 35%;
	margin: 2px 6px 0 0;
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
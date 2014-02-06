<?php
/**
 * Elgg Spiffy Activity JS Lib
 *
 * @package SpiffyActivity
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */
?>
//<script>
elgg.provide('elgg.spiffyactivity');

// modified Isotope methods for gutters in masonry
$.Isotope.prototype._getMasonryGutterColumns = function() {
    var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
        containerWidth = this.element.width();

    this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
                  // or use the size of the first item
                  this.$filteredAtoms.outerWidth(true) ||
                  // if there's no items, use size of container
                  containerWidth;

    this.masonry.columnWidth += gutter;

    this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
    this.masonry.cols = Math.max( this.masonry.cols, 1 );
};

$.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    // FIXME shouldn't have to call this again
    this._getMasonryGutterColumns();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
        this.masonry.colYs.push( 0 );
    }
};

$.Isotope.prototype._masonryResizeChanged = function() {
    var prevSegments = this.masonry.cols;
    // update cols/rows
    this._getMasonryGutterColumns();
    // return if updated cols/rows is not equal to previous
    return ( this.masonry.cols !== prevSegments );
};

elgg.spiffyactivity.filtrate_init = function(hook, type, params, value) {
    var $container = $('.spiffyactivity-list');

   
    if ($container.data('isIsotope')) {
        $container.isotope('destroy'); 
    } else {
        // First init of isotope, hide the items initally for fancy fade in
        var $hidden_container = $('<div/>', {
            style: 'display: none',
        }).appendTo($container.parent());

        $container.find('li.spiffyactivity-list-item').appendTo($hidden_container);
    }
    
    $container.isotope({
        // options
        itemSelector : '.spiffyactivity-list-item',
        layoutMode : 'masonry',
        masonry: {
            width: 100,
            gutterWidth: 10
        }
    });

    if (!$container.data('isIsotope')) {
        $container.isotope('insert', $hidden_container.find('li.spiffyactivity-list-item')); 
    }

    $container.data('isIsotope', true);
}

elgg.spiffyactivity.filtrate_infinite = function(hook, type, params, value) {
    params.container.isotope('appended', params.items);
}

//elgg.register_hook_handler('init', 'system', elgg.spiffyactivity.init);
elgg.register_hook_handler('content_loaded', 'filtrate', elgg.spiffyactivity.filtrate_init);
elgg.register_hook_handler('infinite_loaded', 'filtrate', elgg.spiffyactivity.filtrate_infinite);




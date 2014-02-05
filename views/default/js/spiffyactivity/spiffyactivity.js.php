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

// elgg.spiffyactivity.init = function() {
// 	// $('.elgg-river').parent().append('<div class="elgg-ajax-loader"></div>');

// 	var $container = $('.elgg-list-river');

// 	$container.isotope({
//       // options
//       itemSelector : '.elgg-item',
//       layoutMode : 'masonry',
//       masonry: {
//           width: 100
//       }
// 	});

// 	$container.infinitescroll({
//         navSelector  : '.elgg-pagination',    // selector for the paged navigation 
//         nextSelector : '.elgg-pagination li:last-child a',  // selector for the NEXT link (to page 2)
//         itemSelector : '.elgg-item',     // selector for all items you'll retrieve
//         loading: {
//             finishedMsg: 'No more pages to load.',
//             img: 'http://i.imgur.com/qkKy8.gif'
//           }
//         },
//         // call Isotope as a callback
//         function( newElements ) {
//           $container.isotope( 'appended', $( newElements ) ); 
//         }
//       );

// 	$('.elgg-list-river').css({'visibility': 'visible'});
// }

elgg.spiffyactivity.filtrate_init = function(hook, type, params, value) {
    var $container = $('.elgg-list-river');

    if ($container.data('isIsotope')) {
        $container.isotope('destroy');  
    }
    
    $container.isotope({
        // options
        itemSelector : '.elgg-item',
        layoutMode : 'masonry',
        masonry: {
            width: 100
        }
    });

    $container.data('isIsotope', true);
}

elgg.spiffyactivity.filtrate_infinite = function(hook, type, params, value) {
    params.container.isotope('appended', params.items);
}

//elgg.register_hook_handler('init', 'system', elgg.spiffyactivity.init);
elgg.register_hook_handler('content_loaded', 'filtrate', elgg.spiffyactivity.filtrate_init);
elgg.register_hook_handler('infinite_loaded', 'filtrate', elgg.spiffyactivity.filtrate_infinite);
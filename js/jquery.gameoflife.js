/**
 * Game of Life in PHP
 * @package webworker01\gameoflife
 * @author webworker01 <webworker@live.com>
 * @since jQuery 1.10.x+ 1/22/14 2:27 PM
 * @license http://opensource.org/licenses/MIT
 * @copyright Copyright © webworker01 <webworker@live.com> 2014
 * @link http://en.wikipedia.org/wiki/Conway's_Game_of_Life#Rules Rules of the game
 */

/**
 * This plugin implementation depends on the server to provide updated coordinates
 *
 * Usage:
 * $('#mapdiv').gameoflife({
 *      xSize: 80, //Should match size in PHP
 *      ySize: 75, //Should match size in PHP
 *      coordinates: startingCoordinates, //Coordinates in 2D JSON format
 *      ajaxPath: './tick'
 * });
 *
 */
(function( $ ) {
    var autoReload = true;

    $.fn.gameoflife = function(options) {

        //Set up default options and import user defined options
        var settings = $.extend({
            xSize: 80,
            ySize: 75,
            coordinates: [[0]],
            ajaxPath: './'
        }, options );

        var mapElement = this;

        //First draw
        drawmap(mapElement, settings.xSize, settings.coordinates);

        refreshmap(settings.ajaxPath, mapElement, settings.xSize);
    }

    function refreshmap(path, mapElement, xSize) {
        if (autoReload) {
            $.ajax({
                url : path,
                type : 'POST',
                data : encodeURI('ajax=ajax'),
                dataType : 'json',
                timeout : 20000,
                error : function(obj, errortype, errormessage) {
                    $('#debug').html('Tick failed');
                },
                success: function(data) {
                    $(mapElement).html('');
                    drawmap(mapElement, xSize, data);
                    refreshmap(mapElement, xSize);
                }
            });
        }
    }

    function drawmap (mapElement, xSize, coordinates) {
        $.each(coordinates, function (row) {
            $.each(this, function (index, value) {
                if (value == 0) {
                    mapElement.append('<span class="off" data-x="'+index+'" data-y="'+row+'">&nbsp;&nbsp;</span>');
                } else {
                    mapElement.append('<span class="on" data-x="'+index+'" data-y="'+row+'">&#9608;&#9608;</span>');
                }

                if (index+1 == xSize) {
                    mapElement.append('<br>');
                }
            });
        });
    }
})( jQuery );

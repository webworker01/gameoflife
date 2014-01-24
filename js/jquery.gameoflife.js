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

        setInterval(function() {
            //refreshmap(settings.ajaxPath, mapElement, settings.xSize);
            newCoordinates = refreshmap(settings.coordinates);

            $(mapElement).html('');
            drawmap(mapElement, settings.xSize, newCoordinates);
        }, 1);
    }

    //function refreshmap(path, mapElement, xSize) {
    function refreshmap(coordinates) {
        /*
         * Any live cell with fewer than two live neighbours dies, as if caused by under-population.
         * Any live cell with two or three live neighbours lives on to the next generation.
         * Any live cell with more than three live neighbours dies, as if by overcrowding.
         * Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.
         */
        //Parse the existing state of the map for the game rules
        var newMap = Array();
        $.each(coordinates, function (x) {
            var rowMap = Array();
            $.each(this, function (y, value) {

                $('#debug').html(x + ' ' + y);

                var liveNeighbors =
                    ((typeof coordinates[(x)-1] == 'undefined' || typeof coordinates[(x)-1][(y)-1] == 'undefined') ? 0 : coordinates[(x)-1][(y)-1])
                        + ((typeof coordinates[x] == 'undefined' || typeof coordinates[x][(y)-1] == 'undefined') ? 0 : coordinates[x][(y)-1])
                        + ((typeof coordinates[(x)+1] == 'undefined' || typeof coordinates[(x)+1][(y)-1] == 'undefined') ? 0 : coordinates[(x)+1][(y)-1])
                        + ((typeof coordinates[(x)-1] == 'undefined' || typeof coordinates[(x)-1][y]  == 'undefined') ? 0 : coordinates[(x)-1][y])
                        + ((typeof coordinates[(x)+1] == 'undefined' || typeof coordinates[(x)+1][y] == 'undefined') ? 0 : coordinates[(x)+1][y])
                        + ((typeof coordinates[(x)-1] == 'undefined' || typeof coordinates[(x)-1][(y)+1] == 'undefined') ? 0 : coordinates[(x)-1][(y)+1])
                        + ((typeof coordinates[x] == 'undefined' || typeof coordinates[x][(y)+1] == 'undefined') ? 0 : coordinates[x][(y)+1])
                        + ((typeof coordinates[(x)+1] == 'undefined' || typeof coordinates[(x)+1][(y)+1] == 'undefined') ? 0 : coordinates[(x)+1][(y)+1])

                if (liveNeighbors < 2) {
                    rowMap[y] = 0;
                } else if (liveNeighbors < 4 && value) {
                    rowMap[y] = 1;
                } else if (liveNeighbors == 3) {
                    rowMap[y] = 1;
                } else {
                    rowMap[y] = 0;
                }
            });

            newMap[x] = rowMap;
        });

        //Persist the updated map
        $.each(newMap, function (x) {
            $.each(this, function (y, value) {
                coordinates[x][y] = value;
            });
        });

        return coordinates;
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

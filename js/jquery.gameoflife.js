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
    $.fn.gameoflife = function(options) {

        //Set up default options and import user defined options
        var settings = $.extend({
            xSize: 80,
            ySize: 75,
            coordinates: [[0]],
            ajaxPath: './'
        }, options );

        var mapElement = this;

        //Create the blank map
        blankmap(mapElement, settings.xSize, settings.ySize);

        $(mapElement).append('<div id="gameoflifeMenu"><a id="seedLink" href="./?seed=true">Reseed</a><br><a id="pause" style="display:none">Pause</a><a id="start">Start</a></div>');

        $('#seedLink').click(function() {
            clearInterval(tick);
        });

        $('#gameoflifeMenu #pause').click(function() {
            clearInterval(tick);
            $(this).hide();
            $('#gameoflifeMenu #start').show();
        });

        $('#gameoflifeMenu #start').click(function() {
            autoReload = true;

            tick = setInterval(function() {
                tickActions(mapElement, settings);
            }, 1);

            $(this).hide();
            $('#gameoflifeMenu #pause').show();
        });

        //First draw
        drawmap(mapElement, settings.coordinates);
    }

    function tickActions(mapElement, settings) {
        newCoordinates = refreshmap(settings.coordinates);
        //$(mapElement).html('');
        drawmap(mapElement, newCoordinates);
    }

    /**
     * Runs the rules for the game
     * @param coordinates
     * @returns {*}
     */
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

    /**
     * Generate a blank grid on the map
     * @param xSize The total width of the grid
     * @param ySize The total height of the grid
     */
    function blankmap(mapElement, xSize, ySize) {

        for (var y=0; y < ySize; y++) {
            var appendString = '';

            for (var x=0; x < xSize ; x++) {
                appendString += '<span class="off" id="cell-'+x+'-'+y+'">&#9608;&#9608;</span>';
            }

            appendString += '<br>';

            mapElement.append(appendString);
        }
    }

    /**
     * Draw the map points
     * @param mapElement the element that contains the map points
     * @param xSize max horizontal size
     * @param coordinates contains all the points on the map and their state
     */
    function drawmap (mapElement, coordinates) {
        $.each(coordinates, function (x) {
            $.each(this, function (y, value) {
                if (value == 0) {
                    $('#cell-'+x+'-'+y).addClass('off').removeClass('on');
                } else {
                    $('#cell-'+x+'-'+y).addClass('on').removeClass('off');
                }
            });
        });
    }
})( jQuery );

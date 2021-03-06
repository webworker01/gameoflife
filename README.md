Game of Life in PHP
===================

This package implements the Game of Life <http://en.wikipedia.org/wiki/Conway's_Game_of_Life>, a mathematical model in the field of cellular automata <http://en.wikipedia.org/wiki/Cellular_automata>.  This field has spawned interesting theories ranging from practical (random number generation) to philosophical <http://www.youtube.com/watch?v=YOxDb_BbXzU>.

In the Game of Life we have a grid (of undetermined size) seeded with a number of cells considered live and arranged in a starting configuration at various points in the grid.  Each live cell in the grid will be represented in the program as a boolean true.

A timer function scans the entire grid and applies the following four simple rules:

1. Any live cell with fewer than two live neighbours dies, as if caused by under-population.
2. Any live cell with two or three live neighbours lives on to the next generation.
3. Any live cell with more than three live neighbours dies, as if by overcrowding.
4. Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.

The timer then continues ad infinitum, applying these rules to all cells in the grid simultaneously.

Getting Started
---------------

To start using this library add the following lines to your composer.json

    "require": {
        "webworker01/gameoflife": "dev-master"
    }

A simple example to get started with the library

    //Add composer autoloader
    require 'vendor/autoload.php';

    use webworker01\gameoflife;

    //See if we have a map stored already for the session
    if (empty($_SESSION['map'])) {
        $map = new webworker01\gameoflife\Map(80, 75);
        $map->seed();
    } else {
        $map = unserialize($_SESSION['map']);
        $map->tick();
    }
    $_SESSION['map'] = serialize($map);

From here you can simply print out some HTML to see the current generation of the map

    <html>
    ...
    <?php echo $map; ?>
    ...
    </html>

Or for a more animated version, use the included jquery plugin in your HTML

    <html>
        <head>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
            <script src="./vendor/webworker01/gameoflife/js/jquery.gameoflife.js"></script>
            <link href="./vendor/webworker01/gameoflife/css/gameoflife.css" rel="stylesheet" type="text/css">
        </head>
        <body>
            <div id="gameoflife"></div>

            <script>
            $(function() {
                $('#gameoflife').gameoflife({
                    coordinates: <?= $map->output('json'); ?>;
                });
            });
            </script>
        </body>
    </html>

Why Another Game of Life?
-------------------------

I'm just doing this for fun and would like to expand my knowledge in the concepts mentioned above.

Future Features
---------------

In this interpretation of the Game of Life we will strive to add some additional functionality, time permitting:

* Add a color based system to cells to add variables such as 
** Longevity of a cell
** "Dead zones" on the grid
** Nomad cells
* Saving interesting starting configurations based on final states of infinite loops of repeated movement
* Allow for user input of some sort to modify the seeding configurations
* Additional views
** Animated GIF/PNG
** HTML5 Canvas

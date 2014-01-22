***REMOVED***

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
* Saving interesting starting configurations based on final states of infinte loops of repeated movement
* Allow for user input of some sort to modify the seeding configurations
* Multiple views
** HTML5 / jQuery
** Animated GIF/PNG
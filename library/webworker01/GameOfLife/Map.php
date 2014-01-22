<?php
namespace webworker01\GameOfLife;
/**
 * Game of Life in PHP
 *
 * @package webworker01\GameOfLife
 * @author ***REMOVED***
 * @since 20140121
 * @copyright Copyright © ***REMOVED*** 2014
 * @link http://en.wikipedia.org/wiki/Conway's_Game_of_Life#Rules Rules of the game
 */

/**
 * Class Map
 *
 */
class Map
{
    public $xSize;
    public $ySize;

    /**
     * When instantiating the map
     *
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->xSize = $x;
        $this->ySize = $y;
    }

    /**
     * Do what needs to be done to create the next transition
     *
     * Any live cell with fewer than two live neighbours dies, as if caused by under-population.
     * Any live cell with two or three live neighbours lives on to the next generation.
     * Any live cell with more than three live neighbours dies, as if by overcrowding.
     * Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.
     *
     * @param Array $oldMap A two dimensional array holding the previous map to run life transitions against
     * @return Array $newMap A two dimensional array holding the next iteration of the map
     */
    public function step(Array $oldMap)
    {
        foreach ($oldMap as $xCoordinates => $yCoordinateData) {
            foreach ($yCoordinateData as $yCoordinate) {

            }
        }

        return $newMap;
    }
}

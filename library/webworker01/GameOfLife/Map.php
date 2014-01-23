<?php
/**
 * Game of Life in PHP
 *
 * @package webworker01\GameOfLife
 * @author webworker@live.com
 * @since PHP 5.4.x 1/21/14 5:17 PM
 * @copyright Copyright © ***REMOVED*** 2014
 * @link http://en.wikipedia.org/wiki/Conway's_Game_of_Life#Rules Rules of the game
 */

namespace webworker01\GameOfLife;

/**
 * Class Map
 * Represents the map in the game
 * @package webworker01\GameOfLife
 */
class Map
{
    /**
     * The total number of points across in the map
     * @var int|int
     */
    protected $xSize;

    /**
     * The total number of points vertical in the map
     * @var int|int
     */
    protected $ySize;

    /**
     * Collection of all cells in the map
     * @var Array
     */
    protected $cells;

    /**
     * When instantiating the map
     *
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
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
     */
    public function tick()
    {

        //Parse the existing state of the map for the game rules
        for ($y = 0; $y < $this->ySize; $y++) {
            for ($x = 0; $x < $this->xSize; $x++) {

                $liveNeighbors = $this->cells[$x-1][$y-1]->state + $this->cells[$x][$y-1]->state + $this->cells[$x+1][$y-1]->state
                                + $this->cells[$x-1][$y]->state + $this->cells[$x+1][$y]->state
                                + $this->cells[$x-1][$y+1]->state + $this->cells[$x][$y+1]->state + $this->cells[$x+1][$y+1]->state;

                if ($liveNeighbors < 2) {
                    $this->cells[$x][$y]->setState(0);
                } elseif ($liveNeighbors < 4) {
                    $this->cells[$x][$y]->setState(1);
                } elseif ($liveNeighbors == 3) {
                    $this->cells[$x][$y]->setState(1);
                } else {
                    $this->cells[$x][$y]->setState(0);
                }
            }
        }

        //Persist the updated map
        for ($y = 0; $y < $this->ySize; $y++) {
            for ($x = 0; $x < $this->xSize; $x++) {
                $this->cells[$x][$y]->persist();
            }
        }
    }

    /**
     * Set up the map with initial values
     */
    public function seed()
    {
        for ($y = 0; $y < $this->ySize; $y++) {
            for ($x = 0; $x < $this->xSize; $x++) {
                $this->cells[$x][$y] = new Cell($x, $y, mt_rand(0, 1));
            }
        }
    }

    /**
     * Simple string based html output of the current map
     * @return string Contains the current map in string form
     */
    public function __toString()
    {
        $stringOutput = '';

        for ($y = 0; $y < $this->ySize; $y++) {
//            $stringOutput .= sprintf("%02d", $y).' - ';
            for ($x = 0; $x < $this->xSize; $x++) {
                if ($this->cells[$x][$y]->state == false) {
                    $stringOutput .= '&nbsp;';
                } else {
                    $stringOutput .= '&#9608;';
                }
            }

            $stringOutput .= '<br>';
        }

        return $stringOutput;
    }
}

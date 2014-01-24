<?php
/**
 * Game of Life in PHP
 * @package webworker01\gameoflife
 * @author webworker01 <webworker@live.com>
 * @since PHP 5.4.x 1/22/14 2:27 PM
 * @license http://opensource.org/licenses/MIT
 * @copyright Copyright © webworker01 <webworker@live.com> 2014
 * @link http://en.wikipedia.org/wiki/Conway's_Game_of_Life#Rules Rules of the game
 */

namespace webworker01\gameoflife;

/**
 * Class Map
 * Represents the map in the game
 * @package webworker01\gameoflife
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
     * Set up the map with initial values
     */
    public function seed()
    {
        for ($y = 0; $y < $this->ySize; $y++) {
            for ($x = 0; $x < $this->xSize; $x++) {

                $random = mt_rand(0, 100);

                if ($random < 75) {
                    $state = 0;
                } else {
                    $state = 1;
                }

                $this->cells[$x][$y] = new Cell($x, $y, $state);
            }
        }
    }

    /**
     * This method imports a 2D array of points into the object and replaces the existing map if it exists
     * @param $map A two dimensional array of boolean data representing cell states
     */
    public function setCoordinates($map)
    {
        //Create cells from the passed in map
        $this->xSize = count($map);
        $maxRows = 0;

        foreach ($map as $column => $row) {
            foreach ($row as $stateData) {
                $this->cells[$column][$row] = new Cell($x, $y, $stateData);
            }

            $numberRows = count($row);
            if ($numberRows > $maxRows) {
                $maxRows = $numberRows;
            }
        }

        $this->ySize = $maxRows;
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

                $currentState = $this->cells[$x][$y]->state;

                $liveNeighbors = $this->cells[$x-1][$y-1]->state + $this->cells[$x][$y-1]->state + $this->cells[$x+1][$y-1]->state
                                + $this->cells[$x-1][$y]->state + $this->cells[$x+1][$y]->state
                                + $this->cells[$x-1][$y+1]->state + $this->cells[$x][$y+1]->state + $this->cells[$x+1][$y+1]->state;

                if ($liveNeighbors < 2) {
                    $this->cells[$x][$y]->setState(0);
                } elseif ($liveNeighbors < 4 && $currentState) {
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
     * Outputs the current state of the grid in multiple formats
     * @param String $format (array|json) are the current options
     * @return mixed The current state of the grid in the requested format
     */
    public function output($format='array')
    {
        $output = Array();

        switch ($format) {
            case 'json':
                //Persist the updated map
                for ($y = 0; $y < $this->ySize; $y++) {
                    for ($x = 0; $x < $this->xSize; $x++) {
                        $output[$y][$x] = $this->cells[$x][$y]->state;
                    }
                }
                return json_encode($output);
                break;
            case 'array':
            default:
                //Persist the updated map
                for ($y = 0; $y < $this->ySize; $y++) {
                    for ($x = 0; $x < $this->xSize; $x++) {
                        $output[$x][$y] = $this->cells[$x][$y]->state;
                    }
                }

                return $output;
                break;
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
                if ($this->cells[$x][$y]->state < 1) {
                    $stringOutput .= '<span style="background-color:'.$this->cells[$x][$y]->color.'">&nbsp;&nbsp;</span>';
                } else {
                    $stringOutput .= '<span style="color:'.$this->cells[$x][$y]->color.'">&#9608;&#9608;</span>';
                }
            }

            $stringOutput .= '<br>';
        }

        return $stringOutput;
    }
}

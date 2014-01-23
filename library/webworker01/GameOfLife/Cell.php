<?php
/**
 * Game of Life in PHP
 * @package webworker01\GameOfLife
 * @author webworker@live.com
 * @since PHP 5.4.x 1/22/14 2:27 PM
 * @copyright Copyright © Owen Cole 2014
 */

namespace webworker01\GameOfLife;

/**
 * Class Cell
 * Represents an individual cell in the game
 * @package webworker01\GameOfLife
 */
class Cell
{
    /**
     * The x coordinate for this cell
     * @var
     */
    protected $x;

    /**
     * The y coordinate for this cell
     * @var
     */
    protected $y;

    /**
     * Current state of the cell
     * @var
     */
    protected $state;

    public function __construct($x, $y, $state = false)
    {
        $this->x = $x;
        $this->y = $y;
        $this->state = $state;
    }

    public function __get($variable)
    {
        return $this->$variable;
    }
}

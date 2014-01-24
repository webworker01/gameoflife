<?php
/**
 * Game of Life in PHP
 * @package webworker01\gameoflife
 * @author webworker01 <webworker@live.com>
 * @since PHP 5.4.x 1/22/14 2:27 PM
 * @license http://opensource.org/licenses/MIT
 * @copyright Copyright © webworker01 <webworker@live.com> 2014
 */

namespace webworker01\gameoflife;

/**
 * Class Cell
 * Represents an individual cell in the game
 * @package webworker01\gameoflife
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

    /**
     * Stored new state of the cell
     * @var
     */
    protected $newState;

    public function __construct($x, $y, $state = 0)
    {
        $this->x = $x;
        $this->y = $y;
        $this->state = $state;
    }

    /**
     * Setter for the new state
     * @param $state
     */
    public function setState($state)
    {
        $this->newState = $state;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Persist the new state to the actual state
     */
    public function persist()
    {
        $this->state = $this->newState;
    }

    /**
     * Generic getter method
     *
     * @param $variable
     * @return mixed
     */
    public function __get($variable)
    {
        return $this->$variable;
    }
}

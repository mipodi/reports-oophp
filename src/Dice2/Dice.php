<?php

namespace Mipodi\Dice2;

/**
 * Trying out class w methods and properties
 */

class Dice
{
    /**
     * @var integer $dice          A dice.
     * @var array $throwResults    The cast dice results.
     * @var int $lastRoll          Value of the last roll.
     */
    private $dice;
    private $throwResults;
    protected $lastRoll;


    /**
     * Constructor to create a Dice.
     *
     */
    public function __construct()
    {
        $this->dice = 0;
        $this->throwResults = [];
        $this->lastRoll = 0;
    }

    /**
     * Roll the dice X no of times.
     *
     * @param int $throws How many times to throw, default 1
     *
     * @return void
     */
    public function roll(int $throws = 1)
    {
        // $this->throwResults = [];
        $throws = 1;
        for ($i = 0; $i < $throws; $i++) {
            $this->throwResults[] = rand(1, 6);
        }
        $this->lastRoll = end($this->throwResults);
        // var_dump("hello");
        return $this->throwResults;
    }

    /**
     * Roll the dice
     *
     *
     * @return int with result.
     */
    public function rollDice2()         // Varning, lagvidrig lösning!? Temporär.
    {
        return rand(1, 6);
    }

    /**
     * Get all results.
     *
     * @return array with results from all throws.
     */
    public function results()
    {
        // $this->throwResults = [];
        return $this->throwResults;
    }

    /**
     * Get last Roll
     *
     * @return int with last roll.
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}

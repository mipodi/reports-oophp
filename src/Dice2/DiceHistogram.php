<?php

namespace Mipodi\Dice2;

/**
 * A dice which has the ability to present data to be used for creating
 * a histogram.
 */
class DiceHistogram extends Dice implements HistogramInterface
{
    use HistogramTrait;


    // /**
    //  * Get max value for the histogram.
    //  *
    //  * @return int with the max value.
    //  */
    // public function getHistogramMax()
    // {
    //     // return $this->sides;
    //     return $this->dice;
    // }

    /**
     * Roll the dice, remember its value in the serie and
     * return its value.
     *
     * @return int the value of the rolled dice.
     */
    public function rollDice2(int $throws = 1)
    {
        // $this->serie[] = parent::roll();
        $serie[] = parent::roll();
        $this->serie = end($serie);
        return $this->getLastRoll();
    }
}

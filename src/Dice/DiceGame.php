<?php

namespace Mipodi\Dice;

/**
 * A dicehand, consists of dices.
 */
class DiceGame
{
    /**
     * @var DiceHand $diceHands     Array consisting of dices.
     * @var int $values     Array consisting of last roll of the dices.
     */
    private $dices;
    private $tempPoints;
    private $values;
    private $humanPlayerScore;
    private $computerPlayerScore;
    // private $gameStatus;

    /**
     * Constructor to initiate the dice game with a number of players.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $players = 2)
    {
        // $this->dices   = [];
        // $this->values  = [];

        $this->humanPlayerScore     = 0;
        $this->computerPlayerScore  = 0;
        $this->$tempPoints          = 0;

        $this->gameStatus = 0;

        for ($i = 0; $i < $players; $i++) {
            $this->players[]  = new DiceGraphic();
            $this->values[] = null;
        }

        // for ($i = 0; $i < $dices; $i++) {
        //     $this->dices[]  = new Dice();
        //     // $this->values[] = null;
        // }

    }

    /**
     * Check if
     *
     * @return void.
     */
    public function play($gameStatus)
    {
        var_dump($gameStatus);

        if ($gameStatus === "Roll") {
            // echo "hello";
            $dice = new DiceGraphic();
            $rolls = 2;
            $res = [];
            $class = [];

            for ($i = 0; $i < $rolls; $i++) {
                // $res[] = $dice->roll();
                $dice->roll();
                $class[] = $dice->graphic();
            }

            $res = $dice->results();
            if (in_array(1, $res)) {
                $this->tempPoints = 0;
            }

            $this->tempPoints += array_sum($res);
            return $res;

        } elseif ($gameStatus === "Save") {
            // $diceGame->save($res);
            var_dump($this->tempPoints);

            $this->computerPlayerScore += $this->tempPoints;
            // $score = $this->values;
            // $this->computerPlayerScore += $score;
            var_dump($this->computerPlayerScore);
            // $this->values = [];
            // var_dump($this->values);
        }

    }

    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function save($score)
    {
        // $score = implode(", ", $this->values);
        $score = array_sum($score);
        $this->humanPlayerScore += $score;
        // ersätta delar av "human" med en parameter
        var_dump($this->humanPlayerScore);

    }
    //
    //
    // /**
    //  * Roll all dices save their value.
    //  *
    //  * @return void.
    //  */
    // public function roll()
    // {
    //     foreach ($this->dices as $value) {
    //         $this->values[] = $value->rollDice2();
    //     }
    //
    //     // return $this->dices;
    // }
    //
    // /**
    //  * Get values of dices from last roll.
    //  *
    //  * @return array with values of the last roll.
    //  */
    // public function values()
    // {
    //     return $this->values;
    // }
    //
    // /**
    //  * Get the sum of all dices.
    //  *
    //  * @return int as the sum of all dices.
    //  */
    // public function sum()
    // {
    //     return array_sum($this->values);
    // }
    //
    // /**
    //  * Get the average of all dices.
    //  *
    //  * @return float as the average of all dices.
    //  */
    // public function average()
    // {
    //     return array_sum($this->values)/count($this->values);
    // }
}

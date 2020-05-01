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
    private $winner;

    /**
     * Constructor to initiate the dice game with a number of players.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $players = 2)
    {
        $this->humanPlayerScore     = 0;
        $this->computerPlayerScore  = 0;
        $this->$tempPoints          = 0;
        $this->winner               = null;

        for ($i = 0; $i < $players; $i++) {
            $this->players[]  = new DiceGraphic();
            $this->values[] = null;
        }
    }

    /**
     * Check if
     *
     * @return void.
     */
    public function play($gameStatus)
    {
        var_dump($gameStatus);

        if ($gameStatus === "Restart") {
            $this->resetGame();
        } elseif ($gameStatus === "Roll") {
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
                var_dump($this->tempPoints);
                // $res = 0;
                $this->playByComputer();
                // return $res;
            }

            $this->tempPoints += array_sum($res);
            return $res;

        } elseif ($gameStatus === "Save") {
            $this->humanPlayerScore += $this->tempPoints;
            var_dump($this->humanPlayerScore);
            $this->tempPoints = 0;
            $this->playByComputer();
        }

    }

        /**
         * Check if
         *
         * @return void.
         */
        public function playByComputer()
        {
            echo "I'm the computer and I'm playing.";
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

            if ($this->computerPlayerScore += array_sum($res) >=10) {
                $res = 0;
                $this->finishGame();
                return $res;
            }

            if (in_array(1, $res)) {
                $this->tempPoints = 0;
                var_dump($this->tempPoints);
                $res = 0;
                return $res;
            }

            $this->tempPoints += array_sum($res);
            $this->computerPlayerScore += $this->tempPoints;
            var_dump("Computer score" . $this->computerPlayerScore);
            $this->tempPoints = 0;

            $res = null;
            return $res;
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

    /**
     * Save point values to the record.
     *
     * @return int.
     */
    public function humanScore()
    {
        return $this->humanPlayerScore;
    }

    /**
     * Save point values to the record.
     *
     * @return int.
     */
    public function computerScore()
    {
        return $this->computerPlayerScore;
    }

    /**
     * Save point values to the record.
     *
     * @return int.
     */
    public function tempScore()
    {
        return $this->tempPoints;
    }

    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function resetGame()
    {
        // echo "hello resets game";
        $this->humanPlayerScore = 0;
        $this->computerPlayerScore = 0;
    }

    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function finishGame()
    {
        // echo "hello resets game";
        $this->winner = "We have a winner!";
    }

    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function isWinner()
    {
        return $this->winner;
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

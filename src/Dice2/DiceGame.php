<?php

namespace Mipodi\Dice2;

/**
 * Dice game, orchestrates a game of dices.
 */
class DiceGame
{
    use HistogramTrait;
    /**
     * @var DiceHand $diceHands     Array consisting of dices.
     * @var int $values     Array consisting of last roll of the dices.
     */
    // private $dices;
    // private $values;
    private $humanDices;
    private $computerDices;
    private $humanPlayerScore;
    private $computerPlayerScore;
    private $tempPoints;
    private $humanLatestRoll;
    private $computerLatestRoll;
    private $winner;
    private $humanThrows;
    private $computerThrows;

    private $humanHistogram;
    private $computerHistogram;
    private $riskyAiCounter;
    private $safeAiCounter;

    /**
     * Constructor to initiate the dice game with a number of players.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct()
    {
        $this->humanPlayerScore     = 0;
        $this->computerPlayerScore  = 0;
        $this->winner               = null;

        for ($i = 0; $i < 2; $i++) {
            $this->humanDices[] = new DiceHistogram();
            $this->computerDices[] = new DiceHistogram();
        }

        $this->humanHistogram = new Histogram();
        $this->computerHistogram = new Histogram();

        $this->computerThrows = [];
        $this->riskyAiCounter = 4;
        $this->safeAiCounter = 1;
        // var_dump($this->humanHistogram);
    }

    /**
     * Run the game with human player as base
     *
     * @return void.
     */
    public function play($gameStatus)
    {
        $this->computerLatestRoll = null;

        if ($gameStatus === "Restart") {
            $this->resetGame();
        } elseif ($gameStatus === "Roll") {

            foreach ($this->humanDices as $value) {
                $this->humanThrows[] = $value->rollDice2();
                $this->humanHistogram->injectData($value);
                // var_dump($value);
            }

            // $this->humanHistogram;
            // var_dump($this->humanThrows);
            // var_dump($this->humanHistogram->getAsText(1, 6));
            // var_dump($this->humanDices);

            $res = array_slice($this->humanThrows, -2);
            $this->humanLatestRoll = $res;

            if (in_array(1, $res)) {
                $this->tempPoints = 0;
                $this->playByComputer();
                return;
            }

            $this->tempPoints += array_sum($res);
            return $res;
        } elseif ($gameStatus === "Save") {
            $this->humanPlayerScore += $this->tempPoints;

            if ($this->humanPlayerScore >= 100) {
                $this->finishGame();
                return;
            }

            $this->tempPoints = 0;
            $this->playByComputer();
        }
        // $histogram->injectData($dice);

    }

    /**
     * Check if
     *
     * @return void.
     */
    public function playByComputer()
    {
        $this->tempPoints = 0;
        foreach ($this->computerDices as $value) {
            $this->computerThrows[] = $value->rollDice2();
        }

        $res = array_slice($this->computerThrows, -2);

        if (in_array(1, $res)) {
            $this->computerLatestRoll = $res;
            $this->tempPoints = 0;
        } elseif (!in_array(1, $res)) {
            if (($this->computerPlayerScore + array_sum($res)) >= 100) {
                $this->finishGame();
            }

            if ($this->humanPlayerScore > $this->computerPlayerScore) {
                for ($i=0; $i < $this->riskyAiCounter; $i++) {
                    $this->playByComputer();
                    $this->riskyAiCounter -= $this->riskyAiCounter;
                }
            } elseif ($this->humanPlayerScore < $this->computerPlayerScore) {
                for ($i=0; $i < $this->safeAiCounter; $i++) {
                    $this->playByComputer();
                    $this->safeAiCounter -= $this->safeAiCounter;
                }
            }
            $this->tempPoints += array_sum($res);
            $this->computerLatestRoll = $res;
            $this->computerPlayerScore += $this->tempPoints;
            $this->tempPoints = 0;
        }
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
    public function getHumanLatestRoll()
    {
        return $this->humanLatestRoll;
    }


    /**
     * Save point values to the record.
     *
     * @return int.
     */
    public function getComputerLatestRoll()
    {
        return $this->computerLatestRoll;
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
        $this->winner = "Game over!";
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


    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function humanThrows()
    {
        // var_dump($this->humanHistogram->getAsText());
        $this->humanHistogram->getSerie();
        return $this->humanHistogram->getAsText();
        // return $this->humanHistogram->getSerie();
        // return implode(", ", $this->histogram->getSerie());
        // return $this->humanThrows;
    }

    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function computerThrows()
    {
        // return $this->computerThrows;
        return null;
    }


    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function testInterface()
    {
        $rolls = 6;

        $dice = new DiceHistogram();

        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $histogram = new Histogram();
        $histogram->injectData($dice);

        return $histogram;
    }


    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function printComputerHistogram(int $min = null, int $max = null)
    {
        $starHistogram = "";
        $baseArray = [
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
            6 => null
        ];

        // print_r($baseArray);

        $diceSerie = $this->computerThrows;
        // ksort($diceSerie);
        // print_r($diceSerie);

        $diceSerie = array_count_values($diceSerie);
        ksort($diceSerie);
        // print_r($diceSerie);

        if ($min && $max) {
            $diceSerie = array_replace($baseArray, $diceSerie);
            $diceSerie = array_slice($diceSerie, $min - 1, $max - 2, true);
        }

        foreach (array_keys($diceSerie) as $key) {
                $starHistogram .= $key. ": ";

            for ($star = 0; $star < $diceSerie[$key]; $star++) {
                $starHistogram .= "*";
            }
            $starHistogram .= "\r\n";
        }
        return $starHistogram;
    }

    /**
     * Save point values to the record.
     *
     * @return void.
     */
    public function printHumanHistogram(int $min = null, int $max = null)
    {
        $starHistogram = "";
        $baseArray = [
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
            6 => null
        ];

        // print_r($baseArray);

        $diceSerie = $this->humanThrows;
        // ksort($diceSerie);
        // print_r($diceSerie);

        $diceSerie = array_count_values($diceSerie);
        ksort($diceSerie);
        // print_r($diceSerie);

        if ($min && $max) {
            $diceSerie = array_replace($baseArray, $diceSerie);
            $diceSerie = array_slice($diceSerie, $min - 1, $max - 2, true);
        }

        foreach (array_keys($diceSerie) as $key) {
                $starHistogram .= $key. ": ";

            for ($star = 0; $star < $diceSerie[$key]; $star++) {
                $starHistogram .= "*";
            }
            $starHistogram .= "\r\n";
        }
        return $starHistogram;
    }
}

<?php

namespace Mipodi\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    private $number;
    private $tries;

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $tries = 6)
    {
        // $this->number = $number;
        $this->number = rand(1, 100);
        $this->tries = $tries;
    }
    // public function __construct(int $number = -1, int $tries = 6)
    // {
    //     // $this->number = $number;
    //     $this->number = rand(1, 100);
    //     $this->tries = $tries;
    // }


    // /**
    //  * Randomize the secret number between 1 and 100 to initiate a new game.
    //  *
    //  * @return void
    //  */
    // public function random()
    // {
    //     return rand(1, 100);
    // }



    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries()
    {
        return $this->tries;
    }

    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * Reset tries and number.
     *
     * @return void
     */
    public function resetGame()
    {
        $this->number = rand(1, 100);
        $this->tries = 6;
    }

    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess(int $guess)
    {
        // var_dump($guess);
        // var_dump($this->number);
        // $guess = intval($guess);

        if ($guess < 1 || $guess > 100) {
            throw new GuessException("Guess is only allowed integer between 1 and 100");
        }

        $this->tries -= 1;
        if ($guess === $this->number) {
            $res = "CORRECT";
        } elseif ($guess > $this->number) {
            $res = "TOO HIGH";
        } else {
            $res = "TOO LOW";
        }
        return $res;
    }
}

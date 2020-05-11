<?php

namespace Mipodi\Dice2;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGameReturnScoresTest extends TestCase
{
    /**
     * Construct object and check if method works
     * by returning integer.
     */
    public function testHumanScore()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Mipodi\Dice2\DiceGame", $diceGame);

        // $diceGame->play("doRoll");
        // $diceGame->play("doSave");
        $res = $diceGame->humanScore();

        $this->assertIsInt($res);
    }

    /**
     * Construct object and check if method works
     * by returning integer.
     */
    public function testComputerScore()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Mipodi\Dice2\DiceGame", $diceGame);

        // $diceGame->play("doRoll");
        // $diceGame->play("doSave");
        $res = $diceGame->computerScore();

        $this->assertIsInt($res);
    }

    /**
     * Construct object and check if method works
     * by being null between runs.
     */
    public function testTempScore()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Mipodi\Dice2\DiceGame", $diceGame);

        $diceGame->play("doRoll");
        $diceGame->play("doSave");
        $res = $diceGame->tempScore();

        $this->assertNull($res);
    }

    // /**
    //  * Construct object and check if method works
    //  * by returning integer.
    //  */
    // public function testGetHumanLatestRoll()
    // {
    //     $diceGame = new DiceGame();
    //     $this->assertInstanceOf("\Mipodi\Dice\DiceGame", $diceGame);
    //
    //     $diceGame->play("doRoll");
    //     $diceGame->play("doRoll");
    //     $diceGame->play("doSave");
    //     $res = $diceGame->getHumanLatestRoll();
    //
    //     var_dump($res);
    //     $this->assertIsArray($res);
    // }
}

<?php

namespace Mipodi\Dice2;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGamePrintHistoTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testPrintHumanHistogram()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Mipodi\Dice2\DiceGame", $diceGame);

        $diceGame->play("doRoll");
        $diceGame->setHumanThrows();
        $res = $diceGame->printHumanHistogram(1, 8);

        $this->assertIsString($res);
        // $res = $guess->tries();
        // $exp = 6;
        // $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testPrintComputerHistogram()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Mipodi\Dice2\DiceGame", $diceGame);

        $diceGame->play("doRoll");
        $diceGame->setComputerThrows();
        $res = $diceGame->printComputerHistogram(1, 8);

        $this->assertIsString($res);
        // $res = $guess->tries();
        // $exp = 6;
        // $this->assertEquals($exp, $res);
    }

    //
    // /**
    //  * Construct object and verify that the object has the expected
    //  * properties. Use only first argument.
    //  */
    // public function testCreateObjectFirstArgument()
    // {
    //     $guess = new Guess(42);
    //     $this->assertInstanceOf("\Mipodi\Guess\Guess", $guess);
    //
    //     $res = $guess->tries();
    //     $exp = 6;
    //     $this->assertEquals($exp, $res);
    //
    //     $res = $guess->number();
    //     $exp = 42;
    //     $this->assertEquals($exp, $res);
    // }
    //
    //
    //
    // /**
    //  * Construct object and verify that the object has the expected
    //  * properties. Use both arguments.
    //  */
    // public function testCreateObjectBothArguments()
    // {
    //     $guess = new Guess(42, 7);
    //     $this->assertInstanceOf("\Mipodi\Guess\Guess", $guess);
    //
    //     $res = $guess->tries();
    //     $exp = 7;
    //     $this->assertEquals($exp, $res);
    //
    //     $res = $guess->number();
    //     $exp = 42;
    //     $this->assertEquals($exp, $res);
    // }
}

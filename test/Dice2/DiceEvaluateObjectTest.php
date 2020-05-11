<?php

namespace Mipodi\Dice2;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceEvaluateObjectTest extends TestCase
{
    /**
     * Construct object and check if roll method works
     * by returning an array.
     */
    public function testRollDice()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Mipodi\Dice2\Dice", $dice);

        $res = $dice->roll();

        $this->assertIsArray($res);
    }

    /**
     * Construct object and check if results method works
     * by returning an array.
     */
    public function testgetResults()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Mipodi\Dice2\Dice", $dice);

        $res = $dice->results();

        $this->assertIsArray($res);
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

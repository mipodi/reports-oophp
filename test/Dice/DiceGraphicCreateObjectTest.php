<?php

namespace Mipodi\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGraphicCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateDiceGraphicObjectNoArguments()
    {
        $dice = new DiceGraphic();
        $this->assertInstanceOf("\Mipodi\Dice\DiceGraphic", $dice);

        // $res = $guess->tries();
        // $exp = 6;
        // $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that upon a roll of the dice
     * the object creates strings to use for class names.
     */
    public function testGetGraphicSides()
    {
        $dice = new DiceGraphic();
        $dice->roll();
        $res = $dice->graphic();

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

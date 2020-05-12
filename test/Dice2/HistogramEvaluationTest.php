<?php

namespace Mipodi\Dice2;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class HistogramEvaluationTest extends TestCase
{
    /**
     * Construct object and check if roll method works
     * by returning an array.
     */
    public function testGetSerieHistogram()
    {

        $rolls = 6;
        $dice = new Dice();

        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $histogram = new Histogram();
        $this->assertInstanceOf("\Mipodi\Dice2\Histogram", $histogram);

        $this->assertIsArray($histogram->getSerie());
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testGetAsTextNoArguments()
    {

        $rolls = 6;
        $dice = new Dice();

        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $histogram = new Histogram();
        $this->assertInstanceOf("\Mipodi\Dice2\Histogram", $histogram);

        $this->assertIsString($histogram->getAsText());
        // $diceGame = new DiceGame();
        // $this->assertInstanceOf("\Mipodi\Dice2\DiceGame", $diceGame);
        //
        // $diceGame->play("doRoll");
        // $diceGame->setHumanThrows();
        // $res = $diceGame->printHumanHistogram(1, 8);
        //
        // $this->assertIsString($res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testGetAsTextWithArguments()
    {
        $rolls = 6;
        $dice = new Dice();

        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $histogram = new Histogram();
        $this->assertInstanceOf("\Mipodi\Dice2\Histogram", $histogram);

        $this->assertIsString($histogram->getAsText(1, 6));
    }
}

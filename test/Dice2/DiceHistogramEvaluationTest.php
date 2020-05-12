<?php

namespace Mipodi\Dice2;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHistogramEvaluationTest extends TestCase
{
    /**
     * Test that the superimposed roll dice-method works
     * by testing if its method returns an array.
     */
    public function testSuperimposeRollDice2()
    {
        $dice = new DiceHistogram();
        $res = $dice->rollDice2();

        $histogram = new Histogram();
        $this->assertInstanceOf("\Mipodi\Dice2\Histogram", $histogram);

        $this->assertIsArray($histogram->getSerie());
        $this->assertIsInt($res);
    }
}

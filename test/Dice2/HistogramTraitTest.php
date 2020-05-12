<?php

namespace Mipodi\Dice2;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class HistogramTraitTest extends TestCase
{
    /**
     * Test that getHistogramSerie works in Trait
     * by testing if its method returns an array.
     */
    public function testGetSerie()
    {
        $rolls = 6;
        $dice = new DiceHistogram();

        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $res = $dice->getHistogramSerie();

        $this->assertIsArray($res);
    }

    /**
     * Test that getHistogramSerie works in Trait
     * by testing if its method returns an array.
     */
    public function testGetHistogramMin()
    {
        $rolls = 6;
        $dice = new DiceHistogram();

        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $res = $dice->getHistogramMin();

        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    // /**
    //  * Test that getHistogramSerie works in Trait
    //  * by testing if its method returns an array.
    //  */
    // public function testGetHistogramMax()
    // {
    //     $rolls = 6;
    //     $dice = new DiceHistogram();
    //
    //     for ($i = 0; $i < $rolls; $i++) {
    //         $dice->roll();
    //     }
    //
    //     $res = $dice->getHistogramMax();
    //     $this->assertIsInt($res);
    // }

    /**
     * Test that getHistogramSerie works in Trait
     * by testing if its method returns an array.
     */
    public function testPrintHistogramNoArguments()
    {
        $rolls = 6;
        $dice = new DiceHistogram();

        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $res = $dice->printHistogram();
        $this->assertIsString($res);
    }

    /**
     * Test that getHistogramSerie works in Trait
     * by testing if its method returns an array.
     */
    public function testPrintHistogramWithArguments()
    {
        $rolls = 6;
        $dice = new DiceHistogram();

        for ($i = 0; $i < $rolls; $i++) {
            $dice->roll();
        }

        $res = $dice->printHistogram(1, 6);

        $firstPart = substr($res, 0, 1);
        $this->assertTrue($firstPart === "1");
    }
}

<?php

namespace Mipodi\Dice2;

/**
 * A trait implementing HistogramInterface.
 *
 */
trait HistogramTrait
{
    /**
     * @var array $serie The numbers store in sequence.
     */
    private $serie = [];

    /**
     * Get the serie.
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }

    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin()
    {
        return 1;
    }

    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return max($this->serie);
    }


    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     * @return string representing the histogram.
     */
    public function printHistogram(int $min = null, int $max = null)
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

        $diceSerie = $this->serie;
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

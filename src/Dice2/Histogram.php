<?php

namespace Mipodi\Dice2;

/**
 * Generating histogram data.
 *
 */
class Histogram
{
    /**
     * @var array   $serie  The numbers store in sequence.
     * @var int     $min    The lowest possible number.
     * @var int     $max    The highest possible number.
     */
    private $serie = [];
    // private $min;
    // private $max;

    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText(int $min = null, int $max = null)
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

    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}

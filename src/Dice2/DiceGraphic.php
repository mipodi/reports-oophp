<?php

namespace Mipodi\Dice2;

// /**
//  * A graphic dice, simple way
//  */
// class DiceGraphic extends Dice
// {
//     /**
//      * Constructor to initiate the dice with six number of sides.
//      */
//     public function __construct()
//     {
//         parent::__construct(6);
//     }
// }


/**
 * A graphic dice, PSR-1 compatible
 */
class DiceGraphic extends Dice
{
    /**
     * @var integer SIDES Number of sides of the Dice.
     */
    const SIDES = 6;

    /**
     * Constructor to initiate the dice with six number of sides.
     */
    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    /**
     * Get a graphic value of the last rolled dice.
     *
     * @return string as graphical representation of last rolled dice
     */
    public function graphic()
    {
        // return "dice-" . $this->getLastRoll();
        // Can now access protected property instead, changed parent from private
        return "dice-" . $this->lastRoll;
    }
}

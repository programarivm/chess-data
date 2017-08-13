<?php
namespace PGNChess;

use PGNChess\PGN;

/**
 * Performs statistics operations regarding the squares of the board.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license MIT
 */
class SquareStats
{
    /**
     * Calculates the free/used squares.
     *
     * @param array $pieces
     * @return stdClass
     */
    public static function calc(array $pieces)
    {
        return (object) [
            'used' => self::getUsed($pieces),
            'free' => self::getFree($pieces)
        ];
    }

    /**
     * Returns all the board's squares.
     *
     * @return array
     */
    private static function getAll()
    {
        $squares = [];

        for($i=0; $i<8; $i++) {
            for($j=1; $j<=8; $j++) {
                $squares[] = chr((ord('a') + $i)) . $j;
            }
        }

        return $squares;
    }

    /**
     * Returns the squares currently being used by both players.
     *
     * @return array
     */
    private static function getUsed(array $pieces)
    {
        $squares = (object) [
            Symbol::COLOR_WHITE => [],
            Symbol::COLOR_BLACK => []
        ];

        foreach ($pieces as $piece) {
            $squares->{$piece->getColor()}[] = $piece->getPosition()->current;
        }

        return $squares;
    }

    /**
     * Returns the free squares.
     *
     * @return array
     */
    private static function getFree(array $pieces)
    {
        $usedSquares = self::getUsed($pieces);

        return array_values(
            array_diff(
                self::getAll(),
                array_merge($usedSquares->{Symbol::COLOR_WHITE}, $usedSquares->{Symbol::COLOR_BLACK})
        ));
    }
}
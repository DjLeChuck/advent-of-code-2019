<?php

declare(strict_types=1);

namespace App\Resolvers\Y2017;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D03 implements ResolverInterface
{
    // https://stackoverflow.com/a/6633113/622843
    // A few constants.
    private const DOWN = 0;
    private const LEFT = 3;
    private const RIGHT = 1;
    private const UP = 2;

    private ?int $secondPartResult = null;

    public function resolve(array $input): Solution
    {
        $value = (int) current($input);
        $spiralData = $this->getSpiral(550, $value);
        [$spiral, $origin] = $spiralData;

        $coordinates = $this->getCoordinates($value, $spiral);

        return new Solution($this->distance($origin, $coordinates), $this->secondPartResult);
    }

    /**
     * Manhattan (aka "Taxicab") distance metric between two vectors
     *
     * The Manhattan (or Taxicab) distance is defined as the sum of the
     * absolute differences between the vector coordinates, and akin to
     * the type of path that one takes when walking around a city block.
     *
     * This distance is defined as
     * D = SUM( ABS(vector1(i) - vector2(i)) )    (i = 0..k)
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Manhattan_distance
     * - http://xlinux.nist.gov/dads/HTML/manhattanDistance.html
     * - http://mathworld.wolfram.com/TaxicabMetric.html
     *
     * @param array $vector1 first vector
     * @param array $vector2 second vector
     *
     * @return int The Manhattan distance between vector1 and vector2
     */
    private function distance(array $vector1, array $vector2): int
    {
        $n = count($vector1);
        $sum = 0;

        for ($i = 0; $i < $n; $i++) {
            $sum += abs($vector1[$i] - $vector2[$i]);
        }

        return (int) $sum;
    }

    private function getSpiral(int $size, int $inputForTwo): array
    {
        $spiral = [];
        $spiral2 = [];

        // The initial number.
        $number = 1;

        // The initial direction.
        $direction = self::RIGHT;

        // The distance and number of points remaining before switching direction.
        $remain = $distance = 1;

        // The initial "x" and "y" point.
        $y = $x = round($size / 2);
        $origin = [$x, $y];

        // The dimension of the spiral.
        $dimension = $size * $size;

        $number2 = 1;

        // Loop
        for ($count = 0; $count < $dimension; $count++) {
            // Add the current number to the "x" and "y" coordinates.
            $spiral[$x][$y] = $number;

            if (null === $this->secondPartResult) {
                $spiral2[$x][$y] = $number2;
            }

            // Depending on the direction, set the "x" or "y" value.
            switch ($direction) {
                case self::LEFT:
                    $y--;
                    break;
                case self::UP:
                    $x++;
                    break;
                case self::DOWN:
                    $x--;
                    break;
                case self::RIGHT:
                    $y++;
                    break;
            }

            // If the distance remaining is "0", switch direction.
            if (--$remain === 0) {
                switch ($direction) {
                    case self::DOWN:
                        $direction = self::LEFT;
                        $distance++;

                        break;
                    case self::UP:
                        $distance++;
                    // cascade
                    default:
                        $direction--;

                        break;
                }

                // Reset the distance remaining.
                $remain = $distance;
            }

            $number++;

            if (null === $this->secondPartResult) {
                $number2 = $this->getNumber2($spiral2, $x, $y);

                if ($number2 > $inputForTwo) {
                    $this->secondPartResult = $number2;
                }
            }
        }

        // Sort by "x" numerically.
        ksort($spiral, SORT_NUMERIC);

        foreach ($spiral as &$x) {
            // Sort by "y" numerically.
            ksort($x, SORT_NUMERIC);
        }

        return [
            $spiral,
            $origin,
        ];
    }

    private function getNumber2($spiral, $x, $y): int
    {
        $number2 = 0;

        $number2 += !empty($spiral[$x - 1][$y]) ? $spiral[$x - 1][$y] : 0;
        $number2 += !empty($spiral[$x - 1][$y - 1]) ? $spiral[$x - 1][$y - 1] : 0;
        $number2 += !empty($spiral[$x][$y - 1]) ? $spiral[$x][$y - 1] : 0;
        $number2 += !empty($spiral[$x + 1][$y]) ? $spiral[$x + 1][$y] : 0;
        $number2 += !empty($spiral[$x + 1][$y + 1]) ? $spiral[$x + 1][$y + 1] : 0;
        $number2 += !empty($spiral[$x][$y + 1]) ? $spiral[$x][$y + 1] : 0;
        $number2 += !empty($spiral[$x - 1][$y + 1]) ? $spiral[$x - 1][$y + 1] : 0;
        $number2 += !empty($spiral[$x + 1][$y - 1]) ? $spiral[$x + 1][$y - 1] : 0;

        return $number2;
    }

    /**
     * Renvoie les coordonnées du nombre demandé dans la spirale.
     *
     * @param int   $number Nombre recherché
     * @param array $spiral Le spirale de nombres
     *
     * @return array|null
     */
    private function getCoordinates(int $number, array $spiral): ?array
    {
        foreach ($spiral as $x => $row) {
            foreach ($row as $y => $value) {
                if ($number === $value) {
                    return [$x, $y];
                }
            }
        }

        return null;
    }
}

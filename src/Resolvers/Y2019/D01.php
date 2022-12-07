<?php

declare(strict_types=1);

namespace App\Resolvers\Y2019;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D01 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        // $assertions = [
        //     'one' => [
        //         12     => 2,
        //         14     => 2,
        //         1969   => 654,
        //         100756 => 33583,
        //     ],
        //     'two' => [
        //         12     => 2,
        //         14     => 2,
        //         1969   => 966,
        //         100756 => 50346,
        //     ],
        // ];
        //
        // foreach ($assertions['one'] as $mass => $expectation) {
        //     $fuel = $this->calculateFuel($mass, false);
        //
        //     if ($fuel !== $expectation) {
        //         dump(
        //             sprintf('Error for the mass %u in assertion one. Expect %u but got %u.', $mass, $expectation, $fuel)
        //         );
        //     }
        // }
        //
        // foreach ($assertions['two'] as $mass => $expectation) {
        //     $fuel = $this->calculateFuel($mass, true);
        //
        //     if ($fuel !== $expectation) {
        //         dump(
        //             sprintf('Error for the mass %u in assertion two. Expect %u but got %u.', $mass, $expectation, $fuel)
        //         );
        //     }
        // }

        $sumPartOne = 0;
        $sumPartTwo = 0;

        foreach ($input as $line) {
            $line = trim($line);

            if (empty($line)) {
                continue;
            }

            $sumPartOne += $this->calculateFuel((int) $line, false);
            $sumPartTwo += $this->calculateFuel((int) $line, true);
        }

        return new Solution($sumPartOne, $sumPartTwo);
    }

    /**
     * Divide the mass by three, round down and finally substract 2.
     *
     * @param int  $mass
     * @param bool $includeFuel
     *
     * @return int
     */
    private function calculateFuel(int $mass, bool $includeFuel): int
    {
        if (!$includeFuel) {
            return (int) (floor($mass / 3) - 2);
        }

        $fuel = 0;
        $remaining = $this->calculateFuel($mass, false);

        do {
            $fuel += $remaining;
            $remaining = $this->calculateFuel($remaining, false);
        } while ($remaining >= 0);

        return $fuel;
    }
}

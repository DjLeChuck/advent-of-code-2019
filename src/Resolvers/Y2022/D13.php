<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D13 implements ResolverInterface
{
    private int $currentComparisonIndex = 0;
    private int $sumValidComparisonIndexes = 0;
    private bool $comparisonHasMatch = false;

    public function resolve(array $input): Solution
    {
        $nbRows = \count($input);

        for ($i = 0; $i < $nbRows; $i += 3) {
            try {
                $left = json_decode($input[$i], true, 512, JSON_THROW_ON_ERROR);
                $right = json_decode($input[$i + 1], true, 512, JSON_THROW_ON_ERROR);
            } catch (\Throwable) {
                continue;
            }

            ++$this->currentComparisonIndex;

            $this->compareLists($left, $right, true);
        }

        return new Solution($this->sumValidComparisonIndexes.' (wrong, to high)');
    }

    private function compareLists(array|int|null $left, array|int|null $right, bool $topLevel = false): void
    {
        // Always treat as array
        $left = is_int($left) ? [$left] : $left;
        $right = is_int($right) ? [$right] : $right;

        if ($topLevel) {
            $this->comparisonHasMatch = false;
        }

        foreach ($left as $index => $leftValue) {
            $rightValue = $right[$index] ?? null;

            if (null === $rightValue) {
                return;
            }

            // Both are integers
            if (is_int($leftValue) && is_int($rightValue)) {
                // Equals then continue
                if ($leftValue === $rightValue) {
                    continue;
                }

                // Valid if left lower than right
                if ($leftValue < $rightValue) {
                    $this->comparisonHasMatch = true;
                    $this->sumValidComparisonIndexes += $this->currentComparisonIndex;
                }

                break;
            }

            $this->compareLists($leftValue, $rightValue);
        }

        if ($topLevel && !$this->comparisonHasMatch && \count($left) < \count($right)) {
            $this->sumValidComparisonIndexes += $this->currentComparisonIndex;
        }
    }
}

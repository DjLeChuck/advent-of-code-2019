<?php

declare(strict_types=1);

namespace App\DTO\Y2022D12;

class TerrainCost
{
    public const INFINITE = PHP_INT_MAX;

    /** @var int[][] */
    private array $terrainCost;

    /**
     * @param int[][] $terrainCost
     */
    public function __construct(array $terrainCost)
    {
        if (self::isEmpty($terrainCost)) {
            throw new \InvalidArgumentException('The terrain costs array is empty');
        }

        $terrainCost = self::convertToNumericArray($terrainCost);

        $this->terrainCost = self::validateTerrainCosts($terrainCost);
    }

    public function getCost(int $x, int $y): int
    {
        if (!isset($this->terrainCost[$x][$y])) {
            throw new \InvalidArgumentException("Invalid tile: $x, $y");
        }

        return $this->terrainCost[$x][$y];
    }

    public function getTotalRows(): int
    {
        return \count($this->terrainCost);
    }

    public function getTotalColumns(): int
    {
        return \count($this->terrainCost[0]);
    }

    /**
     * @param int[][] $terrainCost
     *
     * @return bool
     */
    private static function isEmpty(array $terrainCost): bool
    {
        if (!empty($terrainCost)) {
            $firstRow = reset($terrainCost);

            return empty($firstRow);
        }

        return true;
    }

    /**
     * @param array[] $terrain
     *
     * @return int[][]
     */
    private static function validateTerrainCosts(array $terrain): array
    {
        $validTerrain = [];

        foreach ($terrain as $x => $xValues) {
            /** @psalm-suppress MixedAssignment PSalm is unable to determine that $value is of mixed type */
            foreach ($xValues as $y => $value) {
                $integerValue = filter_var($value, FILTER_VALIDATE_INT);

                if ($integerValue === false) {
                    throw new \InvalidArgumentException('Invalid terrain cost: '.print_r($value, true));
                }

                $validTerrain[$x][$y] = $integerValue;
            }
        }

        return $validTerrain;
    }

    /**
     * @param int[][] $associativeArray
     *
     * @return int[][]
     */
    private static function convertToNumericArray(array $associativeArray): array
    {
        $numericArray = [];

        foreach ($associativeArray as $x) {
            $numericArray[] = array_values($x);
        }

        return $numericArray;
    }
}

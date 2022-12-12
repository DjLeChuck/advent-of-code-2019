<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\DTO\Y2022D12\DomainLogic;
use App\DTO\Y2022D12\Point;
use App\DTO\Y2022D12\SequencePrinter;
use App\DTO\Y2022D12\TerrainCost;
use App\Resolvers\ResolverInterface;
use JMGQ\AStar\AStar;

class D12 implements ResolverInterface
{
    private const STARTING_POINT = 'S';
    private const END_POINT = 'E';

    private array $terrain;
    private Point $startingPoint;
    private Point $endPoint;

    public function resolve(array $input): Solution
    {
        foreach ($input as $x => $row) {
            if (empty($row)) {
                continue;
            }

            foreach (str_split($row) as $y => $char) {
                if (self::STARTING_POINT === $char) {
                    $this->startingPoint = new Point($x, $y);
                    $char = 'a';
                }

                if (self::END_POINT === $char) {
                    $this->endPoint = new Point($x, $y);
                    $char = 'z';
                }

                $this->terrain[$x][$y] = ord($char);
            }
        }

        $terrainCost = new TerrainCost($this->terrain);
        $domainLogic = new DomainLogic($terrainCost);

        $aStar = new AStar($domainLogic);
        $path = $aStar->run($this->startingPoint, $this->endPoint);

        $printer = new SequencePrinter($terrainCost, $path);

        // $printer->printSequence();

        return new Solution(\count($path));
    }
}

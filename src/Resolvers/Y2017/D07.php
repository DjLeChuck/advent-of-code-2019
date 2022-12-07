<?php

declare(strict_types=1);

namespace App\Resolvers\Y2017;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D07 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $names = [];
        $towerBase = null;

        foreach ($input as $line) {
            $matches = [];

            preg_match('/^([a-z]*) \((\d*)\)( -> ([a-z, ]*))?$/', $line, $matches);

            [, $name, $weight] = $matches;
            $above = isset($matches[4]) ? explode(', ', $matches[4]) : [];

            $names[$name] = [
                'weight' => $weight,
                'above'  => $above,
            ];
        }

        // Partie 1
        $firstAnswer = null;

        foreach ($names as $name => $data) {
            // Rien au-dessus ? On passe.
            if (empty($data['above'])) {
                continue;
            }

            $inSomeoneAbove = false;

            foreach ($names as $oName => $oData) {
                if ($name === $oName) {
                    continue;
                }

                // Dans une des tours au-dessus. On arrête.
                if (\in_array($name, $oData['above'], true)) {
                    $inSomeoneAbove = true;

                    break;
                }
            }

            if (!$inSomeoneAbove) {
                $towerBase = $name;

                $firstAnswer = $name;

                break;
            }
        }

        // Partie 2
        $baseData = $names[$towerBase];

        // Additionne de manière récursive les poids d'une tour et ses dépendances
        $getWeight = static function ($item) use ($names, &$getWeight) {
            $weight = $item['weight'];

            foreach ($item['above'] as $name) {
                $weight += $getWeight($names[$name]);
            }

            return $weight;
        };

        $current = $towerBase;
        $above = $baseData['above'];

        while (true) {
            $weights = [];

            foreach ($above as $name) {
                $weights[$name] = $getWeight($names[$name]);
            }

            asort($weights);

            $first = reset($weights);
            $second = next($weights);
            $last = end($weights);

            if ($first === $second && $first !== $last) {
                $wrong = array_search($last, $weights, true);
            } elseif ($first !== $last) {
                $wrong = array_search($first, $weights, true);
            } else {
                $sibling = null;

                // Récupération d'une des tours au même niveau
                foreach ($names as $name => $data) {
                    if (\in_array($current, $data['above'], true)) {
                        $first = reset($data['above']);
                        $sibling = $current === $first ? end($data['above']) : $first;

                        break;
                    }
                }

                $badWeight = $getWeight($names[$current]);
                $goodWeight = $getWeight($names[$sibling]);
                $diff = abs($badWeight - $goodWeight);

                $secondAnswer = abs($names[$current]['weight'] - $diff);

                break;
            }

            $above = $names[$wrong]['above'];
            $current = $wrong;
        }

        return new Solution($firstAnswer, $secondAnswer);
    }
}

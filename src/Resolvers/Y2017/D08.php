<?php

declare(strict_types=1);

namespace App\Resolvers\Y2017;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D08 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $data = [];
        $maxEver = 0;
        $doAction = static function ($action, $var, $value) use (&$data) {
            switch ($action) {
                case 'inc':
                    $data[$var] += $value;
                    break;
                case 'dec':
                    $data[$var] -= $value;
                    break;
                default:
                    throw new \Exception(sprintf('Action "%s" inconnue.', $action));
            }
        };
        $conditionIsValid = static function ($left, $operator, $right) {
            // Je n'utiliserais pas d'eval ! è_é
            return match ($operator) {
                '>' => $left > $right,
                '<' => $left < $right,
                '>=' => $left >= $right,
                '<=' => $left <= $right,
                '==' => $left === $right,
                '!=' => $left !== $right,
                default => throw new \Exception(sprintf('Opérateur "%s" inconnu.', $operator)),
            };
        };

        foreach (array_filter($input) as $line) {
            [
                $var,
                $action,
                $value,
                ,
                $conditionVar,
                $conditionOperator,
                $conditionValue,
            ] = explode(' ', $line);

            $value = (int) $value;
            $conditionValue = (int) $conditionValue;

            if (!array_key_exists($var, $data)) {
                $data[$var] = 0;
            }

            if (!array_key_exists($conditionVar, $data)) {
                $data[$conditionVar] = 0;
            }

            if ($conditionIsValid($data[$conditionVar], $conditionOperator, $conditionValue)) {
                $doAction($action, $var, $value);

                $maxEver = max($data[$var], $maxEver);
            }
        }

        return new Solution(max($data), $maxEver);
    }
}

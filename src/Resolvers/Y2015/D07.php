<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D07 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $map = [];

        uasort($input, static function ($a, $b) {
            return strlen($a) < strlen($b);
        });

        while (0 !== count($input)) {
            foreach ($input as $key => $line) {
                $parts = explode(' ', $line);
                $continue = false;

                switch (count($parts)) {
                    case 3:
                        $num = $parts[0];

                        if (is_numeric($num)) {
                            $num = ((int) $num & 0xFFFF);
                        } elseif (isset($map[$num])) {
                            $num = $map[$num];
                        } else {
                            $continue = true;
                            break;
                        }

                        $map[$parts[2]] = $num;

                        break;
                    case 4:
                        $num = $parts[1];

                        if (is_numeric($num)) {
                            $num = ((int) $num & 0xFFFF);
                        } elseif (isset($map[$num])) {
                            $num = $map[$num];
                        } else {
                            $continue = true;
                            break;
                        }

                        $map[$parts[3]] = ~$num & 0xFFFF;
                        break;
                    case 5:
                        $a = $parts[0];

                        if (is_numeric($a)) {
                            $a = ((int) $a & 0xFFFF);
                        } elseif (isset($map[$a])) {
                            $a = $map[$a];
                        } else {
                            $continue = true;
                            break;
                        }

                        $b = $parts[2];

                        if (is_numeric($b)) {
                            $b = ((int) $b & 0xFFFF);
                        } elseif (isset($map[$b])) {
                            $b = $map[$b];
                        } else {
                            $continue = true;
                            break;
                        }

                        $c = null;

                        switch ($parts[1]) {
                            case 'AND':
                                $c = ($a & $b) & 0xFFFF;
                                break;
                            case 'OR':
                                $c = ($a | $b) & 0xFFFF;
                                break;
                            case 'RSHIFT':
                                $c = ($a >> $b) & 0xFFFF;
                                break;
                            case 'LSHIFT':
                                $c = ($a << $b) & 0xFFFF;
                                break;
                        }

                        $map[$parts[4]] = $c;
                        break;
                    default:
                }

                if (!$continue) {
                    unset($input[$key]);
                }
            }
        }

        return new Solution($map['a']);
    }
}

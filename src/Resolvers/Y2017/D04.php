<?php

declare(strict_types=1);

namespace App\Resolvers\Y2017;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D04 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $result = 0;
        $result2 = 0;

        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            }

            $words = explode(" ", $line);
            $isValid = true;
            $isValid2 = true;

            foreach ($words as $key => $value) {
                $value2 = $this->sortLetters($value);

                foreach ($words as $oKey => $oValue) {
                    if ($oKey === $key) {
                        continue;
                    }

                    $oValue2 = $this->sortLetters($oValue);

                    if ($value === $oValue) {
                        $isValid = false;
                    }

                    if ($value2 === $oValue2) {
                        $isValid2 = false;
                    }
                }
            }

            if ($isValid) {
                ++$result;
            }

            if ($isValid2) {
                ++$result2;
            }
        }

        return new Solution($result, $result2);
    }

    private function sortLetters($str): string
    {
        $parts = str_split($str);

        sort($parts);

        return implode('', $parts);
    }
}

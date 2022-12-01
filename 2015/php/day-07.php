<?php

/*
 * Only part one is OK.
 */

$data   = trim(file_get_contents('inputs/day-07.txt'));
$map    = [];
$lines  = explode("\n", $data);

uasort($lines, function($a, $b) {
    return strlen($a) < strlen($b);
});

while (0 !== count($lines)) {
    foreach ($lines as $key => $line) {
        $parts      = explode(' ', $line);
        $continue   = false;

        switch (count($parts)) {
            case 3:
                $num = $parts[0];

                if (is_numeric($num)) {
                    $num = ((int) $num & 0xFFFF);
                } else {
                    if (isset($map[$num])) {
                        $num = $map[$num];
                    } else {
                        $continue = true;
                        continue;
                    }
                }

                $map[$parts[2]] = $num;

                break;
            case 4:
                $num = $parts[1];

                if (is_numeric($num)) {
                    $num = ((int) $num & 0xFFFF);
                } else {
                    if (isset($map[$num])) {
                        $num = $map[$num];
                    } else {
                        $continue = true;
                        continue;
                    }
                }

                $map[$parts[3]] = ~ $num & 0xFFFF;
                break;
            case 5:
                $a = $parts[0];

                if (is_numeric($a)) {
                    $a = ((int) $a & 0xFFFF);
                } else {
                    if (isset($map[$a])) {
                        $a = $map[$a];
                    } else {
                        $continue = true;
                        continue;
                    }
                }

                $b = $parts[2];

                if (is_numeric($b)) {
                    $b = ((int) $b & 0xFFFF);
                } else {
                    if (isset($map[$b])) {
                        $b = $map[$b];
                    } else {
                        $continue = true;
                        continue;
                    }
                }

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
                throw new Exception('Invalid input line.');
        }

        if (!$continue) {
            unset($lines[$key]);
        }
    }
}

echo sprintf('First part: %u', $map['a']).PHP_EOL;

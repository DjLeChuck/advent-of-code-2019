<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D07 implements ResolverInterface
{
    private const MAX_ALLOWED_SIZE = 100000;
    private const DISK_SPACE = 70000000;
    private const UPDATE_SPACE = 30000000;

    public function resolve(array $input): Solution
    {
        $tree = [];
        $list = [];
        $sizes = [];

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            // Not a command, so it's a listed item
            if (!str_starts_with($row, '$')) {
                if (!str_starts_with($row, 'dir')) {
                    $list[] = $row;
                }

                continue;
            }

            // Before executing command, process current list buffer
            if (!empty($list)) {
                $this->processList($sizes, $tree, $list);

                $list = [];
            }

            // ls command, start a new list buffer
            if (str_ends_with($row, 'ls')) {
                $list = [];
            } else {
                $dir = str_replace('$ cd ', '', $row);

                if ('/' === $dir) {
                    $tree = ['/'];
                } elseif ('..' === $dir) {
                    array_pop($tree);
                } else {
                    $tree[] = $dir;
                }
            }
        }

        // Last list processing
        if (!empty($list)) {
            $this->processList($sizes, $tree, $list);
        }

        foreach ($sizes as $path => $size) {
            $parts = explode('.', $path);
            array_pop($parts); // Remove the current directory

            while (!empty($parts)) {
                $sizes[$this->preparePath($sizes, $parts)] += $size;

                array_pop($parts);
            }
        }

        $sumSizes = 0;
        $unusedSpace = self::DISK_SPACE - $sizes['/'];
        $neededSpace = self::UPDATE_SPACE - $unusedSpace;
        $deletable = [];

        foreach ($sizes as $dir => $size) {
            if (self::MAX_ALLOWED_SIZE >= $size) {
                $sumSizes += $size;
            }

            if ($size >= $neededSpace) {
                $deletable[$dir] = $size;
            }
        }

        asort($deletable);

        return new Solution($sumSizes, array_shift($deletable));
    }

    private function preparePath(array &$sizes, array $tree): string
    {
        $path = implode('.', $tree);
        if (!isset($sizes[$path])) {
            $sizes[$path] = 0;
        }

        return $path;
    }

    private function processList(array &$sizes, array $tree, array $list): void
    {
        $path = $this->preparePath($sizes, $tree);

        foreach ($list as $item) {
            [$size,] = explode(' ', $item);
            $sizes[$path] += (int) $size;
        }
    }
}

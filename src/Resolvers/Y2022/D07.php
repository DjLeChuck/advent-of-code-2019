<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D07 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $tree = [];
        $position = '';

        foreach ($input as $row) {
            if (str_starts_with($row, '$')) {
                if ('$ ls' === $row) {
                    $buffer = [];
                } else {
                    if (!empty($buffer)) {
                        $this->processBuffer($tree, $buffer, $position);
                        $buffer = [];
                    }

                    $folder = str_replace('$ cd ', '', $row);

                    if ('..' === $folder) {
                        $parts = explode('/', $position);
                        array_pop($parts);
                        $position = implode('/', $parts);

                        if (empty($position)) {
                            $position = '/';
                        }
                    } elseif (empty($position) || str_ends_with('/', $position)) {
                        $position .= $folder;
                    } else {
                        $position .= '/'.$folder;
                    }

                    // dump($position);
                }
            } else {
                // listing files from previous command
                $buffer[] = $row;
            }
        }

        if (!empty($buffer)) {
            $this->processBuffer($tree, $buffer, $position);
        }

        foreach ($tree as $dir => $size) {
            $subDirs = array_filter(explode('/', $dir));
            if (2 > \count($subDirs)) {
                continue;
            }

            // Remove last, which is current looping dir
            array_pop($subDirs);

            foreach ($subDirs as $item) {
                $tree['/'.$item] += $size;
            }
        }

        $heavyDirectories = [];

        foreach ($tree as $dir => $size) {
            if (100000 <= $size) {
                $heavyDirectories[] = $dir;
            }
        }

        dump($tree, $heavyDirectories);

        // $tree = [];
        // $listing = false;
        // $buffer = [];
        // $position = '';

        // foreach ($input as $row) {
        //     if (str_starts_with($row, '$ cd')) {
        //         if (!empty($buffer)) {
        //             dump($position, $this->processList($buffer));
        //         }
        //
        //         $listing = false;
        //         $folder = str_replace('$ cd ', '', $row);
        //
        //         if ('..' === $folder) {
        //             $parts = explode('/', $position);
        //             array_pop($parts);
        //             $position = implode('/', $parts);
        //
        //             if (empty($position)) {
        //                 $position = '/';
        //             }
        //         } elseif (empty($position) || str_ends_with('/', $position)) {
        //             $position .= $folder;
        //         } else {
        //             $position .= '/'.$folder;
        //         }
        //     } elseif (str_starts_with($row, '$ ls')) {
        //         if (!empty($buffer)) {
        //             dump($position, $this->processList($buffer));
        //         }
        //
        //         $listing = true;
        //         $buffer = [];
        //     } else {
        //         if (!$listing) {
        //             throw new \LogicException(sprintf('Ligne "%s" non traitable.', $row));
        //         }
        //
        //         $buffer[] = $row;
        //     }
        // }

        return new Solution();
    }

    private function processBuffer(array &$tree, array $buffer, string $position): void
    {
        $size = 0;

        foreach ($buffer as $row) {
            if (str_starts_with($row, 'dir ')) {
                continue;
            }

            [$fileSize,] = explode(' ', $row);
            $size += (int) $fileSize;
        }

        $tree[$position] = $size;
    }

    private function processList(array $buffer): int
    {
        $size = 0;

        foreach ($buffer as $row) {
            if (str_starts_with($row, 'dir ')) {
                continue;
            }

            [$fileSize,] = explode(' ', $row);
            $size += (int) $fileSize;
        }

        return $size;
    }

    private function move(array &$tree, string $command): void
    {
        $folder = str_replace('$ cd ', '', $command);

        if ('..' === $folder) {
        } else {
            if (!isset($tree[$folder])) {
                $tree[$folder] = ['directories' => [], 'files' => []];
            }
        }
    }
}

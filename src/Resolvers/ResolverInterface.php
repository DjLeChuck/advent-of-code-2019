<?php

declare(strict_types=1);

namespace App\Resolvers;

interface ResolverInterface
{
    public function resolve(array $input): void;
}

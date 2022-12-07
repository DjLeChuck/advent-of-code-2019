<?php

declare(strict_types=1);

namespace App\Resolvers;

use App\DTO\Solution;

interface ResolverInterface
{
    public function resolve(array $input): Solution;
}

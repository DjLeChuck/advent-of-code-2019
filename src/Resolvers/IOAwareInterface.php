<?php

declare(strict_types=1);

namespace App\Resolvers;

use Symfony\Component\Console\Style\SymfonyStyle;

interface IOAwareInterface
{
    public function setIo(SymfonyStyle $io): void;
}

<?php

declare(strict_types=1);

namespace App\Resolvers;

use Symfony\Component\Console\Style\SymfonyStyle;

trait IOAwareTrait
{
    private SymfonyStyle $io;

    public function setIo(SymfonyStyle $io): void
    {
        $this->io = $io;
    }
}

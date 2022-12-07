<?php

declare(strict_types=1);

namespace App\Command;

use App\AdventOfCode\InputGrabber;
use App\Resolvers\ResolverInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:resolve',
    description: 'Resolve an Advent of Code\'s  puzzle.',
    hidden: false
)]
class ResolveCommand extends Command
{
    private const FIRST_YEAR = 2015;
    private const LAST_YEAR = 2022;
    private const FIRST_DAY = 1;
    private const LAST_DAY = 25;

    protected function configure(): void
    {
        $this
            ->addOption(
                'year',
                'y',
                InputOption::VALUE_OPTIONAL,
                'The concerned year.',
                self::LAST_YEAR
            )
            ->addOption(
                'day',
                'd',
                InputOption::VALUE_OPTIONAL,
                'The concerned day.',
                date('d')
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $year = (int) $input->getOption('year');
        if (self::FIRST_YEAR > $year || self::LAST_YEAR < $year) {
            $io->error(sprintf('The year must be between %u and %u!', self::FIRST_YEAR, self::LAST_YEAR));

            return self::FAILURE;
        }

        $day = (int) $input->getOption('day');
        if (self::FIRST_DAY > $day || self::LAST_DAY < $day) {
            $io->error(sprintf('The day must be between %u and %u!', self::FIRST_DAY, self::LAST_DAY));

            return self::FAILURE;
        }

        $resolver = $this->getResolver($year, $day);
        $inputGrabber = new InputGrabber();

        $solution = $resolver->resolve($inputGrabber->getInput($year, $day));

        $io->title(sprintf('<info>🎄 Solution au problème du jour %u de l\'année %u 🎄</>', $day, $year));

        $io->table(
            ['Première partie', 'Seconde partie'],
            [
                [
                    $solution->getFirstPart() ?? 'Pas encore résolue !',
                    $solution->getSecondPart() ?? 'Pas encore résolue !',
                ],
            ]
        );

        $io->writeln('<comment>🎅🎁 Joyeux Noël ! 🎁🎅</>');

        return self::SUCCESS;
    }

    private function getResolver(int $year, int $day): ResolverInterface
    {
        $class = sprintf(
            '\App\Resolvers\Y%u\D%s',
            $year,
            str_pad((string) $day, 2, '0', STR_PAD_LEFT)
        );

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('The resolver %s does not exists.', $class));
        }

        return new $class();
    }
}

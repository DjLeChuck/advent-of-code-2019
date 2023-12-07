<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\DTO\Y2023D07\Game;
use App\Resolvers\ResolverInterface;

class D07 implements ResolverInterface
{
    private const CARDS_VALUES = ['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'];
    private const CARDS_SECOND_VALUES = ['A', 'K', 'Q', 'T', '9', '8', '7', '6', '5', '4', '3', '2', 'J'];

    /** @var array<int, Game> */
    private array $games = [];
    /** @var array<int, Game> */
    private array $gamesTwo = [];

    public function resolve(array $input): Solution
    {
        foreach ($input as $game) {
            if (empty($game)) {
                continue;
            }

            $matches = [];
            preg_match('/^([AKQJT98765432]{5}) (\d+)$/', $game, $matches);

            $this->games[] = new Game($matches[1], (int) $matches[2]);
            $this->gamesTwo[] = new Game($matches[1], (int) $matches[2]);
        }

        $this->sortGames();

        return new Solution(
            $this->calculateTotal($this->games),
            $this->calculateTotal($this->gamesTwo)
        );
    }

    private function sortGames(): void
    {
        usort(
            $this->games,
            fn(Game $a, Game $b) => $this->compareGames($a, $b, self::CARDS_VALUES, false)
        );
        usort(
            $this->gamesTwo,
            fn(Game $a, Game $b) => $this->compareGames($a, $b, self::CARDS_SECOND_VALUES, true)
        );
    }

    private function compareGames(Game $a, Game $b, array $values, bool $useJoker): int
    {
        $aValue = $a->getHandValue($useJoker);
        $bValue = $b->getHandValue($useJoker);

        if ($aValue !== $bValue) {
            return $aValue <=> $bValue;
        }

        $bCards = $b->getCards();

        foreach ($a->getCards() as $i => $card) {
            $aIndex = array_search($card, $values, true);
            $bIndex = array_search($bCards[$i], $values, true);

            if ($aIndex < $bIndex) {
                return 1;
            }

            if ($aIndex > $bIndex) {
                return -1;
            }
        }

        return 0;
    }

    private function calculateTotal(array $games): int
    {
        $score = 0;

        foreach ($games as $i => $game) {
            $score += $game->getBit() * ($i + 1);
        }

        return $score;
    }
}

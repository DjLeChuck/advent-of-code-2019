<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\DTO\Y2023D07\Game;
use App\Resolvers\ResolverInterface;

class D07 implements ResolverInterface
{
    private const CARDS_VALUES = ['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'];

    /** @var array<int, Game> */
    private array $games = [];

    public function resolve(array $input): Solution
    {
        foreach ($input as $game) {
            if (empty($game)) {
                continue;
            }

            $matches = [];
            preg_match('/^([AKQJT98765432]{5}) (\d+)$/', $game, $matches);

            $this->games[] = new Game($matches[1], (int) $matches[2]);
        }

        $this->sortGames();

        return new Solution($this->calculateTotal());
    }

    private function sortGames(): void
    {
        usort($this->games, fn(Game $a, Game $b) => $this->compareGames($a, $b));
    }

    private function compareGames(Game $a, Game $b): int
    {
        if ($a->getHandValue() !== $b->getHandValue()) {
            return $a->getHandValue() <=> $b->getHandValue();
        }

        $bCards = $b->getCards();

        foreach ($a->getCards() as $i => $card) {
            $aIndex = array_search($card, self::CARDS_VALUES, true);
            $bIndex = array_search($bCards[$i], self::CARDS_VALUES, true);

            if ($aIndex < $bIndex) {
                return 1;
            }

            if ($aIndex > $bIndex) {
                return -1;
            }
        }

        return 0;
    }

    private function calculateTotal(): int
    {
        $score = 0;

        foreach ($this->games as $i => $game) {
            $score += $game->getBit() * ($i + 1);
        }

        return $score;
    }
}

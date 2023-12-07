<?php

declare(strict_types=1);

namespace App\DTO\Y2023D07;

final class Game
{
    private array $cards;
    private ?int $handValue = null;

    public function __construct(
        string $cards,
        private readonly int $bit,
    ) {
        $this->cards = str_split($cards);
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function getBit(): int
    {
        return $this->bit;
    }

    public function getHandValue(bool $useJoker): int
    {
        if (null === $this->handValue) {
            $this->handValue = $this->calculateHandValue($useJoker);
        }

        return $this->handValue;
    }

    private function calculateHandValue(bool $useJoker): int
    {
        $cardsCount = array_count_values($this->cards);
        asort($cardsCount);

        if ($useJoker && \array_key_exists('J', $cardsCount)) {
            $nbJ = $cardsCount['J'];
            unset($cardsCount['J']);

            if (empty($cardsCount)) {
                return 7;
            }

            $maxValue = max(array_values($cardsCount));
            $maxKey = array_search($maxValue, $cardsCount, true);

            $cardsCount[$maxKey] += $nbJ;
        }

        if (\in_array(5, $cardsCount, true)) {
            return 7;
        }

        if (\in_array(4, $cardsCount, true)) {
            return 6;
        }

        if (\in_array(3, $cardsCount, true) && \in_array(2, $cardsCount, true)) {
            return 5;
        }

        if (\in_array(3, $cardsCount, true)) {
            return 4;
        }

        if (\in_array(2, $cardsCount, true)) {
            if (2 === array_count_values($cardsCount)[2]) {
                return 3;
            }

            return 2;
        }

        return 1;
    }
}

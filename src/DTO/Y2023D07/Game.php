<?php

declare(strict_types=1);

namespace App\DTO\Y2023D07;

final class Game
{
    private array $cards;
    private array $cardsCount;
    private int $handValue;

    public function __construct(
        string $cards,
        private readonly int $bit,
    ) {
        $this->cards = str_split($cards);
        $this->cardsCount = array_count_values($this->cards);
        asort($this->cardsCount);

        $this->handValue = $this->calculateHandValue();
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function getBit(): int
    {
        return $this->bit;
    }

    public function getHandValue(): int
    {
        return $this->handValue;
    }

    private function calculateHandValue(): int
    {
        if (\in_array(5, $this->cardsCount, true)) {
            return 7;
        }

        if (\in_array(4, $this->cardsCount, true)) {
            return 6;
        }

        if (\in_array(3, $this->cardsCount, true) && \in_array(2, $this->cardsCount, true)) {
            return 5;
        }

        if (\in_array(3, $this->cardsCount, true)) {
            return 4;
        }

        if (\in_array(2, $this->cardsCount, true)) {
            if (2 === array_count_values($this->cardsCount)[2]) {
                return 3;
            }

            return 2;
        }

        return 1;
    }
}

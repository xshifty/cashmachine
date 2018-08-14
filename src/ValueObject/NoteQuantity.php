<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain\ValueObject;

final class NoteQuantity
{
    private $note;
    private $quantity;
    private $remainder;

    public function __construct(float $note, int $quantity, float $remainder)
    {
        $this->note = $note;
        $this->quantity = $quantity;
        $this->remainder = $remainder;
    }

    public function getNote(): float
    {
        return $this->note;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getRemainder(): float
    {
        return $this->remainder;
    }
}

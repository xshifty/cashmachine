<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

use Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;
use Xshifty\CashMachine\Domain\ValueObject\NoteQuantity;

final class NoteManager implements NoteManagerInterface
{
    private $availableNotes = [];

    public function setAvailableNotes(array $noteValues): bool
    {
        $this->availableNotes = array_map(function ($value) {
            return floatval($value);
        }, $noteValues);

        $this->availableNotes = array_filter(array_unique($this->availableNotes));
        return rsort($this->availableNotes, SORT_NUMERIC);
    }

    public function getAvailableNotes(): array
    {
        return $this->availableNotes;
    }

    public function getQuantityMax(float $value): NoteQuantity
    {
        $filtered = array_filter($this->availableNotes, function ($note) use ($value) {
            return floatval($value) > floatval($note);
        });

        if (count($filtered) < 1) {
            throw new NoteUnavailableException('Invalid value');
        }

        $quantity = intval($value / $filtered[0]);
        $remainder = intval($value % $filtered[0]);

        return new NoteQuantity($filtered[0], $quantity, $remainder);
    }
}

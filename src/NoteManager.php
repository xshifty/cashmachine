<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

use Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;
use Xshifty\CashMachine\Domain\ValueObject\NoteResult;

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

    public function getQuantityMax(float $value): NoteResult
    {
        $pos = 0;

        while (isset($this->availableNotes[$pos]) && $this->availableNotes[$pos] > $value) {
            $pos++;
        }

        if (!isset($this->availableNotes[$pos])) {
            throw new NoteUnavailableException('Not have all needed notes available for this amount.');
        }

        $note = $this->availableNotes[$pos];

        return $this->calculateNoteResult($note, $value);
    }

    private function calculateNoteResult(float $note, float $value): NoteResult
    {
        $quantity = intval($value / $note);
        $remainder = intval($value % $note);

        return new NoteResult($note, $quantity, $remainder);
    }
}

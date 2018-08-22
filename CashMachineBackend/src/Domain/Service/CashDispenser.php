<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain\Service;

use \Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;

final class CashDispenser implements CashDispenserInterface
{
    private $availableNotes;

    public function __construct(array $availableNotes)
    {
        $this->setAvailableNotes($availableNotes);
    }

    public function getAvailableNotes(): array
    {
        return $this->availableNotes;
    }

    public function getNoteBatch(float $note, float $amount, int $ignoreNoteIndex = null): array
    {
        if (!in_array($note, $this->availableNotes)) {
            throw new NoteUnavailableException("Note {$note} isn't available.");
        }

        if ($note > $amount) {
            return [];
        }

        if (!empty($ignoreNoteIndex)
            && array_key_exists($ignoreNoteIndex, $this->availableNotes)
            && $note == $this->availableNotes[$ignoreNoteIndex]) {
            return [];
        }

        $quantity = intval($amount / $note);
        return array_fill(0, $quantity, $note);
    }

    private function setAvailableNotes(array $availableNotes)
    {
        $this->availableNotes = array_filter(
            array_unique(
                array_map('floatval', $availableNotes)));
        rsort($this->availableNotes, SORT_NUMERIC);
    }
}

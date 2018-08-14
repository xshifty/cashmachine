<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

use \SplMaxHeap;

final class NoteManager implements NoteManagerInterface
{
    private $availableNotes = [];

    public function __construct(array $notes)
    {
        $this->setAvailableNotes($notes);
    }

    public function setAvailableNotes(array $noteValues): bool
    {
        return true;
    }

    public function getAvailableNotes(): array
    {
        return [];
    }

    public function getQuantityMax(float $value): array
    {
        return [];
    }
}

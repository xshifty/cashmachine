<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

interface NoteManagerInterface
{
    public function setAvailableNotes(array $noteValues): bool;
    public function getAvailableNotes(): array;
    public function getQuantityMax(float $value);
}

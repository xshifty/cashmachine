<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

use Xshifty\CashMachine\Domain\ValueObject\NoteQuantity;

interface NoteManagerInterface
{
    public function setAvailableNotes(array $noteValues): bool;
    public function getAvailableNotes(): array;
    public function getQuantityMax(float $value): NoteQuantity;
}

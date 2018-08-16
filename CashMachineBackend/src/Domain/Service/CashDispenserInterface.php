<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain\Service;

interface CashDispenserInterface
{
    public function getAvailableNotes(): array;
    public function getNoteBatch(float $note, float $amount): array;
}

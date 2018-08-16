<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

interface CashMachineInterface
{
    public function setAvailableNotes(array $availableNotes);
    public function getAvailableNotes(): array;
    public function withdraw($amount): array;
}

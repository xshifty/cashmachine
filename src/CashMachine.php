<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

final class CashMachine implements CashMachineInterface
{
    private $notes;
    
    public function __construct(NoteManagerInterface $notes)
    {
        $this->notes = $notes;
    }

    public function withdraw(float $value): array
    {
        return [];
    }
}
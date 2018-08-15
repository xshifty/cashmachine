<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

use \InvalidArgumentException;

final class CashMachine implements CashMachineInterface
{
    private $notes;
    
    public function __construct(NoteManagerInterface $notes)
    {
        $this->notes = $notes;
    }

    public function withdraw($value): array
    {
        if (is_null($value)) {
            return [];
        }

        $value = floatval($value);
        if ($value <= 0) {
            throw new InvalidArgumentException('Invalid withdraw amount.');
        }

        $result = [];
        while ($value > 0) {
            $noteResult = $this->notes->getQuantityMax($value);
            $result = array_merge($result, array_fill(0, $noteResult->getQuantity(), $noteResult->getNote()));
            $value = $noteResult->getRemainder();
        }

        if (rsort($result, SORT_NUMERIC)) {
            return $result;
        }

        return [];
    }
}
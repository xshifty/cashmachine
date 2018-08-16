<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Application\Service;

use \InvalidArgumentException;
use \Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;
use \Xshifty\CashMachine\Domain\Service\CashDispenserInterface;

final class CashMachine implements CashMachineInterface
{
    private $cashDispenser;

    public function __construct(CashDispenserInterface $cashDispenser)
    {
        $this->cashDispenser = $cashDispenser;
    }
    
    public function withdraw($amount): array
    {
        if (!$this->checkAmount($amount)) {
            return [];
        }

        $availableNotes = $this->cashDispenser->getAvailableNotes();
        $withdrawResult = [];
        $remainder = $amount;

        foreach ($availableNotes as $note) {
            $withdrawResult = array_merge(
                $withdrawResult,
                $this->cashDispenser->getNoteBatch($note, $remainder));
            $remainder = intval($remainder % $note);
        }

        if ($remainder > 0) {
            throw new NoteUnavailableException('Not have all needed notes available for this amount.');
        }

        return $withdrawResult;
    }

    private function checkAmount($amount)
    {
        if (is_null($amount)) {
            return false;
        }

        $amount = floatval($amount);
        if ($amount <= 0) {
            throw new InvalidArgumentException('Invalid withdraw amount.');
        }

        return true;
    }
}
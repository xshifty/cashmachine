<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Application\Service;

use \InvalidArgumentException;
use \Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;
use \Xshifty\CashMachine\Domain\Service\CashDispenserInterface;

final class CashMachine implements CashMachineInterface
{
    private $cashDispenser;
    private $ignoreNoteIndex;

    public function __construct(CashDispenserInterface $cashDispenser)
    {
        $this->cashDispenser = $cashDispenser;
    }

    public function withdraw($amount): array
    {
        $this->ignoreNoteIndex = count($this->cashDispenser->getAvailableNotes());
        return $this->recursiveWithdraw($amount);
    }

    private function recursiveWithdraw($amount): array
    {
        if (!$this->checkAmount($amount)) {
            return [];
        }

        $availableNotes = $this->cashDispenser->getAvailableNotes();
        $withdrawResult = [];
        $remainder = $amount;

        foreach ($availableNotes as $note) {
            $batch = $this->cashDispenser->getNoteBatch($note, $remainder, $this->ignoreNoteIndex);
            $withdrawResult = array_merge($withdrawResult, $batch);
            $remainder = intval($remainder - array_sum($batch));
        }

        if ($remainder > 0 && $this->ignoreNoteIndex < 1) {
            throw new NoteUnavailableException('Not have all needed notes available for this amount.');
        }

        if ($remainder > 0) {
            $this->ignoreNoteIndex--;
            return $this->recursiveWithdraw($amount);
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

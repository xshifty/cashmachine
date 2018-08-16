<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

use \InvalidArgumentException;
use \Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;

final class CashMachine implements CashMachineInterface
{
    private $availableNotes;
    
    public function setAvailableNotes(array $availableNotes)
    {
        $this->availableNotes = array_map(function ($note) {
            return floatval($note);
        }, $availableNotes);

        $this->availableNotes = array_filter(array_unique($this->availableNotes));
        rsort($this->availableNotes, SORT_NUMERIC);
    }

    public function getAvailableNotes(): array
    {
        return $this->availableNotes;
    }

    public function withdraw($amount): array
    {
        if (!$this->checkAmount($amount)) {
            return [];
        }

        $withdrawResult = [];
        $remainder = $amount;

        foreach ($this->availableNotes as $note) {
            $withdrawResult = array_merge($withdrawResult, $this->getNoteBatch($note, $remainder));
            $remainder = intval($remainder % $note);
        }

        if ($remainder > 0) {
            throw new NoteUnavailableException('Not have all needed notes available for this amount.');
        }

        return $withdrawResult;
    }

    private function getNoteBatch(float $note, float $amount)
    {
        if ($note > $amount) {
            return [];
        }

        $quantity = intval($amount / $note);
        return array_fill(0, $quantity, $note);
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
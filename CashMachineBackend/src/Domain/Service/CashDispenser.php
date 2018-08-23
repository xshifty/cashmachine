<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain\Service;

use \Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;

final class CashDispenser implements CashDispenserInterface
{
    private $availableNotes;

    public function __construct(array $availableNotes)
    {
        $this->setAvailableNotes($availableNotes);
    }

    public function getAvailableNotes(): array
    {
        return $this->availableNotes;
    }

    public function getNoteBatch(float $amount): array
    {
        $current = 0;
        $stack = [];
        $note = 0;
        $count = 0;
        
        while ($amount > 0) {
            $this->resolveAmount($amount, $current, $note, $count, $stack);
        }

        return $stack;
    }

    private function resolveAmount(float &$amount, int &$current, float &$note, int &$count, array &$stack): bool
    {
        if (isset($this->availableNotes[$current])) {
            $note = $this->availableNotes[$current];
            $count = intval($amount / $note);
        }

        $current++;
        if ($count > 0) {
            array_push($stack, [--$current, $note]);
            $amount -= $note;
        }

        if ($amount == 0) {
            return true;
        }

        if ($amount > 0 && $current > count($this->availableNotes)) {
            $this->resolveAmountIterative($note, $amount, $current, $stack);
        }

        if ($current >= count($this->availableNotes) && count($stack) == 0) {
            throw new NoteUnavailableException('Not have all needed notes available for this amount.');
        }

        return false;
    }

    private function resolveAmountIterative(float $note, float &$amount, int &$current, array &$stack)
    {
        $done = false;
        while (!$done && count($stack) > 0) {
            $wrong = array_pop($stack);
            $amount += $wrong[1];
            $done = $this->verifyWrongStep($note, $current, $wrong);
        }
    }

    private function verifyWrongStep(float $note, int &$current, array $wrong): bool
    {
        if ($wrong[1] != $note) {
            $current = $wrong[0] + 1;
            return true;
        }

        return false;
    }

    private function setAvailableNotes(array $availableNotes)
    {
        $this->availableNotes = array_filter(
            array_unique(
                array_map('floatval', $availableNotes)));
        rsort($this->availableNotes, SORT_NUMERIC);
    }
}

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

        return array_map(function ($note) {
            return $note[1];
        }, $this->cashDispenser->getNoteBatch($amount));
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

<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Domain;

interface CashMachineInterface
{
    public function withdraw($value): array;
}

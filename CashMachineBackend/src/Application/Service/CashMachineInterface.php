<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Application\Service;

interface CashMachineInterface
{
    public function withdraw($amount): array;
}

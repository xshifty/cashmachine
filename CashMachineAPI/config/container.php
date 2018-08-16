<?php
$container['cashMachineService'] = function () use ($container) {
    $cashMachineService = new \Xshifty\CashMachine\Domain\CashMachine();
    $cashMachineService->setAvailableNotes([100, 50, 20, 10]);

    return $cashMachineService;
};
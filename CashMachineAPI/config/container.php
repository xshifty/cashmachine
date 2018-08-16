<?php
$container['service.noteManager'] = function () {
    $noteManager = new \Xshifty\CashMachine\Domain\NoteManager();
    $noteManager->setAvailableNotes([100, 50, 20, 10]);
    return $noteManager;
};

$container['service.cashMachine'] = function () use ($container) {
    return new \Xshifty\CashMachine\Domain\CashMachine($container['service.noteManager']);
};
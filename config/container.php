<?php
$container['controller.cashmachine'] = function () {
};

$container['service.noteManager'] = function () {
    $noteManager = new \Xshifty\CashMachine\Domain\NoteManager();
    $noteManager->setAvailableNotes([100, 50, 20, 10]);
    return $noteManager;
};

$container['service.cashmachine'] = function () {
};
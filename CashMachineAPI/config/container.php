<?php
$container['cashDispenser'] = function() {
    return new \Xshifty\CashMachine\Domain\Service\CashDispenser([
        100, 50, 20, 10
    ]);
};

$container['cashMachine'] = function() use ($container) {
    return new \Xshifty\CashMachine\Application\Service\CashMachine(
        $container['cashDispenser']
    );
};

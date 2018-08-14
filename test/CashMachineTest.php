<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Test;

use \InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Xshifty\CashMachine\Domain\CashMachine;
use Xshifty\CashMachine\Domain\NoteManager;
use Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;

final class CashMachineTest extends TestCase
{
    private $cashMachine;

    public function testWithdraw()
    {
        $this->assertEquals(
            $this->cashMachine->withdraw(340),
            [100.0, 100.0, 100.0, 20.0, 20.0]
        );

        $this->assertEquals(
            $this->cashMachine->withdraw(20),
            [20.0]
        );

        $this->assertEquals(
            $this->cashMachine->withdraw(NULL),
            []
        );
    }

    public function testUnavailableWithdraw()
    {
        $this->expectException(NoteUnavailableException::class);
        $this->cashMachine->withdraw(345);
    }

    public function testInvalidNegativeValueWithdraw()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->cashMachine->withdraw(-300);
    }

    public function testInvalidNonNumericValueWithdraw()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->cashMachine->withdraw('hello');
    }

    public function setUp()
    {
        $noteManager = new NoteManager();
        $noteManager->setAvailableNotes([100, 50, 20, 10]);

        $this->cashMachine = new CashMachine($noteManager);
    }
}

<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Test\Application\Service;

use \InvalidArgumentException;
use \PHPUnit\Framework\TestCase;
use \Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;
use \Xshifty\CashMachine\Domain\Service\CashDispenser;
use \Xshifty\CashMachine\Application\Service\CashMachine;

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
            $this->cashMachine->withdraw(null),
            []
        );
    }

    public function testInvalidNonNumericValueWithdraw()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->cashMachine->withdraw('hello');
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

    public function testSmallNotesDataset()
    {
        $cashDispenser = new CashDispenser([100, 50, 20]);
        $cashMachine = new CashMachine($cashDispenser);

        $this->assertEquals(
            $cashMachine->withdraw(380),
            [100, 100, 100, 20, 20, 20, 20]
        );
    }

    public function testBigNotesDataset()
    {
        $cashDispenser = new CashDispenser([
            10000, 5000, 4000, 3000, 2000, 1000,
            500, 200, 100,
            50, 20, 10,
            5, 1
        ]);

        $cashMachine = new CashMachine($cashDispenser);

        $expected = array_fill(0, 51, 10000.0);
        $expected = array_merge($expected, array_fill(0, 1, 5000.0));
        $expected = array_merge($expected, array_fill(0, 1, 4000.0));
        $expected = array_merge($expected, array_fill(0, 1, 200.0));
        $expected = array_merge($expected, array_fill(0, 1, 100.0));
        $expected = array_merge($expected, array_fill(0, 1, 50.0));
        $expected = array_merge($expected, array_fill(0, 1, 20.0));
        $expected = array_merge($expected, array_fill(0, 1, 5.0));
        $expected = array_merge($expected, array_fill(0, 3, 1.0));

        $this->assertEquals($cashMachine->withdraw(519378), $expected);
    }

    public function setUp()
    {
        $cashDispenser = new CashDispenser([100, 50, 20, 10]);
        $this->cashMachine = new CashMachine($cashDispenser);
    }
}

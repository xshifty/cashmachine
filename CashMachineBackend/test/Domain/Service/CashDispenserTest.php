<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Test\Domain\Service;

use \InvalidArgumentException;
use \Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;
use \PHPUnit\Framework\TestCase;
use \Xshifty\CashMachine\Domain\Service\CashDispenser;

final class CashDispenserTest extends TestCase
{
    private $cashDispenser;

    public function testGetAvailability()
    {
        $cashDispenser = new CashDispenser([10, 100.0, '50', 20]);
        $expected = [100.0, 50.0, 20.0, 10.0];
        $this->assertEquals($cashDispenser->getAvailableNotes(), $expected);
    }

    public function testGetNoteBatch()
    {
        $expected = array_fill(0, 5, [0, 100.0]);
        $expected = array_merge($expected, [[2, 20.0], [3, 10.0]]);
        $this->assertEquals($this->cashDispenser->getNoteBatch(530), $expected);

        $expected = array_fill(0, 3, [0, 100.0]);
        $expected = array_merge($expected, array_fill(0, 2, [2, 20.0]));
        $this->assertEquals($this->cashDispenser->getNoteBatch(340), $expected);
    }

    public function testGetNoteBatchInvalidNote()
    {
        $this->expectException(NoteUnavailableException::class);
        $this->cashDispenser->getNoteBatch(305);
    }

    public function testGetNoteBatchZeroAmount()
    {
        $this->assertEquals($this->cashDispenser->getNoteBatch(0), []);
    }

    public function setUp()
    {
        $this->cashDispenser = new CashDispenser([100, 50, 20, 10]);
    }
}

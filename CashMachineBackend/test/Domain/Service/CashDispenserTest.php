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

        $this->assertEquals(
            $cashDispenser->getAvailableNotes(),
            $expected
        );
    }

    public function testGetNoteBatch()
    {
        $this->assertEquals(
            $this->cashDispenser->getNoteBatch(100, 530),
            array_fill(0, 5, 100.0)
        );

        $this->assertEquals(
            $this->cashDispenser->getNoteBatch(50, 60),
            [50.0]
        );

        $this->assertEquals(
            $this->cashDispenser->getNoteBatch(100, 230),
            array_fill(0, 2, 100.0)
        );
    }

    public function testGetNoteBatchInvalidNote()
    {
        $this->expectException(NoteUnavailableException::class);
        $this->cashDispenser->getNoteBatch(200, 300);
    }

    public function testGetNoteBatchZeroAmount()
    {
        $this->assertEquals($this->cashDispenser->getNoteBatch(20, 0), []);
    }

    public function setUp()
    {
        $this->cashDispenser = new CashDispenser([100, 50, 20, 10]);
    }
}

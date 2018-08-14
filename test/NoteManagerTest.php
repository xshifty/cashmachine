<?php
declare(strict_types=1);

namespace Xshifty\CashMachine\Test;

use PHPUnit\Framework\TestCase;
use Xshifty\CashMachine\Domain\NoteManager;
use Xshifty\CashMachine\Domain\Exception\NoteUnavailableException;

final class NoteManagerTest extends TestCase
{
    private $noteManager;

    public function testNotesAvailability()
    {
        $this->noteManager = new NoteManager();
        $this->noteManager->setAvailableNotes([10, 100.0, '50', 20]);

        $expected = [100.0, 50.0, 20.0, 10.0];

        $this->assertEquals(
            $this->noteManager->getAvailableNotes(),
            $expected
        );
    }

    public function testQuantityMaxOutput()
    {
        $this->noteManager->setAvailableNotes([100, 50, 20, 10]);
        
        $result = $this->noteManager->getQuantityMax(560.0);
        
        $this->assertEquals($result->getNote(), 100.0);
        $this->assertEquals($result->getQuantity(), 5);
        $this->assertEquals($result->getRemainder(), 60.0);
    }

    public function testUnavailableNote()
    {
        $this->noteManager->setAvailableNotes([100, 50, 20, 10]);
        $this->expectException(NoteUnavailableException::class);
        $this->noteManager->getQuantityMax(7.0);
    }

    public function setUp()
    {
        $this->noteManager = new NoteManager();
    }
}

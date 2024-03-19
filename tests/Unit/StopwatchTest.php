<?php


namespace Tests\Unit;

use Tankfairies\Benchmark\Stopwatch;
use Tests\Support\UnitTester;
use Codeception\Test\Unit;
use Error;

class StopwatchTest extends Unit
{

    protected UnitTester $tester;

    // tests
    public function testStart()
    {
        $stopwatch = new Stopwatch();

        $this->assertIsFloat($stopwatch->start());
    }

    public function testElapsed()
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start();

        $this->assertIsFloat($stopwatch->elapsed());
    }

    public function testNotStarted()
    {
        $this->tester->expectThrowable(
            new Error('Typed property Tankfairies\Benchmark\Stopwatch::$start must not be accessed before initialization'),
            function () {
                $stopwatch = new Stopwatch();
                $stopwatch->elapsed();
            }
        );
    }
}

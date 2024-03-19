<?php


namespace Tests\Unit;

use DG\BypassFinals;
use Tankfairies\Benchmark\Benchmark;
use Tests\Support\UnitTester;
use Codeception\Test\Unit;
use Tankfairies\Benchmark\Stopwatch;
use ReflectionProperty;
use ReflectionException;
use Exception;

class BenchmarkTest extends Unit
{

    protected UnitTester $tester;

    public function setup(): void
    {
        BypassFinals::enable(bypassReadOnly: false);
    }

    protected function _before()
    {
    }

    // tests

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testConstruct()
    {
        $stopwatch = $this->make(
            Stopwatch::class,
            [
                'start' => function () {
                    return 1.0;
                }
            ]
        );

        $benchmark = new Benchmark($stopwatch);

        $reflection = new ReflectionProperty($benchmark, 'stopwatch');
        $this->assertEquals($stopwatch, $reflection->getValue($benchmark));
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testMultiplier()
    {

        $stopwatch = $this->make(Stopwatch::class);

        $benchmark = new Benchmark($stopwatch);

        $benchmark->multiplier(2000, 5);

        $reflection = new ReflectionProperty($benchmark, 'times');
        $this->assertEquals(2000, $reflection->getValue($benchmark));


        $reflection = new ReflectionProperty($benchmark, 'loops');
        $this->assertEquals(5, $reflection->getValue($benchmark));
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testMultiplierWithZeroTimes()
    {
        $stopwatch = $this->make(Stopwatch::class);

        $benchmark = new Benchmark($stopwatch);

        $benchmark->multiplier(0, 5);

        $reflection = new ReflectionProperty($benchmark, 'times');
        $this->assertEquals(0, $reflection->getValue($benchmark));


        $reflection = new ReflectionProperty($benchmark, 'loops');
        $this->assertEquals(5, $reflection->getValue($benchmark));
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testScript()
    {
        $stopwatch = $this->make(Stopwatch::class);

        $func = function () {
            rand(1, 10);
        };

        $benchmark = new Benchmark($stopwatch);
        $benchmark->script($func);

        $reflection = new ReflectionProperty($benchmark, 'script');
        $this->assertEquals($func, $reflection->getValue($benchmark));
    }

    /**
     * @throws Exception
     */
    public function testRun()
    {
        $stopwatch = $this->make(
            Stopwatch::class,
            [
                'start' => function () {
                    return 1.0;
                },
                'elapsed' => function () {
                    return 2.0;
                }
            ]
        );

        $benchmark = new Benchmark($stopwatch);
        $benchmark->multiplier(2, 2);

        $func = function () {
            rand(1, 10);
        };

        $benchmark->script($func);

        $results = $benchmark->run();

        $this->assertEquals([1 => '2.0000', 2 => '2.0000'], $results['time']);
    }

    /**
     * @throws Exception
     */
    public function testRunMultipliersNotSet()
    {
        $stopwatch = $this->make(
            Stopwatch::class,
            [
                'start' => function () {
                    return 1.0;
                },
                'elapsed' => function () {
                    return 2.0;
                }
            ]
        );

        $benchmark = new Benchmark($stopwatch);

        $func = function () {
            rand(1, 10);
        };

        $benchmark->script($func);

        $results = $benchmark->run();

        $this->assertEquals(['error' => 'Multiplier times or loops not set'], $results);
    }
}

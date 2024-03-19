<?php
/**
 * Copyright (c) 2024 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/brnchmark
 */

namespace Tankfairies\Benchmark;

use Exception;
use Closure;

/**
 * Class Benchmark
 *
 * A class for benchmarking the performance of a script or function.
 */
class Benchmark
{
    private int $times = 0;
    private int $loops = 0;
    private Closure $script;


    public function __construct(readonly Stopwatch $stopwatch)
    {
    }

    /**
     * Sets the multiplier times and loops.
     *
     * @param int $times The number of times to multiply.
     * @param int $loops The number of loops to perform.
     * @return $this
     */
    public function multiplier(int $times, int $loops): self
    {
        $this->times = $times;
        $this->loops = $loops;
        return $this;
    }

    /**
     * Sets the script to be executed.
     *
     * @param Closure $script The script to be executed.
     * @return $this
     */
    public function script(Closure $script): self
    {
        $this->script = $script;
        return $this;
    }

    /**
     * Run the script multiple times and measure the execution time and memory usage.
     *
     * @return array Returns an array containing the execution times and memory usage.
     */
    function run(): array
    {
        try {
            if ($this->times <= 0 || $this->loops <= 0) {
                throw new Exception('Multiplier times or loops not set');
            }

            $time = [];
            for ($i=0; $i < $this->loops; $i++) {
                $this->stopwatch->start();
                for ($j = 0; $j < $this->times; $j++) {
                    ($this->script)();
                }
                $time[$i+1] = number_format($this->stopwatch->elapsed(), 4);
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

        return [
            'time' => $time,
            'memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 2)
        ];
    }
}

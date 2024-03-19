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


/**
 * Class Stopwatch
 *
 * The Stopwatch class provides functionality to measure the elapsed time of an operation.
 */
final class Stopwatch
{
    private const TO_SECONDS = 1e9;

    private float $start;


    /**
     * Sets the start time to the current time.
     *
     * @return float The start time.
     */
    public function start(): float
    {
        return $this->start = $this->currentTime();
    }

    /**
     * Stops the timer and calculates the elapsed time since the start.
     *
     * @return float The elapsed time.
     */
    public function elapsed(): float
    {
        return $this->currentTime() - $this->start;
    }

    /**
     * Returns the current time as a Unix timestamp.
     *
     * @return float The current time.
     */
    private function currentTime(): float
    {
        return hrtime(true) / self::TO_SECONDS;
    }
}

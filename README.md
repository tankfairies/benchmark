[![Latest Stable Version](https://poser.pugx.org/tankfairies/benchmark/v/stable)](https://packagist.org/packages/tankfairies/benchmark)
[![Total Downloads](https://poser.pugx.org/tankfairies/benchmark/downloads)](https://packagist.org/packages/tankfairies/benchmark)
[![Latest Unstable Version](https://poser.pugx.org/tankfairies/benchmark/v/unstable)](https://packagist.org/packages/tankfairies/benchmark)
[![License](https://poser.pugx.org/tankfairies/benchmark/license)](https://packagist.org/packages/tankfairies/benchmark)
[![Build Status](https://travis-ci.com/tankfairies/benchmark.svg?branch=1.0)](https://travis-ci.com/github/tankfairies/benchmark)

# Benchmark

Provides the ability to do simple performance tests on code blocks.


## Installation

Install with [Composer](https://getcomposer.org/):

```bash
composer require tankfairies/benchmark 
```

## Usage

### Server Details

This will output an array of basic details on the machine you're running performance testing on.

For server details: -
```php
$server = new Server();
$details = $server->getDetails();
```

Output Example: -

```php
Array (
    [PHP] => 8.2.16
    [Platform] => Darwin
    [Arch] => arm64
    [Max memory usage] => 128M
    [OPCache status] => disabled
    [OPCache JIT] => disabled/unavailable
    [PCRE JIT] => enabled
    [XDebug extension] => disabled
)
```
For installed extensions: -

```php
$server = new Server();
$extensions = $server->getInstalledExtensions();
```

Output Example: -

```php
Array
(
    [0] => Core
    [1] => date
    [2] => libxml
    [3] => openssl
    [4] => pcre
    [5] => sqlite3
    [6] => zlib
    [7] => bcmath
    ...
```

### Stopwatch

Handles the time recording for benchmarking.

### Benchmark

Call or place the code you want to test into an anonymous function, for example: -

```php
$func = function () {
    rand(1, 100000);
};
```

Setup the benchmark as below: -

```php 
$benchmark = new Benchmark(new Stopwatch());
$completion = $benchmark
    ->multiplier(200000, 5)
    ->script($func)
    ->run();
```
You can define your own run criteria for example the above will run the test 
200000 times for a total of 5 loops.  This will produce 5 sets of results in
seconds in the format: -

```php
Array (
    [1] => 0.1699
    [2] => 0.1642
    [3] => 0.1641
    [4] => 0.1643
    [5] => 0.1645
)
```

The above shows the execution time in seconds for each 200k run.

## Copyright and license

The tankfairies/benchmark library is Copyright (c) 2019 Tankfairies (https://tankfairies.com) and licensed for use under the MIT License (MIT).

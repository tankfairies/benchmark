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
 * Class Server
 *
 * This class provides functionality to gather server details.
 */
class Server
{
    private array $records;

    /**
     * Retrieves system details and returns them as an associative array.
     *
     * @return array The system details including PHP version, platform, architecture, maximum memory usage,
     *               OPCache status (enabled or disabled), OPCache JIT status (enabled or disabled/unavailable),
     *               PCRE JIT status (enabled or disabled), and XDebug extension status (enabled or disabled).
     */
    public function getDetails(): array
    {
        $this->records['PHP'] = PHP_VERSION;
        $this->records['Platform'] = PHP_OS;
        $this->records['Arch'] = php_uname('m');
        $this->records['Max memory usage'] = ini_get('memory_limit');

        $opStatus = function_exists('opcache_get_status') ? opcache_get_status() : false;
        $this->records['OPCache status'] = is_array($opStatus) && @$opStatus['opcache_enabled'] ? 'enabled' : 'disabled';

        $this->records['OPCache JIT'] = is_array($opStatus) && @$opStatus['jit']['enabled'] ? 'enabled' : 'disabled/unavailable';
        $this->records['PCRE JIT'] = ini_get('pcre.jit') ? 'enabled' : 'disabled';
        $this->records['XDebug extension'] = extension_loaded('xdebug') ? 'enabled' : 'disabled';

        return $this->records;
    }

    /**
     * Retrieves the list of installed PHP extensions and returns them as an array.
     *
     * @return array The list of installed PHP extensions.
     */
    public function getInstalledExtensions(): array
    {
        return get_loaded_extensions();
    }
}

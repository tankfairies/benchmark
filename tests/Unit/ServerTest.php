<?php


namespace Tests\Unit;

use Tankfairies\Benchmark\Server;
use Tests\Support\UnitTester;
use Codeception\Test\Unit;

class ServerTest extends Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testGetDetails()
    {
        $server = new Server();
        $details = $server->getDetails();

        $this->assertIsArray($details);
    }

    public function testGetInstalledExtensions()
    {
        $server = new Server();
        $extensions = $server->getInstalledExtensions();

        $this->assertIsArray($extensions);
    }
}

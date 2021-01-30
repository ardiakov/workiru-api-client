<?php

declare(strict_types=1);

namespace Ardiakov\Workiru\Tests;

use Ardiakov\Workiru\WorkiClient;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class WorkiClientTest
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class WorkiClientTest extends TestCase
{
    public function testGetAccessToken(): void
    {
        $login = '';
        $password = '';

        $httpClient = $this->createMock(ClientInterface::class);

        $cache = $this->createMock(CacheInterface::class);
        $cache->method('get')->willReturn('1');

        $client = new WorkiClient(
            $login,
            $password,
            $httpClient,
            $cache
        );

        $this->assertEquals('1',  $client->accessToken());
    }
}
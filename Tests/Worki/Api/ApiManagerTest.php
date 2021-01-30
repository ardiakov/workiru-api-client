<?php

declare(strict_types=1);

namespace Ardiakov\Workiru\Tests\Api;

use Ardiakov\Workiru\Api\ApiManager;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiManagerTest
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class ApiManagerTest extends TestCase
{
    public function testBuildQuery(): void
    {
        $url = ApiManager::url('sessions');

        $this->assertEquals('https://api.iconjob.co/api/external/v1/sessions', $url);
    }
}
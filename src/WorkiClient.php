<?php

declare(strict_types=1);

namespace Ardiakov\Workiru;

use Ardiakov\Workiru\Api\ApiManager;
use GuzzleHttp\ClientInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class Client
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class WorkiClient
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @var string
     */
    private string $login;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string|null
     */
    private ?string $accessToken = null;

    /**
     * @var CacheInterface
     */
    private CacheInterface $cache;

    /**
     * WorkiClient constructor.
     *
     * @param string          $workiLogin
     * @param string          $workiPassword
     * @param ClientInterface $client
     * @param CacheInterface  $cache
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $workiLogin, string $workiPassword, ClientInterface $client, CacheInterface $cache)
    {
        $this->client = $client;
        $this->login = $workiLogin;
        $this->password = $workiPassword;
        $this->cache = $cache;

        $this->accessToken();
    }

    /**
     * Получение accessToken-a
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function accessToken(): string
    {
        $this->accessToken = $accessToken = $this->cache->get('workiAccessToken', function (ItemInterface $item) {
            return $this->api()->auth();
        });

        return $this->accessToken;
    }

    /**
     * @return ApiManager
     */
    public function api(): ApiManager
    {
        return new ApiManager($this->client, $this->login, $this->password, $this->accessToken);
    }
}
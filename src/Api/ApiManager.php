<?php

declare(strict_types=1);

namespace Ardiakov\Workiru\Api;

use Ardiakov\Workiru\Exceptions\WorkiException;
use GuzzleHttp\ClientInterface;

/**
 * Class ApiManager
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class ApiManager
{
    public const BASE_URL    = 'https://api.iconjob.co/api/external';
    public const API_VERSION = 'v1';

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
    private ?string $accessToken;

    /**
     * ApiManager constructor.
     *
     * @param ClientInterface $client
     * @param string          $login
     * @param string          $password
     * @param string|null     $accessToken
     */
    public function __construct(ClientInterface $client, string $login, string $password, ?string $accessToken)
    {
        $this->client = $client;
        $this->login = $login;
        $this->password = $password;
        $this->accessToken = $accessToken;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function url(string $url): string
    {
        return self::BASE_URL . '/' . self::API_VERSION . '/' . $url;
    }

    /**
     * Авторизация, получение accessToken-а
     *
     * @throws WorkiException
     *
     * @return string
     */
    public function auth(): string
    {
        return (new Auth($this->client, $this->login, $this->password))();
    }

    public function vacancies()
    {
        return (new Vacancies($this->client, $this->accessToken))();
    }
}
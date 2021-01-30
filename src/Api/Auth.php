<?php

declare(strict_types=1);

namespace Ardiakov\Workiru\Api;

use Ardiakov\Workiru\Exceptions\WorkiException;
use GuzzleHttp\ClientInterface;
use Throwable;

/**
 * Эндпоинт получения токена
 *
 * Class Auth
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
class Auth
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
     * Auth constructor.
     *
     * @param ClientInterface $client
     * @param string          $login
     * @param string          $password
     */
    public function __construct(ClientInterface $client, string $login, string $password)
    {
        $this->client = $client;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * Метод получения accessToken-а
     *
     * @throws WorkiException
     * @return string
     */
    public function __invoke(): string
    {
        try {
            $response = $this->client->request('POST', ApiManager::url('session'), [
                'form_params' => [
                    'login'    => $this->login,
                    'password' => $this->password
                ]
            ]);

            if (200 !== $response->getStatusCode()) {
                throw new WorkiException(
                    $response->getStatusCode(),
                    $response->getBody()->getContents(),
                );
            }

            $result = json_decode($response->getBody()->getContents(), true);

            return $result['token'];
        } catch (Throwable $ex) {
            throw new WorkiException($ex->getCode(), $ex->getMessage());
        }
    }
}
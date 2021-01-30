<?php

declare(strict_types=1);

namespace Ardiakov\Workiru\Api;

use Ardiakov\Workiru\Exceptions\WorkiException;
use GuzzleHttp\ClientInterface;
use Throwable;

/**
 * Эндпоинт получения списка вакансий
 *
 * Class Auth
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
class Vacancies
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @var string
     */
    private string $accessToken;

    /**
     * Auth constructor.
     *
     * @param ClientInterface $client
     * @param string          $login
     * @param string          $password
     */
    public function __construct(ClientInterface $client, string $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Метод получения списка вакансий
     *
     * @throws WorkiException
     * @return string
     */
    public function __invoke()
    {
        try {
            $response = $this->client->request('GET', ApiManager::url('jobs'), [
                'headers' => [
                    'Authorization' => 'Worki ' . $this->accessToken
                ]
            ]);

            if (200 !== $response->getStatusCode()) {
                throw new WorkiException(
                    $response->getStatusCode(),
                    $response->getBody()->getContents(),
                );
            }

            $result = json_decode($response->getBody()->getContents(), true);

            return $result;
        } catch (Throwable $ex) {
            throw new WorkiException($ex->getCode(), $ex->getMessage());
        }
    }
}
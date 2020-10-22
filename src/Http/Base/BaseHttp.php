<?php

namespace MedianetDev\PConnector\Http\Base;

use MedianetDev\PConnector\AuthManager;
use MedianetDev\PConnector\Contracts\Http;

abstract class BaseHttp implements Http
{
    /**
     * @var \MedianetDev\PConnector\AuthManager
     *
     * The auth manager instance
     */
    protected $authManager;

    public function __construct($withAuth = true)
    {
        $this->authManager = $withAuth ? new AuthManager() : null;
    }

    public function send(string $url, array $data, string $method, string $profile, bool $withAuth): array
    {
        switch (strtoupper($method)) {
            case 'POST':
                return $this->post($url, $data, $profile, $withAuth);
            case 'GET':
                return $this->get($url, $data, $profile, $withAuth);
            case 'PUT':
                return $this->put($url, $data, $profile, $withAuth);
            case 'PATCH':
                return $this->patch($url, $data, $profile, $withAuth);
            case 'DELETE':
                return $this->delete($url, $data, $profile, $withAuth);

            default:
                throw new \InvalidArgumentException(
                    'Unrecognized "'.strtoupper($method).'" method,
                        supported methods are: "POST", "GET", "PUT" , "PATCH" and "DELETE"'
                );
        }
    }

    /**
     * Return the sent request data and the response with a status to indicate if the is an error or not.
     *
     * @param string $rul
     * @param string $method
     * @param array  $payload
     * @param mixed  $response
     * @param bool   $status
     * @param string $errorMessage
     *
     * @return array
     */
    abstract protected function parser(string $url, string $method, array $payload, $response, bool $status = true, string $errorMessage = null): array;
}

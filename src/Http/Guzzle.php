<?php

namespace MedianetDev\PConnector\Http;

use GuzzleHttp\Client;
use MedianetDev\PConnector\Http\Base\BaseHttp;

class Guzzle extends BaseHttp
{
    /**
     * @var \GuzzleHttp\Client
     *
     * The Guzzle http client instance
     */
    private $client;

    public function __construct($withAuth = true)
    {
        parent::__construct($withAuth);
        $this->client = new Client();
    }

    public function post(string $url, array $data, string $profile, bool $withAuth, $headers = []): array
    {
        try {
            $payload = $this->prepareGuzzlePayload($profile, $withAuth, $headers);
            $payload['json'] = $data;

            return $this->parser($url, 'POST', $payload, $this->client->post($url, $payload));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $this->parser($url, 'POST', $payload, null, false, $e->getMessage());
        }
    }

    public function get(string $url, array $data, string $profile, bool $withAuth, $headers = []): array
    {
        try {
            $payload = $this->prepareGuzzlePayload($profile, $withAuth, $headers);
            $payload['query'] = $data;

            return $this->parser($url, 'GET', $payload, $this->client->get($url, $payload));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $this->parser($url, 'GET', $payload, null, false, $e->getMessage());
        }
    }

    public function put(string $url, array $data, string $profile, bool $withAuth, $headers = []): array
    {
        try {
            $payload = $this->prepareGuzzlePayload($profile, $withAuth, $headers);
            $payload['json'] = $data;

            return $this->parser($url, 'PUT', $payload, $this->client->put($url, $payload));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $this->parser($url, 'PUT', $payload, null, false, $e->getMessage());
        }
    }

    public function patch(string $url, array $data, string $profile, bool $withAuth, $headers = []): array
    {
        try {
            $payload = $this->prepareGuzzlePayload($profile, $withAuth, $headers);
            $payload['json'] = $data;

            return $this->parser($url, 'PATCH', $payload, $this->client->put($url, $payload));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $this->parser($url, 'PATCH', $payload, null, false, $e->getMessage());
        }
    }

    public function delete(string $url, array $data, string $profile, bool $withAuth, $headers = []): array
    {
        try {
            $payload = $this->prepareGuzzlePayload($profile, $withAuth, $headers);
            $payload['json'] = $data;

            return $this->parser($url, 'DELETE', $payload, $this->client->delete($url, $payload));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return $this->parser($url, 'DELETE', $payload, null, false, $e->getMessage());
        }
    }

    protected function parser(string $url, string $method, array $payload, $response, bool $status = true, string $errorMessage = null): array
    {
        $result['status'] = $status;
        $result['request'] = [
            'url' => $url,
            'method' => $method,
            'payload' => $payload,
        ];
        if (! is_null($response)) {
            $result['response'] = [
                'status_code' => $response->getStatusCode(),
                'headers' => $response->getHeaders(),
                'body' => $response->getBody()->getContents(),
            ];
        }
        if (! is_null($errorMessage)) {
            $result['error_message'] = $errorMessage;
        }

        return $result;
    }

    /**
     * Build the guzzle payload.
     *
     * @param string $profile
     * @param bool   $withAuth
     * @param array  $headers
     *
     * @return array
     */
    protected function prepareGuzzlePayload($profile, $withAuth, $headers)
    {
        $payload['headers'] = array_merge(config(
            'p-connector.profiles.'.$profile.'.request.headers',
            config('p-connector.request.headers', ['Accept' => 'application/json'])
        ), $headers);
        if ($withAuth) {
            $payload['headers'] = array_merge($payload['headers'], $this->authManager->getAuthenticationHeader($profile));
        }
        $payload['http_errors'] = config(
            'p-connector.profiles.'.$profile.'.request.http_errors',
            config('p-connector.request.http_errors', false)
        );
        $payload['connect_timeout'] = config(
            'p-connector.profiles.'.$profile.'.request.connect_timeout',
            config('p-connector.request.connect_timeout', 3)
        );
        $payload['timeout'] = config(
            'p-connector.profiles.'.$profile.'.request.timeout',
            config('p-connector.request.timeout', 3)
        );

        return $payload;
    }
}

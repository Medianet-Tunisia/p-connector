<?php

namespace MedianetDev\PConnector;

use MedianetDev\PConnector\Concerns\Configurations;
use MedianetDev\PConnector\Concerns\Requests;
use MedianetDev\PConnector\Concerns\Utils;

class PConnector
{
    use Configurations;
    use Requests;
    use Utils;

    /**
     * @var \MedianetDev\PConnector\Contracts\Http
     *
     * The http client
     */
    private $httpClient;

    public function __construct(\MedianetDev\PConnector\Contracts\Http $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->profile(config('p-connector.default_profile'));
    }

    /**
     * Send a request.
     *
     * @param string $path   [EX: 'posts']
     * @param array  $data   The query data
     * @param string $method
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function send(string $path = '', array $data = [], string $method = 'GET')
    {
        if (config('p-connector.profiles.'.$this->profile.'.request.enable_localization', config('p-connector.request.enable_localization', true)) && ! array_key_exists('Accept-Language', $this->headers)) {
            $this->lang();
        }
        $this->loadResponse($this->httpClient->send(build_url($path, $this->profile), $data, $method, $this->profile, $this->withAuthentication, $this->headers));

        if ($this->status &&
                $this->withAuthentication &&
                in_array($this->response['status_code'], config('p-connector.profiles.'.$this->profile.'.auth.re_auth_on_codes', config('p-connector.auth.re_auth_on_codes', [401])))
        ) {
            AuthManager::deleteTokenFor($this->profile);
            $this->loadResponse($this->httpClient->send(build_url($path, $this->profile), $data, $method, $this->profile, $this->withAuthentication, $this->headers));
        }

        if ($this->allowDebugging) {
            $this->log();
        }

        return $this;
    }

    /**
     * Logout the profile by deleting it's token from database.
     *
     * @return void
     */
    public function logout()
    {
        AuthManager::deleteTokenFor($this->profile);
    }
}

<?php

namespace MedianetDev\PConnector\Concerns;

trait Requests
{
    /**
     * @var array
     *
     * The request details
     */
    private $request;

    /**
     * @var array
     *
     * The response details
     */
    private $response;

    /**
     * @var bool
     *
     * The status of the request
     */
    private $status;

    /**
     * @var string
     *
     * Error message
     */
    private $errorMessage;

    /**
     * Send a get request.
     *
     * @param string $path [EX: 'posts']
     * @param array  $data The query data
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function get(string $path = '', array $data = [])
    {
        return $this->send($path, $data, 'GET');
    }

    /**
     * Send a post request.
     *
     * @param string $path [EX: 'posts']
     * @param array  $data The query data
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function post(string $path = '', array $data = [])
    {
        return $this->send($path, $data, 'POST');
    }

    /**
     * Send a put request.
     *
     * @param string $path [EX: 'posts']
     * @param array  $data The query data
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function put(string $path = '', array $data = [])
    {
        return $this->send($path, $data, 'PUT');
    }

    /**
     * Send a patch request.
     *
     * @param string $path [EX: 'posts']
     * @param array  $data The query data
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function patch(string $path = '', array $data = [])
    {
        return $this->send($path, $data, 'PATCH');
    }

    /**
     * Send a delete request.
     *
     * @param string $path [EX: 'posts']
     * @param array  $data The query data
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function delete(string $path = '', array $data = [])
    {
        return $this->send($path, $data, 'DELETE');
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getResponseBody()
    {
        return $this->response['body'];
    }

    public function getResponseStatusCode()
    {
        return $this->response['status_code'];
    }

    public function getResponseHeaders()
    {
        return $this->response['headers'];
    }

    public function getRequestUrl()
    {
        return $this->request['rul'];
    }

    public function getRequestMethod()
    {
        return $this->request['method'];
    }

    public function getRequestData()
    {
        return $this->request['payload'];
    }
}

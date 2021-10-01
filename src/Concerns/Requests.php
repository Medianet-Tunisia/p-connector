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
     * @var array
     *
     * Additional headers
     */
    private $headers = [];

    /**
     * Send a get request.
     *
     * @param  string  $path  [EX: 'posts']
     * @param  array|string  $data  The query data
     * @return \MedianetDev\PConnector\PConnector
     */
    public function get(string $path = '', $data = [])
    {
        return $this->send($path, $data, 'GET');
    }

    /**
     * Send a post request.
     *
     * @param  string  $path  [EX: 'posts']
     * @param  array|string  $data  The query data
     * @return \MedianetDev\PConnector\PConnector
     */
    public function post(string $path = '', $data = [])
    {
        return $this->send($path, $data, 'POST');
    }

    /**
     * Send a put request.
     *
     * @param  string  $path  [EX: 'posts']
     * @param  array|string  $data  The query data
     * @return \MedianetDev\PConnector\PConnector
     */
    public function put(string $path = '', $data = [])
    {
        return $this->send($path, $data, 'PUT');
    }

    /**
     * Send a patch request.
     *
     * @param  string  $path  [EX: 'posts']
     * @param  array|string  $data  The query data
     * @return \MedianetDev\PConnector\PConnector
     */
    public function patch(string $path = '', $data = [])
    {
        return $this->send($path, $data, 'PATCH');
    }

    /**
     * Send a delete request.
     *
     * @param  string  $path  [EX: 'posts']
     * @param  array|string  $data  The query data
     * @return \MedianetDev\PConnector\PConnector
     */
    public function delete(string $path = '', $data = [])
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

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * Add additional headers to the request.
     *
     * @param  array  $headers
     * @return \MedianetDev\PConnector\PConnector
     */
    public function withHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * Add additional header to the request.
     *
     * @param  string  $key  the header name
     * @param  string  $value  the header value
     * @return \MedianetDev\PConnector\PConnector
     */
    public function withHeader(string $key, string $value)
    {
        $this->headers = array_merge($this->headers, [$key => $value]);

        return $this;
    }
}

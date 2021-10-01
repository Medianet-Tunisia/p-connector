<?php

namespace MedianetDev\PConnector\Contracts;

interface Http
{
    /**
     * Send diver requests.
     *
     * @param  string  $url  the url where to send the request
     * @param  array  $data  the data to be sent
     * @param  string  $method  one of those values: POST, GET, PUT, DELETE
     * @param  string  $profile  one used profile
     * @param  bool  $withAuth  authenticate or not
     * @param  array  $headers  additional headers
     * @return array
     */
    public function send(string $url, $data, string $method, string $profile, bool $withAuth, array $headers = []): array;

    /**
     * Send a post request.
     *
     * @param  string  $url  the url where to send the request
     * @param  array|string  $data  the data to be sent
     * @param  string  $profile  the used profile
     * @param  bool  $withAuth  authenticate or not
     * @param  array  $headers  additional headers
     * @return array
     */
    public function post(string $url, $data, string $profile, bool $withAuth, array $headers = []): array;

    /**
     * Send a get request.
     *
     * @param  string  $url  the url where to send the request
     * @param  array|string  $data  the data to be sent
     * @param  string  $profile  the used profile
     * @param  bool  $withAuth  authenticate or not
     * @param  array  $headers  additional headers
     * @return array
     */
    public function get(string $url, $data, string $profile, bool $withAuth, array $headers = []): array;

    /**
     * Send a put request.
     *
     * @param  string  $url  the url where to send the request
     * @param  array|string  $data  the data to be sent
     * @param  string  $profile  the used profile
     * @param  bool  $withAuth  authenticate or not
     * @param  array  $headers  additional headers
     * @return array
     */
    public function put(string $url, $data, string $profile, bool $withAuth, array $headers = []): array;

    /**
     * Send a patch request.
     *
     * @param  string  $url  the url where to send the request
     * @param  array|string  $data  the data to be sent
     * @param  string  $profile  the used profile
     * @param  bool  $withAuth  authenticate or not
     * @param  array  $headers  additional headers
     * @return array
     */
    public function patch(string $url, $data, string $profile, bool $withAuth, array $headers = []): array;

    /**
     * Send a delete request.
     *
     * @param  string  $url  the url where to send the request
     * @param  array|string  $data  the data to be sent
     * @param  string  $profile  the used profile
     * @param  bool  $withAuth  authenticate or not
     * @param  array  $headers  additional headers
     * @return array
     */
    public function delete(string $url, $data, string $profile, bool $withAuth, array $headers = []): array;
}

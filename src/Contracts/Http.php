<?php

namespace MedianetDev\PConnector\Contracts;

interface Http
{
    /**
     * Send diver requests.
     *
     * @param string $url      the url where to send the request
     * @param array  $data     the data to be sent
     * @param string $method   one of those values: POST, GET, PUT, DELETE
     * @param string $profile  one used profile
     * @param bool   $withAuth authenticate or not
     *
     * @return array
     */
    public function send(string $url, array $data, string $method, string $profile, bool $withAuth): array;

    /**
     * Send a post request.
     *
     * @param string $url      the url where to send the request
     * @param array  $data     the data to be sent
     * @param string $profile  the used profile
     * @param bool   $withAuth authenticate or not
     *
     * @return array
     */
    public function post(string $url, array $data, string $profile, bool $withAuth): array;

    /**
     * Send a get request.
     *
     * @param string $url      the url where to send the request
     * @param array  $data     the data to be sent
     * @param string $profile  the used profile
     * @param bool   $withAuth authenticate or not
     *
     * @return array
     */
    public function get(string $url, array $data, string $profile, bool $withAuth): array;

    /**
     * Send a put request.
     *
     * @param string $url      the url where to send the request
     * @param array  $data     the data to be sent
     * @param string $profile  the used profile
     * @param bool   $withAuth authenticate or not
     *
     * @return array
     */
    public function put(string $url, array $data, string $profile, bool $withAuth): array;

    /**
     * Send a patch request.
     *
     * @param string $url      the url where to send the request
     * @param array  $data     the data to be sent
     * @param string $profile  the used profile
     * @param bool   $withAuth authenticate or not
     *
     * @return array
     */
    public function patch(string $url, array $data, string $profile, bool $withAuth): array;

    /**
     * Send a delete request.
     *
     * @param string $url      the url where to send the request
     * @param array  $data     the data to be sent
     * @param string $profile  the used profile
     * @param bool   $withAuth authenticate or not
     *
     * @return array
     */
    public function delete(string $url, array $data, string $profile, bool $withAuth): array;
}

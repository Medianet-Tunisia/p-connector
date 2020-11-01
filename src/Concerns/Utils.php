<?php

namespace MedianetDev\PConnector\Concerns;

trait Utils
{
    /**
     * Load the response from http client to PConnector.
     */
    private function loadResponse($data)
    {
        $this->status = $data['status'];
        $this->request = $data['request'];
        $this->errorMessage = $this->status ? null : $data['error_message'];

        if ($this->status) {
            $this->response = $data['response'];
            switch ($this->decodeResponse) {
                case 'object':
                    $this->response['body'] = json_decode($data['response']['body']);
                    break;
                case 'array':
                    $this->response['body'] = json_decode($data['response']['body'], true);
                    break;

                default:
                    break;
            }
        }
    }

    /**
     * Log the request & response data to the log files.
     *
     * @return void
     */
    public function log()
    {
        app('log')->debug(
            '[PConnector: '.$this->profile.'] '.
            "\n------------------- gateway request --------------------".
            "\n#Url: ".$this->request['url'].
            "\n#Method: ".$this->request['method'].
            "\n#Data: ".json_encode($this->request['payload']).
            "\n------------------- gateway response -------------------".
            "\n#Status code: ".$this->response['status_code'].
            "\n#Headers: ".json_encode($this->response['headers']).
            "\n#Body: ".(is_string($this->response['body']) ? $this->response['body'] : json_encode($this->response['body'])).
            "\n--------------------------------------------------------"
        );
    }

    /**
     * Log the request & response data to the log files if response code is equal to.
     *
     * @param int $responseCode
     *
     * @return void
     */
    public function logIfResponseCodeNot($responseCode)
    {
        if ($this->responseCodeNot($responseCode)) {
            app('log')->debug(
                '[PConnector: '.$this->profile.'] '.
                "\n------------------- gateway request --------------------".
                "\n#Url: ".$this->request['url'].
                "\n#Method: ".$this->request['method'].
                "\n#Data: ".json_encode($this->request['payload']).
                "\n------------------- gateway response -------------------".
                "\n#Status code: ".$this->response['status_code'].
                "\n#Headers: ".json_encode($this->response['headers']).
                "\n#Body: ".(is_string($this->response['body']) ? $this->response['body'] : json_encode($this->response['body'])).
                "\n--------------------------------------------------------"
            );
        }
    }

    /**
     * Dump the \MedianetDev\PConnector\PConnector using laravel dump function.
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function dump()
    {
        dump($this);

        return $this;
    }

    /**
     * Get attribute from the response.
     *
     * @param string $attribute The attribute path, for nested attributes use the "." separator [EX: "profile.name"]
     * @param mixed  $default   The fallback value if the attribute is not on the response object
     *
     * @return mixed
     */
    public function getAttribute($attribute, $default = null)
    {
        if ('object' !== gettype($this->response['body'])) {
            throw new \BadMethodCallException(
                'You can use the get() function only if you are parsing the response as object, your response body type is: '.
                gettype($this->response['body']).
                '. You can set in the config with the "decode_response" key.'
            );
        }

        return _get($this->response['body'], explode('.', $attribute), $default);
    }

    /**
     * Check if the response code is not equal to.
     *
     * @return bool
     */
    public function responseCodeNot(int $code)
    {
        return $this->response['status_code'] !== $code;
    }

    /**
     * Check if the response code is not in.
     *
     * @return bool
     */
    public function responseCodeNotIn(array $code)
    {
        return ! in_array($this->response['status_code'], $code);
    }

    public function __get($name)
    {
        return $this->response['body']->{$name};
    }
}

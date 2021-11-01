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
            "\n#Error: ".($this->errorMessage ? $this->errorMessage : 'none').
            "\n--------------------------------------------------------"
        );
    }

    /**
     * Log the request & response data to the log files if response code is equal to.
     *
     * @param  int  $responseCode
     * @return void
     */
    public function logIfResponseCodeNot($responseCode)
    {
        if ($this->responseCodeNot($responseCode)) {
            $this->log();
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
     * Dump and die the \MedianetDev\PConnector\PConnector using laravel dd function.
     */
    public function dd()
    {
        dd($this);
    }

    /**
     * Get attribute from the response.
     *
     * @param  string  $attribute  The attribute path, for nested attributes use the "." separator [EX: "profile.name"]
     * @param  mixed  $default  The fallback value if the attribute is not on the response object
     * @return mixed
     */
    public function getAttribute($attribute, $default = null)
    {
        if (config('p-connector.'.$this->profile.'.decode_response', config('p-connector.decode_response')) === 'object') {
            throw new \BadMethodCallException('You can use the get() function only if you are parsing the response as object, your response body type is: '.gettype($this->response['body']).'. You can set in the config with the "decode_response" key.');
        }

        if (0 === $this->status || 'object' !== gettype($this->response['body'])) {
            return $default;
        }

        return _get($this->response['body'], explode('.', $attribute), $default);
    }

    /**
     * Check if the response code is equal to.
     *
     * @return bool
     */
    public function responseCodeIs(int $code)
    {
        return $this->response['status_code'] === $code;
    }

    /**
     * Check if the response code is not equal to.
     *
     * @return bool
     */
    public function responseCodeNot(int $code)
    {
        return ! $this->responseCodeIs($code);
    }

    /**
     * Check if the response code is in the given array.
     *
     * @return bool
     */
    public function responseCodeIn(array $code)
    {
        return in_array($this->response['status_code'], $code);
    }

    /**
     * Check if the response code is not in the given array.
     *
     * @return bool
     */
    public function responseCodeNotIn(array $code)
    {
        return ! $this->responseCodeIn($code);
    }

    /**
     * Check if the response code is in [200, 201, 202, 204] range.
     *
     * @return bool
     */
    public function responseOK()
    {
        return $this->responseCodeIn([200, 201, 202, 204]);
    }

    /**
     * Check if the response code is not in [200, 201, 202, 204] range.
     *
     * @return bool
     */
    public function responseNOK()
    {
        return ! $this->responseOK();
    }

    public function __get($name)
    {
        return $this->status ? $this->response['body']->{$name} : null;
    }
}

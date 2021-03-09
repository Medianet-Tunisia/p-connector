<?php

namespace MedianetDev\PConnector\Concerns;

trait Configurations
{
    /**
     * @var bool
     *
     * Whether to use authentication header or not
     */
    private $withAuthentication;

    /**
     * @var bool
     *
     * The gateway profile
     */
    private $profile;

    /**
     * @var bool
     *
     * Should we log the request and the response or not
     */
    private $allowDebugging;

    /**
     * @var string
     *
     * Parse response as [string, object, array]
     */
    private $decodeResponse;

    private function updateSettings($profile)
    {
        $this->withAuthentication = config('p-connector.profiles.'.$profile.'.auth.authenticate_by_default', config('p-connector.auth.authenticate_by_default', false));
        $this->allowDebugging = config('p-connector.profiles.'.$profile.'.log', config('p-connector.log', false));
        $this->decodeResponse = config('p-connector.profiles.'.$profile.'.decode_response', config('p-connector.decode_response', false));
    }

    /**
     * Set the profile to use before sending the request.
     *
     * It's **RECOMMENDED** to use the profile before using any other setting function to not override any setting
     *
     * @param string $profile The profile name
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function profile(string $profile)
    {
        if (! in_array($profile, array_keys(config('p-connector.profiles')))) {
            throw new InvalidArgumentException('The profile"'.$profile.'" does not exist!');
        }
        $this->profile = $profile;
        $this->updateSettings($profile);

        return $this;
    }

    /**
     * Send language using the app locale through the Accept-Language header.
     *
     * @param string $locale [optional] The locale will default to the app.locale if not provided
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function lang(string $locale = null)
    {
        $this->withHeader('Accept-Language', $locale ?? app()->getLocale());

        return $this;
    }

    /**
     * Use authentication for this request.
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function withAuth()
    {
        $this->withAuthentication = true;

        return $this;
    }

    /**
     * Don't use authentication for this request.
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function withoutAuth()
    {
        $this->withAuthentication = false;

        return $this;
    }

    /**
     * Log this request.
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function withLog()
    {
        $this->allowDebugging = true;

        return $this;
    }

    /**
     * Don't log this request.
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function withoutLog()
    {
        $this->allowDebugging = false;

        return $this;
    }

    /**
     * Parse the response as an object.
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function objectResponse()
    {
        $this->decodeResponse = 'object';

        return $this;
    }

    /**
     * Parse the response as a string.
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function htmlResponse()
    {
        $this->decodeResponse = 'string';

        return $this;
    }

    /**
     * Parse the response as an array.
     *
     * @return \MedianetDev\PConnector\PConnector
     */
    public function arrayResponse()
    {
        $this->decodeResponse = 'array';

        return $this;
    }
}

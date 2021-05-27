<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Please note
    |--------------------------------------------------------------------------
    |
    | Some setting can be set as a profile setting, you will find those
    | setting with [AAPS] annotation to distinguish them (AAPS: Also A Profile Setting).
    | To set settings for a profile, you have to put them inside the appropriate profile array.
    | Also, note if a setting is defined inside a profile and as global in the same time,
    | the profile one will be used.
    |
    */

    // If the profile is not presided we fallback to the default_profile
    'default_profile' => 'demo',
    // The PConnector database table
    'table' => 'p_connector',
    // The http client used to send requests
    'http_client' => \MedianetDev\PConnector\Http\Guzzle::class,
    // How to parse the response, string, array or object parsing (you can make an exception with objectResponse() and htmlResponse() arrayResponse() methods)
    'decode_response' => 'object', // [AAPS]
    // The authentication settings
    'auth' => [ // [AAPS]
        // Whether to use authentication by default or not (you can make an exception with withAuth() and withoutAuth() methods)
        'authenticate_by_default' => false,
        // How to authenticate (Accepted values are: api_key, basic, bearer)
        'auth_method' => 'bearer',
        // If the api_key method is use then you SHOULD provide an api_key key
        // 'api_key' => 'X-AUTH-TOKEN',
        // The path of the login
        'login_path' => 'login',
        // The http method used to login
        'login_http_method' => 'POST',
        'credentials' => [
            'username' => 'username',
            'password' => 'password',
        ],
        // The expected http code response when login in
        'success_login_code' => [200],
        // When should we re-authenticate
        're_auth_on_codes' => [401],
        // Where to find the token in the response (you can youse the dot syntax EX: 'data.user.auth.token')
        'token_path' => 'token',
    ],
    // Request settings
    'request' => [ // [AAPS]
        // The default request headers
        'headers' => ['Accept' => 'application/json'],
        // Whether to send the language through the header by default or not
        'enable_localization' => true,
        // Handle http errors or not
        'http_errors' => false,
        // Http connect timeout value
        'connect_timeout' => 3,
        // Http timeout value
        'timeout' => 3,
        // The data type; json, form-data, ...
        'post_data' => 'json',
    ],
    // Log requests & responses to log files or not (you can make an exception with withLog() and withoutLog() methods)
    'log' => false, // [AAPS]

    /*
    |--------------------------------------------------------------------------
    | List of the available profiles with it's configurations
    |--------------------------------------------------------------------------
    */
    'profiles' => [
        'demo' => [
            'protocol' => 'https',
            'host' => 'my-json-server.typicode.com',
            'port' => 443,
            'prefix' => 'typicode/demo',
        ],
    ],
];

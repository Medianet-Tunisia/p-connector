<br>
<p align="center">
<a href="#" title="PConnector"><img src="https://user-images.githubusercontent.com/10948245/97109260-837eca80-16d2-11eb-95ad-a6c89cb400fd.PNG" style="max-width: 600px"></a>
<p>


<p align="center">
<a href="https://packagist.org/packages/medianet-dev/p-connector" title="Latest Version on Packagist"><img src="https://img.shields.io/packagist/v/medianet-dev/p-connector.svg"></a>
<a href="https://www.travis-ci.com/Medianet-Tunisia/p-connector" title="Build Status"><img src="https://www.travis-ci.com/Medianet-Tunisia/p-connector.svg?branch=master"></a>
<a href="https://scrutinizer-ci.com/g/Medianet-Tunisia/p-connector" title="Quality Score"><img src="https://img.shields.io/scrutinizer/quality/g/Medianet-Tunisia/p-connector.svg?b=master"></a>
<a href="https://packagist.org/packages/medianet-dev/p-connector" title="Total Downloads"><img src="https://img.shields.io/packagist/dt/medianet-dev/p-connector.svg"></a>
</p>

**PConnector** is a package that makes linking projects together much easier than performing a manual *Guzzle* or *Curl* requests.
You only need to set some basic settings of your gateway(s) and that's it.

## Installation

You can install the package via composer:

```bash
composer require medianet-dev/p-connector
```

Then migrate the package table by running:
```bash
php artisan migrate
```

## Usage
Here we will pass through some examples of doing some basic and advanced Api calls .

### Configuring your gateway(s)
Before start playing with the package you need to setup a profile for your gateway, and to do so, you need to publish the configuration file by running:
```bash
php artisan vendor:publish --provider="MedianetDev\PConnector\PConnectorServiceProvider"
```
After publishing the configuration, go to `p-connector.php` config file and setup you first profile setting:
```php
# file: p-connector.php

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
```
> Note that you can set **more than one** profile.

And that's it for basic configuration, other available settings are described in the configuration file itself.

### Some usage examples
```php
// Import the PConnector facade to get available methods hints 
use MedianetDev\PConnector\Facade\PConnector;

// Or use tha alias without available methods hints
# use PConnector;

// Method 1:
$demo = PConnector::get('posts/1');
echo '<h1>'.$demo->title.'</h1>';

// Method 2:
# $demo = PConnector::send('posts/1', [], 'GET');
# echo '<h1>'.$demo->title.'</h1>';
```

We don't have to tell the **PConnector** witch profile to use if we set the `default_profile` parameter, but if we have more than on profile and we want to switch between them, we can use the `profile()` function like so:

```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::profile('demo')->get('posts/1');
$demo2 = PConnector::profile('demo_2')->get('users/1');
```
> **IMPORTANT**: The profile function will apply a specific profile configuration and **erase** any other setting,
> so if you want to switch the profile call the `profile()` function before any other function.
> 
#### Configuration:
Some setting can be set as a profile setting, you will find those
setting with **[AAPS]** annotation to distinguish them (AAPS: Also A Profile Setting).
To set settings for a profile, you have to put them inside the appropriate profile array.
Also, note if a setting is defined inside a profile and as global in the same time,
the profile one will be used.
#### Http Methods:
```php
send(string $path = '', array $data = [], string $method = 'GET')
post(string $path = '', array $data = [])
get(string $path = '', array $data = [])
put(string $path = '', array $data = [])
patch(string $path = '', array $data = [])
delete(string $path = '', array $data = [])
```
#### Authentication:
PConnector supports sending request with authentication, and to do so you need to configuration the authentication settings
for the desired profile or for all the profiles.
```php
# file: p-connector.php

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
```
If for some reason you don't want to include authentication while sending some request, you can tell the PConnector like so:
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::profile('demo')->withoutAuth()->get('posts/1');
# $demo = PConnector::withoutAuth()->get('users/1');
```
> Remember that the profile function will apply a specific profile configuration and **erase** any other setting (in our case the `withoutAuth()` function), that why we use the `profile()` before `withoutAuth()`.



#### Request
```php 
# file: p-connector.php

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
```
##### Localization
Send **Accept-Language** header when needed:
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::lang('ar')->get('posts/1');
```
Or configure the **PConnector** to send it automatically via the configuration file.

##### Quickly change the current url
```php
PConnector::url('https://jsonplaceholder.typicode.com')->get('todos')
```
Or you can use tha alias setUrl() method

##### This is the list of getters available for the request:
* getRequestUrl()
* getRequestMethod()
* getRequestData()

#### Response
You can configure how do you want to save the response body:
* As a string
* As an object
* As an array

```php
# file: p-connector.php

'decode_response' => 'object', // [AAPS]
```
And if you want to change that for a specific response:
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::objectResponse()->get('posts/1');
$demo = PConnector::htmlResponse()->get('posts/1');
$demo = PConnector::arrayResponse()->get('posts/1');
```

The received response body can be retrieved using `getResponseBody()` after sending the request.
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::get('posts/1')->getResponseBody();
```

This is the list of getters available for the response:
* getResponseBody()
* getResponseStatusCode()
* getResponseHeaders()

If you decode the response body as an object, you can use `getAttribute('attribute_name')` or `->attribute_name` to retrieve a specific attribute, or even you can go more deep and do `getAttribute('object.object.attribute_name', 'fallback value')`, as an example:
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::get('posts/1')->getAttribute('title');
$demo = PConnector::get('posts/1')->title;
$demo = PConnector::get('posts/1')->getAttribute('author.name', 'Unknown author');
```

Response status code checks:
- `function responseCodeIs(int $code): bool`
- `function responseCodeNot(int $code): bool`
- `function responseCodeIn(array $codes): bool`
- `function responseCodeNotIn(array $codes): bool`
- `function responseOK(): bool`
- `function responseNOK(): bool`

> Example:
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::get('posts/1');
if ($demo->responseCodeNot(200)) {
    echo 'This is not what I was expecting from Demo!';
} else {
    echo '<h1>'.$demo->title.'</h1>';
}

$demo = PConnector::post('posts', ['title' => 'My title']);
 if ($demo->responseCodeNotIn([200, 201])) {
    echo 'This is not what I was expecting from Demo!';
} else {
    echo 'Post created, Hola!';
}
```

#### Logging
```php
# file: p-connector.php

// Log requests & responses to log files or not (you can make an exception with withLog() and withoutLog() methods)
'log' => false, // [AAPS]
```
Example 1:
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::get('posts/1')->dump();

if ($demo->responseCodeNot(200)) {
    $demo->log();
} else {
    echo '<h1>'.$demo->title.'</h1>';
}
```
Example 2:
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::withLog()->get('posts/1');
```

#### Debugging
You can debug the **PConnector** object using the `dump()` or the `dd()` method.
```php
use MedianetDev\PConnector\Facade\PConnector;

$demo = PConnector::get('posts/1')->dump();
$demo = PConnector::get('posts/1')->dd();
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email soufiene.slimi@medianet.com.tn instead of using the issue tracker.

## Credits

- [Soufiene Slimi](https://github.com/soufiene-slimi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

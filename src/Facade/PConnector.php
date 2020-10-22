<?php

namespace MedianetDev\PConnector\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \MedianetDev\PConnector\PConnector send(string $path = '', array $data = [], string $method = 'GET')
 * @method static \MedianetDev\PConnector\PConnector post(string $path = '', array $data = [])
 * @method static \MedianetDev\PConnector\PConnector get(string $path = '', array $data = [])
 * @method static \MedianetDev\PConnector\PConnector put(string $path = '', array $data = [])
 * @method static \MedianetDev\PConnector\PConnector patch(string $path = '', array $data = [])
 * @method static \MedianetDev\PConnector\PConnector delete(string $path = '', array $data = [])
 * @method static \MedianetDev\PConnector\PConnector profile(string $profile)                                          It's **RECOMMENDED** to use the profile before using any other setting function to not override any setting
 * @method static \MedianetDev\PConnector\PConnector withAuth()
 * @method static \MedianetDev\PConnector\PConnector withoutAuth()
 * @method static \MedianetDev\PConnector\PConnector withLog()
 * @method static \MedianetDev\PConnector\PConnector withoutLog()
 * @method static \MedianetDev\PConnector\PConnector objectResponse()
 * @method static \MedianetDev\PConnector\PConnector htmlResponse()
 * @method static \MedianetDev\PConnector\PConnector arrayResponse()
 * @method static \MedianetDev\PConnector\PConnector dump()
 * @method static void logout(string $profile)
 *
 * @see \MedianetDev\PConnector\PConnector
 */
class PConnector extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance('p-connector');

        return 'p-connector';
    }
}

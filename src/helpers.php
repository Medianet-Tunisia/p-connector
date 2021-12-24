<?php

if (! function_exists('_get')) {
    /**
     * Get attribute value from a given object.
     *
     * @param  object  $object  The object
     * @param  array  $attribute  The attribute name must be an array to support nesting [EX: "profile.name"]
     * @param  mixed  $default  The fallback value if the attribute is not found
     * @return mixed
     */
    function _get(object $object, array $attribute, $default)
    {
        if (count($attribute) > 1) {
            $object2 = $object->{$attribute[0]} ?? [];
            array_shift($attribute);
            if (gettype($object2) !== 'object') {
                return $default;
            }

            return _get($object2, $attribute, $default);
        } else {
            return $object->{$attribute[0]} ?? $default;
        }
    }
}

if (! function_exists('build_url')) {
    /**
     * Build the url of the gateway from settings for the desired profile.
     *
     * @param  string  $path  The path
     * @param  string  $profile  The profile name
     * @param  string  $url  The new url
     * @return string
     */
    function build_url(string $path, string $profile, string $url = null): string
    {
        return (string) (
            $url ? (endsWith($url, '/') ? $url : ($path != '' ? $url.'/' : $url)) : config('p-connector.profiles.'.$profile.'.protocol', 'http')
            .'://'.config('p-connector.profiles.'.$profile.'.host', 'localhost')
            .':'.config('p-connector.profiles.'.$profile.'.port', 80)
            .(startsWith(config('p-connector.profiles.'.$profile.'.prefix', ''), '/') ? '' : '/')
            .(
                endsWith(config('p-connector.profiles.'.$profile.'.prefix', ''), '/') ?
                config('p-connector.profiles.'.$profile.'.prefix', '') :
                (
                    null != config('p-connector.profiles.'.$profile.'.prefix', '') ?
                    config('p-connector.profiles.'.$profile.'.prefix', '').'/' :
                    ''
                )
            )
        ).(startsWith($path, '/') ? substr($path, 1) : $path);
    }
}
if (! function_exists('startsWith')) {
    function startsWith($haystack, $needle)
    {
        return 0 === substr_compare($haystack, $needle, 0, strlen($needle));
    }
}
if (! function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        return 0 === substr_compare($haystack, $needle, -strlen($needle));
    }
}

<?php

if (! function_exists('_get')) {
    /**
     * Get attribute value from a given object.
     *
     * @param object $object    The object
     * @param array  $attribute The attribute name must be an array to support nesting [EX: "profile.name"]
     * @param mixed  $default   The fallback value if the attribute is not found
     *
     * @return mixed
     */
    function _get(object $object, array $attribute, $default)
    {
        if (count($attribute) > 1) {
            $object2 = $object->{$attribute[0]} ?? [];
            array_shift($attribute);

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
     * @param string $path    The path
     * @param string $profile The profile name
     *
     * @return string
     */
    function build_url(string $path, string $profile): string
    {
        return (string) config('p-connector.profiles.'.$profile.'.protocol')
            .'://'.config('p-connector.profiles.'.$profile.'.host')
            .':'.config('p-connector.profiles.'.$profile.'.port')
            .(\Str::startsWith(config('p-connector.profiles.'.$profile.'.prefix'), '/') ? '' : '/')
            .(\Str::endsWith(config('p-connector.profiles.'.$profile.'.prefix'), '/') ? config('p-connector.profiles.'.$profile.'.prefix') : (null != config('p-connector.profiles.'.$profile.'.prefix') ? config('p-connector.profiles.'.$profile.'.prefix').'/' : ''))
            .(\Str::startsWith($path, '/') ? substr($path, 1) : $path);
    }
}

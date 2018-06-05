<?php

/**
 * Including methods that help you get request variables
 * instead of using built-in global PHP variables.
 * We could add filter value for these method later.
 */
class Luzo_Model_Request
{

    /**
     * All in one method
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call($name, $arguments)
    {
        $undefined = '';
        $var_name = 'undefined';
        $default = isset($arguments[1]) ? $arguments[1] : false;

        switch ($name) {
            case 'get':
                $var_name = '_GET';
                break;

            case 'post':
                $var_name = '_POST';
                break;

            case 'server':
                $var_name = '_SERVER';
                break;

            case 'request':
                $var_name = '_REQUEST';
                break;

            case 'session':
                $var_name = '_SESSION';
                break;
        }

        if (array_key_exists($arguments[0], ${$var_name})) {
            return ${$var_name}[$arguments[0]];
        }

        return $default;
    }
}

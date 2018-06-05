<?php

/**
 * Core class used to run this plugin
 */
class Luzo
{

    /**
     * @static
     * @var Luzo_Model_PluginRunner
     */
    protected static $_runner;

    /**
     * @static
     * @return void
     */
    public static function run()
    {
        spl_autoload_register('Luzo::autoloader');

        self::$_runner = new Luzo_Model_PluginRunner;
        self::$_runner->run();
    }

    /**
     * Autoloader
     *
     * @static
     * @param string $class
     * @return void
     */
    public static function autoloader($class)
    {
        // First of all, detect if required class belong to this plugin
        $regex = '/^' . LUZO_CLASS_PREFIX . '([a-zA-Z0-9_]+)/';
        if (preg_match($regex, $class, $matches)) {

            // Combine matches to class file path
            $class_file = str_replace('_', '/', $matches[1]) . '.php';

            // And load it if exists
            if (file_exists(LUZO_PLUGIN_PATH . '/' . $class_file)) {
                include_once LUZO_PLUGIN_PATH . '/' . $class_file;
            }
        }
    }

    /**
     * Load model
     *
     * @static
     * @param string $class
     * @return object
     */
    public static function load_model($class)
    {
        return self::$_runner->load_model($class);
    }

    /**
     * Get model
     *
     * @static
     * @param string $class
     * @return object
     */
    public static function get_model($class)
    {
        return self::$_runner->get_model($class);
    }

    /**
     * Get request handler model
     *
     * @static
     * @return Luzo_Model_Request
     */
    public static function get_request()
    {
        return self::$_runner->load_model('Request');
    }

    /**
     * An alias of self::_load_config
     *
     * @static
     * @param string $file
     * @return boolean|array
     */
    public static function load_config($file)
    {
        $configs = self::_load_config($file);
        // Allow other plugins can modify configs
        $configs = apply_filters('luzo_load_config_'.$file, $configs);

        return $configs;
    }

    /**
     * Load configuration from file
     *
     * @static
     * @param string $file
     * @return boolean|array
     */
    private static function _load_config($file)
    {
        $file = (string) $file;
        $path = LUZO_PLUGIN_PATH . '/config/' . $file . '.php';

        if (file_exists($path)) {
            return include $path;
        }

        return false;
    }
}

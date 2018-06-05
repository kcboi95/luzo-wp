<?php

/**
 * Generate template
 */
class Luzo_Template extends Luzo_Object
{
    /**
     * Template directory name
     *
     * @var string
     */
    private static $_template_dirname = 'templates';

    /**
     * Template file extension
     *
     * @var string
     */
    private static $_file_ext = '.php';

    /**
     * Variable pool for template file
     *
     * @var array
     */
    private static $_vars = [];

    /**
     * Load template
     *
     * @param string $path
     * @return void
     */
    public static function load($path)
    {
        $abs_path = LUZO_PLUGIN_PATH . self::$_template_dirname . DIRECTORY_SEPARATOR . trim($path, DIRECTORY_SEPARATOR) . self::$_file_ext;

        if (file_exists($abs_path)) {
            extract(self::$_vars);

            include $abs_path;
        } else {
            throw new Luzo_Exception(__('Template file not found in ' . $abs_path));
        }
    }

    /**
     * Assign variable to template
     *
     * @param string $key
     * @param mixed $value
     * @param boolean $forced
     * @return void
     */
    public static function assign($key, $value, $forced = false)
    {
        if (!$forced && array_key_exists($key, self::$_vars)) {
            throw new Luzo_Exception(__('Cannot redeclare variable $'.$key.' in template'));
        }

        self::$_vars[$key] = $value;
    }
}
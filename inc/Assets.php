<?php

/**
 * Common functions for working with plugin's assets
 */
class Luzo_Model_Assets
{
    /**
     * Basic asset types
     */
    const TYPE_CSS = 'css';
    const TYPE_JS = 'js';
    const TYPE_IMAGE = 'image';

    /**
     * Assets directory's name
     *
     * @var string
     */
    protected $assets_dirname = 'assets';

    /**
     * Set assets directory's name
     *
     * @param string $dirname
     * @return void
     */
    public function set_assets_dir($dirname)
    {
        $this->assets_dirname = $dirname;
    }

    /**
     * Get image link in assets dir
     *
     * @param string $path
     * @return void
     */
    public function image_link($path)
    {
        return $this->link($path, self::TYPE_IMAGE);
    }

    /**
     * Get css link in assets dir
     *
     * @param string $path
     * @return void
     */
    public function css_link($path)
    {
        return $this->link($path, self::TYPE_CSS);
    }

    /**
     * Get js link in assets dir
     *
     * @param string $path
     * @return void
     */
    public function js_link($path)
    {
        return $this->link($path, self::TYPE_JS);
    }

    /**
     * Generate asset link
     *
     * @param string $path
     * @param string $type
     * @return void
     */
    public function link($path, $type)
    {
        $path = (string) $path;
        $type = (string) $type;
        $allowed_types = [self::TYPE_CSS, self::TYPE_JS, self::TYPE_IMAGE];

        if (!in_array($type, $allowed_types)) {
            throw new Luzo_Exception(__('Asset with type is ' . $type . ' is not allowed.'));
        }

        $path = LUZO_PLUGIN_PATH . $this->_assets_dirname . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . trim($path);

        if (file_exists($path)) {
            return LUZO_PLUGIN_URL . $this->_assets_dirname . '/' . $type . '/' . trim($path);
        } else {
            throw new WSM_Exception(__('Link type ' . $type . ' does not exists, path="' . $path . '".'));
        }
    }
}

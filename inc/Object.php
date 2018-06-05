<?php

/**
 * Root class for most of classes
 */
class Luzo_Object
{
    /**
     * Save variables value
     *
     * @var array
     */
    protected $_data = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_construct();
    }

    /**
     * Replacement of __construct
     */
    protected function _construct()
    {
        // TODO: to be defined in child class
    }

    /**
     * Set data value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set_data($key, $value)
    {
        $key = (string) $key;

        $this->_data[$key] = $value;
        return $this;
    }

    /**
     * Get data value
     *
     * @param string $key
     * @param bool $default
     * @return mixed
     */
    public function get_data($key, $default = false)
    {
        $key = (string) $key;

        if (array_key_exists($key, $this->_data)) {
            return $this->_data[$key];
        }

        return false;
    }

    /**
     * Support set/get data flexible
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $substr = substr($name, 0, 4);
        $key = substr($name, 4);

        if ($substr == 'get_') {
            $default = isset($arguments[0]) ? $arguments[0] : false;
            return $this->get_data($key, $default);
        } elseif ($substr == 'set_') {
            return $this->set_data($key, $arguments[0]);
        }
    }
}

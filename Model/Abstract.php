<?php

/**
 * Abstract class for models
 */
class Luzo_Model_Abstract extends Luzo_Object
{

    /**
     * Alias of global variable $wpdb;
     *
     * @var wpdb
     */
    protected $db;

    /**
     * Custom constructor
     *
     * @return void
     */
    protected function _construct()
    {
        global $wpdb;

        parent::_construct();
        $this->db = &$wpdb;
    }
}

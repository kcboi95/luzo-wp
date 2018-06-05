<?php

/**
 * Abstract class for front-end controllers
 * May be REST APIs, custom front-end endpoint
 */
abstract class Luzo_Controller_AbstractAction extends Luzo_Object
{

    /**
     * Request handler object
     *
     * @var Luzo_Model_Request
     */
    protected $_request;

    /**
     * Custom constructor for child classes.
     * Use this instead of built-in __construct method
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_request = Luzo::load_model('Request');
    }

    /**
     * Execute
     *
     * Execute controller action logic and return HTML, headers for browser
     *
     * @return mixed
     */
    abstract public function execute();

    /**
     * Load template file
     *
     * @param string $file
     * @return void
     */
    protected function load_template(string $file)
    {
        Luzo_Template::load($file);
    }
}

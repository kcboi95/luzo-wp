<?php

class Luzo_Controller_Admin_Plugin_Settings extends Luzo_Controller_Admin_AbstractAction
{
    public function execute()
    {
        Luzo_Template::assign('name', 'Dat');
        $this->load_template('plugin/settings');
    }
}
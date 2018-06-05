<?php

class Luzo_Controller_Admin_Link_About extends Luzo_Controller_Admin_AbstractAction
{
    public function execute()
    {
        wp_redirect('http://luzotech.com');
        exit;
    }
}
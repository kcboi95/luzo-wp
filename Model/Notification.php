<?php
class Luzo_Model_Notification extends Luzo_Model_Abstract
{
    protected $cache = [];

    protected function _construct()
    {
        parent::_construct();
    }

    public function get_text($text_id, $domain)
    {
        if (array_key_exists($domain, $this->cache)) {

        }
        $this->cache[$domain] = Luzo::load_config('notification/'.$domain);
    }
}
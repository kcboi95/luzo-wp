<?php

/**
 * Main class use for:
 * - register/remove menu
 * - route url to correct controller action
 * - load/get model
 */
final class Luzo_Model_PluginRunner extends Luzo_Model_Abstract
{

    /**
     * Cache model objects
     *
     * @var array
     */
    protected $loaded_models = [];

    /**
     * Page slug prefix
     *
     * @var string
     */
    protected $page_slug_prefix = '';

    const DEFAULT_CAPABILITY = 'manage_options';
    const DEFAULT_ICON_URL = '';
    const DEFAULT_POSITION = null;

    /**
     * Main method used to run plugin
     */
    public function run()
    {
        add_action('admin_menu', [$this, 'register_menu']);
        add_action('network_admin_menu', [$this, 'register_menu']);
        register_activation_hook(LUZO_PLUGIN_REGISTRATION_FILE, [$this->load_model('Script'), 'activate']);
        register_deactivation_hook(LUZO_PLUGIN_REGISTRATION_FILE, [$this->load_model('Script'), 'deactivate']);
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function register_menu()
    {
        global $menu, $submenu;

        $menu_cfg = $this->load_menu_config();
        $submenu_cfgs = Luzo::load_config('submenu');

        $this->page_slug_prefix = $menu_cfg['menu_slug'];

        $page_hook_prefix = trim(str_replace(' ', '-', strtolower($menu_cfg['menu_title'])), '-');

        foreach ($submenu_cfgs as $child_key => $submenu_cfg) {
            // Set default values for submenu config
            $this->complete_submenu_default_values($submenu_cfg);

            $slug = $menu_cfg['menu_slug'] . '_' . $submenu_cfg['controller'] . '_' . $submenu_cfg['action'];

            // Only start create mainmenu in case we found a submenu belong to this plugin's mainmenu
            if (!isset($parent_slug) && is_null($submenu_cfg['parent_slug'])) {
                $parent_slug = $slug;

                add_menu_page(
                    __($menu_cfg['page_title']), __($menu_cfg['menu_title']), $menu_cfg['capability'], $slug, [$this, 'handle_menu_page_content'], $menu_cfg['icon_url'], $menu_cfg['position']
                );
            }

            $menu_title = $submenu_cfg['add_to_menu'] ? __($submenu_cfg['menu_title']) : null;

            $submenu_parent_slug = $submenu_cfg['add_to_menu'] ? $submenu_parent_slug : $slug;
            $submenu_parent_slug = is_string($submenu_cfg['parent_slug']) ? $submenu_cfg['parent_slug'] : $parent_slug;

            add_submenu_page(
                $submenu_parent_slug, __($submenu_cfg['page_title']), $menu_title, $submenu_cfg['capability'], $slug, [$this, 'handle_menu_page_content']
            );

            // Skip include 'wp-admin/admin-header.php' by default in wp-admin/admin.php
            // You can include it in your template to prevent error like header already sent, ...
            if ($submenu_cfg['no_header'] === true) {
                // For orginal menu page URL
                add_action('load-toplevel_page_' . $slug, function () {
                    $_GET['noheader'] = 'true';
                });

                // For submenu page URL
                add_action('load-'.$page_hook_prefix.'_page_' . $slug, function () {
                    $_GET['noheader'] = 'true';
                });

                // For page added by add_submenu_page but doesn't appear in menu
                add_action('load-admin_page_' . $slug, function() {
                    $_GET['noheader'] = 'true';
                });
            }
        }
    }

    /**
     * Decide which controller should be loaded and execute it
     *
     * @return void
     */
    public function handle_menu_page_content()
    {
        $regex = '/^' . $this->page_slug_prefix . '_([a-zA-Z0-9_]+)/';
        if (preg_match($regex, $_GET['page'], $matches)) {
            $route = explode('_', $matches[1]);
            $class = LUZO_CLASS_PREFIX . 'Controller_Admin_' . ucfirst($route[0]) . '_' . ucfirst($route[1]);

            $action = new $class;
            $action->execute();
        }
    }

    /**
     * Init model object
     *
     * @param string $class
     * @return object
     */
    public function get_model($class)
    {
        $final_class = LUZO_CLASS_PREFIX . 'Model_' . trim($class, '_');
        return new $final_class;
    }

    /**
     * Load model object from cache
     *
     * @param string $class
     * @return object
     */
    public function load_model($class)
    {
        if (!array_key_exists($class, $this->loaded_models)) {
            $this->loaded_models[$class] = $this->get_model($class);
        }

        return $this->loaded_models[$class];
    }

    /**
     * Load menu config from file and set default values
     *
     * @return array
     */
    private function load_menu_config()
    {
        $menu_cfg = Luzo::load_config('menu');

        $menu_cfg['capability'] = isset($menu_cfg['capability']) ? $menu_cfg['capability'] : self::DEFAULT_CAPABILITY;
        $menu_cfg['icon_url'] = isset($menu_cfg['icon_url']) ? $menu_cfg['icon_url'] : self::DEFAULT_ICON_URL;
        $menu_cfg['position'] = isset($menu_cfg['position']) ? $menu_cfg['position'] : self::DEFAULT_POSITION;

        return $menu_cfg;
    }

    /**
     * Set default values for submenu config
     *
     * @param array $submenu_cfg
     * @return void
     */
    private function complete_submenu_default_values(&$submenu_cfg)
    {
        if (!isset($submenu_cfg['add_to_menu'])) {
            $submenu_cfg['add_to_menu'] = true;
        }

        if (!isset($submenu_cfg['parent_slug'])) {
            $submenu_cfg['parent_slug'] = null;
        }

        if (!isset($submenu_cfg['capability'])) {
            $submenu_cfg['capability'] = self::DEFAULT_CAPABILITY;
        }

        if (!isset($submenu_cfg['no_header'])) {
            $submenu_cfg['no_header'] = false;
        }
    }
}
